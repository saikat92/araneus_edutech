<?php
$page_title = "Dashboard";
require_once 'includes/header.php';

// Available courses for browse modal
$availableCourses = $conn->query("SELECT * FROM courses WHERE is_active = 1 ORDER BY title")->fetch_all(MYSQLI_ASSOC);

// Re-use enrollments from header
$enrollments->data_seek(0);
$enrollmentsList = [];
while ($row = $enrollments->fetch_assoc()) { $enrollmentsList[] = $row; }
$enrollmentsCount = count($enrollmentsList);

// Upcoming deadlines (next 5)
$deadlineStmt = $conn->prepare("
    SELECT a.id, a.title, a.due_date, c.title AS course_name,
           (SELECT COUNT(*) FROM submissions s WHERE s.assignment_id=a.id AND s.student_id=?) as submitted
    FROM assignments a
    JOIN courses c ON a.course_id = c.id
    JOIN enrollments e ON e.course_id = c.id AND e.student_id = ?
    WHERE a.due_date >= CURDATE()
    ORDER BY a.due_date ASC LIMIT 5
");
$deadlineStmt->bind_param("ii", $studentId, $studentId);
$deadlineStmt->execute();
$deadlines = $deadlineStmt->get_result()->fetch_all(MYSQLI_ASSOC);
$deadlineStmt->close();

function statusColor($s){ return match($s){ 'completed'=>'success','in_progress'=>'primary','dropped'=>'danger', default=>'secondary' }; }
function progressPct($s){ return match($s){ 'completed'=>100,'in_progress'=>50, default=>10 }; }
function daysLeft($d){ return max(0, (int)((strtotime($d)-time())/86400)); }
?>

<!-- Welcome strip -->
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <h4 class="fw-bold mb-1" style="color:#1a1a2e;">
            Good <?= date('H')<12?'morning':(date('H')<17?'afternoon':'evening') ?>, <?= htmlspecialchars(explode(' ',$studentData['full_name'])[0]) ?> 👋
        </h4>
        <p class="text-muted mb-0 small">Here's what's happening with your learning today.</p>
    </div>
    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#browseCoursesModal">
        <i class="fas fa-plus me-1"></i> Browse Courses
    </button>
</div>

<!-- Stat tiles -->
<div class="row g-3 mb-4">
    <?php foreach ([
        ['fas fa-book-open',   '#e8f4ff', '#378add', $enrollmentsCount, 'Enrolled Courses'],
        ['fas fa-tasks',       '#fff3e8', '#ff8c00', $pendingAssignments, 'Pending Assignments'],
        ['fas fa-certificate', '#fffbe8', '#e6ac00', $certCount, 'Certificates Earned'],
        ['fas fa-clock',       '#e8fff3', '#1d9e75', htmlspecialchars($studentData['time_hours']).'h', 'Course Hours Logged'],
    ] as [$icon, $bg, $color, $val, $label]): ?>
    <div class="col-6 col-lg-3">
        <div class="stat-tile">
            <div class="stat-tile-icon" style="background:<?= $bg ?>;">
                <i class="<?= $icon ?>" style="color:<?= $color ?>;"></i>
            </div>
            <div>
                <div class="stat-tile-num" style="color:<?= $color ?>;"><?= $val ?></div>
                <div class="stat-tile-label"><?= $label ?></div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="row g-3">
    <!-- My Courses -->
    <div class="col-lg-8">
        <div class="p-card">
            <div class="p-card-header">
                <h5><i class="fas fa-book me-2" style="color:var(--portal-primary);"></i>My Courses</h5>
                <a href="courses.php" class="btn btn-sm btn-outline-primary" style="font-size:.78rem;">View All</a>
            </div>
            <div class="p-card-body" style="padding:0;">
                <?php if ($enrollmentsCount > 0): ?>
                <div style="overflow-x:auto;">
                    <table class="table table-hover mb-0" style="font-size:.83rem;">
                        <thead style="background:#f8f9fa;">
                            <tr>
                                <th class="ps-3" style="font-weight:600;color:#888;font-size:.75rem;text-transform:uppercase;letter-spacing:.04em;">Course</th>
                                <th style="font-weight:600;color:#888;font-size:.75rem;text-transform:uppercase;">Enrolled</th>
                                <th style="font-weight:600;color:#888;font-size:.75rem;text-transform:uppercase;">Status</th>
                                <th style="font-weight:600;color:#888;font-size:.75rem;text-transform:uppercase;">Progress</th>
                                <th class="pe-3" style="font-weight:600;color:#888;font-size:.75rem;text-transform:uppercase;"></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($enrollmentsList as $e): ?>
                            <tr>
                                <td class="ps-3" style="vertical-align:middle;">
                                    <div class="fw-semibold"><?= htmlspecialchars($e['course_name'] ?? 'N/A') ?></div>
                                </td>
                                <td style="vertical-align:middle;color:#888;"><?= date('d M Y', strtotime($e['enrollment_date'])) ?></td>
                                <td style="vertical-align:middle;">
                                    <span class="badge rounded-pill bg-<?= statusColor($e['status']) ?>" style="font-size:.72rem;">
                                        <?= ucfirst(str_replace('_',' ',$e['status'])) ?>
                                    </span>
                                </td>
                                <td style="vertical-align:middle;min-width:100px;">
                                    <?php $pct = progressPct($e['status']); ?>
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="flex:1;height:6px;background:#f0f0f0;border-radius:3px;">
                                            <div style="width:<?= $pct ?>%;height:100%;border-radius:3px;background:var(--portal-gradient);"></div>
                                        </div>
                                        <span style="font-size:.72rem;color:#888;flex-shrink:0;"><?= $pct ?>%</span>
                                    </div>
                                </td>
                                <td class="pe-3" style="vertical-align:middle;">
                                    <a href="course-view.php?id=<?= $e['id'] ?>" class="btn btn-sm btn-outline-primary" style="font-size:.75rem;padding:4px 10px;">
                                        View <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center py-5 px-3">
                    <div style="width:60px;height:60px;border-radius:16px;background:rgba(255,64,0,.08);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                        <i class="fas fa-book-open" style="color:var(--portal-primary);font-size:1.4rem;"></i>
                    </div>
                    <h6 class="fw-bold mb-1">No courses yet</h6>
                    <p class="text-muted small mb-3">Start your learning journey by enrolling in a course.</p>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#browseCoursesModal">
                        Browse Courses
                    </button>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Right column -->
    <div class="col-lg-4 d-flex flex-column gap-3">

        <!-- Profile card -->
        <div class="p-card">
            <div class="p-card-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <?php $av = avatarUrl($studentData); ?>
                    <div style="width:52px;height:52px;border-radius:50%;background:var(--portal-gradient);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:1rem;overflow:hidden;flex-shrink:0;">
                        <?php if ($av): ?><img src="<?= $av ?>" style="width:100%;height:100%;object-fit:cover;"><?php else: echo studentInitials($studentData['full_name']); endif; ?>
                    </div>
                    <div>
                        <div class="fw-bold" style="font-size:.9rem;"><?= htmlspecialchars($studentData['full_name']) ?></div>
                        <div class="text-muted small"><?= htmlspecialchars($studentData['email']) ?></div>
                    </div>
                </div>
                <div class="small text-muted mb-1"><i class="fas fa-calendar me-2 opacity-50"></i>Member since <?= date('d M Y', strtotime($studentData['created_at'])) ?></div>
                <?php if (!empty($studentData['github_link'])): ?>
                <div class="small text-muted mb-1">
                    <i class="fab fa-github me-2 opacity-50"></i>
                    <a href="<?= htmlspecialchars($studentData['github_link']) ?>" target="_blank" class="text-decoration-none" style="color:var(--portal-primary);">GitHub Profile</a>
                </div>
                <?php endif; ?>
                <a href="profile.php" class="btn btn-outline-primary w-100 mt-3" style="font-size:.8rem;">
                    <i class="fas fa-user me-1"></i> Edit Profile
                </a>
            </div>
        </div>

        <!-- Upcoming deadlines -->
        <div class="p-card flex-grow-1">
            <div class="p-card-header">
                <h5><i class="fas fa-calendar-alt me-2" style="color:#e6ac00;"></i>Upcoming Deadlines</h5>
            </div>
            <div class="p-card-body" style="padding:0;">
                <?php if (!empty($deadlines)): ?>
                <?php foreach ($deadlines as $dl):
                    $days = daysLeft($dl['due_date']);
                    $urgentColor = $days<=3 ? '#dc3545' : ($days<=7 ? '#e6ac00' : '#1d9e75');
                ?>
                <div style="padding:12px 16px;border-bottom:1px solid rgba(0,0,0,.04);display:flex;align-items:center;justify-content:space-between;gap:8px;">
                    <div style="min-width:0;">
                        <div class="fw-semibold text-truncate" style="font-size:.83rem;"><?= htmlspecialchars($dl['title']) ?></div>
                        <div class="text-muted" style="font-size:.72rem;"><?= htmlspecialchars($dl['course_name']) ?></div>
                    </div>
                    <div style="text-align:right;flex-shrink:0;">
                        <div style="font-size:.7rem;font-weight:700;color:<?= $urgentColor ?>;"><?= $days === 0 ? 'Today' : $days.'d left' ?></div>
                        <div style="font-size:.7rem;color:#aaa;"><?= date('d M', strtotime($dl['due_date'])) ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
                <div class="text-center p-2">
                    <a href="assignments.php" style="font-size:.78rem;color:var(--portal-primary);text-decoration:none;font-weight:600;">View all assignments →</a>
                </div>
                <?php else: ?>
                <div class="text-center py-4 px-3">
                    <i class="fas fa-check-circle fa-2x mb-2 d-block" style="color:#1d9e75;opacity:.5;"></i>
                    <p class="text-muted small mb-0">No upcoming deadlines — you're all caught up!</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quick links -->
        <div class="p-card">
            <div class="p-card-header"><h5><i class="fas fa-bolt me-2" style="color:var(--portal-secondary);"></i>Quick Links</h5></div>
            <div class="p-card-body" style="padding:8px;">
                <?php foreach ([
                    ['courses.php',     'fas fa-book-open',   'Course Materials',   '#378add'],
                    ['assignments.php', 'fas fa-tasks',       'Assignments',         '#ff8c00'],
                    ['grades.php',      'fas fa-chart-bar',   'Grades',              '#1d9e75'],
                    ['certificates.php','fas fa-certificate', 'Certificates',        '#e6ac00'],
                ] as [$href,$icon,$label,$color]): ?>
                <a href="<?= $href ?>" style="display:flex;align-items:center;gap:10px;padding:9px 10px;border-radius:8px;text-decoration:none;transition:.15s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='transparent'">
                    <div style="width:30px;height:30px;border-radius:8px;background:<?= $color ?>18;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="<?= $icon ?>" style="color:<?= $color ?>;font-size:.8rem;"></i>
                    </div>
                    <span style="font-size:.82rem;font-weight:500;color:#333;"><?= $label ?></span>
                    <i class="fas fa-chevron-right ms-auto" style="font-size:.65rem;color:#ccc;"></i>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</div>

<!-- Browse Courses Modal -->
<div class="modal fade" id="browseCoursesModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="border-radius:16px;overflow:hidden;">
            <div class="modal-header" style="background:var(--portal-gradient);color:#fff;border:none;">
                <h5 class="modal-title fw-bold"><i class="fas fa-graduation-cap me-2"></i>Available Courses</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <?php if (empty($availableCourses)): ?>
                <p class="text-muted text-center py-3">No courses available right now.</p>
                <?php else: ?>
                <div class="row g-3">
                    <?php foreach ($availableCourses as $course): ?>
                    <div class="col-md-6">
                        <div style="border-radius:12px;border:1px solid #e9ecef;overflow:hidden;height:100%;">
                            <?php if ($course['image_url']): ?>
                            <img src="<?= htmlspecialchars($course['image_url']) ?>" alt="" style="width:100%;height:130px;object-fit:cover;">
                            <?php endif; ?>
                            <div class="p-3">
                                <h6 class="fw-bold mb-1" style="font-size:.88rem;"><?= htmlspecialchars($course['title']) ?></h6>
                                <p class="text-muted mb-2" style="font-size:.78rem;"><?= htmlspecialchars(substr($course['description'],0,90)) ?>…</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <strong style="color:var(--portal-primary);font-size:.88rem;">₹<?= number_format($course['fee']) ?></strong>
                                    <button class="btn btn-sm btn-primary enroll-btn"
                                            data-course-id="<?= $course['id'] ?>"
                                            data-course-title="<?= htmlspecialchars($course['title']) ?>"
                                            data-course-fee="<?= $course['fee'] ?>"
                                            style="font-size:.78rem;">Enroll Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Enrollment Modal -->
<div class="modal fade" id="enrollmentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:16px;overflow:hidden;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Enroll in Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div id="enrollStep1">
                    <div style="background:#f8f9fa;border-radius:10px;padding:14px 16px;margin-bottom:16px;">
                        <div class="fw-bold small" id="selectedCourseTitle"></div>
                        <div class="text-muted small">Fee: <strong id="selectedCourseFee"></strong></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Special requirements <span class="text-muted fw-normal">(optional)</span></label>
                        <textarea class="form-control form-control-sm" id="notes" rows="2"></textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="agreeTerms">
                        <label class="form-check-label small" for="agreeTerms">I agree to the terms and conditions</label>
                    </div>
                    <input type="hidden" id="courseId">
                    <button class="btn btn-primary w-100" id="proceedToPayment" disabled>
                        Proceed to Payment <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </div>
                <div id="enrollStep2" style="display:none;text-align:center;">
                    <h6 class="fw-bold mb-3">Scan QR to Pay</h6>
                    <div id="qrCodeContainer" class="mb-3"></div>
                    <p class="text-muted small mb-3">After payment, click "Confirm Enrollment" below.</p>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary flex-fill" id="backToStep1">Back</button>
                        <button class="btn btn-success flex-fill" id="confirmEnrollment">Confirm Enrollment</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('agreeTerms').addEventListener('change', function() {
    document.getElementById('proceedToPayment').disabled = !this.checked;
});
document.querySelectorAll('.enroll-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        document.getElementById('selectedCourseTitle').textContent = this.dataset.courseTitle;
        document.getElementById('selectedCourseFee').textContent  = '₹' + this.dataset.courseFee;
        document.getElementById('courseId').value = this.dataset.courseId;
        document.getElementById('enrollStep1').style.display = 'block';
        document.getElementById('enrollStep2').style.display = 'none';
        document.getElementById('agreeTerms').checked = false;
        document.getElementById('proceedToPayment').disabled = true;
        bootstrap.Modal.getInstance(document.getElementById('browseCoursesModal'))?.hide();
        new bootstrap.Modal(document.getElementById('enrollmentModal')).show();
    });
});
document.getElementById('proceedToPayment').addEventListener('click', function() {
    var courseId = document.getElementById('courseId').value;
    var fee = document.getElementById('selectedCourseFee').textContent.replace('₹','');
    document.getElementById('qrCodeContainer').innerHTML =
        '<img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Course+'+courseId+'+Fee+Rs'+fee+'" alt="QR">';
    document.getElementById('enrollStep1').style.display = 'none';
    document.getElementById('enrollStep2').style.display = 'block';
});
document.getElementById('backToStep1').addEventListener('click', function() {
    document.getElementById('enrollStep1').style.display = 'block';
    document.getElementById('enrollStep2').style.display = 'none';
});
document.getElementById('confirmEnrollment').addEventListener('click', function() {
    var courseId = document.getElementById('courseId').value;
    var notes    = document.getElementById('notes').value;
    fetch('enroll.php', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'course_id='+courseId+'&notes='+encodeURIComponent(notes)
    })
    .then(r=>r.json())
    .then(data => {
        if (data.success) { location.reload(); }
        else { alert('Error: ' + (data.error || 'Unknown error')); }
    })
    .catch(() => alert('Network error.'));
});
</script>

<?php $conn->close(); require_once 'includes/footer.php'; ?>
