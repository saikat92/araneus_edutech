<?php
session_start();
$page_title = "Student Portal Login";
require_once  __DIR__ . '/../assets/_header.php';

// Handle login
$errorMsg = '';
$successMsg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $candidate_id = trim($_POST['candidate_id'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    // Basic validation
    if (empty($candidate_id) || empty($password)) {
        $errorMsg = "Please enter both Candidate ID and Password";
    } else {
        try {
            require_once __DIR__ . '/../core/connection.php';
            $db = new Database();
            $conn = $db->getConnection();
            
            // Prepare SQL to check student
            $stmt = $conn->prepare("SELECT * FROM students WHERE candidate_id = ? AND status = 'active'");
            $stmt->bind_param("s", $candidate_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 1) {
                $student = $result->fetch_assoc();
                
                // Verify password (assuming passwords are hashed)
                if (password_verify($password, $student['password'])) {
                    // Set session variables
                    $_SESSION['student_id'] = $student['id'];
                    $_SESSION['candidate_id'] = $student['candidate_id'];
                    $_SESSION['student_name'] = $student['full_name'];
                    $_SESSION['student_email'] = $student['email'];
                    $_SESSION['logged_in'] = true;
                    
                    // Update last login
                    $updateStmt = $conn->prepare("UPDATE students SET last_login = NOW() WHERE id = ?");
                    $updateStmt->bind_param("i", $student['id']);
                    $updateStmt->execute();
                    $updateStmt->close();
                    
                    // Redirect to dashboard
                    header("Location: portal-dashboard.php");
                    exit();
                } else {
                    $errorMsg = "Invalid Candidate ID or Password";
                }
            } else {
                $errorMsg = "Invalid Candidate ID or Password";
            }
            
            $stmt->close();
            $db->close();
            
        } catch (Exception $e) {
            $errorMsg = "Login failed. Please try again later.";
        }
    }
}
?>

<!-- Hero Section -->
<section class="portal-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="portal-info">
                    <h1 class="display-4 fw-bold mb-4">Student Portal</h1>
                    <p class="lead mb-4">Access your personalized learning dashboard, course materials, assignments, and track your academic progress.</p>
                    
                    <div class="portal-features">
                        <div class="feature-item mb-3">
                            <i class="fas fa-check-circle text-success me-3"></i>
                            <span>Access course materials & resources</span>
                        </div>
                        <div class="feature-item mb-3">
                            <i class="fas fa-check-circle text-success me-3"></i>
                            <span>Submit assignments online</span>
                        </div>
                        <div class="feature-item mb-3">
                            <i class="fas fa-check-circle text-success me-3"></i>
                            <span>Track your progress & grades</span>
                        </div>
                        <div class="feature-item mb-3">
                            <i class="fas fa-check-circle text-success me-3"></i>
                            <span>Participate in discussion forums</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check-circle text-success me-3"></i>
                            <span>Connect with instructors & peers</span>
                        </div>
                    </div>
                    
                    <div class="mt-5">
                        <p>New to the portal? <a href="portal-register.php" class="text-primary fw-bold">Create an account</a></p>
                        <p>Forgot your password? <a href="portal-forgot-password.php" class="text-primary fw-bold">Reset it here</a></p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="portal-login-card">
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <div class="portal-logo mb-3">
                                    <i class="fas fa-user-graduate fa-3x text-primary"></i>
                                </div>
                                <h2 class="h3 mb-3">Student Login</h2>
                                <p class="text-muted">Enter your credentials to access your dashboard</p>
                            </div>
                            
                            <?php if ($errorMsg): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i> <?php echo $errorMsg; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($successMsg): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i> <?php echo $successMsg; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php endif; ?>
                            
                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="loginForm">
                                <div class="mb-4">
                                    <label for="candidate_id" class="form-label fw-bold">Candidate ID</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-user text-primary"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0" id="candidate_id" name="candidate_id" 
                                               placeholder="Enter your Candidate ID" required
                                               value="<?php echo htmlspecialchars($_POST['candidate_id'] ?? ''); ?>">
                                    </div>
                                    <div class="form-text">Your unique student identification number</div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="password" class="form-label fw-bold">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-lock text-primary"></i>
                                        </span>
                                        <input type="password" class="form-control border-start-0" id="password" name="password" 
                                               placeholder="Enter your password" required>
                                        <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="mb-4 form-check">
                                    <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
                                    <label class="form-check-label" for="rememberMe">Remember me</label>
                                </div>
                                
                                <div class="d-grid mb-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-sign-in-alt me-2"></i> Login to Portal
                                    </button>
                                </div>
                                
                                <div class="text-center">
                                    <p class="mb-0">
                                        <a href="https://araneus.plastwork.in/studProfile/" target="_blank" class="text-decoration-none">
                                            <i class="fas fa-external-link-alt me-1"></i> Access Legacy Portal
                                        </a>
                                    </p>
                                </div>
                            </form>
                            
                            <div class="login-divider my-4">
                                <span class="bg-light px-3 text-muted">or continue with</span>
                            </div>
                            
                            <div class="text-center">
                                <a href="#" class="btn btn-outline-primary me-2 mb-2">
                                    <i class="fab fa-google me-2"></i> Google
                                </a>
                                <a href="#" class="btn btn-outline-primary mb-2">
                                    <i class="fab fa-microsoft me-2"></i> Microsoft
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Portal Benefits Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">Portal Features</h2>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card text-center p-4 h-100">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-book-open fa-3x text-primary"></i>
                    </div>
                    <h4 class="h5 mb-3">Course Materials</h4>
                    <p>Access all your course materials, lectures, and study resources in one place.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card text-center p-4 h-100">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-tasks fa-3x text-primary"></i>
                    </div>
                    <h4 class="h5 mb-3">Assignment Submission</h4>
                    <p>Submit assignments online, track deadlines, and receive feedback from instructors.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card text-center p-4 h-100">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-chart-line fa-3x text-primary"></i>
                    </div>
                    <h4 class="h5 mb-3">Progress Tracking</h4>
                    <p>Monitor your academic progress, grades, and performance analytics.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Technical Support Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="support-img">
                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" 
                         alt="Technical Support" class="img-fluid rounded">
                </div>
            </div>
            <div class="col-lg-6">
                <h2 class="mb-4">Need Help?</h2>
                <p class="lead mb-4">Our technical support team is available to assist you with any portal-related issues.</p>
                
                <div class="support-contact">
                    <div class="d-flex align-items-start mb-3">
                        <div class="support-icon me-3">
                            <i class="fas fa-headset fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h5>Portal Support</h5>
                            <p class="mb-0">Email: portal-support@araneusedutech.com</p>
                            <p>Phone: +91 98765 43210 (Ext. 2)</p>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-start mb-3">
                        <div class="support-icon me-3">
                            <i class="fas fa-clock fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h5>Support Hours</h5>
                            <p class="mb-0">Monday - Friday: 9:00 AM - 6:00 PM</p>
                            <p>Saturday: 10:00 AM - 4:00 PM</p>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-start">
                        <div class="support-icon me-3">
                            <i class="fas fa-question-circle fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h5>FAQs & Guides</h5>
                            <p class="mb-0">Check our <a href="portal-guide.php" class="text-primary fw-bold">portal guide</a> for detailed instructions</p>
                            <p>Visit our <a href="portal-faq.php" class="text-primary fw-bold">FAQ section</a> for common questions</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Additional CSS for Portal -->
<style>
    .portal-hero {
        padding: 100px 0 80px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }
    
    .portal-features .feature-item {
        display: flex;
        align-items: center;
    }
    
    .portal-login-card {
        max-width: 500px;
        margin: 0 auto;
    }
    
    .portal-login-card .card {
        border-radius: 15px;
        border: none;
    }
    
    .portal-logo {
        width: 80px;
        height: 80px;
        background-color: rgba(255, 69, 0, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    
    .login-divider {
        position: relative;
        text-align: center;
    }
    
    .login-divider:before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background-color: #dee2e6;
        z-index: 1;
    }
    
    .login-divider span {
        position: relative;
        z-index: 2;
        background-color: white;
    }
    
    .feature-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }
    
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .feature-icon {
        width: 80px;
        height: 80px;
        background-color: rgba(255, 69, 0, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    
    .support-img img {
        width: 100%;
        height: 350px;
        object-fit: cover;
    }
    
    .support-icon {
        width: 50px;
        height: 50px;
        background-color: rgba(255, 69, 0, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    @media (max-width: 768px) {
        .portal-hero {
            padding: 80px 0 60px;
        }
        
        .portal-login-card {
            padding: 0 15px;
        }
    }
</style>

<!-- JavaScript for Login Page -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    
    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle eye icon
            const icon = this.querySelector('i');
            if (type === 'password') {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
    }
    
    // Form validation
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            let isValid = true;
            
            // Clear previous error states
            const inputs = this.querySelectorAll('input[required]');
            inputs.forEach(input => {
                input.classList.remove('is-invalid');
            });
            
            // Validate each required field
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                }
            });
            
            if (!isValid) {
                event.preventDefault();
                event.stopPropagation();
                
                // Show alert if not already shown
                if (!document.querySelector('.alert-danger')) {
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                    alertDiv.innerHTML = `
                        <i class="fas fa-exclamation-circle me-2"></i> Please fill in all required fields.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    
                    const form = document.querySelector('#loginForm');
                    if (form) {
                        form.insertBefore(alertDiv, form.firstChild);
                    }
                }
            }
        });
    }
});
</script>

<?php require_once  __DIR__ . '/../assets/_footer.php'; ?>