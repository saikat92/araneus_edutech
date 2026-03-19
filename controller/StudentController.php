<?php
class StudentController {
    private $db;
    private $conn;

    public function __construct() {
       require_once __DIR__ . '/../includes/database.php'; 
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Add methods for fetch single student record with id
    public function getStudentById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>