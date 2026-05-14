<?php
namespace App\Models;
use App\Core\Model;

class AssignmentModel extends Model {
    protected string $table = 'assignments';

    public function getWithCourse(int $limit = 30, int $offset = 0): array {
        return $this->db->fetchAll(
            "SELECT a.*, c.title as course_title FROM assignments a
             JOIN courses c ON c.id = a.course_id
             ORDER BY a.due_date ASC LIMIT $limit OFFSET $offset");
    }

    public function getByCourse(int $courseId): array {
        return $this->db->fetchAll(
            "SELECT * FROM assignments WHERE course_id=? ORDER BY due_date", [$courseId]);
    }
}
