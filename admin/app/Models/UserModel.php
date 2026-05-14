<?php
namespace App\Models;
use App\Core\Model;

class UserModel extends Model {
    protected string $table = 'users';

    public function findByUsername(string $username): ?array {
        return $this->db->fetch("SELECT * FROM users WHERE username=?", [$username]);
    }

    public function findByEmail(string $email): ?array {
        return $this->db->fetch("SELECT * FROM users WHERE email=?", [$email]);
    }

    public function adminExists(): bool {
        return $this->db->count("SELECT COUNT(*) FROM users WHERE role='admin'") > 0;
    }

    public function updateLastLogin(int $id): void {
        $this->db->update('users', ['last_login' => date('Y-m-d H:i:s')], 'id=?', [$id]);
    }
}
