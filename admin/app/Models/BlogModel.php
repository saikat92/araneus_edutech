<?php
namespace App\Models;
use App\Core\Model;

class BlogModel extends Model {
    protected string $table = 'blogs';

    public function findBySlug(string $slug): ?array {
        return $this->db->fetch("SELECT * FROM blogs WHERE slug=?", [$slug]);
    }
}
