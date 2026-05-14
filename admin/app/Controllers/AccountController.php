<?php
namespace App\Controllers;
use App\Core\Controller;

class AccountController extends Controller {
    public function __construct() { $this->requireAuth(); }

    public function index(): void {
        $db = \App\Core\Database::getInstance();
        // All clients with total invoiced, total paid, balance
        $clients = $db->fetchAll("
            SELECT c.*,
                COALESCE(SUM(i.total_amount),0)  AS total_invoiced,
                COALESCE(SUM(i.amount_paid),0)   AS total_paid,
                COALESCE(SUM(i.balance_due),0)   AS balance_due
            FROM clients c
            LEFT JOIN invoices i ON i.client_id = c.id
            GROUP BY c.id
            ORDER BY c.client_name
        ");
        // Araneus summary (sum across all)
        $summary = $db->fetch("
            SELECT
                COALESCE(SUM(total_amount),0) AS total_billed,
                COALESCE(SUM(amount_paid),0)  AS total_received,
                COALESCE(SUM(balance_due),0)  AS total_outstanding
            FROM invoices
        ");
        $this->view('admin/accounts/index', compact('clients','summary') + ['title' => 'Accounts Ledger']);
    }

    public function ledger(string $clientId): void {
        $db = \App\Core\Database::getInstance();
        $client = $db->fetch("SELECT * FROM clients WHERE id=?", [(int)$clientId]);
        if (!$client) { $this->setFlash('danger','Client not found'); $this->redirect('/admin/accounts'); }

        // Build ledger: invoices (debit) + payments (credit) merged and sorted by date
        $invoices = $db->fetchAll("
            SELECT 'invoice' AS type, invoice_number AS ref,
                   invoice_date AS txn_date, total_amount AS debit, 0 AS credit,
                   status, id
            FROM invoices WHERE client_id=?
        ", [(int)$clientId]);

        $payments = $db->fetchAll("
            SELECT 'payment' AS type, COALESCE(p.transaction_id, CONCAT('PMT-',p.id)) AS ref,
                   p.payment_date AS txn_date, 0 AS debit, p.amount AS credit,
                   'paid' AS status, p.id
            FROM payments p
            JOIN invoices i ON i.id = p.invoice_id
            WHERE i.client_id=?
        ", [(int)$clientId]);

        // Merge + sort
        $ledger = array_merge($invoices, $payments);
        usort($ledger, fn($a,$b) => strcmp($a['txn_date'], $b['txn_date']));

        // Running balance
        $balance = 0;
        foreach ($ledger as &$row) {
            $balance += (float)$row['debit'] - (float)$row['credit'];
            $row['running_balance'] = $balance;
        }
        unset($row);

        $this->view('admin/accounts/ledger', compact('client','ledger','balance') + ['title' => $client['client_name'].' — Ledger']);
    }
}