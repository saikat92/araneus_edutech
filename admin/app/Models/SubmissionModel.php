<?php
namespace App\Models;
use App\Core\Model;

class SubmissionModel extends Model {
    protected string $table = 'submissions';

    public function getWithDetails(int $limit = 20, int $offset = 0): array {
        return $this->db->fetchAll(
            "SELECT sub.*, s.full_name, s.candidate_id, a.title as assignment_title,
                    c.title as course_title
             FROM submissions sub
             JOIN students s ON s.id = sub.student_id
             JOIN assignments a ON a.id = sub.assignment_id
             JOIN courses c ON c.id = a.course_id
             ORDER BY sub.submitted_at DESC LIMIT $limit OFFSET $offset");
    }

    public function findWithDetail(int $id): ?array {
        return $this->db->fetch(
            "SELECT sub.*, s.full_name, s.candidate_id, s.email,
                    a.title as assignment_title, a.description as assignment_desc,
                    c.title as course_title
             FROM submissions sub
             JOIN students s ON s.id=sub.student_id
             JOIN assignments a ON a.id=sub.assignment_id
             JOIN courses c ON c.id=a.course_id
             WHERE sub.id=?", [$id]);
    }

    public function countPending(): int {
        return $this->db->count("SELECT COUNT(*) FROM submissions WHERE grade IS NULL");
    }
}
