<?php
session_start();
require_once '../controller/Auth.php';
require_once '../includes/Database.php';

header('Content-Type: application/json');

$auth = new Auth();
if (!$auth->isLoggedIn() || $auth->getUserRole() !== 'student') {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$studentId = $auth->getStudentId();
$courseId = $_POST['course_id'] ?? 0;
$notes = $_POST['notes'] ?? '';

if (!$courseId) {
    echo json_encode(['success' => false, 'error' => 'Course ID required']);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

// Check if already enrolled
$check = $conn->prepare("SELECT id FROM enrollments WHERE student_id = ? AND course_id = ?");
$check->bind_param("ii", $studentId, $courseId);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    echo json_encode(['success' => false, 'error' => 'Already enrolled in this course']);
    $check->close();
    $conn->close();
    exit;
}
$check->close();

// Insert enrollment
$enrollDate = date('Y-m-d');
$status = 'enrolled';
$stmt = $conn->prepare("INSERT INTO enrollments (student_id, course_id, enrollment_date, status, notes) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iisss", $studentId, $courseId, $enrollDate, $status, $notes);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}
$stmt->close();
$conn->close();