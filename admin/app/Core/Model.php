<?php
namespace App\Core;

abstract class Model {
    protected Database $db;
    protected string $table;
    protected string $primaryKey = 'id';

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function findAll(string $orderBy = '', int $limit = 0, int $offset = 0): array {
        $sql = "SELECT * FROM `{$this->table}`";
        if ($orderBy) $sql .= " ORDER BY $orderBy";
        if ($limit)   $sql .= " LIMIT $limit OFFSET $offset";
        return $this->db->fetchAll($sql);
    }

    public function findById(int $id): ?array {
        return $this->db->fetch("SELECT * FROM `{$this->table}` WHERE `{$this->primaryKey}`=?", [$id]);
    }

    public function create(array $data): int {
        return $this->db->insert($this->table, $data);
    }

    public function update(int $id, array $data): int {
        return $this->db->update($this->table, $data, "`{$this->primaryKey}`=?", [$id]);
    }

    public function delete(int $id): int {
        return $this->db->delete($this->table, "`{$this->primaryKey}`=?", [$id]);
    }

    public function count(): int {
        return $this->db->count("SELECT COUNT(*) FROM `{$this->table}`");
    }

    public function countWhere(string $where, array $params = []): int {
        return $this->db->count("SELECT COUNT(*) FROM `{$this->table}` WHERE $where", $params);
    }
}
