<?php
$page_title = "Student Profile";
require_once 'includes/header.php';

// Fetch enrollments with course details and certificate info
$enrollments = [];
$query = "
    SELECT 
        e.*,
        c.title AS course_name,
        c.syllabus_file,
        cert.id AS certificate_id,
        cert.issue_date,
        cert.expiry_date,
        cert.file_path AS cert_file
    FROM enrollments e
    LEFT JOIN courses c ON e.course_id = c.id
    LEFT JOIN certificates cert ON e.certificate_id = cert.certificate_id
    WHERE e.student_id = ?
    ORDER BY e.enrollment_date DESC
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $studentId);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $enrollments[] = $row;
}
$stmt->close();
?>

<section class="py-5">
    <div class="container">
        <!-- First row: Profile Card and Info Card -->
        <div class="row">
            <!-- Profile Picture Card (left aligned) -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body d-flex align-items-center">
                        <!-- Clickable avatar -->
                        <div class="profile-avatar me-3" style="cursor: pointer;" onclick="document.getElementById('avatarUpload').click();">
                            <?php if (!empty($studentData['profile_picture'])): ?>
                                <img src="<?php echo SITE_URL . 'uploads/profile_pictures/' . htmlspecialchars($studentData['profile_picture']); ?>" 
                                     alt="Profile" class="rounded-circle" width="100" height="100" style="object-fit: cover;">
                            <?php else: ?>
                                <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center bg-primary text-white" 
                                     style="width: 100px; height: 100px;">
                                    <i class="fas fa-user fa-2x"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- Hidden file input -->
                        <form id="avatarForm" enctype="multipart/form-data" style="display:none;">
                            <input type="file" id="avatarUpload" name="profile_picture" accept="image/*">
                        </form>
                        <div>
                            <h5><?php echo htmlspecialchars($studentData['full_name']); ?></h5>
                            <p class="text-muted mb-1">
                                <i class="fas fa-envelope me-1"></i> <?php echo htmlspecialchars($studentData['email']); ?>
                            </p>
                            <p class="text-muted mb-0">
                                <i class="fas fa-phone me-1"></i> <?php echo htmlspecialchars($studentData['phone']); ?>
                            </p>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <small class="text-muted">Click on the avatar to change photo</small>
                    </div>
                </div>
            </div>

            <!-- My Profile Card with Edit Button in Header -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">My Profile</h4>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                            <i class="fas fa-edit me-1"></i> Edit
                        </button>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="fas fa-id-card me-2 text-primary"></i>
                                <strong>Candidate ID:</strong> <?php echo htmlspecialchars($studentData['candidate_id']); ?>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-graduation-cap me-2 text-primary"></i>
                                <strong>Highest Qualification:</strong> 
                                <?php echo htmlspecialchars($studentData['highest_qualification'] ?? 'Not specified'); ?>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-building me-2 text-primary"></i>
                                <strong>Current Organization:</strong> 
                                <?php echo htmlspecialchars($studentData['current_organization'] ?? 'Not specified'); ?>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-id-badge me-2 text-primary"></i>
                                <strong>Org. ID Card:</strong> 
                                <?php echo htmlspecialchars($studentData['org_i_card'] ?? 'Not specified'); ?>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                <strong>Address:</strong> 
                                <?php echo htmlspecialchars($studentData['address'] ?? 'Not specified'); ?>
                            </li>
                            <li class="mb-2">
                                <i class="fab fa-github me-2 text-primary"></i>
                                <strong>GitHub:</strong> 
                                <?php if (!empty($studentData['github_link'])): ?>
                                    <a href="<?php echo htmlspecialchars($studentData['github_link']); ?>" target="_blank">
                                        <?php echo htmlspecialchars($studentData['github_link']); ?>
                                    </a>
                                <?php else: ?>
                                    Not provided
                                <?php endif; ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second row: Enrollments Table -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <h4 class="mb-0">My Courses & Progress</h4>
                    </div>
                    <div class="card-body">
                        <?php if (empty($enrollments)): ?>
                            <p class="text-muted">You are not enrolled in any courses yet.</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Course</th>
                                            <th>Enrolled</th>
                                            <th>Completed</th>
                                            <th>Status</th>
                                            <th>Grade</th>
                                            <th>Certificate</th>
                                            <th>Syllabus</th>
                                            <th>Attendance</th>
                                            <th>Payment</th>
                                            <th>Project</th>
                                            <th>GitHub</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($enrollments as $enroll): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($enroll['course_name']); ?></td>
                                            <td><?php echo date('d M Y', strtotime($enroll['enrollment_date'])); ?></td>
                                            <td>
                                                <?php echo $enroll['completion_date'] ? date('d M Y', strtotime($enroll['completion_date'])) : '-'; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $badge = match($enroll['status']) {
                                                    'completed' => 'success',
                                                    'in_progress' => 'warning',
                                                    'dropped' => 'danger',
                                                    default => 'secondary'
                                                };
                                                ?>
                                                <span class="badge bg-<?php echo $badge; ?>">
                                                    <?php echo ucfirst(str_replace('_', ' ', $enroll['status'])); ?>
                                                </span>
                                            </td>
                                            <td><?php echo htmlspecialchars($enroll['grade'] ?? '-'); ?></td>
                                            <td>
                                                <?php if (!empty($enroll['cert_file'])): ?>
                                                    <button class="btn btn-sm btn-outline-primary" 
                                                            onclick="viewCertificate(<?php echo $enroll['certificate_id']; ?>)">
                                                        <i class="fas fa-certificate"></i> View
                                                    </button>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (!empty($enroll['syllabus_file'])): ?>
                                                    <a href="<?php echo SITE_URL . 'uploads/syllabus/' . $enroll['syllabus_file']; ?>" 
                                                       class="btn btn-sm btn-outline-secondary" download>
                                                        <i class="fas fa-download"></i> PDF
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (!empty($enroll['attendance_sheet'])): ?>
                                                    <a href="<?php echo SITE_URL . 'uploads/attendance/' . $enroll['attendance_sheet']; ?>" 
                                                       class="btn btn-sm btn-outline-secondary" download>
                                                        <i class="fas fa-download"></i> Sheet
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (!empty($enroll['payment_receipt'])): ?>
                                                    <a href="<?php echo SITE_URL . 'uploads/receipts/' . $enroll['payment_receipt']; ?>" 
                                                       class="btn btn-sm btn-outline-secondary" download>
                                                        <i class="fas fa-download"></i> Receipt
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (!empty($enroll['project_report'])): ?>
                                                    <a href="<?php echo SITE_URL . 'uploads/projects/' . $enroll['project_report']; ?>" 
                                                       class="btn btn-sm btn-outline-secondary" download>
                                                        <i class="fas fa-download"></i> Report
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (!empty($studentData['github_link'])): ?>
                                                    <a href="<?php echo htmlspecialchars($studentData['github_link']); ?>" 
                                                       target="_blank" class="btn btn-sm btn-outline-dark">
                                                        <i class="fab fa-github"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
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
            </div>
        </div>
    </div>
</section>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editProfileForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" 
                                   value="<?php echo htmlspecialchars($studentData['full_name']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" 
                                   value="<?php echo htmlspecialchars($studentData['phone']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($studentData['email']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="father_name" class="form-label">Father's Name</label>
                            <input type="text" class="form-control" id="father_name" name="father_name" 
                                   value="<?php echo htmlspecialchars($studentData['father_name']); ?>">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="2"><?php echo htmlspecialchars($studentData['address']); ?></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="highest_qualification" class="form-label">Highest Qualification</label>
                            <input type="text" class="form-control" id="highest_qualification" name="highest_qualification" 
                                   value="<?php echo htmlspecialchars($studentData['highest_qualification'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="current_organization" class="form-label">Current Organization</label>
                            <input type="text" class="form-control" id="current_organization" name="current_organization" 
                                   value="<?php echo htmlspecialchars($studentData['current_organization'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="org_i_card" class="form-label">Organization ID Card</label>
                            <input type="text" class="form-control" id="org_i_card" name="org_i_card" 
                                   value="<?php echo htmlspecialchars($studentData['org_i_card'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="github_link" class="form-label">GitHub Link</label>
                            <input type="url" class="form-control" id="github_link" name="github_link" 
                                   value="<?php echo htmlspecialchars($studentData['github_link'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Certificate View Modal -->
<div class="modal fade" id="certificateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Certificate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="certificateContent">
                <!-- Loaded via AJAX -->
            </div>
        </div>
    </div>
</div>

<script>
// Avatar upload via AJAX
document.getElementById('avatarUpload').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    const formData = new FormData();
    formData.append('profile_picture', file);
    fetch('upload_avatar.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // or update avatar src dynamically
        } else {
            alert('Upload failed: ' + data.error);
        }
    })
    .catch(err => alert('Error uploading file.'));
});

// Edit profile form submission
document.getElementById('editProfileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('update_profile.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Update failed: ' + data.error);
        }
    })
    .catch(err => alert('Error updating profile.'));
});

// View certificate modal
function viewCertificate(certId) {
    fetch('get_certificate.php?id=' + certId)
        .then(response => response.text())
        .then(html => {
            document.getElementById('certificateContent').innerHTML = html;
            new bootstrap.Modal(document.getElementById('certificateModal')).show();
        });
}
</script>

<?php 
$conn->close();
require_once 'includes/footer.php'; 
?>