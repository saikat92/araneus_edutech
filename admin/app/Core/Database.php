<?php
namespace App\Core;

class Database {
    private static ?Database $instance = null;
    private \PDO $pdo;

    private function __construct() {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->pdo = new \PDO($dsn, DB_USER, DB_PASS, $options);
    }

    public static function getInstance(): Database {
        if (self::$instance === null) self::$instance = new self();
        return self::$instance;
    }

    public function query(string $sql, array $params = []): \PDOStatement {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function fetchAll(string $sql, array $params = []): array {
        return $this->query($sql, $params)->fetchAll();
    }

    public function fetch(string $sql, array $params = []): ?array {
        $row = $this->query($sql, $params)->fetch();
        return $row ?: null;
    }

    public function insert(string $table, array $data): int {
        $cols = implode(',', array_map(fn($k) => "`$k`", array_keys($data)));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $this->query("INSERT INTO `$table` ($cols) VALUES ($placeholders)", array_values($data));
        return (int)$this->pdo->lastInsertId();
    }

    public function update(string $table, array $data, string $where, array $whereParams = []): int {
        $sets = implode(',', array_map(fn($k) => "`$k`=?", array_keys($data)));
        $stmt = $this->query("UPDATE `$table` SET $sets WHERE $where", array_merge(array_values($data), $whereParams));
        return $stmt->rowCount();
    }

    public function delete(string $table, string $where, array $params = []): int {
        return $this->query("DELETE FROM `$table` WHERE $where", $params)->rowCount();
    }

    public function count(string $sql, array $params = []): int {
        return (int)$this->query($sql, $params)->fetchColumn();
    }

    public function getPdo(): \PDO { return $this->pdo; }
}
