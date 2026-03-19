<?php
session_start();
require_once '../controller/Auth.php';
require_once '../includes/Database.php';

$auth = new Auth();
if (!$auth->isLoggedIn() || $auth->getUserRole() !== 'student') {
    http_response_code(403);
    exit;
}

$certId = $_GET['id'] ?? 0;
if (!$certId) {
    echo '<p class="text-danger">Invalid certificate.</p>';
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("
    SELECT c.*, s.full_name, s.candidate_id, co.title AS course_title
    FROM certificates c
    JOIN students s ON c.student_name = s.full_name  -- adjust if needed
    JOIN courses co ON c.course_name = co.title
    WHERE c.id = ?
");
$stmt->bind_param("i", $certId);
$stmt->execute();
$result = $stmt->get_result();
if ($cert = $result->fetch_assoc()) {
    ?>
    <div class="text-center">
        <h4><?php echo htmlspecialchars($cert['certificate_id']); ?></h4>
        <p><strong>Student:</strong> <?php echo htmlspecialchars($cert['student_name']); ?></p>
        <p><strong>Course:</strong> <?php echo htmlspecialchars($cert['course_name']); ?></p>
        <p><strong>Issue Date:</strong> <?php echo date('d M Y', strtotime($cert['issue_date'])); ?></p>
        <?php if ($cert['expiry_date']): ?>
            <p><strong>Expiry Date:</strong> <?php echo date('d M Y', strtotime($cert['expiry_date'])); ?></p>
        <?php endif; ?>
        <p><strong>Status:</strong> <?php echo ucfirst($cert['status']); ?></p>
        <?php if (!empty($cert['file_path'])): ?>
            <a href="<?php echo SITE_URL . $cert['file_path']; ?>" class="btn btn-primary" download>Download PDF</a>
        <?php endif; ?>
    </div>
    <?php
} else {
    echo '<p class="text-danger">Certificate not found.</p>';
}
$stmt->close();
$conn->close();