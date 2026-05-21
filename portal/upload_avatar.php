<?php
// session handled by Auth.php
require_once '../controller/Auth.php';

$auth = new Auth();
if (!$auth->isLoggedIn() || $auth->getUserRole() !== 'student') {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$studentId = $auth->getStudentId();

// ── All portal uploads go into admin/uploads/ ─────────────────
// portal/upload_avatar.php → ../admin/uploads/profile_pictures/
$targetDir = dirname(__DIR__) . '/admin/uploads/profile_pictures/';
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

$response = ['success' => false];

if (!isset($_FILES['profile_picture']) || $_FILES['profile_picture']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'error' => 'No file uploaded or upload error.']);
    exit;
}

$file          = $_FILES['profile_picture'];
$ext           = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$allowedTypes  = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
$maxSize       = 3 * 1024 * 1024; // 3 MB

if (!in_array($ext, $allowedTypes)) {
    echo json_encode(['success' => false, 'error' => 'Only JPG, JPEG, PNG, GIF & WEBP files are allowed.']);
    exit;
}
if ($file['size'] > $maxSize) {
    echo json_encode(['success' => false, 'error' => 'Image too large. Max size is 3 MB.']);
    exit;
}

$fileName   = time() . '_' . $studentId . '.' . $ext;
$targetFile = $targetDir . $fileName;

if (!move_uploaded_file($file['tmp_name'], $targetFile)) {
    echo json_encode(['success' => false, 'error' => 'Failed to save image. Check folder permissions.']);
    exit;
}

// Update DB — reuse connection from Auth (which already started session + loaded config)
require_once '../includes/database.php';
$db   = new Database();
$conn = $db->getConnection();

// Delete old avatar file if it exists
$oldStmt = $conn->prepare("SELECT profile_picture FROM students WHERE id = ?");
$oldStmt->bind_param("i", $studentId);
$oldStmt->execute();
$oldRow = $oldStmt->get_result()->fetch_assoc();
$oldStmt->close();
if (!empty($oldRow['profile_picture'])) {
    $oldFile = $targetDir . $oldRow['profile_picture'];
    if (file_exists($oldFile)) @unlink($oldFile);
}

$stmt = $conn->prepare("UPDATE students SET profile_picture = ? WHERE id = ?");
$stmt->bind_param("si", $fileName, $studentId);

if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['error'] = 'Database update failed: ' . $stmt->error;
    // Clean up the uploaded file on DB failure
    @unlink($targetFile);
}
$stmt->close();
$conn->close();

echo json_encode($response);