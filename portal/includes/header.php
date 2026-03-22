<?php
require_once '../controller/Auth.php';
require_once '../controller/StudentController.php';

$auth = new Auth();
$student = new StudentController();

// Check if user is logged in
if (!$auth->isLoggedIn() || $auth->getUserRole() !== 'student') {
    header("Location: ../pages/login.php");
    exit();
}

$db = new Database();
$conn = $db->getConnection();


// Fetch student details
$studentId = $auth->getStudentId();
$studentData = $student->getStudentById($studentId);

// Fetch enrollments
$enrollmentStmt = $conn->prepare("
    SELECT e.*, c.title AS course_name 
    FROM enrollments e
    LEFT JOIN courses c ON e.course_id = c.id
    WHERE e.student_id = ?
    ORDER BY e.enrollment_date DESC
");
// id	student_id	course_id	course_name	enrollment_date	completion_date	status	grade	certificate_issued	created_at	course_name	

$enrollmentStmt->bind_param("i", $studentId);
$enrollmentStmt->execute();
$enrollments = $enrollmentStmt->get_result();
$enrollmentStmt->close();


// Fetch certificates count (from enrollments)
$certStmt = $conn->prepare("SELECT COUNT(*) as cert_count FROM enrollments WHERE student_id = ? AND certificate_issued = 1");
$certStmt->bind_param("i", $studentId);
$certStmt->execute();
$certResult = $certStmt->get_result();
$certCount = $certResult->fetch_assoc()['cert_count'];
$certStmt->close();

// Fetch pending assignments count (if assignments table exists)
$assignStmt = $conn->prepare("
    SELECT COUNT(*) as pending 
    FROM assignments a
    LEFT JOIN submissions s ON a.id = s.assignment_id AND s.student_id = ?
    WHERE a.due_date >= CURDATE() AND s.id IS NULL
");
$assignStmt->bind_param("i", $studentId);
$assignStmt->execute();
$assignResult = $assignStmt->get_result();
$pendingAssignments = $assignResult->fetch_assoc()['pending'] ?? 0;
$assignStmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Araneus Edutech LLP - <?php echo $page_title ?? 'Professional Consultancy'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">    
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/css/style.css">    
    <link rel="icon" type="image/x-icon" href="<?php echo SITE_URL; ?>assets/images/icon.png"></head>
<body>
    
<!-- Dashboard Header – unchanged -->
    <section class="dashboard-header bg-primary text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h2 mb-2">Welcome, <?php echo htmlspecialchars($studentData['full_name']); ?>!</h1>
                    <p class="mb-0">Candidate ID: <strong><?php echo htmlspecialchars($studentData['candidate_id']); ?></strong></p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-2"></i> My Account
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="dashboard.php"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
                            <li><a class="dropdown-item" href="courses.php"><i class="fas fa-book-open me-2"></i> My Courses</a></li>
                            <li><a class="dropdown-item" href="assignments.php"><i class="fas fa-tasks me-2"></i> Assignments</a></li>
                            <li><a class="dropdown-item" href="grades.php"><i class="fas fa-chart-bar me-2"></i> Grades</a></li>
                            <li><a class="dropdown-item" href="certificates.php"><i class="fas fa-certificate me-2"></i> Certificates</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i> Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>