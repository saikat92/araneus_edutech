<?php
session_start();
require_once '../controller/Auth.php';
require_once '../includes/Database.php';

$auth = new Auth();
if (!$auth->isLoggedIn() || $auth->getUserRole() !== 'student') {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$studentId = $auth->getStudentId();
$data = $_POST;

// Basic validation
$required = ['full_name', 'phone', 'email'];
foreach ($required as $field) {
    if (empty($data[$field])) {
        echo json_encode(['success' => false, 'error' => ucfirst($field) . ' is required.']);
        exit;
    }
}

$db = new Database();
$conn = $db->getConnection();

// Check email uniqueness (exclude current student)
$check = $conn->prepare("SELECT id FROM students WHERE email = ? AND id != ?");
$check->bind_param("si", $data['email'], $studentId);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    echo json_encode(['success' => false, 'error' => 'Email already in use by another student.']);
    $check->close();
    $conn->close();
    exit;
}
$check->close();

// Update query
$query = "UPDATE students SET 
    full_name = ?, 
    phone = ?, 
    email = ?, 
    father_name = ?, 
    address = ?, 
    highest_qualification = ?, 
    current_organization = ?, 
    org_i_card = ?, 
    github_link = ? 
    WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param(
    "sssssssssi",
    $data['full_name'],
    $data['phone'],
    $data['email'],
    $data['father_name'],
    $data['address'],
    $data['highest_qualification'],
    $data['current_organization'],
    $data['org_i_card'],
    $data['github_link'],
    $studentId
);

$response = ['success' => false];
if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['error'] = 'Database error: ' . $stmt->error;
}
$stmt->close();
$conn->close();

echo json_encode($response);