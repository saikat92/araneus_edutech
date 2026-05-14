<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\{PaymentModel, InvoiceModel};

class PaymentController extends Controller {
    private PaymentModel $model;
    public function __construct() { $this->requireAuth(); $this->model = new PaymentModel(); }

    public function index(): void {
        $page=max(1,(int)$this->get('page',1)); $limit=15; $offset=($page-1)*$limit;
        $payments=$this->model->getWithInvoice($limit,$offset);
        $total=$this->model->count(); $pages=ceil($total/$limit);
        $this->view('admin/payments/index', compact('payments','total','pages','page')+['title'=>'Payments']);
    }
    public function create(): void {
        $db=\App\Core\Database::getInstance();
        $invoices=$db->fetchAll("SELECT i.*,c.client_name FROM invoices i JOIN clients c ON c.id=i.client_id WHERE i.status IN ('sent','partial','overdue') ORDER BY i.invoice_number");
        $this->view('admin/payments/form',['title'=>'Record Payment','invoices'=>$invoices]);
    }
    public function store(): void {
        $amount=(float)$this->post('amount',0);
        $invoiceId=(int)$this->post('invoice_id');
        $this->model->create([
            'invoice_id'     => $invoiceId,
            'payment_date'   => $this->post('payment_date',date('Y-m-d')),
            'payment_method' => $this->post('payment_method','bank_transfer'),
            'transaction_id' => trim($this->post('transaction_id')),
            'amount'         => $amount,
            'notes'          => trim($this->post('notes')),
        ]);
        $inv=(new InvoiceModel())->findById($invoiceId);
        if ($inv) {
            $paid=(float)$inv['amount_paid']+$amount;
            $bal=(float)$inv['total_amount']-$paid;
            $status=$bal<=0?'paid':($paid>0?'partial':$inv['status']);
            (new InvoiceModel())->update($invoiceId,['amount_paid'=>$paid,'balance_due'=>max(0,$bal),'status'=>$status]);
        }
        $this->setFlash('success','Payment recorded.'); $this->redirect('/admin/payments');
    }
}
