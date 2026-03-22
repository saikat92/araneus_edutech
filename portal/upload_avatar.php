<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once '../controller/Auth.php';
require_once '../controller/StudentController.php';
require_once '../includes/Database.php';

$auth = new Auth();
if (!$auth->isLoggedIn() || $auth->getUserRole() !== 'student') {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$studentId = $auth->getStudentId();
$targetDir = '../uploads/profile_pictures/';
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

$response = ['success' => false];
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $fileTmp = $_FILES['profile_picture']['tmp_name'];
    $fileName = time() . '_' . basename($_FILES['profile_picture']['name']);
    $targetFile = $targetDir . $fileName;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($imageFileType, $allowedTypes)) {
        if (move_uploaded_file($fileTmp, $targetFile)) {
            // Update database
            $db = new Database();
            $conn = $db->getConnection();
            $stmt = $conn->prepare("UPDATE students SET profile_picture = ? WHERE id = ?");
            $stmt->bind_param("si", $fileName, $studentId);
            if ($stmt->execute()) {
                $response['success'] = true;
            } else {
                $response['error'] = 'Database update failed';
            }
            $stmt->close();
            $conn->close();
        } else {
            $response['error'] = 'Failed to move uploaded file.';
        }
    } else {
        $response['error'] = 'Only JPG, JPEG, PNG & GIF files are allowed.';
    }
} else {
    $response['error'] = 'No file uploaded or upload error.';
}

echo json_encode($response);