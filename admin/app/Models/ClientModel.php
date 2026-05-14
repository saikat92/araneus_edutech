<?php
namespace App\Models;
use App\Core\Model;

class ClientModel extends Model {
    protected string $table = 'clients';

    public function search(string $q = '', int $limit = 20, int $offset = 0): array {
        $where = '1=1'; $params = [];
        if ($q) {
            $where .= " AND (client_name LIKE ? OR email LIKE ? OR phone LIKE ?)";
            $s = "%$q%"; array_push($params, $s, $s, $s);
        }
        return $this->db->fetchAll(
            "SELECT * FROM clients WHERE $where ORDER BY client_name LIMIT $limit OFFSET $offset", $params);
    }
}
