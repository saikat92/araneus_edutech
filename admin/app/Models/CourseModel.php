<?php
namespace App\Models;
use App\Core\Model;

class CourseModel extends Model {
    protected string $table = 'courses';

    public function getActive(): array {
        return $this->db->fetchAll("SELECT * FROM courses WHERE is_active=1 ORDER BY title");
    }
}
