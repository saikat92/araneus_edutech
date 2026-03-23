<?php
$page_title = "Course Details";
require_once 'includes/header.php';

// ── Filesystem root derived from __DIR__ (no SITE_ROOT needed) ──
// portal/course-view.php  →  __DIR__ = .../araneus_edutech/portal
// uploads live at         →  .../araneus_edutech/uploads/
define('UPLOAD_ROOT', dirname(__DIR__) . '/uploads/');

$enrollmentId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$enrollmentId) {
    echo '<div class="alert alert-danger m-4">Invalid course access.</div>';
    require_once 'includes/footer.php'; exit;
}

// ── Fetch enrollment + course ────────────────────────────────────
$enrollStmt = $conn->prepare("
    SELECT e.*, c.id AS course_id, c.title, c.description, c.duration,
           c.instructor, c.tools_provided, c.hardware_kit, c.syllabus_file
    FROM enrollments e
    JOIN courses c ON e.course_id = c.id
    WHERE e.id = ? AND e.student_id = ?
");
$enrollStmt->bind_param("ii", $enrollmentId, $studentId);
$enrollStmt->execute();
$enrollment = $enrollStmt->get_result()->fetch_assoc();
$enrollStmt->close();

if (!$enrollment) {
    echo '<div class="alert alert-danger m-4">Course not found or access denied.</div>';
    require_once 'includes/footer.php'; exit;
}
$courseId      = $enrollment['course_id'];
$projectReport = $enrollment['project_report'];

// ── Fetch assignments into array (avoids pointer issues) ─────────
$assignStmt = $conn->prepare("SELECT * FROM assignments WHERE course_id = ? ORDER BY due_date ASC");
$assignStmt->bind_param("i", $courseId);
$assignStmt->execute();
$assignmentsAll = $assignStmt->get_result()->fetch_all(MYSQLI_ASSOC);
$assignStmt->close();

// ── Fetch this student's submissions (keyed by assignment_id) ────
$submissions = [];
$subStmt = $conn->prepare(
    "SELECT assignment_id, submission_file, grade, feedback, submitted_at
     FROM submissions WHERE student_id = ?"
);
$subStmt->bind_param("i", $studentId);
$subStmt->execute();
$subRes = $subStmt->get_result();
while ($row = $subRes->fetch_assoc()) {
    $submissions[$row['assignment_id']] = $row;
}
$subStmt->close();

// ── Fetch attendance for this course ────────────────────────────
$attStmt = $conn->prepare(
    "SELECT date, hours FROM attendance WHERE student_id = ? AND course_id = ? ORDER BY date DESC"
);
$attStmt->bind_param("ii", $studentId, $courseId);
$attStmt->execute();
$attRes         = $attStmt->get_result();
$totalHours     = 0;
$attendanceList = [];
while ($row = $attRes->fetch_assoc()) {
    $totalHours += $row['hours'];
    $attendanceList[] = $row;
}
$attStmt->close();

// ── Fetch certificate if issued ──────────────────────────────────
// enrollments.certificate_id stores the cert code (varchar 50)
// certificates.certificate_id is the same code — join on it safely
$certRecord = null;
if ($enrollment['certificate_issued'] && !empty($enrollment['certificate_id'])) {
    $certStmt = $conn->prepare(
        "SELECT * FROM certificates WHERE certificate_id = ? LIMIT 1"
    );
    $certStmt->bind_param("s", $enrollment['certificate_id']);
    $certStmt->execute();
    $certRecord = $certStmt->get_result()->fetch_assoc();
    $certStmt->close();
}

// ── Allowed file types ───────────────────────────────────────────
$allowedAssignment = ['pdf','doc','docx','zip','py','ipynb','txt','pptx','xlsx'];
$allowedProject    = ['pdf','doc','docx','zip'];
$maxFileSizeBytes  = 10 * 1024 * 1024; // 10 MB

// ── Handle POST submissions (PRG pattern) ───────────────────────
$uploadMessage = '';
$uploadError   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ── 1. Assignment submission ─────────────────────────────────
    if (isset($_POST['submit_assignment'])) {
        $assignmentId = intval($_POST['assignment_id'] ?? 0);

        if (!$assignmentId) {
            $uploadError = "Invalid assignment.";
        } elseif (!isset($_FILES['assignment_file']) || $_FILES['assignment_file']['error'] !== UPLOAD_ERR_OK) {
            $codes = [
                UPLOAD_ERR_INI_SIZE   => 'File exceeds server size limit.',
                UPLOAD_ERR_FORM_SIZE  => 'File exceeds form size limit.',
                UPLOAD_ERR_NO_FILE    => 'No file selected.',
                UPLOAD_ERR_PARTIAL    => 'File was only partially uploaded.',
            ];
            $uploadError = $codes[$_FILES['assignment_file']['error'] ?? UPLOAD_ERR_NO_FILE] ?? 'File upload error.';
        } else {
            $file = $_FILES['assignment_file'];
            $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowedAssignment)) {
                $uploadError = "File type '.$ext' not allowed. Accepted: " . implode(', ', $allowedAssignment);
            } elseif ($file['size'] > $maxFileSizeBytes) {
                $uploadError = "File too large. Maximum size is 10 MB.";
            } else {
                // Ensure directory exists
                $uploadDir = UPLOAD_ROOT . 'submissions/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $filename = 'assign_' . $studentId . '_' . $assignmentId . '_' . time() . '.' . $ext;
                $dest     = $uploadDir . $filename;

                if (!move_uploaded_file($file['tmp_name'], $dest)) {
                    $uploadError = "Failed to save file. Check server permissions on uploads/submissions/.";
                } else {
                    // Upsert submission record
                    $chk = $conn->prepare(
                        "SELECT id FROM submissions WHERE assignment_id = ? AND student_id = ?"
                    );
                    $chk->bind_param("ii", $assignmentId, $studentId);
                    $chk->execute();
                    $chk->store_result();
                    $exists = $chk->num_rows > 0;
                    $chk->close();

                    if ($exists) {
                        $u = $conn->prepare(
                            "UPDATE submissions SET submission_file = ?, submitted_at = NOW()
                             WHERE assignment_id = ? AND student_id = ?"
                        );
                        $u->bind_param("sii", $filename, $assignmentId, $studentId);
                        $u->execute();
                        $u->close();
                    } else {
                        $i = $conn->prepare(
                            "INSERT INTO submissions (assignment_id, student_id, submission_file)
                             VALUES (?, ?, ?)"
                        );
                        $i->bind_param("iis", $assignmentId, $studentId, $filename);
                        $i->execute();
                        $i->close();
                    }

                    // PRG redirect with success message in query string
                    header("Location: course-view.php?id={$enrollmentId}&tab=assignments&msg=assignment_ok");
                    exit;
                }
            }
        }
    }

    // ── 2. Project report upload ─────────────────────────────────
    if (isset($_POST['upload_project'])) {
        if (!isset($_FILES['project_file']) || $_FILES['project_file']['error'] !== UPLOAD_ERR_OK) {
            $codes = [
                UPLOAD_ERR_INI_SIZE  => 'File exceeds server size limit.',
                UPLOAD_ERR_FORM_SIZE => 'File exceeds form size limit.',
                UPLOAD_ERR_NO_FILE   => 'No file selected.',
                UPLOAD_ERR_PARTIAL   => 'File was only partially uploaded.',
            ];
            $uploadError = $codes[$_FILES['project_file']['error'] ?? UPLOAD_ERR_NO_FILE] ?? 'File upload error.';
        } else {
            $file = $_FILES['project_file'];
            $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowedProject)) {
                $uploadError = "Only PDF, DOC, DOCX, or ZIP files are accepted for project reports.";
            } elseif ($file['size'] > $maxFileSizeBytes) {
                $uploadError = "File too large. Maximum size is 10 MB.";
            } else {
                $uploadDir = UPLOAD_ROOT . 'projects/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $filename = 'project_' . $studentId . '_' . $enrollmentId . '_' . time() . '.' . $ext;
                $dest     = $uploadDir . $filename;

                if (!move_uploaded_file($file['tmp_name'], $dest)) {
                    $uploadError = "Failed to save project file. Check server permissions on uploads/projects/.";
                } else {
                    $u = $conn->prepare(
                        "UPDATE enrollments SET project_report = ? WHERE id = ?"
                    );
                    $u->bind_param("si", $filename, $enrollmentId);
                    $u->execute();
                    $u->close();

                    header("Location: course-view.php?id={$enrollmentId}&tab=project&msg=project_ok");
                    exit;
                }
            }
        }
    }

    // ── 3. Attendance ────────────────────────────────────────────
    if (isset($_POST['mark_attendance'])) {
        $attDate = trim($_POST['attendance_date'] ?? date('Y-m-d'));
        $hours   = floatval($_POST['hours'] ?? 1.0);
        $hours   = max(0.5, min(12.0, $hours)); // clamp

        // Validate date not in the future
        if ($attDate > date('Y-m-d')) {
            $uploadError = "Cannot mark attendance for a future date.";
        } else {
            $chk = $conn->prepare(
                "SELECT id FROM attendance WHERE student_id = ? AND course_id = ? AND date = ?"
            );
            $chk->bind_param("iis", $studentId, $courseId, $attDate);
            $chk->execute();
            $chk->store_result();
            $alreadyMarked = $chk->num_rows > 0;
            $chk->close();

            if ($alreadyMarked) {
                $uploadError = "Attendance already marked for " . date('d M Y', strtotime($attDate)) . ".";
            } else {
                $ins = $conn->prepare(
                    "INSERT INTO attendance (student_id, course_id, date, hours) VALUES (?, ?, ?, ?)"
                );
                $ins->bind_param("iisd", $studentId, $courseId, $attDate, $hours);
                $ins->execute();
                $ins->close();

                $upd = $conn->prepare(
                    "UPDATE students SET time_hours = time_hours + ? WHERE id = ?"
                );
                $upd->bind_param("di", $hours, $studentId);
                $upd->execute();
                $upd->close();

                header("Location: course-view.php?id={$enrollmentId}&tab=attendance&msg=attendance_ok");
                exit;
            }
        }
    }
}

// ── Flash messages from PRG redirects ───────────────────────────
$flashMessages = [
    'assignment_ok'  => ['success', 'Assignment submitted successfully!'],
    'project_ok'     => ['success', 'Project report uploaded successfully!'],
    'attendance_ok'  => ['success', 'Attendance marked successfully!'],
];
if (isset($_GET['msg']) && isset($flashMessages[$_GET['msg']])) {
    [$flashType, $flashText] = $flashMessages[$_GET['msg']];
    if (empty($uploadMessage) && empty($uploadError)) {
        if ($flashType === 'success') $uploadMessage = $flashText;
        else $uploadError = $flashText;
    }
    // Re-fetch fresh data after redirect
    $projectReport = $enrollment['project_report'];
    // Re-fetch submissions after assignment upload redirect
    if ($_GET['msg'] === 'assignment_ok') {
        $submissions = [];
        $subStmt2 = $conn->prepare(
            "SELECT assignment_id, submission_file, grade, feedback, submitted_at
             FROM submissions WHERE student_id = ?"
        );
        $subStmt2->bind_param("i", $studentId);
        $subStmt2->execute();
        $subRes2 = $subStmt2->get_result();
        while ($row = $subRes2->fetch_assoc()) {
            $submissions[$row['assignment_id']] = $row;
        }
        $subStmt2->close();
    }
    if ($_GET['msg'] === 'project_ok') {
        $pStmt = $conn->prepare("SELECT project_report FROM enrollments WHERE id = ?");
        $pStmt->bind_param("i", $enrollmentId);
        $pStmt->execute();
        $pRow = $pStmt->get_result()->fetch_assoc();
        $pStmt->close();
        $projectReport = $pRow['project_report'] ?? '';
    }
}

// ── Active tab from query string ────────────────────────────────
$activeTab = $_GET['tab'] ?? 'attendance';
$validTabs = ['attendance','assignments','project','resources','certificate'];
if (!in_array($activeTab, $validTabs)) $activeTab = 'attendance';

$statusColor = match($enrollment['status']) {
    'completed'   => 'success',
    'in_progress' => 'primary',
    'dropped'     => 'danger',
    default       => 'secondary'
};
$counter = 1;
?>

<!-- Breadcrumb -->
<div class="portal-breadcrumb">
    <a href="dashboard.php">Dashboard</a>
    <span class="sep">/</span>
    <a href="courses.php">My Courses</a>
    <span class="sep">/</span>
    <span class="current"><?= htmlspecialchars($enrollment['title']) ?></span>
</div>

<?php if ($uploadMessage): ?>
<div class="alert alert-success alert-dismissible fade show mb-3" style="border-radius:10px;">
    <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($uploadMessage) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>
<?php if ($uploadError): ?>
<div class="alert alert-danger alert-dismissible fade show mb-3" style="border-radius:10px;">
    <i class="fas fa-times-circle me-2"></i><?= htmlspecialchars($uploadError) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- Course header card -->
<div class="p-card mb-4">
    <div class="p-card-body">
        <div class="row align-items-start g-3">
            <div class="col-md-8">
                <h4 class="fw-bold mb-2" style="color:#1a1a2e;"><?= htmlspecialchars($enrollment['title']) ?></h4>
                <p class="text-muted small mb-3"><?= htmlspecialchars($enrollment['description']) ?></p>
                <div class="d-flex flex-wrap gap-3 small text-muted">
                    <span>
                        <i class="fas fa-user-tie me-1" style="color:var(--portal-primary);"></i>
                        <?= htmlspecialchars($enrollment['instructor']) ?>
                    </span>
                    <span>
                        <i class="fas fa-clock me-1" style="color:var(--portal-primary);"></i>
                        <?= htmlspecialchars($enrollment['duration']) ?>
                    </span>
                    <span>
                        <i class="fas fa-calendar me-1" style="color:var(--portal-primary);"></i>
                        Enrolled <?= date('d M Y', strtotime($enrollment['enrollment_date'])) ?>
                    </span>
                    <?php if ($enrollment['grade']): ?>
                    <span>
                        <i class="fas fa-star me-1" style="color:#e6ac00;"></i>
                        Grade: <strong><?= htmlspecialchars($enrollment['grade']) ?></strong>
                    </span>
                    <?php endif; ?>
                    <?php if ($enrollment['completion_date']): ?>
                    <span>
                        <i class="fas fa-flag-checkered me-1" style="color:#1d9e75;"></i>
                        Completed <?= date('d M Y', strtotime($enrollment['completion_date'])) ?>
                    </span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-4 text-md-end">
                <span class="badge bg-<?= $statusColor ?> rounded-pill px-3 py-2 mb-2 d-inline-block">
                    <?= ucfirst(str_replace('_', ' ', $enrollment['status'])) ?>
                </span>
                <?php if ($enrollment['syllabus_file']): ?>
                <br>
                <a href="<?= SITE_URL ?>uploads/syllabus/<?= urlencode($enrollment['syllabus_file']) ?>"
                   class="btn btn-sm btn-outline-primary mt-1" download style="font-size:.78rem;">
                    <i class="fas fa-download me-1"></i>Syllabus
                </a>
                <?php endif; ?>
                <?php if ($enrollment['certificate_issued']): ?>
                <br>
                <a href="?id=<?= $enrollmentId ?>&tab=certificate"
                   class="btn btn-sm btn-outline-warning mt-1" style="font-size:.78rem;">
                    <i class="fas fa-certificate me-1"></i>View Certificate
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Tabs -->
<div class="p-card">
    <div class="p-card-header" style="padding:0 20px;">
        <ul class="nav portal-tabs" id="courseTabs">
            <?php
            $tabs = [
                'attendance'  => ['fas fa-calendar-check', 'Attendance'],
                'assignments' => ['fas fa-tasks',           'Assignments', count($assignmentsAll)],
                'project'     => ['fas fa-file-code',       'Project'],
                'resources'   => ['fas fa-box-open',        'Resources'],
                'certificate' => ['fas fa-certificate',     'Certificate'],
            ];
            foreach ($tabs as $tabKey => $tabData):
                $icon  = $tabData[0];
                $label = $tabData[1];
                $count = $tabData[2] ?? null;
            ?>
            <li class="nav-item">
                <button class="nav-link <?= $activeTab === $tabKey ? 'active' : '' ?>"
                        data-bs-toggle="tab"
                        data-bs-target="#tab<?= ucfirst($tabKey) ?>">
                    <i class="<?= $icon ?> me-1"></i><?= $label ?>
                    <?php if (isset($count) && $count > 0): ?>
                    <span class="badge bg-primary rounded-pill ms-1" style="font-size:.63rem;"><?= $count ?></span>
                    <?php endif; ?>
                </button>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="tab-content p-card-body">

        <!-- ══ ATTENDANCE TAB ══════════════════════════════════════ -->
        <div class="tab-pane fade <?= $activeTab === 'attendance' ? 'show active' : '' ?>"
             id="tabAttendance">
            <div class="row g-4">
                <!-- Mark form -->
                <div class="col-md-5">
                    <div style="background:#f8f9fa;border-radius:12px;padding:20px;">
                        <h6 class="fw-bold mb-3"><i class="fas fa-plus-circle me-2" style="color:var(--portal-primary);"></i>Mark Attendance</h6>
                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Date</label>
                                <input type="date" class="form-control form-control-sm"
                                       name="attendance_date"
                                       value="<?= date('Y-m-d') ?>"
                                       max="<?= date('Y-m-d') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Hours</label>
                                <input type="number" step="0.5" min="0.5" max="12"
                                       class="form-control form-control-sm"
                                       name="hours" value="1.0" required>
                            </div>
                            <button type="submit" name="mark_attendance"
                                    class="btn btn-success w-100 btn-sm">
                                <i class="fas fa-check-circle me-2"></i>Mark Attendance
                            </button>
                        </form>
                    </div>

                    <!-- Total hours tile -->
                    <div class="mt-3">
                        <div style="background:var(--portal-gradient);border-radius:12px;padding:16px;color:#fff;text-align:center;">
                            <div style="font-size:2.4rem;font-weight:800;line-height:1;"><?= number_format($totalHours, 1) ?></div>
                            <div style="font-size:.8rem;opacity:.85;margin-top:4px;">Total Hours Logged</div>
                        </div>
                    </div>
                </div>

                <!-- Attendance history -->
                <div class="col-md-7">
                    <h6 class="fw-bold mb-3"><i class="fas fa-history me-2" style="color:#888;"></i>Attendance History</h6>
                    <?php if (!empty($attendanceList)): ?>
                    <div style="max-height:340px;overflow-y:auto;border-radius:10px;border:1px solid rgba(0,0,0,.07);">
                        <table class="table table-sm table-hover mb-0" style="font-size:.83rem;">
                            <thead style="position:sticky;top:0;background:#f8f9fa;z-index:1;">
                                <tr>
                                    <th style="padding:10px 14px;font-weight:600;color:#888;font-size:.72rem;border:none;">Date</th>
                                    <th style="padding:10px 14px;font-weight:600;color:#888;font-size:.72rem;border:none;">Hours</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($attendanceList as $att): ?>
                                <tr>
                                    <td style="padding:10px 14px;vertical-align:middle;">
                                        <?= date('d M Y', strtotime($att['date'])) ?>
                                    </td>
                                    <td style="padding:10px 14px;vertical-align:middle;">
                                        <span class="badge bg-success rounded-pill"><?= $att['hours'] ?>h</span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-calendar fa-3x mb-3 d-block opacity-20"></i>
                        <p class="small mb-0">No attendance records yet.<br>Mark your first session above.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- ══ ASSIGNMENTS TAB ════════════════════════════════════ -->
        <div class="tab-pane fade <?= $activeTab === 'assignments' ? 'show active' : '' ?>"
             id="tabAssignments">

            <?php if (empty($assignmentsAll)): ?>
            <div class="text-center py-5 text-muted">
                <i class="fas fa-clipboard fa-3x mb-3 d-block opacity-20"></i>
                <p class="mb-0">No assignments posted for this course yet.</p>
            </div>

            <?php else:
                $submittedCount = 0;
                $pendingCount   = 0;
                foreach ($assignmentsAll as $a) {
                    if (isset($submissions[$a['id']])) $submittedCount++;
                    else $pendingCount++;
                }
            ?>

            <!-- Progress summary -->
            <div class="d-flex gap-3 mb-4 flex-wrap">
                <div style="background:#f0fff4;border-radius:10px;padding:12px 18px;flex:1;min-width:120px;">
                    <div style="font-size:1.5rem;font-weight:800;color:#1d9e75;"><?= $submittedCount ?></div>
                    <div style="font-size:.75rem;color:#888;">Submitted</div>
                </div>
                <div style="background:#fff8e8;border-radius:10px;padding:12px 18px;flex:1;min-width:120px;">
                    <div style="font-size:1.5rem;font-weight:800;color:#e6ac00;"><?= $pendingCount ?></div>
                    <div style="font-size:.75rem;color:#888;">Pending</div>
                </div>
                <div style="background:#eef3ff;border-radius:10px;padding:12px 18px;flex:1;min-width:120px;">
                    <div style="font-size:1.5rem;font-weight:800;color:#378add;"><?= count($assignmentsAll) ?></div>
                    <div style="font-size:.75rem;color:#888;">Total</div>
                </div>
            </div>

            <div class="d-flex flex-column gap-3">
            <?php foreach ($assignmentsAll as $assign):
                $submitted  = isset($submissions[$assign['id']]);
                $sub        = $submitted ? $submissions[$assign['id']] : null;
                $isOverdue  = strtotime($assign['due_date']) < strtotime(date('Y-m-d'));
                $daysLeft   = (int)((strtotime($assign['due_date']) - strtotime(date('Y-m-d'))) / 86400);

                // Due badge
                if ($submitted) {
                    $dueBadge = ['success', '<i class="fas fa-check me-1"></i>Submitted'];
                } elseif ($isOverdue) {
                    $dueBadge = ['danger',  '<i class="fas fa-exclamation-circle me-1"></i>Overdue'];
                } elseif ($daysLeft <= 3) {
                    $dueBadge = ['warning', '<i class="fas fa-clock me-1"></i>Due in '.$daysLeft.'d'];
                } else {
                    $dueBadge = ['info',    '<i class="fas fa-calendar me-1"></i>'.date('d M', strtotime($assign['due_date']))];
                }

                // Card border colour
                $borderColor = $submitted ? '#1d9e75' : ($isOverdue ? '#dc3545' : ($daysLeft<=3 ? '#e6ac00' : 'rgba(0,0,0,.07)'));
            ?>
            <div style="border:1.5px solid <?= $borderColor ?>;border-radius:12px;padding:18px;background:#fff;">
                <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap">

                    <!-- Left: title + desc + grade -->
                    <div style="flex:1;min-width:0;">
                        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                            <span class="fw-bold" style="font-size:.9rem;color:#1a1a2e;">
                                <?= $counter++ ?>. <?= htmlspecialchars($assign['title']) ?>
                            </span>
                            <span class="badge bg-<?= $dueBadge[0] ?> rounded-pill" style="font-size:.68rem;">
                                <?= $dueBadge[1] ?>
                            </span>
                        </div>

                        <p class="text-muted mb-2" style="font-size:.8rem;line-height:1.6;">
                            <?= nl2br(htmlspecialchars($assign['description'])) ?>
                        </p>

                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <span class="text-muted" style="font-size:.75rem;">
                                <i class="fas fa-calendar-alt me-1"></i>
                                Due: <?= date('d M Y', strtotime($assign['due_date'])) ?>
                            </span>

                            <?php if ($submitted && $sub['grade']): ?>
                            <span class="badge rounded-pill px-2 py-1"
                                  style="background:rgba(55,138,221,.12);color:#378add;font-size:.72rem;">
                                <i class="fas fa-star me-1"></i>Grade: <?= htmlspecialchars($sub['grade']) ?>
                            </span>
                            <?php endif; ?>

                            <?php if ($submitted && $sub['submitted_at']): ?>
                            <span class="text-muted" style="font-size:.72rem;">
                                <i class="fas fa-upload me-1"></i>
                                Submitted <?= date('d M Y, h:i A', strtotime($sub['submitted_at'])) ?>
                            </span>
                            <?php endif; ?>
                        </div>

                        <?php if ($submitted && $sub['feedback']): ?>
                        <div style="background:#f8f9fa;border-radius:8px;padding:10px 12px;margin-top:10px;font-size:.8rem;">
                            <span style="font-weight:600;color:#555;">Instructor feedback:</span>
                            <span class="text-muted"> <?= htmlspecialchars($sub['feedback']) ?></span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Right: action buttons -->
                    <div style="flex-shrink:0;text-align:right;display:flex;flex-direction:column;gap:6px;align-items:flex-end;">

                        <!-- Download submitted file -->
                        <?php if ($submitted && !empty($sub['submission_file'])): ?>
                        <a href="<?= SITE_URL ?>uploads/submissions/<?= urlencode($sub['submission_file']) ?>"
                           download
                           class="btn btn-sm btn-outline-secondary"
                           style="font-size:.75rem;">
                            <i class="fas fa-download me-1"></i>My file
                        </a>
                        <?php endif; ?>

                        <!-- Submit / Resubmit — always visible if not overdue, OR if already submitted -->
                        <?php if ($submitted): ?>
                        <!-- Can always resubmit if assignment is still open -->
                        <?php if (!$isOverdue): ?>
                        <button class="btn btn-sm btn-outline-primary"
                                style="font-size:.75rem;"
                                data-bs-toggle="modal"
                                data-bs-target="#submitModal<?= $assign['id'] ?>">
                            <i class="fas fa-redo me-1"></i>Resubmit
                        </button>
                        <?php endif; /* submitted & overdue → show nothing extra */ ?>

                        <?php elseif (!$isOverdue): ?>
                        <!-- Not submitted, still open -->
                        <button class="btn btn-sm btn-primary"
                                style="font-size:.75rem;"
                                data-bs-toggle="modal"
                                data-bs-target="#submitModal<?= $assign['id'] ?>">
                            <i class="fas fa-upload me-1"></i>Submit
                        </button>

                        <?php else: ?>
                        <!-- Not submitted AND overdue -->
                        <span class="text-muted" style="font-size:.75rem;">
                            <i class="fas fa-lock me-1"></i>Deadline passed
                        </span>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

            <!-- Per-assignment submit modal -->
            <div class="modal fade" id="submitModal<?= $assign['id'] ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg" style="border-radius:16px;overflow:hidden;">
                        <form method="post" enctype="multipart/form-data">
                            <input type="hidden" name="assignment_id" value="<?= $assign['id'] ?>">
                            <div class="modal-header text-white border-0"
                                 style="background:var(--portal-gradient);">
                                <h6 class="modal-title fw-bold">
                                    <i class="fas fa-upload me-2"></i>
                                    <?= $submitted ? 'Resubmit' : 'Submit' ?> Assignment
                                </h6>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div style="background:#f8f9fa;border-radius:8px;padding:10px 14px;margin-bottom:16px;">
                                    <div class="fw-semibold small"><?= htmlspecialchars($assign['title']) ?></div>
                                    <div class="text-muted" style="font-size:.75rem;">
                                        Due: <?= date('d M Y', strtotime($assign['due_date'])) ?>
                                    </div>
                                </div>
                                <?php if ($submitted): ?>
                                <div class="alert alert-info py-2 small mb-3">
                                    <i class="fas fa-info-circle me-1"></i>
                                    You already submitted this. Uploading a new file will replace your previous submission.
                                </div>
                                <?php endif; ?>
                                <label class="form-label small fw-semibold">
                                    Select File <span class="text-danger">*</span>
                                </label>
                                <input type="file" name="assignment_file"
                                       class="form-control form-control-sm" required>
                                <div class="form-text mt-1">
                                    Accepted: PDF, DOC, DOCX, ZIP, PY, IPYNB, TXT, PPTX, XLSX &nbsp;·&nbsp; Max 10 MB
                                </div>
                            </div>
                            <div class="modal-footer border-0 pt-0">
                                <button type="button" class="btn btn-secondary btn-sm"
                                        data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" name="submit_assignment"
                                        class="btn btn-primary btn-sm">
                                    <i class="fas fa-upload me-1"></i>
                                    <?= $submitted ? 'Resubmit' : 'Submit' ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- ══ PROJECT TAB ════════════════════════════════════════ -->
        <div class="tab-pane fade <?= $activeTab === 'project' ? 'show active' : '' ?>"
             id="tabProject">
            <div class="row g-4">

                <!-- Current report -->
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-file-pdf me-2" style="color:#dc3545;"></i>Current Report
                    </h6>
                    <?php if ($projectReport): ?>
                    <div style="border:1.5px solid #e9ecef;border-radius:12px;padding:18px;display:flex;align-items:center;gap:14px;background:#fff;">
                        <div style="width:48px;height:48px;border-radius:12px;background:#fff5f5;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-file-pdf" style="color:#dc3545;font-size:1.4rem;"></i>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div class="fw-semibold small mb-1 text-truncate">
                                <?= htmlspecialchars($projectReport) ?>
                            </div>
                            <div class="d-flex gap-2 mt-1 flex-wrap">
                                <a href="<?= SITE_URL ?>uploads/projects/<?= urlencode($projectReport) ?>"
                                   target="_blank"
                                   class="btn btn-sm btn-outline-primary"
                                   style="font-size:.75rem;">
                                    <i class="fas fa-eye me-1"></i>View
                                </a>
                                <a href="<?= SITE_URL ?>uploads/projects/<?= urlencode($projectReport) ?>"
                                   download
                                   class="btn btn-sm btn-outline-secondary"
                                   style="font-size:.75rem;">
                                    <i class="fas fa-download me-1"></i>Download
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-4"
                         style="border:2px dashed #e0e0e0;border-radius:12px;">
                        <i class="fas fa-file-upload fa-2x mb-2 d-block text-muted opacity-40"></i>
                        <p class="text-muted small mb-0">No project report uploaded yet.</p>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Upload form -->
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-upload me-2" style="color:var(--portal-primary);"></i>
                        <?= $projectReport ? 'Replace Report' : 'Upload Report' ?>
                    </h6>
                    <form method="post" enctype="multipart/form-data"
                          style="background:#f8f9fa;border-radius:12px;padding:20px;">
                        <?php if ($projectReport): ?>
                        <div class="alert alert-warning py-2 small mb-3">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Uploading a new file will replace your existing report.
                        </div>
                        <?php endif; ?>
                        <label class="form-label small fw-semibold">
                            Select File <span class="text-danger">*</span>
                        </label>
                        <input type="file"
                               class="form-control form-control-sm mb-2"
                               name="project_file"
                               accept=".pdf,.doc,.docx,.zip"
                               required>
                        <div class="form-text mb-3">
                            Accepted: PDF, DOC, DOCX, ZIP &nbsp;·&nbsp; Max 10 MB
                        </div>
                        <button type="submit" name="upload_project"
                                class="btn btn-primary btn-sm w-100">
                            <i class="fas fa-upload me-2"></i>
                            <?= $projectReport ? 'Replace Report' : 'Upload Project' ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- ══ RESOURCES TAB ══════════════════════════════════════ -->
        <div class="tab-pane fade <?= $activeTab === 'resources' ? 'show active' : '' ?>"
             id="tabResources">
            <div class="row g-3">
                <?php foreach ([
                    ['fas fa-tools',     'Tools Provided', $enrollment['tools_provided'] ?? ''],
                    ['fas fa-microchip', 'Hardware Kit',   $enrollment['hardware_kit']   ?? ''],
                ] as [$icon, $title, $val]): ?>
                <div class="col-md-6">
                    <div style="background:#f8f9fa;border-radius:12px;padding:18px;height:100%;">
                        <h6 class="fw-semibold mb-2 small">
                            <i class="<?= $icon ?> me-2" style="color:var(--portal-primary);"></i><?= $title ?>
                        </h6>
                        <?php if (trim($val)): ?>
                        <p class="text-muted mb-0 small" style="line-height:1.7;">
                            <?= nl2br(htmlspecialchars($val)) ?>
                        </p>
                        <?php else: ?>
                        <p class="text-muted mb-0 small">Not specified for this course.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>

                <!-- Downloads -->
                <?php
                $downloads = [];
                if ($enrollment['syllabus_file'])
                    $downloads[] = ['fas fa-file-pdf text-danger', 'Syllabus', SITE_URL.'uploads/syllabus/'.urlencode($enrollment['syllabus_file'])];
                if ($enrollment['attendance_sheet'])
                    $downloads[] = ['fas fa-calendar-check text-success', 'Attendance Sheet', SITE_URL.'uploads/attendance/'.urlencode($enrollment['attendance_sheet'])];
                if ($enrollment['payment_receipt'])
                    $downloads[] = ['fas fa-receipt text-primary', 'Payment Receipt', SITE_URL.'uploads/receipts/'.urlencode($enrollment['payment_receipt'])];
                if (!empty($downloads)):
                ?>
                <div class="col-12">
                    <h6 class="fw-semibold mb-2 small">
                        <i class="fas fa-download me-2" style="color:#378add;"></i>Downloads
                    </h6>
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach ($downloads as [$icon, $label, $url]): ?>
                        <a href="<?= $url ?>" class="btn btn-sm btn-outline-secondary" download style="font-size:.78rem;">
                            <i class="<?= $icon ?> me-1"></i><?= $label ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- ══ CERTIFICATE TAB ════════════════════════════════════ -->
        <div class="tab-pane fade <?= $activeTab === 'certificate' ? 'show active' : '' ?>"
             id="tabCertificate">

            <?php if ($certRecord): ?>
            <!-- ── Certificate found in DB ── -->
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <!-- Certificate display card -->
                    <div style="border:2px solid #e6ac00;border-radius:16px;overflow:hidden;background:#fff;">
                        <!-- Gold header strip -->
                        <div style="background:linear-gradient(135deg,#e6ac00,#ffd54f);padding:20px;text-align:center;">
                            <i class="fas fa-certificate" style="font-size:2.5rem;color:#fff;margin-bottom:8px;display:block;"></i>
                            <div style="font-family:'Montserrat',sans-serif;font-weight:800;font-size:1.1rem;color:#fff;">
                                Certificate of Completion
                            </div>
                        </div>

                        <!-- Certificate details -->
                        <div style="padding:24px;">
                            <div class="text-center mb-4">
                                <div class="text-muted small mb-1">This certifies that</div>
                                <div style="font-size:1.3rem;font-weight:700;color:#1a1a2e;">
                                    <?= htmlspecialchars($certRecord['student_name']) ?>
                                </div>
                                <div class="text-muted small mt-1">has successfully completed</div>
                                <div style="font-size:1rem;font-weight:600;color:#ff4000;margin-top:4px;">
                                    <?= htmlspecialchars($certRecord['course_name']) ?>
                                </div>
                            </div>

                            <?php $details = [
                                ['fas fa-id-card',    'Certificate ID',  $certRecord['certificate_id']],
                                ['fas fa-calendar',   'Issue Date',      date('d F Y', strtotime($certRecord['issue_date']))],
                            ];
                            if ($certRecord['expiry_date'])
                                $details[] = ['fas fa-clock', 'Valid Until', date('d F Y', strtotime($certRecord['expiry_date']))];
                            ?>

                            <?php foreach ($details as [$icon, $label, $value]): ?>
                            <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid #f0f0f0;font-size:.85rem;">
                                <span class="text-muted">
                                    <i class="<?= $icon ?> me-2" style="color:var(--portal-primary);width:14px;"></i><?= $label ?>
                                </span>
                                <strong><?= htmlspecialchars($value) ?></strong>
                            </div>
                            <?php endforeach; ?>

                            <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;font-size:.85rem;">
                                <span class="text-muted"><i class="fas fa-shield-alt me-2" style="color:var(--portal-primary);width:14px;"></i>Status</span>
                                <span class="badge bg-<?= $certRecord['status']==='active' ? 'success' : ($certRecord['status']==='expired' ? 'warning' : 'danger') ?> rounded-pill">
                                    <?= ucfirst($certRecord['status']) ?>
                                </span>
                            </div>

                            <!-- Actions -->
                            <div class="d-flex gap-2 mt-4 flex-wrap">
                                <?php if (!empty($certRecord['file_path'])): ?>
                                <a href="<?= SITE_URL . htmlspecialchars($certRecord['file_path']) ?>"
                                   class="btn btn-primary flex-fill"
                                   style="font-size:.85rem;"
                                   download>
                                    <i class="fas fa-download me-2"></i>Download PDF
                                </a>
                                <?php endif; ?>
                                <button onclick="copyCertId('<?= htmlspecialchars($certRecord['certificate_id']) ?>')"
                                        class="btn btn-outline-secondary flex-fill"
                                        style="font-size:.85rem;">
                                    <i class="fas fa-copy me-2"></i>Copy ID
                                </button>
                            </div>

                            <?php if (!empty($certRecord['qr_code'])): ?>
                            <div class="text-center mt-3">
                                <img src="<?= SITE_URL . htmlspecialchars($certRecord['qr_code']) ?>"
                                     alt="QR Code" width="80" height="80" class="rounded">
                                <div class="text-muted mt-1" style="font-size:.7rem;">Scan to verify</div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Verify link -->
                    <div class="text-center mt-3">
                        <a href="<?= SITE_URL ?>pages/certificates.php?certificate_id=<?= urlencode($certRecord['certificate_id']) ?>"
                           target="_blank"
                           class="text-muted small text-decoration-none">
                            <i class="fas fa-external-link-alt me-1"></i>
                            Verify this certificate publicly
                        </a>
                    </div>
                </div>
            </div>

            <?php elseif ($enrollment['certificate_issued']): ?>
            <!-- ── Issued flag set but record not found ── -->
            <div class="text-center py-4">
                <i class="fas fa-certificate fa-4x mb-3 d-block" style="color:#e6ac00;opacity:.5;"></i>
                <h5 class="fw-bold mb-2">Certificate Issued</h5>
                <p class="text-muted small mb-3">
                    Your certificate has been issued but the record could not be loaded.<br>
                    Please contact <a href="mailto:<?= SITE_EMAIL ?>"><?= SITE_EMAIL ?></a> for assistance.
                </p>
                <a href="certificates.php" class="btn btn-outline-primary btn-sm">
                    Go to My Certificates
                </a>
            </div>

            <?php elseif ($enrollment['status'] === 'completed'): ?>
            <!-- ── Course completed, certificate pending ── -->
            <div class="text-center py-5">
                <div style="width:80px;height:80px;border-radius:50%;background:#fff8e1;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                    <i class="fas fa-hourglass-half fa-2x" style="color:#e6ac00;"></i>
                </div>
                <h5 class="fw-bold mb-2">Certificate Pending</h5>
                <p class="text-muted small mb-3">
                    Congratulations on completing the course! 🎉<br>
                    Your certificate is being processed and will be available here shortly.
                </p>
                <p class="text-muted" style="font-size:.78rem;">
                    Questions? Contact
                    <a href="mailto:<?= SITE_EMAIL ?>"><?= SITE_EMAIL ?></a>
                </p>
            </div>

            <?php else: ?>
            <!-- ── Course not yet completed ── -->
            <div class="text-center py-5">
                <div style="width:80px;height:80px;border-radius:50%;background:#f0f2f5;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                    <i class="fas fa-graduation-cap fa-2x" style="color:#aaa;"></i>
                </div>
                <h5 class="fw-bold mb-2" style="color:#888;">Certificate Not Yet Issued</h5>
                <p class="text-muted small mb-0">
                    Complete all assignments and the course to earn your certificate.
                </p>
            </div>
            <?php endif; ?>

        </div>

    </div><!-- /.tab-content -->
</div><!-- /.p-card -->

<!-- Toast for copy -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index:9999;">
    <div id="certCopyToast" class="toast align-items-center text-white bg-success border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body small">
                <i class="fas fa-check me-2"></i>Certificate ID copied to clipboard!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<script>
function copyCertId(id) {
    navigator.clipboard.writeText(id).then(function() {
        new bootstrap.Toast(document.getElementById('certCopyToast')).show();
    }).catch(function() {
        // Fallback for older browsers
        var el = document.createElement('textarea');
        el.value = id;
        document.body.appendChild(el);
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);
        new bootstrap.Toast(document.getElementById('certCopyToast')).show();
    });
}
</script>

<?php $conn->close(); require_once 'includes/footer.php'; ?>
