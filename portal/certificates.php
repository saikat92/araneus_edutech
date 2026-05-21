<?php
$page_title = "My Certificates";
require_once 'includes/header.php';

// ── Fetch certificates from live admin schema ─────────────────
// Admin CertificateController writes: program_name, qr_code_path,
// issued_date, status='issued', student_id, certificate_id
// (not: course_name, qr_code, issue_date, file_path from old schema)
$stmt = $conn->prepare("
    SELECT
        c.id,
        c.certificate_id,
        c.program_name,
        c.issued_date,
        c.status,
        c.qr_code_path,
        c.enrollment_id
    FROM certificates c
    WHERE c.student_id = ?
    ORDER BY c.issued_date DESC
");
$stmt->bind_param("i", $studentId);
$stmt->execute();
$result       = $stmt->get_result();
$certificates = [];
while ($row = $result->fetch_assoc()) {
    $certificates[] = $row;
}
$stmt->close();

// ── Completed enrollments without a certificate yet ───────────
$pendingStmt = $conn->prepare("
    SELECT e.id AS enrollment_id, c.title AS program_name, e.completion_date, e.grade
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

// QR image base URL — admin saves QR files to admin/uploads/qrcodes/
$qrBaseUrl = SITE_URL . 'admin/uploads/qrcodes/';
?>

<div class="portal-breadcrumb">
    <a href="dashboard.php">Dashboard</a>
    <span class="sep">/</span>
    <span class="current">My Certificates</span>
</div>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="fas fa-certificate me-2 text-warning"></i>My Certificates</h4>
        <p class="text-muted mb-0 small">Download and verify your earned certificates</p>
    </div>
</div>

<!-- Summary tiles -->
<div class="row g-3 mb-4">
    <?php foreach ([
        ['fas fa-certificate fa-2x text-warning', count($certificates),                                           'Issued'],
        ['fas fa-hourglass-half fa-2x text-info',  count($pendingCerts),                                          'Pending Issue'],
        ['fas fa-check-double fa-2x text-success',  count(array_filter($certificates, fn($c)=>$c['status']==='issued')), 'Active'],
    ] as [$icon, $num, $label]): ?>
    <div class="col-6 col-md-4">
        <div class="stat-tile">
            <div class="stat-tile-icon" style="background:#f8f9fa;">
                <i class="<?= $icon ?>"></i>
            </div>
            <div>
                <div class="stat-tile-num"><?= $num ?></div>
                <div class="stat-tile-label"><?= $label ?></div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- ── Issued certificates ─────────────────────────────────── -->
<?php if (!empty($certificates)): ?>
<h5 class="fw-bold mb-3"><i class="fas fa-award me-2 text-warning"></i>Issued Certificates</h5>
<div class="row g-4 mb-4">
    <?php foreach ($certificates as $cert): ?>
    <div class="col-md-6 col-lg-4">
        <div class="p-card h-100">
            <div class="p-card-body">

                <!-- Header -->
                <div class="d-flex align-items-center mb-3 gap-3">
                    <div style="width:50px;height:50px;border-radius:50%;background:rgba(255,169,0,.12);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-certificate text-warning fa-lg"></i>
                    </div>
                    <div>
                        <div class="fw-semibold text-truncate" style="max-width:180px;"
                             title="<?= htmlspecialchars($cert['program_name']) ?>">
                            <?= htmlspecialchars($cert['program_name']) ?>
                        </div>
                        <small class="text-muted">
                            <?= $cert['issued_date'] ? date('d M Y', strtotime($cert['issued_date'])) : '—' ?>
                        </small>
                    </div>
                </div>

                <!-- Details table -->
                <table class="table table-sm table-borderless mb-3 small">
                    <tr>
                        <td class="text-muted ps-0">Certificate ID</td>
                        <td class="fw-semibold text-end">
                            <code><?= htmlspecialchars($cert['certificate_id']) ?></code>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-0">Issue Date</td>
                        <td class="text-end">
                            <?= $cert['issued_date'] ? date('d M Y', strtotime($cert['issued_date'])) : '—' ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-0">Status</td>
                        <td class="text-end">
                            <?php
                            $statusColor = match($cert['status']) {
                                'issued'  => 'success',
                                'active'  => 'success',
                                'revoked' => 'danger',
                                'expired' => 'warning',
                                default   => 'secondary'
                            };
                            ?>
                            <span class="badge bg-<?= $statusColor ?>">
                                <?= ucfirst($cert['status']) ?>
                            </span>
                        </td>
                    </tr>
                </table>

                <!-- Action buttons -->
                <div class="d-flex gap-2 flex-wrap mb-3">
                    <!-- View / Print certificate (admin public print route) -->
                    <?php if (!empty($cert['id'])): ?>
                    <a href="<?= defined('ADMIN_APP_URL') ? ADMIN_APP_URL : SITE_URL.'admin/public' ?>/certificates/<?= $cert['id'] ?>/print"
                       target="_blank"
                       class="btn btn-primary btn-sm flex-fill">
                        <i class="fas fa-print me-1"></i> View & Print
                    </a>
                    <?php endif; ?>
                    <button class="btn btn-outline-secondary btn-sm flex-fill"
                            onclick="copyCertId('<?= htmlspecialchars($cert['certificate_id']) ?>')">
                        <i class="fas fa-copy me-1"></i> Copy ID
                    </button>
                </div>

                <!-- QR Code -->
                <?php if (!empty($cert['qr_code_path'])): ?>
                <div class="text-center">
                    <img src="<?= $qrBaseUrl . htmlspecialchars($cert['qr_code_path']) ?>"
                         alt="QR Code" width="80" height="80" class="rounded"
                         onerror="this.style.display='none'">
                    <div class="text-muted mt-1" style="font-size:.68rem;">Scan to verify</div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- ── Pending certificates ───────────────────────────────── -->
<?php if (!empty($pendingCerts)): ?>
<h5 class="fw-bold mb-3"><i class="fas fa-hourglass-half me-2 text-info"></i>Pending Certificate Issue</h5>
<div class="p-card mb-4">
    <div style="overflow-x:auto;">
        <table class="table table-hover mb-0" style="font-size:.85rem;">
            <thead style="background:#f8f9fa;">
                <tr>
                    <th style="padding:10px 16px;font-weight:600;color:#888;font-size:.75rem;">Program</th>
                    <th style="padding:10px 16px;font-weight:600;color:#888;font-size:.75rem;">Completion Date</th>
                    <th style="padding:10px 16px;font-weight:600;color:#888;font-size:.75rem;">Grade</th>
                    <th style="padding:10px 16px;font-weight:600;color:#888;font-size:.75rem;">Status</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($pendingCerts as $p): ?>
                <tr>
                    <td style="padding:10px 16px;vertical-align:middle;font-weight:500;">
                        <?= htmlspecialchars($p['program_name']) ?>
                    </td>
                    <td style="padding:10px 16px;vertical-align:middle;color:#888;">
                        <?= $p['completion_date'] ? date('d M Y', strtotime($p['completion_date'])) : '—' ?>
                    </td>
                    <td style="padding:10px 16px;vertical-align:middle;">
                        <?php if ($p['grade']): ?>
                            <span class="badge bg-success rounded-pill"><?= htmlspecialchars($p['grade']) ?></span>
                        <?php else: ?>
                            <span class="text-muted">—</span>
                        <?php endif; ?>
                    </td>
                    <td style="padding:10px 16px;vertical-align:middle;">
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
<p class="text-muted small">
    <i class="fas fa-info-circle me-1"></i>
    Certificates are issued by the admin. Contact
    <a href="mailto:<?= SITE_EMAIL ?>"><?= SITE_EMAIL ?></a> if your certificate is delayed.
</p>
<?php endif; ?>

<!-- Empty state -->
<?php if (empty($certificates) && empty($pendingCerts)): ?>
<div class="p-card text-center" style="padding:48px 24px;">
    <i class="fas fa-certificate fa-4x text-muted mb-3 d-block opacity-25"></i>
    <h5 class="text-muted fw-semibold mb-2">No certificates yet</h5>
    <p class="text-muted small mb-3">Complete a course to earn your first certificate.</p>
    <a href="dashboard.php" class="btn btn-primary btn-sm">Go to Dashboard</a>
</div>
<?php endif; ?>

<!-- Verification note -->
<div class="alert alert-light border mt-3" style="border-radius:10px;">
    <i class="fas fa-shield-alt me-2 text-success"></i>
    <strong>Verify:</strong> All Araneus Edutech certificates can be verified at
    <a href="<?= SITE_URL ?>pages/certificates.php" target="_blank"><?= SITE_URL ?>pages/certificates.php</a>
    using the Certificate ID.
</div>

<!-- Copy toast -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index:9999">
    <div id="copyToast" class="toast align-items-center text-white bg-success border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body small"><i class="fas fa-check me-2"></i>Certificate ID copied!</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<script>
function copyCertId(id) {
    navigator.clipboard.writeText(id).then(function() {
        new bootstrap.Toast(document.getElementById('copyToast')).show();
    }).catch(function() {
        var el = document.createElement('textarea');
        el.value = id; document.body.appendChild(el);
        el.select(); document.execCommand('copy');
        document.body.removeChild(el);
        new bootstrap.Toast(document.getElementById('copyToast')).show();
    });
}
</script>

<?php require_once 'includes/footer.php'; ?>