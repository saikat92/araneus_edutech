<?php
$page_title = "Student Dashboard";
require_once 'includes/header.php';

// Fetch all active courses for the browse modal
$coursesQuery = "SELECT * FROM courses WHERE is_active = 1 ORDER BY title";
$coursesResult = $conn->query($coursesQuery);
$availableCourses = $coursesResult->fetch_all(MYSQLI_ASSOC);

// Re-fetch enrollments (already done in header, but we need a fresh one for the table)
// We'll reuse the $enrollments variable from header, but note that it's a result object.
// If we need to loop again, we should store it in an array.
$enrollments->data_seek(0); // reset pointer
$enrollmentsList = [];
while ($row = $enrollments->fetch_assoc()) {
    $enrollmentsList[] = $row;
}
$enrollmentsCount = count($enrollmentsList);
?>

<!-- Dashboard Content -->
<section class="py-5">
    <div class="container">
        <!-- Quick Stats -->
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <div class="stat-icon mb-3">
                            <i class="fas fa-book-open fa-2x text-primary"></i>
                        </div>
                        <h3 class="mb-2"><?php echo $enrollmentsCount; ?></h3>
                        <p class="text-muted mb-0">Courses Enrolled</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <div class="stat-icon mb-3">
                            <i class="fas fa-tasks fa-2x text-success"></i>
                        </div>
                        <h3 class="mb-2"><?php echo $pendingAssignments; ?></h3>
                        <p class="text-muted mb-0">Pending Assignments</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <div class="stat-icon mb-3">
                            <i class="fas fa-certificate fa-2x text-warning"></i>
                        </div>
                        <h3 class="mb-2"><?php echo $certCount; ?></h3>
                        <p class="text-muted mb-0">Certificates Earned</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <div class="stat-icon mb-3">
                            <i class="fas fa-clock fa-2x text-info"></i>
                        </div>
                        <h3 class="mb-2"><?php echo htmlspecialchars($studentData['time_hours']); ?></h3>
                        <p class="text-muted mb-0">Course Hours</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Row -->
        <div class="row">
            <!-- My Courses -->
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-book me-2"></i> My Courses</h5>
                        <?php if ($enrollmentsCount == 0): ?>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#browseCoursesModal">
                                <i class="fas fa-search me-1"></i> Browse Courses
                            </button>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <?php if ($enrollmentsCount > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Course</th>
                                        <th>Enrollment Date</th>
                                        <th>Status</th>
                                        <th>Progress</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($enrollmentsList as $enrollment): ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo htmlspecialchars($enrollment['course_name'] ?? 'N/A'); ?></strong><br>
                                            <small class="text-muted"><?php echo htmlspecialchars($enrollment['course_id']); ?></small>
                                        </td>
                                        <td><?php echo date('d M Y', strtotime($enrollment['enrollment_date'])); ?></td>
                                        <td>
                                            <span class="badge bg-<?php 
                                                echo $enrollment['status'] == 'completed' ? 'success' : 
                                                     ($enrollment['status'] == 'in_progress' ? 'primary' : 'secondary'); 
                                            ?>">
                                                <?php echo ucfirst($enrollment['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar" role="progressbar" 
                                                     style="width: <?php echo $enrollment['status'] == 'completed' ? '100' : '50'; ?>%;"></div>
                                            </div>
                                            <small><?php echo $enrollment['status'] == 'completed' ? '100%' : '50%'; ?></small>
                                        </td>
                                        <td>
                                            <a href="course-view.php?id=<?php echo $enrollment['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-book fa-3x text-muted mb-3"></i>
                            <h5>No Courses Enrolled</h5>
                            <p class="text-muted">You haven't enrolled in any courses yet.</p>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#browseCoursesModal">
                                Browse Courses
                            </button>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Quick Links & Profile -->
            <div class="col-lg-4 mb-4">
                <!-- Profile Summary -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i> Profile Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="profile-avatar mb-3">
                                <?php if ($studentData['profile_picture']): ?>
                                <img src="<?php echo SITE_URL; ?>uploads/profile_pictures/<?php echo htmlspecialchars($studentData['profile_picture']); ?>" 
                                     alt="Profile" class="rounded-circle" width="100" height="100">
                                <?php else: ?>
                                <div class="avatar-placeholder rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" 
                                     style="width: 100px; height: 100px;">
                                    <i class="fas fa-user fa-2x"></i>
                                </div>
                                <?php endif; ?>
                            </div>
                            <h5><?php echo htmlspecialchars($studentData['full_name']); ?></h5>
                        </div>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-envelope me-2 text-primary"></i>
                                <?php echo htmlspecialchars($studentData['email']); ?>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-calendar me-2 text-primary"></i>
                                Member since: <?php echo date('d M Y', strtotime($studentData['created_at'])); ?>
                            </li>
                        </ul>
                        <!-- <a href="profile.php" class="btn btn-outline-primary w-100">View Profile</a>
                    </div>
                </div>

             
                <div class="card"> -->
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-bolt me-2"></i> Quick Links</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <a href="courses.php" class="list-group-item list-group-item-action">
                                <i class="fas fa-book me-2"></i> Course Materials
                            </a>
                            <a href="assignments.php" class="list-group-item list-group-item-action">
                                <i class="fas fa-tasks me-2"></i> Assignments
                            </a>
                            <a href="grades.php" class="list-group-item list-group-item-action">
                                <i class="fas fa-chart-line me-2"></i> Grades & Progress
                            </a>
                            <a href="certificates.php" class="list-group-item list-group-item-action">
                                <i class="fas fa-certificate me-2"></i> Certificates
                            </a>
                            <a href="discussions.php" class="list-group-item list-group-item-action">
                                <i class="fas fa-comments me-2"></i> Discussion Forum
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Deadlines -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i> Upcoming Deadlines</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        // Fetch upcoming assignments for enrolled courses
                        $deadlineStmt = $conn->prepare("
                            SELECT a.title, a.due_date, c.title as course_name
                            FROM assignments a
                            JOIN courses c ON a.course_id = c.id
                            JOIN enrollments e ON e.course_id = c.id AND e.student_id = ?
                            WHERE a.due_date >= CURDATE()
                            ORDER BY a.due_date ASC
                            LIMIT 5
                        ");
                        $deadlineStmt->bind_param("i", $studentId);
                        $deadlineStmt->execute();
                        $deadlines = $deadlineStmt->get_result();
                        ?>
                        <?php if ($deadlines->num_rows > 0): ?>
                            <div class="list-group">
                                <?php while ($dl = $deadlines->fetch_assoc()): ?>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong><?php echo htmlspecialchars($dl['title']); ?></strong><br>
                                        <small class="text-muted"><?php echo htmlspecialchars($dl['course_name']); ?></small>
                                    </div>
                                    <span class="badge bg-warning">Due: <?php echo date('d M', strtotime($dl['due_date'])); ?></span>
                                </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                No upcoming deadlines. Enjoy your break!
                            </div>
                        <?php endif; ?>
                        <?php $deadlineStmt->close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Browse Courses Modal -->
<div class="modal fade" id="browseCoursesModal" tabindex="-1" aria-labelledby="browseCoursesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="browseCoursesModalLabel">Available Courses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php foreach ($availableCourses as $course): ?>
                    <div class="col-md-6 mb-3">
                        <div class="card h-100">
                            <?php if ($course['image_url']): ?>
                            <img src="<?php echo htmlspecialchars($course['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($course['title']); ?>" style="height: 150px; object-fit: cover;">
                            <?php endif; ?>
                            <div class="card-body">
                                <h6 class="card-title"><?php echo htmlspecialchars($course['title']); ?></h6>
                                <p class="card-text small"><?php echo htmlspecialchars(substr($course['description'], 0, 100)); ?>...</p>
                                <p class="card-text"><strong>Fee: ₹<?php echo $course['fee']; ?></strong></p>
                                <button class="btn btn-sm btn-primary enroll-btn" 
                                        data-course-id="<?php echo $course['id']; ?>"
                                        data-course-title="<?php echo htmlspecialchars($course['title']); ?>"
                                        data-course-fee="<?php echo $course['fee']; ?>">
                                    Enroll Now
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enrollment Modal -->
<div class="modal fade" id="enrollmentModal" tabindex="-1" aria-labelledby="enrollmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enrollmentModalLabel">Enroll in Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="enrollmentStep1">
                    <h6 id="selectedCourseTitle"></h6>
                    <p>Fee: <strong id="selectedCourseFee"></strong></p>
                    <form id="enrollmentForm">
                        <input type="hidden" name="course_id" id="courseId">
                        <div class="mb-3">
                            <label for="notes" class="form-label">Any special requirements? (optional)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                            <label class="form-check-label" for="agreeTerms">
                                I agree to the terms and conditions
                            </label>
                        </div>
                        <button type="button" class="btn btn-primary" id="proceedToPayment" disabled>Proceed to Payment</button>
                    </form>
                </div>
                <div id="enrollmentStep2" style="display: none;">
                    <div class="text-center">
                        <h6>Scan this QR code to pay</h6>
                        <div id="qrCodeContainer" class="my-3"></div>
                        <p>After payment, click "Confirm Enrollment" to complete.</p>
                        <button class="btn btn-success" id="confirmEnrollment">Confirm Enrollment</button>
                        <button class="btn btn-secondary" id="backToStep1">Back</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Enable enroll button only after terms checked
document.getElementById('agreeTerms').addEventListener('change', function() {
    document.getElementById('proceedToPayment').disabled = !this.checked;
});

// Handle enroll button clicks
document.querySelectorAll('.enroll-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const courseId = this.dataset.courseId;
        const courseTitle = this.dataset.courseTitle;
        const courseFee = this.dataset.courseFee;
        
        document.getElementById('selectedCourseTitle').innerText = courseTitle;
        document.getElementById('selectedCourseFee').innerText = '₹' + courseFee;
        document.getElementById('courseId').value = courseId;
        
        // Reset modal steps
        document.getElementById('enrollmentStep1').style.display = 'block';
        document.getElementById('enrollmentStep2').style.display = 'none';
        document.getElementById('agreeTerms').checked = false;
        document.getElementById('proceedToPayment').disabled = true;
        
        // Hide browse modal and show enrollment modal
        bootstrap.Modal.getInstance(document.getElementById('browseCoursesModal')).hide();
        new bootstrap.Modal(document.getElementById('enrollmentModal')).show();
    });
});

// Proceed to payment step
document.getElementById('proceedToPayment').addEventListener('click', function() {
    const courseId = document.getElementById('courseId').value;
    const fee = document.getElementById('selectedCourseFee').innerText.replace('₹', '');
    
    // Generate dummy QR code (using QRServer API)
    const qrContainer = document.getElementById('qrCodeContainer');
    qrContainer.innerHTML = `<img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Payment for course ${courseId} - ₹${fee}" alt="QR Code">`;
    
    document.getElementById('enrollmentStep1').style.display = 'none';
    document.getElementById('enrollmentStep2').style.display = 'block';
});

// Back to step 1
document.getElementById('backToStep1').addEventListener('click', function() {
    document.getElementById('enrollmentStep1').style.display = 'block';
    document.getElementById('enrollmentStep2').style.display = 'none';
});

// Confirm enrollment (AJAX)
document.getElementById('confirmEnrollment').addEventListener('click', function() {
    const courseId = document.getElementById('courseId').value;
    const notes = document.getElementById('notes').value;
    
    fetch('enroll.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `course_id=${courseId}&notes=${encodeURIComponent(notes)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Enrollment successful!');
            location.reload();
        } else {
            alert('Error: ' + data.error);
        }
    })
    .catch(err => alert('Network error.'));
});
</script>

<?php
$conn->close();
require_once 'includes/footer.php';
?>