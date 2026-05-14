<?php
namespace App\Models;
use App\Core\Model;

class ProjectModel extends Model {
    protected string $table = 'projects';

    /** All published projects ordered by sort_order */
    public function findPublished(): array {
        return $this->db->fetchAll(
            "SELECT * FROM `projects` WHERE status = 'published' ORDER BY sort_order ASC, id ASC"
        );
    }

    /** Distinct categories for filter pills */
    public function getCategories(): array {
        return $this->db->fetchAll(
            "SELECT DISTINCT category FROM `projects` WHERE status = 'published' ORDER BY category ASC"
        );
    }
}
