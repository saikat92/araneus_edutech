<?php
namespace App\Models;
use App\Core\Model;

class PaymentModel extends Model {
    protected string $table = 'payments';

    public function getWithInvoice(int $limit = 20, int $offset = 0): array {
        return $this->db->fetchAll(
            "SELECT p.*, i.invoice_number, c.client_name FROM payments p
             JOIN invoices i ON i.id = p.invoice_id
             JOIN clients c ON c.id = i.client_id
             ORDER BY p.payment_date DESC LIMIT $limit OFFSET $offset");
    }

    public function getByInvoice(int $invoiceId): array {
        return $this->db->fetchAll("SELECT * FROM payments WHERE invoice_id=? ORDER BY payment_date DESC", [$invoiceId]);
    }
}
