<?php
namespace App\Models;
use App\Core\Model;

class AssignmentModel extends Model {
    protected string $table = 'assignments';

    public function getFiltered(int $limit, int $offset, array $filters = []): array {
        $where  = ['1=1'];
        $params = [];

        if (!empty($filters['course_id'])) {
            $where[] = 'a.course_id = ?';
            $params[] = (int)$filters['course_id'];
        }
        if (!empty($filters['search'])) {
            $where[] = '(a.title LIKE ? OR a.description LIKE ?)';
            $s = '%' . $filters['search'] . '%';
            $params[] = $s; $params[] = $s;
        }
        if (!empty($filters['due_filter'])) {
            switch ($filters['due_filter']) {
                case 'overdue':  $where[] = 'a.due_date < CURDATE()'; break;
                case 'today':    $where[] = 'a.due_date = CURDATE()'; break;
                case 'week':     $where[] = 'a.due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)'; break;
                case 'upcoming': $where[] = 'a.due_date > CURDATE()'; break;
                case 'noduedate':$where[] = 'a.due_date IS NULL'; break;
            }
        }

        $allowedSort = ['a.due_date', 'a.title', 'a.created_at', 'c.title'];
        $sort  = in_array($filters['sort'] ?? '', $allowedSort) ? $filters['sort'] : 'a.due_date';
        $order = ($filters['order'] ?? 'asc') === 'desc' ? 'DESC' : 'ASC';
        $whereStr = implode(' AND ', $where);

        return $this->db->fetchAll(
            "SELECT a.*,
                    c.title as course_title,
                    COUNT(sub.id) as submission_count,
                    SUM(CASE WHEN sub.grade IS NOT NULL THEN 1 ELSE 0 END) as graded_count
             FROM assignments a
             JOIN courses c ON c.id = a.course_id
             LEFT JOIN submissions sub ON sub.assignment_id = a.id
             WHERE $whereStr
             GROUP BY a.id
             ORDER BY $sort $order, a.id ASC
             LIMIT $limit OFFSET $offset",
            $params
        );
    }

    public function countFiltered(array $filters = []): int {
        $where  = ['1=1'];
        $params = [];

        if (!empty($filters['course_id'])) {
            $where[] = 'a.course_id = ?';
            $params[] = (int)$filters['course_id'];
        }
        if (!empty($filters['search'])) {
            $where[] = '(a.title LIKE ? OR a.description LIKE ?)';
            $s = '%' . $filters['search'] . '%';
            $params[] = $s; $params[] = $s;
        }
        if (!empty($filters['due_filter'])) {
            switch ($filters['due_filter']) {
                case 'overdue':  $where[] = 'a.due_date < CURDATE()'; break;
                case 'today':    $where[] = 'a.due_date = CURDATE()'; break;
                case 'week':     $where[] = 'a.due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)'; break;
                case 'upcoming': $where[] = 'a.due_date > CURDATE()'; break;
                case 'noduedate':$where[] = 'a.due_date IS NULL'; break;
            }
        }

        $whereStr = implode(' AND ', $where);
        return $this->db->count(
            "SELECT COUNT(*) FROM assignments a
             JOIN courses c ON c.id = a.course_id
             WHERE $whereStr",
            $params
        );
    }

    public function getStats(): array {
        return $this->db->fetch(
            "SELECT
                COUNT(*) as total,
                SUM(CASE WHEN due_date < CURDATE() THEN 1 ELSE 0 END) as overdue,
                SUM(CASE WHEN due_date = CURDATE() THEN 1 ELSE 0 END) as due_today,
                SUM(CASE WHEN due_date BETWEEN DATE_ADD(CURDATE(), INTERVAL 1 DAY)
                              AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) THEN 1 ELSE 0 END) as due_week,
                SUM(CASE WHEN due_date IS NULL THEN 1 ELSE 0 END) as no_due_date
             FROM assignments"
        ) ?? [];
    }

    public function getByCourse(int $courseId): array {
        return $this->db->fetchAll(
            "SELECT * FROM assignments WHERE course_id=? ORDER BY due_date", [$courseId]);
    }

    // Keep backward compat
    public function getWithCourse(int $limit = 30, int $offset = 0): array {
        return $this->getFiltered($limit, $offset);
    }
}