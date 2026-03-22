<?php
$page_title = "My Certificates";
require_once 'includes/header.php';

// Fetch certificates using proper student_id FK
$stmt = $conn->prepare("
    SELECT
        c.id,
        c.certificate_id,
        c.course_name,
        c.issue_date,
        c.expiry_date,
        c.status,
        c.file_path,
        c.qr_code,
        co.title     AS course_title,
        co.instructor,
        co.duration
    FROM certificates c
    LEFT JOIN courses co ON co.title = c.course_name
    WHERE c.student_id = ?
    ORDER BY c.issue_date DESC
");
$stmt->bind_param("i", $studentId);
$stmt->execute();
$result = $stmt->get_result();
$certificates = [];
while ($row = $result->fetch_assoc()) {
    $certificates[] = $row;
}
$stmt->close();

// Also fetch completed-but-not-yet-issued enrollments to show "pending" certificates
$pendingStmt = $conn->prepare("
    SELECT e.id AS enrollment_id, c.title AS course_name, e.completion_date, e.grade
    FROM enrollments e
    JOIN courses c ON e.course_id = c.id
    WHERE e.student_id = ? AND e.status = 'completed' AND e.certificate_issued = 0
");
$pendingStmt->bind_param("i", $studentId);
$pendingStmt->execute();
$pendingResult = $pendingStmt->get_result();
$pendingCerts  = [];
while ($row = $pendingResult->fetch_assoc()) {
    $pendingCerts[] = $row;
}
$pendingStmt->close();
?>

<section class="py-5">
<div class="container">

    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="fas fa-certificate me-2 text-warning"></i>My Certificates</h2>
            <p class="text-muted mb-0">Download and verify your earned certificates</p>
        </div>
        <a href="dashboard.php" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Dashboard
        </a>
    </div>

    <!-- Summary -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm text-center h-100">
                <div class="card-body py-3">
                    <i class="fas fa-certificate fa-2x text-warning mb-2"></i>
                    <h4 class="mb-0"><?php echo count($certificates); ?></h4>
                    <small class="text-muted">Issued</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm text-center h-100">
                <div class="card-body py-3">
                    <i class="fas fa-hourglass-half fa-2x text-info mb-2"></i>
                    <h4 class="mb-0"><?php echo count($pendingCerts); ?></h4>
                    <small class="text-muted">Pending issue</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm text-center h-100">
                <div class="card-body py-3">
                    <i class="fas fa-check-double fa-2x text-success mb-2"></i>
                    <h4 class="mb-0">
                        <?php echo count(array_filter($certificates, fn($c) => $c['status'] === 'active')); ?>
                    </h4>
                    <small class="text-muted">Active</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Issued certificates -->
    <?php if (!empty($certificates)): ?>
    <h5 class="mb-3"><i class="fas fa-award me-2 text-warning"></i>Issued Certificates</h5>
    <div class="row g-4 mb-5">
        <?php foreach ($certificates as $cert): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <!-- Certificate header strip -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center me-3"
                             style="width:50px;height:50px;flex-shrink:0;">
                            <i class="fas fa-certificate text-warning fa-lg"></i>
                        </div>
                        <div>
                            <div class="fw-semibold text-truncate" style="max-width:180px;"
                                 title="<?php echo htmlspecialchars($cert['course_name']); ?>">
                                <?php echo htmlspecialchars($cert['course_name']); ?>
                            </div>
                            <small class="text-muted"><?php echo htmlspecialchars($cert['instructor'] ?? ''); ?></small>
                        </div>
                    </div>

                    <table class="table table-sm table-borderless mb-3 small">
                        <tr>
                            <td class="text-muted ps-0">Certificate ID</td>
                            <td class="fw-semibold text-end">
                                <code><?php echo htmlspecialchars($cert['certificate_id']); ?></code>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Issue Date</td>
                            <td class="text-end"><?php echo date('d M Y', strtotime($cert['issue_date'])); ?></td>
                        </tr>
                        <?php if ($cert['expiry_date']): ?>
                        <tr>
                            <td class="text-muted ps-0">Expiry Date</td>
                            <td class="text-end"><?php echo date('d M Y', strtotime($cert['expiry_date'])); ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td class="text-muted ps-0">Status</td>
                            <td class="text-end">
                                <span class="badge bg-<?php
                                    echo $cert['status'] === 'active' ? 'success' : ($cert['status'] === 'expired' ? 'warning' : 'danger');
                                ?>">
                                    <?php echo ucfirst($cert['status']); ?>
                                </span>
                            </td>
                        </tr>
                    </table>

                    <div class="d-flex gap-2 flex-wrap">
                        <?php if (!empty($cert['file_path'])): ?>
                        <a href="<?php echo htmlspecialchars(SITE_URL . $cert['file_path']); ?>"
                           class="btn btn-primary btn-sm flex-fill" download>
                            <i class="fas fa-download me-1"></i> Download
                        </a>
                        <?php endif; ?>
                        <button class="btn btn-outline-secondary btn-sm flex-fill"
                                onclick="copyCertId('<?php echo htmlspecialchars($cert['certificate_id']); ?>')">
                            <i class="fas fa-copy me-1"></i> Copy ID
                        </button>
                    </div>

                    <?php if (!empty($cert['qr_code'])): ?>
                    <div class="text-center mt-3">
                        <img src="<?php echo htmlspecialchars(SITE_URL . $cert['qr_code']); ?>"
                             alt="QR Code" width="80" height="80" class="rounded">
                        <div class="text-muted" style="font-size:10px;">Scan to verify</div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Pending certificates -->
    <?php if (!empty($pendingCerts)): ?>
    <h5 class="mb-3"><i class="fas fa-hourglass-half me-2 text-info"></i>Pending Certificate Issue</h5>
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Course</th>
                            <th>Completion Date</th>
                            <th>Grade</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($pendingCerts as $p): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($p['course_name']); ?></td>
                            <td><?php echo $p['completion_date'] ? date('d M Y', strtotime($p['completion_date'])) : '—'; ?></td>
                            <td>
                                <?php if ($p['grade']): ?>
                                    <span class="badge bg-success"><?php echo htmlspecialchars($p['grade']); ?></span>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    <i class="fas fa-hourglass-half me-1"></i>Awaiting issue
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <p class="text-muted small mb-4">
        <i class="fas fa-info-circle me-1"></i>
        Certificates for completed courses are issued by the admin. Please contact
        <a href="mailto:<?php echo SITE_EMAIL; ?>"><?php echo SITE_EMAIL; ?></a> if your certificate is delayed.
    </p>
    <?php endif; ?>

    <!-- Empty state -->
    <?php if (empty($certificates) && empty($pendingCerts)): ?>
    <div class="card border-0 shadow-sm text-center py-5">
        <div class="card-body">
            <i class="fas fa-certificate fa-4x text-muted mb-3"></i>
            <h5 class="text-muted">No certificates yet</h5>
            <p class="text-muted">Complete a course to earn your certificate.</p>
            <a href="dashboard.php" class="btn btn-primary">Go to Dashboard</a>
        </div>
    </div>
    <?php endif; ?>

    <!-- Verification note -->
    <div class="alert alert-light border mt-2">
        <i class="fas fa-shield-alt me-2 text-success"></i>
        <strong>Verification:</strong> All Araneus Edutech certificates can be verified at
        <a href="<?php echo SITE_URL; ?>certificates.php" target="_blank"><?php echo SITE_URL; ?>certificates.php</a>
        using the Certificate ID.
    </div>

</div>
</section>

<!-- Toast for copy feedback -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index:9999">
    <div id="copyToast" class="toast align-items-center text-white bg-success border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body"><i class="fas fa-check me-2"></i>Certificate ID copied!</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<script>
function copyCertId(id) {
    navigator.clipboard.writeText(id).then(function() {
        var toast = new bootstrap.Toast(document.getElementById('copyToast'));
        toast.show();
    });
}
</script>

<?php require_once 'includes/footer.php'; ?>
