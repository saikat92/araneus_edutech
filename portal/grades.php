<?php
$page_title = "My Grades";
require_once 'includes/header.php';

// Fetch all enrollments with grade data for this student
$stmt = $conn->prepare("
    SELECT
        e.id            AS enrollment_id,
        e.grade,
        e.status        AS enrollment_status,
        e.completion_date,
        e.certificate_issued,
        c.title         AS course_name,
        c.instructor,
        c.duration
    FROM enrollments e
    JOIN courses c ON e.course_id = c.id
    WHERE e.student_id = ?
    ORDER BY e.enrollment_date DESC
");
$stmt->bind_param("i", $studentId);
$stmt->execute();
$gradesResult = $stmt->get_result();
$grades = [];
while ($row = $gradesResult->fetch_assoc()) {
    $grades[] = $row;
}
$stmt->close();

// Grade colour helper
function gradeClass($grade) {
    if (empty($grade)) return 'secondary';
    $g = strtoupper(trim($grade));
    if (in_array($g, ['O', 'AA', 'A+', 'A']))  return 'success';
    if (in_array($g, ['AB', 'B+', 'B']))        return 'primary';
    if (in_array($g, ['BB', 'C']))              return 'warning';
    return 'danger';
}

// Grade label helper
function gradeLabel($grade) {
    if (empty($grade)) return 'Pending';
    $map = [
        'O'  => 'Outstanding',
        'AA' => 'Excellent',
        'AB' => 'Very Good',
        'BB' => 'Good',
        'BC' => 'Above Average',
        'CC' => 'Average',
        'F'  => 'Fail',
    ];
    $g = strtoupper(trim($grade));
    return isset($map[$g]) ? $map[$g] : $grade;
}

// Simple GPA-style summary
$totalCourses  = count($grades);
$gradedCourses = array_filter($grades, fn($r) => !empty($r['grade']));
$completedCourses = array_filter($grades, fn($r) => $r['enrollment_status'] === 'completed');
?>

<section class="py-5">
<div class="container">

    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="fas fa-chart-bar me-2 text-primary"></i>My Grades</h2>
            <p class="text-muted mb-0">Academic performance across all enrolled courses</p>
        </div>
        <a href="dashboard.php" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Dashboard
        </a>
    </div>

    <!-- Summary cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card text-center border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-book-open fa-2x text-primary mb-2"></i>
                    <h3 class="mb-0"><?php echo $totalCourses; ?></h3>
                    <small class="text-muted">Total Enrolled</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h3 class="mb-0"><?php echo count($completedCourses); ?></h3>
                    <small class="text-muted">Completed</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-star fa-2x text-warning mb-2"></i>
                    <h3 class="mb-0"><?php echo count($gradedCourses); ?></h3>
                    <small class="text-muted">Graded</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-certificate fa-2x text-warning mb-2"></i>
                    <h3 class="mb-0"><?php echo array_sum(array_column($grades, 'certificate_issued')); ?></h3>
                    <small class="text-muted">Certificates Earned</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Grades table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Grade Report</h5>
        </div>
        <div class="card-body p-0">
            <?php if (empty($grades)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-3">You have not enrolled in any courses yet.</p>
                    <a href="dashboard.php" class="btn btn-primary">Browse Courses</a>
                </div>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Course</th>
                            <th>Instructor</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Completion Date</th>
                            <th class="text-center">Grade</th>
                            <th class="text-center">Certificate</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($grades as $i => $row): ?>
                        <tr>
                            <td class="text-muted"><?php echo $i + 1; ?></td>
                            <td>
                                <a href="course-view.php?id=<?php echo $row['enrollment_id']; ?>"
                                   class="text-decoration-none fw-semibold">
                                    <?php echo htmlspecialchars($row['course_name']); ?>
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($row['instructor'] ?? '—'); ?></td>
                            <td><?php echo htmlspecialchars($row['duration'] ?? '—'); ?></td>
                            <td>
                                <?php
                                $statusColors = [
                                    'enrolled'    => 'info',
                                    'in_progress' => 'primary',
                                    'completed'   => 'success',
                                    'dropped'     => 'danger',
                                ];
                                $sc = $statusColors[$row['enrollment_status']] ?? 'secondary';
                                ?>
                                <span class="badge bg-<?php echo $sc; ?>">
                                    <?php echo ucfirst(str_replace('_', ' ', $row['enrollment_status'])); ?>
                                </span>
                            </td>
                            <td>
                                <?php echo $row['completion_date']
                                    ? date('d M Y', strtotime($row['completion_date']))
                                    : '<span class="text-muted">—</span>'; ?>
                            </td>
                            <td class="text-center">
                                <?php if (!empty($row['grade'])): ?>
                                    <span class="badge bg-<?php echo gradeClass($row['grade']); ?> fs-6 px-3 py-1"
                                          title="<?php echo gradeLabel($row['grade']); ?>"
                                          data-bs-toggle="tooltip">
                                        <?php echo htmlspecialchars($row['grade']); ?>
                                    </span>
                                    <div class="small text-muted mt-1"><?php echo gradeLabel($row['grade']); ?></div>
                                <?php else: ?>
                                    <span class="text-muted small">Not graded yet</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($row['certificate_issued']): ?>
                                    <i class="fas fa-certificate text-warning fs-5"
                                       title="Certificate issued" data-bs-toggle="tooltip"></i>
                                <?php else: ?>
                                    <span class="text-muted small">—</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Grade scale legend -->
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-light">
            <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Grade Scale Reference</h6>
        </div>
        <div class="card-body">
            <div class="row g-2">
                <?php
                $scale = [
                    ['O',  'Outstanding',   'success'],
                    ['AA', 'Excellent',      'success'],
                    ['AB', 'Very Good',      'primary'],
                    ['BB', 'Good',           'warning'],
                    ['BC', 'Above Average',  'warning'],
                    ['CC', 'Average',        'secondary'],
                    ['F',  'Fail',           'danger'],
                ];
                foreach ($scale as [$g, $label, $color]):
                ?>
                <div class="col-6 col-md-3 col-lg-auto">
                    <span class="badge bg-<?php echo $color; ?> me-1"><?php echo $g; ?></span>
                    <small class="text-muted"><?php echo $label; ?></small>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</div>
</section>

<script>
// Enable Bootstrap tooltips
document.addEventListener('DOMContentLoaded', function () {
    var tooltips = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltips.forEach(function (el) { new bootstrap.Tooltip(el); });
});
</script>

<?php require_once 'includes/footer.php'; ?>
