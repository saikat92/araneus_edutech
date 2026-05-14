<?php
namespace App\Models;
use App\Core\Model;

class EnrollmentModel extends Model {
    protected string $table = 'enrollments';

    public function getWithDetails(int $limit = 20, int $offset = 0): array {
        return $this->db->fetchAll(
            "SELECT e.*, s.full_name, s.candidate_id, s.email, c.title as course_title
             FROM enrollments e
             JOIN students s ON s.id = e.student_id
             LEFT JOIN courses c ON c.id = e.course_id
             ORDER BY e.created_at DESC LIMIT $limit OFFSET $offset");
    }

    public function getByStudent(int $studentId): array {
        return $this->db->fetchAll(
            "SELECT e.*, c.title as course_title FROM enrollments e
             LEFT JOIN courses c ON c.id = e.course_id
             WHERE e.student_id=?", [$studentId]);
    }

    public function findWithDetail(int $id): ?array {
        return $this->db->fetch(
            "SELECT e.*, s.full_name, s.candidate_id, c.title as course_title
             FROM enrollments e
             JOIN students s ON s.id=e.student_id
             LEFT JOIN courses c ON c.id=e.course_id
             WHERE e.id=?", [$id]);
    }
}
