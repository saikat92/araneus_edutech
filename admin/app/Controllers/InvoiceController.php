<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\{InvoiceModel, ClientModel};

class InvoiceController extends Controller {
    private InvoiceModel $model;
    public function __construct() { $this->requireAuth(); $this->model = new InvoiceModel(); }

    public function index(): void {
        $page   = max(1,(int)$this->get('page',1));
        $limit  = 15; $offset = ($page-1)*$limit;
        $status = $this->get('status','');
        $invoices = $this->model->getWithClient($limit, $offset, $status);
        $total    = $this->model->count();
        $pages    = ceil($total/$limit);
        $this->view('admin/invoices/index', compact('invoices','total','pages','page','status')+['title'=>'Invoices']);
    }

    public function show(string $id): void {
        $invoice  = $this->model->findWithClient((int)$id);
        if (!$invoice) { $this->setFlash('danger','Invoice not found'); $this->redirect('/admin/invoices'); }
        $items    = $this->model->getItems((int)$id);
        $payments = (new \App\Models\PaymentModel())->getByInvoice((int)$id);
        $this->view('admin/invoices/show', compact('invoice','items','payments')+['title'=>'Invoice #'.$invoice['invoice_number']]);
    }

    public function create(): void {
        $db       = \App\Core\Database::getInstance();
        $clients  = (new ClientModel())->findAll('client_name');
        $products = $db->fetchAll("SELECT * FROM products_services WHERE is_active=1 ORDER BY name");
        // Students for fee invoicing: join with their enrollments
        $students = $db->fetchAll("
            SELECT s.id, s.full_name, s.candidate_id, s.email,
                   c.id as course_id, c.title as course_title, c.fee as course_fee
            FROM students s
            LEFT JOIN enrollments e ON e.student_id = s.id
            LEFT JOIN courses c ON c.id = e.course_id
            WHERE s.status='active'
            ORDER BY s.full_name
        ");
        $preClientId = (int)$this->get('client_id', 0);
        $this->view('admin/invoices/form', [
            'title'       => 'New Invoice',
            'invoice'     => null,
            'clients'     => $clients,
            'products'    => $products,
            'students'    => $students,
            'preClientId' => $preClientId,
        ]);
    }

    public function store(): void {
        $db = \App\Core\Database::getInstance();

        // Determine if billing a student or a client
        $billType  = $this->post('bill_type', 'client');
        $clientId  = null;
        $studentId = null;

        if ($billType === 'student') {
            $studentId = (int)$this->post('student_id');
            // Auto-register student as client if not already
            $clientId = $this->ensureStudentClient($db, $studentId);
        } else {
            $clientId = (int)$this->post('client_id');
        }

        // Process line items
        $itemNames   = $this->post('item_name',   []);
        $itemQtys    = $this->post('item_qty',     []);
        $itemPrices  = $this->post('item_price',   []);
        $itemGsts    = $this->post('item_gst',     []);
        $itemPsIds   = $this->post('item_ps_id',   []);

        $subTotal  = 0;
        $taxTotal  = 0;
        $lineItems = [];

        foreach ($itemNames as $i => $name) {
            if (empty(trim($name))) continue;
            $qty      = (float)($itemQtys[$i] ?? 1);
            $price    = (float)($itemPrices[$i] ?? 0);
            $gstRate  = (float)($itemGsts[$i] ?? 0);
            $lineAmt  = $qty * $price;
            $taxAmt   = round($lineAmt * $gstRate / 100, 2);
            $totalAmt = $lineAmt + $taxAmt;
            $subTotal += $lineAmt;
            $taxTotal += $taxAmt;
            $lineItems[] = [
                'name'       => trim($name),
                'qty'        => $qty,
                'price'      => $price,
                'gst_rate'   => $gstRate,
                'tax_amount' => $taxAmt,
                'total'      => $totalAmt,
                'ps_id'      => (int)($itemPsIds[$i] ?? 0),
            ];
        }

        $discount   = (float)$this->post('discount_amount', 0);
        $grandTotal = $subTotal + $taxTotal - $discount;

        $invoiceId = $this->model->create([
            'invoice_number'  => 'INV-'.date('Ymd').'-'.rand(100,999),
            'client_id'       => $clientId,
            'invoice_date'    => $this->post('invoice_date', date('Y-m-d')),
            'due_date'        => $this->post('due_date') ?: null,
            'po_number'       => trim($this->post('po_number','')),
            'sub_total'       => round($subTotal, 2),
            'tax_amount'      => round($taxTotal, 2),
            'discount_amount' => $discount,
            'total_amount'    => round($grandTotal, 2),
            'balance_due'     => round($grandTotal, 2),
            'amount_paid'     => 0,
            'status'          => 'draft',
            'payment_terms'   => trim($this->post('payment_terms','')),
            'notes'           => trim($this->post('notes','')),
        ]);

        // Save line items
        foreach ($lineItems as $item) {
            // If no product_service id, use first available or 0
            $psId = $item['ps_id'];
            if (!$psId) {
                // Try to find or create a product_service entry
                $psId = $this->ensureProductService($db, $item['name'], $item['price'], $item['gst_rate']);
            }
            $db->insert('invoice_items', [
                'invoice_id'         => $invoiceId,
                'product_service_id' => $psId,
                'description'        => $item['name'],
                'quantity'           => $item['qty'],
                'unit_price'         => $item['price'],
                'gst_rate'           => $item['gst_rate'],
                'tax_amount'         => $item['tax_amount'],
                'total_amount'       => $item['total'],
            ]);
        }

        $this->setFlash('success','Invoice created with '.count($lineItems).' item(s).');
        $this->redirect('/admin/invoices/'.$invoiceId);
    }

    public function edit(string $id): void {
        $invoice  = $this->model->findWithClient((int)$id);
        $db       = \App\Core\Database::getInstance();
        $clients  = (new ClientModel())->findAll('client_name');
        $products = $db->fetchAll("SELECT * FROM products_services WHERE is_active=1 ORDER BY name");
        $items    = $this->model->getItems((int)$id);
        $students = $db->fetchAll("SELECT s.id, s.full_name, s.candidate_id FROM students WHERE status='active' ORDER BY full_name");
        $this->view('admin/invoices/form', compact('invoice','clients','products','items','students') + ['title'=>'Edit Invoice','preClientId'=>0]);
    }

    public function update(string $id): void {
        $this->model->update((int)$id, [
            'status'        => $this->post('status'),
            'notes'         => trim($this->post('notes','')),
            'due_date'      => $this->post('due_date') ?: null,
            'payment_terms' => trim($this->post('payment_terms','')),
        ]);
        $this->setFlash('success','Invoice updated.');
        $this->redirect('/admin/invoices/'.$id);
    }

    public function delete(string $id): void {
        $db = \App\Core\Database::getInstance();
        $db->delete('invoice_items', 'invoice_id=?', [(int)$id]);
        $this->model->delete((int)$id);
        $this->setFlash('success','Invoice deleted.');
        $this->redirect('/admin/invoices');
    }

    public function updateStatus(string $id): void {
        $this->model->update((int)$id, ['status' => $this->post('status')]);
        $this->setFlash('success','Status updated.');
        $this->redirect('/admin/invoices/'.$id);
    }

    // Auto-register a student as a client for fee invoicing
    private function ensureStudentClient(\App\Core\Database $db, int $studentId): int {
        $student = $db->fetch("SELECT * FROM students WHERE id=?", [$studentId]);
        if (!$student) return 0;
        // Check if already a client by email
        $existing = $db->fetch("SELECT id FROM clients WHERE email=?", [$student['email']]);
        if ($existing) return (int)$existing['id'];
        // Create client from student
        return $db->insert('clients', [
            'client_name'    => $student['full_name'],
            'client_type'    => 'individual',
            'contact_person' => $student['full_name'],
            'email'          => $student['email'],
            'phone'          => $student['phone'],
            'status'         => 'active',
            'notes'          => 'Auto-registered from student: '.$student['candidate_id'],
        ]);
    }

    private function ensureProductService(\App\Core\Database $db, string $name, float $price, float $gstRate): int {
        $existing = $db->fetch("SELECT id FROM products_services WHERE name=? LIMIT 1", [$name]);
        if ($existing) return (int)$existing['id'];
        return $db->insert('products_services', [
            'name'       => $name,
            'type'       => 'service',
            'unit_price' => $price,
            'gst_rate'   => $gstRate,
            'is_active'  => 1,
        ]);
    }
}