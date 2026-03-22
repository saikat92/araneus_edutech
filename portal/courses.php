<?php
$page_title = "My Courses";
require_once 'includes/header.php';

// Fetch all enrolled courses with full details
$stmt = $conn->prepare("
    SELECT
        e.id            AS enrollment_id,
        e.status        AS enrollment_status,
        e.enrollment_date,
        e.completion_date,
        e.grade,
        e.certificate_issued,
        e.attendance_sheet,
        e.payment_receipt,
        e.project_report,
        c.id            AS course_id,
        c.title         AS course_name,
        c.description,
        c.duration,
        c.mode,
        c.instructor,
        c.tools_provided,
        c.hardware_kit,
        c.syllabus_file,
        c.certification_type,
        (SELECT COUNT(*) FROM assignments a WHERE a.course_id = c.id) AS total_assignments,
        (SELECT COUNT(*) FROM submissions  s
            JOIN assignments a ON s.assignment_id = a.id
            WHERE a.course_id = c.id AND s.student_id = e.student_id) AS completed_assignments,
        (SELECT COALESCE(SUM(att.hours), 0) FROM attendance att
            WHERE att.student_id = e.student_id AND att.course_id = c.id) AS total_hours
    FROM enrollments e
    JOIN courses c ON e.course_id = c.id
    WHERE e.student_id = ?
    ORDER BY e.enrollment_date DESC
");
$stmt->bind_param("i", $studentId);
$stmt->execute();
$result  = $stmt->get_result();
$courses = [];
while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
}
$stmt->close();

// Progress percentage helper
function progressPct($completed, $total) {
    if (!$total) return 0;
    return min(100, round(($completed / $total) * 100));
}

// Status badge helper
function statusBadge($status) {
    $map = [
        'enrolled'    => ['info',    'Enrolled'],
        'in_progress' => ['primary', 'In Progress'],
        'completed'   => ['success', 'Completed'],
        'dropped'     => ['danger',  'Dropped'],
    ];
    $d = $map[$status] ?? ['secondary', ucfirst($status)];
    return "<span class=\"badge bg-{$d[0]}\">{$d[1]}</span>";
}
?>

<section class="py-5">
<div class="container">

    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="fas fa-book-open me-2 text-primary"></i>My Courses</h2>
            <p class="text-muted mb-0">All your enrolled courses and materials</p>
        </div>
        <a href="dashboard.php" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Dashboard
        </a>
    </div>

    <?php if (empty($courses)): ?>
    <div class="card border-0 shadow-sm text-center py-5">
        <div class="card-body">
            <i class="fas fa-book-open fa-4x text-muted mb-3"></i>
            <h5 class="text-muted">No courses enrolled yet</h5>
            <p class="text-muted">Go to the dashboard and enrol in a course to get started.</p>
            <a href="dashboard.php" class="btn btn-primary">Browse Courses</a>
        </div>
    </div>
    <?php else: ?>

    <!-- Course cards -->
    <?php foreach ($courses as $course):
        $pct = progressPct($course['completed_assignments'], $course['total_assignments']);
        $pctColor = $pct >= 80 ? 'success' : ($pct >= 40 ? 'primary' : 'warning');
    ?>
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <!-- Left: Course info -->
                <div class="col-md-8">
                    <div class="d-flex align-items-start mb-2 gap-2">
                        <?php echo statusBadge($course['enrollment_status']); ?>
                        <?php if ($course['certificate_issued']): ?>
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-certificate me-1"></i>Certified
                            </span>
                        <?php endif; ?>
                    </div>
                    <h4 class="mb-1"><?php echo htmlspecialchars($course['course_name']); ?></h4>
                    <p class="text-muted small mb-3"><?php echo htmlspecialchars(mb_substr($course['description'], 0, 180)) . (mb_strlen($course['description']) > 180 ? '…' : ''); ?></p>

                    <!-- Meta row -->
                    <div class="d-flex flex-wrap gap-3 small text-muted mb-3">
                        <span><i class="fas fa-user-tie me-1"></i><?php echo htmlspecialchars($course['instructor'] ?? '—'); ?></span>
                        <span><i class="fas fa-clock me-1"></i><?php echo htmlspecialchars($course['duration'] ?? '—'); ?></span>
                        <span><i class="fas fa-laptop me-1"></i><?php echo ucfirst($course['mode'] ?? '—'); ?></span>
                        <span><i class="fas fa-calendar-plus me-1"></i>Enrolled <?php echo date('d M Y', strtotime($course['enrollment_date'])); ?></span>
                        <?php if ($course['completion_date']): ?>
                        <span><i class="fas fa-calendar-check me-1 text-success"></i>
                            Completed <?php echo date('d M Y', strtotime($course['completion_date'])); ?>
                        </span>
                        <?php endif; ?>
                    </div>

                    <!-- Assignment progress bar -->
                    <?php if ($course['total_assignments'] > 0): ?>
                    <div class="mb-2">
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="text-muted">Assignment progress</span>
                            <span><?php echo $course['completed_assignments']; ?> / <?php echo $course['total_assignments']; ?></span>
                        </div>
                        <div class="progress" style="height:8px;">
                            <div class="progress-bar bg-<?php echo $pctColor; ?>"
                                 style="width:<?php echo $pct; ?>%"
                                 role="progressbar"
                                 aria-valuenow="<?php echo $pct; ?>"></div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Attendance hours -->
                    <?php if ($course['total_hours'] > 0): ?>
                    <small class="text-muted">
                        <i class="fas fa-clock me-1"></i>
                        <?php echo number_format($course['total_hours'], 1); ?> attendance hours logged
                    </small>
                    <?php endif; ?>
                </div>

                <!-- Right: Actions + resources -->
                <div class="col-md-4 mt-3 mt-md-0 d-flex flex-column gap-2">
                    <a href="course-view.php?id=<?php echo $course['enrollment_id']; ?>"
                       class="btn btn-primary btn-sm">
                        <i class="fas fa-eye me-1"></i> View Course & Assignments
                    </a>
                    <a href="assignments.php" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-tasks me-1"></i> My Assignments
                    </a>

                    <!-- Downloadable resources -->
                    <?php $hasResources = $course['syllabus_file'] || $course['attendance_sheet'] || $course['payment_receipt'] || $course['project_report']; ?>
                    <?php if ($hasResources): ?>
                    <div class="dropdown mt-1">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle w-100"
                                data-bs-toggle="dropdown">
                            <i class="fas fa-paperclip me-1"></i> Downloads
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <?php if ($course['syllabus_file']): ?>
                            <li><a class="dropdown-item small" href="<?php echo SITE_URL . $course['syllabus_file']; ?>" download>
                                <i class="fas fa-file-pdf me-2 text-danger"></i>Syllabus</a></li>
                            <?php endif; ?>
                            <?php if ($course['attendance_sheet']): ?>
                            <li><a class="dropdown-item small" href="<?php echo SITE_URL . 'uploads/' . $course['attendance_sheet']; ?>" download>
                                <i class="fas fa-file-excel me-2 text-success"></i>Attendance Sheet</a></li>
                            <?php endif; ?>
                            <?php if ($course['payment_receipt']): ?>
                            <li><a class="dropdown-item small" href="<?php echo SITE_URL . 'uploads/' . $course['payment_receipt']; ?>" download>
                                <i class="fas fa-file-invoice me-2 text-primary"></i>Payment Receipt</a></li>
                            <?php endif; ?>
                            <?php if ($course['project_report']): ?>
                            <li><a class="dropdown-item small" href="<?php echo SITE_URL . 'uploads/' . $course['project_report']; ?>" download>
                                <i class="fas fa-file-code me-2 text-warning"></i>Project Report</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <!-- Tools / hardware info pills -->
                    <?php if (!empty($course['tools_provided'])): ?>
                    <div class="mt-1">
                        <span class="badge bg-light text-dark border small">
                            <i class="fas fa-tools me-1"></i><?php echo htmlspecialchars($course['tools_provided']); ?>
                        </span>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($course['hardware_kit'])): ?>
                    <div>
                        <span class="badge bg-light text-dark border small">
                            <i class="fas fa-microchip me-1"></i><?php echo htmlspecialchars($course['hardware_kit']); ?>
                        </span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <?php endif; ?>
</div>
</section>

<?php require_once 'includes/footer.php'; ?>
