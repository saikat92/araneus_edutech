<?php
// session handled by Auth.php
require_once '../controller/Auth.php';
require_once '../includes/database.php';

header('Content-Type: application/json');

$auth = new Auth();
if (!$auth->isLoggedIn() || $auth->getUserRole() !== 'student') {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$studentId = $auth->getStudentId();
$courseId  = intval($_POST['course_id'] ?? 0);
$notes     = trim($_POST['notes'] ?? '');

if (!$courseId) {
    echo json_encode(['success' => false, 'error' => 'Course ID required']);
    exit;
}

// Single DB connection
$db   = new Database();
$conn = $db->getConnection();

// Check if already enrolled
$check = $conn->prepare("SELECT id FROM enrollments WHERE student_id = ? AND course_id = ?");
$check->bind_param("ii", $studentId, $courseId);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    echo json_encode(['success' => false, 'error' => 'Already enrolled in this course']);
    $check->close();
    exit;
}
$check->close();

// Verify course exists and is active
$courseCheck = $conn->prepare("SELECT id FROM courses WHERE id = ? AND is_active = 1");
$courseCheck->bind_param("i", $courseId);
$courseCheck->execute();
$courseCheck->store_result();
if ($courseCheck->num_rows === 0) {
    echo json_encode(['success' => false, 'error' => 'Course not found or inactive']);
    $courseCheck->close();
    exit;
}
$courseCheck->close();

// Insert enrollment
$enrollDate = date('Y-m-d');
$status     = 'enrolled';
$stmt = $conn->prepare("INSERT INTO enrollments (student_id, course_id, enrollment_date, status, notes) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iisss", $studentId, $courseId, $enrollDate, $status, $notes);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Enrolled successfully!']);
} else {
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $stmt->error]);
}
$stmt->close();
