<?php
// session handled by Auth.php
require_once '../controller/Auth.php';
require_once '../includes/database.php';

$auth = new Auth();
if (!$auth->isLoggedIn() || $auth->getUserRole() !== 'student') {
    http_response_code(403);
    echo '<p class="text-danger">Unauthorized access.</p>';
    exit;
}

$certId    = intval($_GET['id'] ?? 0);
$studentId = $auth->getStudentId();

if (!$certId) {
    echo '<p class="text-danger">Invalid certificate.</p>';
    exit;
}

$db   = new Database();
$conn = $db->getConnection();

// BUG FIX: use student_id FK instead of fragile string-match on student_name
$stmt = $conn->prepare("
    SELECT c.*, co.title AS course_title, s.full_name, s.candidate_id
    FROM certificates c
    JOIN students s  ON c.student_id = s.id
    JOIN courses co  ON c.course_name = co.title
    WHERE c.id = ? AND c.student_id = ?
");
$stmt->bind_param("ii", $certId, $studentId);
$stmt->execute();
$result = $stmt->get_result();

if ($cert = $result->fetch_assoc()) {
?>
    <div class="text-center">
        <div class="mb-3">
            <i class="fas fa-certificate fa-4x text-warning"></i>
        </div>
        <h4><?php echo htmlspecialchars($cert['certificate_id']); ?></h4>
        <p><strong>Student:</strong> <?php echo htmlspecialchars($cert['full_name']); ?></p>
        <p><strong>Course:</strong> <?php echo htmlspecialchars($cert['course_name']); ?></p>
        <p><strong>Issue Date:</strong> <?php echo date('d M Y', strtotime($cert['issue_date'])); ?></p>
        <?php if ($cert['expiry_date']): ?>
            <p><strong>Expiry Date:</strong> <?php echo date('d M Y', strtotime($cert['expiry_date'])); ?></p>
        <?php endif; ?>
        <p>
            <strong>Status:</strong>
            <span class="badge bg-<?php echo $cert['status'] === 'active' ? 'success' : 'secondary'; ?>">
                <?php echo ucfirst($cert['status']); ?>
            </span>
        </p>
        <?php if (!empty($cert['file_path'])): ?>
            <a href="<?php echo defined('SITE_URL') ? SITE_URL . $cert['file_path'] : '../' . $cert['file_path']; ?>"
               class="btn btn-primary" download>
                <i class="fas fa-download me-1"></i> Download PDF
            </a>
        <?php endif; ?>
    </div>
<?php
} else {
    echo '<p class="text-danger">Certificate not found or access denied.</p>';
}
$stmt->close();
