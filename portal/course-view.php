<?php
$page_title = "Course Details";
require_once 'includes/header.php';
$counter = 1;
// Get enrollment ID from URL
$enrollmentId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$enrollmentId) {
    echo '<div class="container py-5"><div class="alert alert-danger">Invalid course access.</div></div>';
    require_once 'includes/footer.php';
    exit;
}

// Verify this enrollment belongs to the logged-in student
$enrollStmt = $conn->prepare("
    SELECT e.*, c.id as course_id, c.title, c.description, c.duration, c.instructor, c.tools_provided, c.hardware_kit, c.syllabus_file
    FROM enrollments e
    JOIN courses c ON e.course_id = c.id
    WHERE e.id = ? AND e.student_id = ?
");
$enrollStmt->bind_param("ii", $enrollmentId, $studentId);
$enrollStmt->execute();
$enrollment = $enrollStmt->get_result()->fetch_assoc();
$enrollStmt->close();

if (!$enrollment) {
    echo '<div class="container py-5"><div class="alert alert-danger">Course not found or access denied.</div></div>';
    require_once 'includes/footer.php';
    exit;
}

$courseId = $enrollment['course_id'];

// Fetch assignments for this course
$assignStmt = $conn->prepare("SELECT * FROM assignments WHERE course_id = ? ORDER BY due_date");
$assignStmt->bind_param("i", $courseId);
$assignStmt->execute();
$assignments = $assignStmt->get_result();
$assignStmt->close();

// Fetch existing submissions for this student
$submissions = [];
$subStmt = $conn->prepare("SELECT assignment_id, submission_file, grade, feedback FROM submissions WHERE student_id = ?");
$subStmt->bind_param("i", $studentId);
$subStmt->execute();
$subRes = $subStmt->get_result();
while ($row = $subRes->fetch_assoc()) {
    $submissions[$row['assignment_id']] = $row;
}
$subStmt->close();

// Fetch attendance records for this course
$attStmt = $conn->prepare("SELECT date, hours FROM attendance WHERE student_id = ? AND course_id = ? ORDER BY date DESC");
$attStmt->bind_param("ii", $studentId, $courseId);
$attStmt->execute();
$attendance = $attStmt->get_result();
$attStmt->close();

// Calculate total attendance hours for this course
$totalHours = 0;
$attendanceList = [];
while ($row = $attendance->fetch_assoc()) {
    $totalHours += $row['hours'];
    $attendanceList[] = $row;
}
// Reset pointer for display
$attendance->data_seek(0);

// Fetch existing project report filename
$projectReport = $enrollment['project_report'];

// Handle file uploads
$uploadMessage = '';
$uploadError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle assignment submission
    if (isset($_POST['submit_assignment']) && isset($_FILES['assignment_file'])) {
        $assignmentId = intval($_POST['assignment_id']);
        $file = $_FILES['assignment_file'];
        
        if ($file['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = 'assignment_' . $studentId . '_' . $assignmentId . '_' . time() . '.' . $ext;
            $destination = SITE_ROOT . 'uploads/assignments/' . $filename;
            
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                // Check if submission already exists
                $checkSub = $conn->prepare("SELECT id FROM submissions WHERE assignment_id = ? AND student_id = ?");
                $checkSub->bind_param("ii", $assignmentId, $studentId);
                $checkSub->execute();
                $checkSub->store_result();
                
                if ($checkSub->num_rows > 0) {
                    // Update existing
                    $updateSub = $conn->prepare("UPDATE submissions SET submission_file = ?, submitted_at = NOW() WHERE assignment_id = ? AND student_id = ?");
                    $updateSub->bind_param("sii", $filename, $assignmentId, $studentId);
                    $updateSub->execute();
                    $updateSub->close();
                } else {
                    // Insert new
                    $insertSub = $conn->prepare("INSERT INTO submissions (assignment_id, student_id, submission_file) VALUES (?, ?, ?)");
                    $insertSub->bind_param("iis", $assignmentId, $studentId, $filename);
                    $insertSub->execute();
                    $insertSub->close();
                }
                $checkSub->close();
                
                $uploadMessage = "Assignment submitted successfully.";
            } else {
                $uploadError = "Failed to upload file.";
            }
        } else {
            $uploadError = "File upload error.";
        }
    }
    
    // Handle project report upload
    if (isset($_POST['upload_project']) && isset($_FILES['project_file'])) {
        $file = $_FILES['project_file'];
        
        if ($file['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = 'project_' . $studentId . '_' . $enrollmentId . '_' . time() . '.' . $ext;
            $destination = SITE_ROOT . 'uploads/projects/' . $filename;
            
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $updateProject = $conn->prepare("UPDATE enrollments SET project_report = ? WHERE id = ?");
                $updateProject->bind_param("si", $filename, $enrollmentId);
                $updateProject->execute();
                $updateProject->close();
                
                $projectReport = $filename;
                $uploadMessage = "Project report uploaded successfully.";
            } else {
                $uploadError = "Failed to upload project file.";
            }
        } else {
            $uploadError = "Project file upload error.";
        }
    }
    
    // Handle attendance marking
    if (isset($_POST['mark_attendance'])) {
        $attendanceDate = $_POST['attendance_date'] ?? date('Y-m-d');
        $hours = floatval($_POST['hours'] ?? 1.0);
        
        // Check if attendance already marked for this date
        $checkAtt = $conn->prepare("SELECT id FROM attendance WHERE student_id = ? AND course_id = ? AND date = ?");
        $checkAtt->bind_param("iis", $studentId, $courseId, $attendanceDate);
        $checkAtt->execute();
        $checkAtt->store_result();
        
        if ($checkAtt->num_rows == 0) {
            $insertAtt = $conn->prepare("INSERT INTO attendance (student_id, course_id, date, hours) VALUES (?, ?, ?, ?)");
            $insertAtt->bind_param("iisd", $studentId, $courseId, $attendanceDate, $hours);
            $insertAtt->execute();
            $insertAtt->close();
            
            // Update total time_hours in students table
            $updateHours = $conn->prepare("UPDATE students SET time_hours = time_hours + ? WHERE id = ?");
            $updateHours->bind_param("di", $hours, $studentId);
            $updateHours->execute();
            $updateHours->close();
            
            $uploadMessage = "Attendance marked for " . date('d M Y', strtotime($attendanceDate)) . " (+{$hours} hour(s)).";
        } else {
            $uploadError = "Attendance already marked for this date.";
        }
        $checkAtt->close();
    }
    
    // Refresh page after POST to avoid resubmission
    if ($uploadMessage || $uploadError) {
        // We'll show messages below
    }
}
?>

<section class="py-4">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($enrollment['title']); ?></li>
            </ol>
        </nav>

        <?php if ($uploadMessage): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $uploadMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if ($uploadError): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $uploadError; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Course Header -->
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="mb-3"><?php echo htmlspecialchars($enrollment['title']); ?></h2>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Duration:</strong> <?php echo htmlspecialchars($enrollment['duration']); ?></p>
                        <p><strong>Instructor:</strong> <?php echo htmlspecialchars($enrollment['instructor']); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Enrolled on:</strong> <?php echo date('d M Y', strtotime($enrollment['enrollment_date'])); ?></p>
                        <p><strong>Status:</strong> 
                            <span class="badge bg-<?php echo $enrollment['status'] == 'completed' ? 'success' : ($enrollment['status'] == 'in_progress' ? 'primary' : 'secondary'); ?>">
                                <?php echo ucfirst($enrollment['status']); ?>
                            </span>
                        </p>
                    </div>
                </div>
                <?php if ($enrollment['syllabus_file']): ?>
                <a href="<?php echo SITE_URL; ?>uploads/syllabus/<?php echo $enrollment['syllabus_file']; ?>" class="btn btn-sm btn-outline-primary" download>
                    <i class="fas fa-download"></i> Download Syllabus
                </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs mb-4" id="courseTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab" aria-controls="attendance" aria-selected="false">Attendance</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="assignments-tab" data-bs-toggle="tab" data-bs-target="#assignments" type="button" role="tab" aria-controls="assignments" aria-selected="true">Assignments</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="project-tab" data-bs-toggle="tab" data-bs-target="#project" type="button" role="tab" aria-controls="project" aria-selected="false">Project Report</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="resources-tab" data-bs-toggle="tab" data-bs-target="#resources" type="button" role="tab" aria-controls="resources" aria-selected="false">Resources</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="certificate-tab" data-bs-toggle="tab" data-bs-target="#certificate" type="button" role="tab" aria-controls="certificate" aria-selected="false">Certificates</button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="courseTabsContent">
            <!-- Assignments Tab -->
            <div class="tab-pane fade" id="assignments" role="tabpanel" aria-labelledby="assignments-tab">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Assignments</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($assignments->num_rows == 0): ?>
                            <p class="text-muted">No assignments posted for this course yet.</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sl. No.</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Due Date</th>
                                            <th>Submission</th>
                                            <th>Grade/Feedback</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($assign = $assignments->fetch_assoc()): 
                                            $submitted = isset($submissions[$assign['id']]);
                                            $subData = $submitted ? $submissions[$assign['id']] : null;
                                        ?>
                                        <tr>
                                            <td><?php echo $counter++; ?></td>
                                            <td><?php echo htmlspecialchars($assign['title']); ?></td>
                                            <td><?php echo nl2br(htmlspecialchars($assign['description'])); ?></td>
                                            <td>
                                                <?php echo date('d M Y', strtotime($assign['due_date'])); ?>
                                                <?php if (strtotime($assign['due_date']) < time()): ?>
                                                    <span class="badge bg-danger">Overdue</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($submitted): ?>
                                                    <span class="badge bg-success">Submitted</span>
                                                    <?php if ($subData['submission_file']): ?>
                                                        <br><a href="<?php echo SITE_URL; ?>uploads/assignments/<?php echo $subData['submission_file']; ?>" download class="small">Download</a>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="badge bg-warning">Not submitted</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($submitted && $subData['grade']): ?>
                                                    <strong>Grade:</strong> <?php echo $subData['grade']; ?><br>
                                                <?php endif; ?>
                                                <?php if ($submitted && $subData['feedback']): ?>
                                                    <small><?php echo nl2br(htmlspecialchars($subData['feedback'])); ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (!$submitted || strtotime($assign['due_date']) > time()): ?>
                                                <form method="post" enctype="multipart/form-data" class="d-flex align-items-center">
                                                    <input type="hidden" name="assignment_id" value="<?php echo $assign['id']; ?>">
                                                    <input type="file" name="assignment_file" class="form-control form-control-sm me-2" style="width: 150px;" required>
                                                    <button type="submit" name="submit_assignment" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-upload"></i> Upload
                                                    </button>
                                                </form>
                                                <?php else: ?>
                                                    <span class="text-muted">Closed</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Project Report Tab -->
            <div class="tab-pane fade" id="project" role="tabpanel" aria-labelledby="project-tab">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Project Report</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Current Report:</h6>
                                <?php if ($projectReport): ?>
                                    <p>
                                        <i class="fas fa-file-pdf text-danger"></i> 
                                        <a href="<?php echo SITE_URL; ?>uploads/projects/<?php echo $projectReport; ?>" target="_blank">View Report</a>
                                        <br>
                                        <a href="<?php echo SITE_URL; ?>uploads/projects/<?php echo $projectReport; ?>" download class="btn btn-sm btn-outline-primary mt-2">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    </p>
                                <?php else: ?>
                                    <p class="text-muted">No project report uploaded yet.</p>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <h6>Upload New Report:</h6>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="project_file" class="form-label">Choose file (PDF, DOC, DOCX)</label>
                                        <input type="file" class="form-control" id="project_file" name="project_file" accept=".pdf,.doc,.docx" required>
                                    </div>
                                    <button type="submit" name="upload_project" class="btn btn-primary">
                                        <i class="fas fa-upload"></i> Upload Project
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance Tab -->
            <div class="tab-pane fade show active" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Attendance</h5>
                        <span class="badge bg-info">Total Hours: <?php echo $totalHours; ?></span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6>Mark Today's Attendance</h6>
                                        <form method="post">
                                            <div class="mb-3">
                                                <label for="attendance_date" class="form-label">Date</label>
                                                <input type="date" class="form-control" id="attendance_date" name="attendance_date" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="hours" class="form-label">Hours</label>
                                                <input type="number" step="0.5" min="0.5" max="12" class="form-control" id="hours" name="hours" value="1.0" required>
                                            </div>
                                            <button type="submit" name="mark_attendance" class="btn btn-success">
                                                <i class="fas fa-check-circle"></i> Mark Attendance
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <h6>Recent Attendance</h6>
                                <?php if (count($attendanceList) > 0): ?>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Hours</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($attendanceList as $att): ?>
                                                <tr>
                                                    <td><?php echo date('d M Y', strtotime($att['date'])); ?></td>
                                                    <td><?php echo $att['hours']; ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted">No attendance records yet.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resources Tab -->
            <div class="tab-pane fade" id="resources" role="tabpanel" aria-labelledby="resources-tab">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Course Resources</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Tools Provided</h6>
                                <p><?php echo nl2br(htmlspecialchars($enrollment['tools_provided'] ?? 'Not specified')); ?></p>
                            </div>
                            <div class="col-md-6">
                                <h6>Hardware Kit</h6>
                                <p><?php echo nl2br(htmlspecialchars($enrollment['hardware_kit'] ?? 'Not specified')); ?></p>
                            </div>
                        </div>
                        <?php if ($enrollment['syllabus_file']): ?>
                        <hr>
                        <a href="<?php echo SITE_URL; ?>uploads/syllabus/<?php echo $enrollment['syllabus_file']; ?>" class="btn btn-outline-secondary" download>
                            <i class="fas fa-download"></i> Download Syllabus
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Certificates Tab -->
            <div class="tab-pane fade" id="certificate" role="tabpanel" aria-labelledby="certificate-tab">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Certificates</h5>
                    </div>
                    <div class="card-body">
                        <p>Certificates will be available here once you complete the course.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php 
$conn->close();
require_once 'includes/footer.php'; 
?>