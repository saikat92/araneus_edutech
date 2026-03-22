<?php
$page_title = "Assignments";
require_once 'includes/header.php';

// Fetch all assignments for the student's enrolled courses, with submission status
$stmt = $conn->prepare("
    SELECT
        a.id            AS assignment_id,
        a.title,
        a.description,
        a.due_date,
        c.title         AS course_name,
        e.id            AS enrollment_id,
        s.id            AS submission_id,
        s.submitted_at,
        s.grade         AS submission_grade,
        s.feedback,
        s.submission_file
    FROM assignments a
    JOIN courses c     ON a.course_id = c.id
    JOIN enrollments e ON e.course_id = c.id AND e.student_id = ?
    LEFT JOIN submissions s ON s.assignment_id = a.id AND s.student_id = ?
    ORDER BY a.due_date ASC
");
$stmt->bind_param("ii", $studentId, $studentId);
$stmt->execute();
$result = $stmt->get_result();

$assignments  = [];
$pending      = [];
$submitted    = [];
$overdue      = [];
$today        = date('Y-m-d');

while ($row = $result->fetch_assoc()) {
    $assignments[] = $row;
    if ($row['submission_id']) {
        $submitted[] = $row;
    } elseif ($row['due_date'] < $today) {
        $overdue[] = $row;
    } else {
        $pending[] = $row;
    }
}
$stmt->close();

// Upload directory for assignment submissions
$uploadDir = '../uploads/submissions/';
$uploadDir1 = '../../araneus_admin/public/assets/uploads/submissions/';

if (!is_dir($uploadDir) && !is_dir($uploadDir1)) {
    mkdir($uploadDir, 0755, true);
    mkdir($uploadDir1, 0755, true);
}

// Handle file submission POST
$uploadMsg   = '';
$uploadError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_assignment'])) {
    $assignmentId = intval($_POST['assignment_id'] ?? 0);

    if ($assignmentId && isset($_FILES['assignment_file']) && $_FILES['assignment_file']['error'] === UPLOAD_ERR_OK) {
        $file     = $_FILES['assignment_file'];
        $allowed  = ['pdf', 'doc', 'docx', 'zip', 'py', 'ipynb', 'txt'];
        $ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            $uploadError = "File type not allowed. Accepted: " . implode(', ', $allowed);
        } elseif ($file['size'] > 10 * 1024 * 1024) {
            $uploadError = "File too large (max 10 MB).";
        } else {
            // Check not already submitted
            $chk = $conn->prepare("SELECT id FROM submissions WHERE assignment_id = ? AND student_id = ?");
            $chk->bind_param("ii", $assignmentId, $studentId);
            $chk->execute();
            $chk->store_result();
            if ($chk->num_rows > 0) {
                $uploadError = "You have already submitted this assignment.";
            } else {
                $filename = $studentId . '_' . $assignmentId . '_' . time() . '.' . $ext;
                if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename) && copy($uploadDir . $filename, $uploadDir1 . $filename)) {
                    $ins = $conn->prepare("INSERT INTO submissions (assignment_id, student_id, submission_file) VALUES (?, ?, ?)");
                    $ins->bind_param("iis", $assignmentId, $studentId, $filename);
                    if ($ins->execute()) {
                        $uploadMsg = "Assignment submitted successfully!";
                        // Refresh page to reflect new submission
                        header("Location: assignments.php?submitted=1");
                        exit;
                    } else {
                        $uploadError = "Database error: " . $ins->error;
                    }
                    $ins->close();
                } else {
                    $uploadError = "Failed to save file. Please try again.";
                }
            }
            $chk->close();
        }
    } else {
        $uploadError = "Please select a file to upload.";
    }
}

if (isset($_GET['submitted'])) {
    $uploadMsg = "Assignment submitted successfully!";
}
?>

<section class="py-5">
<div class="container">

    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="fas fa-tasks me-2 text-primary"></i>Assignments</h2>
            <p class="text-muted mb-0">Submit and track your course assignments</p>
        </div>
        <a href="dashboard.php" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Dashboard
        </a>
    </div>

    <?php if ($uploadMsg): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($uploadMsg); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if ($uploadError): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($uploadError); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Summary strip -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center h-100">
                <div class="card-body py-3">
                    <i class="fas fa-list fa-2x text-primary mb-2"></i>
                    <h4 class="mb-0"><?php echo count($assignments); ?></h4>
                    <small class="text-muted">Total</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center h-100">
                <div class="card-body py-3">
                    <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                    <h4 class="mb-0"><?php echo count($pending); ?></h4>
                    <small class="text-muted">Pending</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center h-100">
                <div class="card-body py-3">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h4 class="mb-0"><?php echo count($submitted); ?></h4>
                    <small class="text-muted">Submitted</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center h-100">
                <div class="card-body py-3">
                    <i class="fas fa-exclamation-triangle fa-2x text-danger mb-2"></i>
                    <h4 class="mb-0"><?php echo count($overdue); ?></h4>
                    <small class="text-muted">Overdue</small>
                </div>
            </div>
        </div>
    </div>

    <?php if (empty($assignments)): ?>
        <div class="card border-0 shadow-sm text-center py-5">
            <div class="card-body">
                <i class="fas fa-clipboard fa-3x text-muted mb-3"></i>
                <p class="text-muted">No assignments found. Enrol in a course to see your assignments.</p>
                <a href="dashboard.php" class="btn btn-primary">Browse Courses</a>
            </div>
        </div>
    <?php else: ?>

    <!-- Filter tabs -->
    <ul class="nav nav-tabs mb-3" id="assignTab">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#tab-all">
                All <span class="badge bg-secondary ms-1"><?php echo count($assignments); ?></span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab-pending">
                Pending <span class="badge bg-warning text-dark ms-1"><?php echo count($pending); ?></span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab-submitted">
                Submitted <span class="badge bg-success ms-1"><?php echo count($submitted); ?></span>
            </a>
        </li>
        <?php if (count($overdue)): ?>
        <li class="nav-item">
            <a class="nav-link text-danger" data-bs-toggle="tab" href="#tab-overdue">
                Overdue <span class="badge bg-danger ms-1"><?php echo count($overdue); ?></span>
            </a>
        </li>
        <?php endif; ?>
    </ul>

    <div class="tab-content">

        <?php
        // Render one tab pane
        function renderAssignments($list, $tabId, $active, $studentId, $today) {
            $isActive = $active ? 'show active' : '';
            echo "<div class=\"tab-pane fade {$isActive}\" id=\"{$tabId}\">";
            if (empty($list)) {
                echo '<div class="text-center py-4 text-muted"><i class="fas fa-check fa-2x mb-2"></i><p>Nothing here.</p></div>';
                echo '</div>';
                return;
            }
            foreach ($list as $a):
                $isSubmitted = !empty($a['submission_id']);
                $isOverdue   = !$isSubmitted && $a['due_date'] < $today;
                $daysLeft    = (strtotime($a['due_date']) - strtotime($today)) / 86400;
                $dueColor    = $isSubmitted ? 'success' : ($isOverdue ? 'danger' : ($daysLeft <= 3 ? 'warning' : 'secondary'));
        ?>
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <div class="row align-items-start">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center mb-1">
                            <span class="badge bg-<?php echo $dueColor; ?> me-2">
                                <?php echo $isSubmitted ? 'Submitted' : ($isOverdue ? 'Overdue' : ($daysLeft <= 3 ? 'Due soon' : 'Pending')); ?>
                            </span>
                            <small class="text-muted"><?php echo htmlspecialchars($a['course_name']); ?></small>
                        </div>
                        <h5 class="mb-1"><?php echo htmlspecialchars($a['title']); ?></h5>
                        <p class="text-muted small mb-2"><?php echo nl2br(htmlspecialchars($a['description'])); ?></p>
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>
                            Due: <strong><?php echo date('d M Y', strtotime($a['due_date'])); ?></strong>
                            <?php if (!$isSubmitted && !$isOverdue): ?>
                                &nbsp;·&nbsp; <?php echo (int)$daysLeft; ?> day<?php echo $daysLeft == 1 ? '' : 's'; ?> left
                            <?php endif; ?>
                        </small>
                        <?php if ($isSubmitted && !empty($a['submission_grade'])): ?>
                            <div class="mt-2">
                                <span class="badge bg-success me-1">Grade: <?php echo htmlspecialchars($a['submission_grade']); ?></span>
                                <?php if (!empty($a['feedback'])): ?>
                                    <small class="text-muted"><i class="fas fa-comment me-1"></i><?php echo htmlspecialchars($a['feedback']); ?></small>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <?php if ($isSubmitted): ?>
                            <div class="text-success mb-2">
                                <i class="fas fa-check-circle me-1"></i>
                                Submitted <?php echo date('d M Y', strtotime($a['submitted_at'])); ?>
                            </div>
                            <?php if (!empty($a['submission_file'])): ?>
                                <a href="../uploads/submissions/<?php echo htmlspecialchars($a['submission_file']); ?>"
                                   class="btn btn-sm btn-outline-secondary" download>
                                    <i class="fas fa-download me-1"></i>My file
                                </a>
                            <?php endif; ?>
                        <?php elseif (!$isOverdue): ?>
                            <button class="btn btn-primary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#submitModal"
                                    data-assignment-id="<?php echo $a['assignment_id']; ?>"
                                    data-assignment-title="<?php echo htmlspecialchars($a['title']); ?>">
                                <i class="fas fa-upload me-1"></i> Submit
                            </button>
                        <?php else: ?>
                            <span class="text-danger small"><i class="fas fa-lock me-1"></i>Deadline passed</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach;
            echo '</div>';
        }

        renderAssignments($assignments, 'tab-all',       true,  $studentId, $today);
        renderAssignments($pending,     'tab-pending',   false, $studentId, $today);
        renderAssignments($submitted,   'tab-submitted', false, $studentId, $today);
        if (count($overdue)):
            renderAssignments($overdue, 'tab-overdue',   false, $studentId, $today);
        endif;
        ?>
    </div>

    <?php endif; ?>

</div>
</section>

<!-- Submit Assignment Modal -->
<div class="modal fade" id="submitModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-upload me-2"></i>Submit Assignment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="submit_assignment" value="1">
                    <input type="hidden" name="assignment_id" id="modalAssignmentId">
                    <p class="mb-3">Submitting: <strong id="modalAssignmentTitle"></strong></p>
                    <div class="mb-3">
                        <label class="form-label">Upload File <span class="text-danger">*</span></label>
                        <input type="file" name="assignment_file" class="form-control" required
                               accept=".pdf,.doc,.docx,.zip,.py,.ipynb,.txt">
                        <div class="form-text">Accepted: PDF, DOC, DOCX, ZIP, PY, IPYNB, TXT &nbsp;·&nbsp; Max 10 MB</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-1"></i> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var submitModal = document.getElementById('submitModal');
    if (submitModal) {
        submitModal.addEventListener('show.bs.modal', function (e) {
            var btn = e.relatedTarget;
            document.getElementById('modalAssignmentId').value    = btn.getAttribute('data-assignment-id');
            document.getElementById('modalAssignmentTitle').textContent = btn.getAttribute('data-assignment-title');
        });
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>
