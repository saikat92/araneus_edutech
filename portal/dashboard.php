<?php
session_start();
require_once '../controller/Auth.php';

$auth = new Auth();

// Check if user is logged in
if (!$auth->isLoggedIn() || $auth->getUserRole() !== 'student') {
    header("Location: ../pages/login.php");
    exit();
}

$page_title = "Student Dashboard";
require_once '../includes/header.php';

// Database connection for fetching student data
require_once '../includes/database.php';
$db = new Database();
$conn = $db->getConnection();

// Fetch student details
$studentId = $auth->getStudentId();
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $studentId);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Fetch enrollments
$enrollmentStmt = $conn->prepare("
    SELECT e.*, c.course_name 
    FROM enrollments e
    LEFT JOIN courses c ON e.course_id = c.course_code
    WHERE e.student_id = ?
    ORDER BY e.enrollment_date DESC
");
$enrollmentStmt->bind_param("i", $studentId);
$enrollmentStmt->execute();
$enrollments = $enrollmentStmt->get_result();
$enrollmentStmt->close();
?>

<!-- Dashboard Header -->
<section class="dashboard-header bg-primary text-white py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="h2 mb-2">Welcome, <?php echo htmlspecialchars($student['full_name']); ?>!</h1>
                <p class="mb-0">Candidate ID: <strong><?php echo htmlspecialchars($student['candidate_id']); ?></strong></p>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-2"></i> My Account
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="courses.php"><i class="fas fa-book me-2"></i> My Courses</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Dashboard Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Quick Stats -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <div class="stat-icon mb-3">
                            <i class="fas fa-book-open fa-2x text-primary"></i>
                        </div>
                        <h3 class="mb-2"><?php echo $enrollments->num_rows; ?></h3>
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
                        <h3 class="mb-2">0</h3>
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
                        <h3 class="mb-2">0</h3>
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
                        <h3 class="mb-2"><?php echo htmlspecialchars($student['time_hours']); ?></h3>
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
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-book me-2"></i> My Courses</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($enrollments->num_rows > 0): ?>
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
                                    <?php while($enrollment = $enrollments->fetch_assoc()): ?>
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
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-book fa-3x text-muted mb-3"></i>
                            <h5>No Courses Enrolled</h5>
                            <p class="text-muted">You haven't enrolled in any courses yet.</p>
                            <a href="../pages/solutions/education.php" class="btn btn-primary">Browse Courses</a>
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
                                <?php if ($student['profile_picture']): ?>
                                <img src="../uploads/<?php echo htmlspecialchars($student['profile_picture']); ?>" 
                                     alt="Profile" class="rounded-circle" width="100" height="100">
                                <?php else: ?>
                                <div class="avatar-placeholder rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" 
                                     style="width: 100px; height: 100px;">
                                    <i class="fas fa-user fa-2x"></i>
                                </div>
                                <?php endif; ?>
                            </div>
                            <h5><?php echo htmlspecialchars($student['full_name']); ?></h5>
                            <p class="text-muted"><?php echo htmlspecialchars($student['course_completed']); ?></p>
                        </div>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-envelope me-2 text-primary"></i>
                                <?php echo htmlspecialchars($student['email']); ?>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-calendar me-2 text-primary"></i>
                                Course: <?php echo date('d M Y', strtotime($student['start_date'])); ?> - 
                                <?php echo date('d M Y', strtotime($student['end_date'])); ?>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-clock me-2 text-primary"></i>
                                Mode: <?php echo htmlspecialchars($student['mode']); ?>
                            </li>
                        </ul>
                        <a href="profile.php" class="btn btn-outline-primary w-100">Edit Profile</a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-bolt me-2"></i> Quick Links</h5>
                    </div>
                    <div class="card-body">
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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i> Upcoming Deadlines</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            No upcoming deadlines. Check back later!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Dashboard CSS -->
<style>
    .dashboard-header {
        background: linear-gradient(135deg, #FF4500 0%, #FFA500 100%);
    }
    
    .stat-card {
        border: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        background-color: rgba(255, 69, 0, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    
    .profile-avatar .avatar-placeholder {
        background: linear-gradient(135deg, #FF4500 0%, #FFA500 100%);
    }
    
    .table th {
        font-weight: 600;
        color: #555;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .progress {
        background-color: #e9ecef;
    }
    
    .progress-bar {
        background-color: #FF4500;
    }
    
    @media (max-width: 768px) {
        .dashboard-header {
            text-align: center;
        }
        
        .dashboard-header .text-md-end {
            text-align: center !important;
            margin-top: 15px;
        }
    }
</style>

<?php 
$db->close();
require_once '../includes/footer.php'; 
?>