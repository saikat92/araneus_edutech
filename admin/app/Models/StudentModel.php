<?php
namespace App\Models;
use App\Core\Model;

class StudentModel extends Model {
    protected string $table = 'students';

    public function findWithCourse(int $id): ?array {
        return $this->db->fetch(
            "SELECT s.*, c.title as course_title, e.status as enrollment_status 
             FROM students s
             LEFT JOIN enrollments e ON e.student_id = s.id
             LEFT JOIN courses c ON c.id = e.course_id
             WHERE s.id = ?", [$id]);
    }

    public function searchAll(string $search = '', string $status = '', int $limit = 20, int $offset = 0): array {
        $where = '1=1';
        $params = [];
        if ($search) {
            $where .= " AND (full_name LIKE ? OR email LIKE ? OR candidate_id LIKE ? OR phone LIKE ?)";
            $s = "%$search%";
            array_push($params, $s, $s, $s, $s);
        }
        if ($status) { $where .= " AND status=?"; $params[] = $status; }
        return $this->db->fetchAll(
            "SELECT * FROM students WHERE $where ORDER BY created_at DESC LIMIT $limit OFFSET $offset", $params);
    }

    public function countSearch(string $search = '', string $status = ''): int {
        $where = '1=1'; $params = [];
        if ($search) {
            $where .= " AND (full_name LIKE ? OR email LIKE ? OR candidate_id LIKE ? OR phone LIKE ?)";
            $s = "%$search%"; array_push($params, $s, $s, $s, $s);
        }
        if ($status) { $where .= " AND status=?"; $params[] = $status; }
        return $this->db->count("SELECT COUNT(*) FROM students WHERE $where", $params);
    }
}
