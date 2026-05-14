<?php
namespace App\Models;
use App\Core\Model;

class InvoiceModel extends Model {
    protected string $table = 'invoices';

    public function getWithClient(int $limit = 20, int $offset = 0, string $status = ''): array {
        $where = $status ? "WHERE i.status='".addslashes($status)."'" : '';
        return $this->db->fetchAll(
            "SELECT i.*, c.client_name FROM invoices i
             JOIN clients c ON c.id = i.client_id
             $where
             ORDER BY i.created_at DESC LIMIT $limit OFFSET $offset");
    }

    public function findWithClient(int $id): ?array {
        return $this->db->fetch(
            "SELECT i.*, c.client_name, c.client_type, c.email as client_email,
                    c.phone as client_phone, c.gstin, c.pan, c.address,
                    c.city, c.state, c.country
             FROM invoices i
             JOIN clients c ON c.id = i.client_id
             WHERE i.id=?", [$id]);
    }

    public function getItems(int $invoiceId): array {
        return $this->db->fetchAll(
            "SELECT ii.*, ps.name as product_name, ps.hsn_sac_code
             FROM invoice_items ii
             LEFT JOIN products_services ps ON ps.id = ii.product_service_id
             WHERE ii.invoice_id=?
             ORDER BY ii.id", [$invoiceId]);
    }

    public function totalRevenue(): float {
        return (float)($this->db->fetch(
            "SELECT COALESCE(SUM(total_amount),0) as t FROM invoices WHERE status='paid'"
        )['t'] ?? 0);
    }

    public function getByClient(int $clientId): array {
        return $this->db->fetchAll(
            "SELECT * FROM invoices WHERE client_id=? ORDER BY invoice_date DESC", [$clientId]);
    }
}