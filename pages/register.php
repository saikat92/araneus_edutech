<?php
session_start();
$page_title = "Student Registration";
require_once '../includes/header.php';

// Initialize Auth Controller
require_once '../controller/Auth.php';
$auth = new Auth();

// Handle registration
$errorMsg = '';
$successMsg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    // Collect form data
    $formData = [
        'candidate_id' => trim($_POST['candidate_id'] ?? ''),
        'full_name' => trim($_POST['full_name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'password' => $_POST['password'] ?? '',
        'confirm_password' => $_POST['confirm_password'] ?? '',
        'father_name' => trim($_POST['father_name'] ?? ''),
        'course_completed' => trim($_POST['course_completed'] ?? ''),
        'certification' => trim($_POST['certification'] ?? ''),
        'mode' => trim($_POST['mode'] ?? ''),
        'time_hours' => intval($_POST['time_hours'] ?? 0),
        'start_date' => $_POST['start_date'] ?? '',
        'end_date' => $_POST['end_date'] ?? '',
        'llpin' => trim($_POST['llpin'] ?? ''),
        'address' => trim($_POST['address'] ?? ''),
        'github_link' => trim($_POST['github_link'] ?? '')
    ];
    
    // Validate passwords match
    if ($formData['password'] !== $formData['confirm_password']) {
        $errorMsg = "Passwords do not match";
    } else {
        $result = $auth->registerStudent($formData);
        
        if ($result['success']) {
            $successMsg = $result['message'];
            // Clear form data on success
            $formData = array_fill_keys(array_keys($formData), '');
        } else {
            $errorMsg = $result['message'];
        }
    }
}
?>

<!-- Hero Section -->
<section class="portal-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-5 mb-lg-0">
                <div class="portal-info">
                    <h1 class="display-4 fw-bold mb-4">Student Registration</h1>
                    <p class="lead mb-4">Create your account to access the student portal and begin your learning journey with Araneus Edutech.</p>
                    
                    <div class="portal-features">
                        <div class="feature-item mb-3">
                            <i class="fas fa-check-circle text-success me-3"></i>
                            <span>Access all course materials</span>
                        </div>
                        <div class="feature-item mb-3">
                            <i class="fas fa-check-circle text-success me-3"></i>
                            <span>Track your academic progress</span>
                        </div>
                        <div class="feature-item mb-3">
                            <i class="fas fa-check-circle text-success me-3"></i>
                            <span>Submit assignments online</span>
                        </div>
                        <div class="feature-item mb-3">
                            <i class="fas fa-check-circle text-success me-3"></i>
                            <span>Receive certificates upon completion</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check-circle text-success me-3"></i>
                            <span>Connect with mentors and peers</span>
                        </div>
                    </div>
                    
                    <div class="mt-5">
                        <p>Already have an account? <a href="login.php" class="text-primary fw-bold">Login here</a></p>
                        <p>Need help? <a href="contact.php" class="text-primary fw-bold">Contact support</a></p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-7">
                <div class="portal-register-card">
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-4 p-lg-5">
                            <div class="text-center mb-4">
                                <div class="portal-logo mb-3">
                                    <i class="fas fa-user-plus fa-3x text-primary"></i>
                                </div>
                                <h2 class="h3 mb-3">Create Student Account</h2>
                                <p class="text-muted">Fill in your details to register for the student portal</p>
                            </div>
                            
                            <?php if ($errorMsg): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i> <?php echo htmlspecialchars($errorMsg); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($successMsg): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i> <?php echo htmlspecialchars($successMsg); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php endif; ?>
                            
                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="registerForm">
                                <input type="hidden" name="register" value="1">
                                
                                <div class="row">
                                    <!-- Personal Information -->
                                    <div class="col-md-6 mb-3">
                                        <label for="candidate_id" class="form-label fw-bold">Candidate ID *</label>
                                        <input type="text" class="form-control" id="candidate_id" name="candidate_id" 
                                               placeholder="e.g., ARN2024001" required
                                               value="<?php echo htmlspecialchars($formData['candidate_id']); ?>">
                                        <div class="form-text">Your unique student identification number</div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="full_name" class="form-label fw-bold">Full Name *</label>
                                        <input type="text" class="form-control" id="full_name" name="full_name" 
                                               placeholder="Enter your full name" required
                                               value="<?php echo htmlspecialchars($formData['full_name']); ?>">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label fw-bold">Email Address *</label>
                                        <input type="email" class="form-control" id="email" name="email" 
                                               placeholder="Enter your email" required
                                               value="<?php echo htmlspecialchars($formData['email']); ?>">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="father_name" class="form-label fw-bold">Father's Name *</label>
                                        <input type="text" class="form-control" id="father_name" name="father_name" 
                                               placeholder="Enter father's name" required
                                               value="<?php echo htmlspecialchars($formData['father_name']); ?>">
                                    </div>
                                    
                                    <!-- Passwords -->
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label fw-bold">Password *</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password" 
                                                   placeholder="Create password" required>
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword1">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="form-text">Minimum 8 characters</div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="confirm_password" class="form-label fw-bold">Confirm Password *</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                                   placeholder="Confirm password" required>
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword2">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Course Information -->
                                    <div class="col-md-6 mb-3">
                                        <label for="course_completed" class="form-label fw-bold">Course Completed *</label>
                                        <input type="text" class="form-control" id="course_completed" name="course_completed" 
                                               placeholder="e.g., Full Stack Development" required
                                               value="<?php echo htmlspecialchars($formData['course_completed']); ?>">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="certification" class="form-label fw-bold">Certification *</label>
                                        <input type="text" class="form-control" id="certification" name="certification" 
                                               placeholder="e.g., Certified Full Stack Developer" required
                                               value="<?php echo htmlspecialchars($formData['certification']); ?>">
                                    </div>
                                    
                                    <div class="col-md-4 mb-3">
                                        <label for="mode" class="form-label fw-bold">Mode *</label>
                                        <select class="form-select" id="mode" name="mode" required>
                                            <option value="">Select Mode</option>
                                            <option value="Online" <?php echo ($formData['mode'] == 'Online') ? 'selected' : ''; ?>>Online</option>
                                            <option value="Offline" <?php echo ($formData['mode'] == 'Offline') ? 'selected' : ''; ?>>Offline</option>
                                            <option value="Hybrid" <?php echo ($formData['mode'] == 'Hybrid') ? 'selected' : ''; ?>>Hybrid</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-4 mb-3">
                                        <label for="time_hours" class="form-label fw-bold">Duration (Hours) *</label>
                                        <input type="number" class="form-control" id="time_hours" name="time_hours" 
                                               min="1" max="1000" required
                                               value="<?php echo htmlspecialchars($formData['time_hours']); ?>">
                                    </div>
                                    
                                    <div class="col-md-4 mb-3">
                                        <label for="llpin" class="form-label fw-bold">LLPIN</label>
                                        <input type="text" class="form-control" id="llpin" name="llpin" 
                                               placeholder="e.g., AAP-3776"
                                               value="<?php echo htmlspecialchars($formData['llpin']); ?>">
                                    </div>
                                    
                                    <!-- Dates -->
                                    <div class="col-md-6 mb-3">
                                        <label for="start_date" class="form-label fw-bold">Start Date *</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" required
                                               value="<?php echo htmlspecialchars($formData['start_date']); ?>">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="end_date" class="form-label fw-bold">End Date *</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" required
                                               value="<?php echo htmlspecialchars($formData['end_date']); ?>">
                                    </div>
                                    
                                    <!-- Address & Links -->
                                    <div class="col-12 mb-3">
                                        <label for="address" class="form-label fw-bold">Address *</label>
                                        <textarea class="form-control" id="address" name="address" rows="3" 
                                                  placeholder="Enter your complete address" required><?php echo htmlspecialchars($formData['address']); ?></textarea>
                                    </div>
                                    
                                    <div class="col-12 mb-4">
                                        <label for="github_link" class="form-label fw-bold">GitHub Profile Link</label>
                                        <input type="url" class="form-control" id="github_link" name="github_link" 
                                               placeholder="https://github.com/yourusername"
                                               value="<?php echo htmlspecialchars($formData['github_link']); ?>">
                                    </div>
                                    
                                    <!-- Terms and Submit -->
                                    <div class="col-12 mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                            <label class="form-check-label" for="terms">
                                                I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms of Service</a> and <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">Privacy Policy</a>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                <i class="fas fa-user-plus me-2"></i> Create Account
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            
                            <div class="text-center mt-4">
                                <p class="mb-0">Already have an account? <a href="login.php" class="text-primary fw-bold">Login here</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Terms of Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>1. Acceptance of Terms</h6>
                <p>By registering for the Araneus Edutech Student Portal, you agree to comply with and be bound by these terms of service.</p>
                
                <h6>2. Student Responsibilities</h6>
                <p>You are responsible for maintaining the confidentiality of your account and password, and for restricting access to your computer.</p>
                
                <h6>3. Code of Conduct</h6>
                <p>Students must adhere to the code of conduct and academic integrity policies of Araneus Edutech.</p>
                
                <h6>4. Intellectual Property</h6>
                <p>All course materials, content, and resources are the intellectual property of Araneus Edutech and may not be redistributed without permission.</p>
                
                <h6>5. Termination</h6>
                <p>Araneus Edutech reserves the right to terminate accounts that violate these terms or engage in inappropriate conduct.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Privacy Modal -->
<div class="modal fade" id="privacyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Privacy Policy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>1. Information Collection</h6>
                <p>We collect personal information that you provide during registration, including your name, email, and academic details.</p>
                
                <h6>2. Use of Information</h6>
                <p>Your information is used to provide educational services, track progress, issue certificates, and communicate important updates.</p>
                
                <h6>3. Data Protection</h6>
                <p>We implement appropriate security measures to protect your personal information from unauthorized access or disclosure.</p>
                
                <h6>4. Third-Party Disclosure</h6>
                <p>We do not sell, trade, or transfer your personally identifiable information to outside parties without your consent.</p>
                
                <h6>5. Your Rights</h6>
                <p>You have the right to access, correct, or delete your personal information by contacting our support team.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Additional CSS for Registration Page -->
<style>
    .portal-register-card {
        max-width: 900px;
        margin: 0 auto;
    }
    
    .portal-register-card .card {
        border-radius: 15px;
        border: none;
    }
    
    .form-label {
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .form-control, .form-select {
        padding: 10px 15px;
        border-radius: 8px;
        border: 1px solid #ddd;
        font-size: 0.95rem;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #FF4500;
        box-shadow: 0 0 0 0.2rem rgba(255, 69, 0, 0.25);
    }
    
    .form-text {
        font-size: 0.85rem;
        color: #6c757d;
    }
    
    @media (max-width: 768px) {
        .portal-register-card {
            padding: 0 15px;
        }
    }
</style>

<!-- JavaScript for Registration Page -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePassword1 = document.getElementById('togglePassword1');
    const togglePassword2 = document.getElementById('togglePassword2');
    const password1 = document.getElementById('password');
    const password2 = document.getElementById('confirm_password');
    
    function togglePasswordVisibility(button, input) {
        button.addEventListener('click', function() {
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            
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
    
    if (togglePassword1 && password1) togglePasswordVisibility(togglePassword1, password1);
    if (togglePassword2 && password2) togglePasswordVisibility(togglePassword2, password2);
    
    // Form validation
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(event) {
            let isValid = true;
            
            // Clear previous error states
            const inputs = this.querySelectorAll('input[required], select[required], textarea[required]');
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
            
            // Validate password match
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');
            if (password && confirmPassword && password.value !== confirmPassword.value) {
                password.classList.add('is-invalid');
                confirmPassword.classList.add('is-invalid');
                isValid = false;
                
                if (!document.querySelector('#passwordError')) {
                    const errorDiv = document.createElement('div');
                    errorDiv.id = 'passwordError';
                    errorDiv.className = 'text-danger mt-1 small';
                    errorDiv.textContent = 'Passwords do not match';
                    
                    if (confirmPassword.parentNode) {
                        confirmPassword.parentNode.appendChild(errorDiv);
                    }
                }
            }
            
            // Validate dates
            const startDate = document.getElementById('start_date');
            const endDate = document.getElementById('end_date');
            if (startDate && endDate && startDate.value && endDate.value) {
                const start = new Date(startDate.value);
                const end = new Date(endDate.value);
                
                if (end <= start) {
                    endDate.classList.add('is-invalid');
                    isValid = false;
                    
                    if (!document.querySelector('#dateError')) {
                        const errorDiv = document.createElement('div');
                        errorDiv.id = 'dateError';
                        errorDiv.className = 'text-danger mt-1 small';
                        errorDiv.textContent = 'End date must be after start date';
                        
                        if (endDate.parentNode) {
                            endDate.parentNode.appendChild(errorDiv);
                        }
                    }
                }
            }
            
            // Validate terms agreement
            const termsCheckbox = document.getElementById('terms');
            if (termsCheckbox && !termsCheckbox.checked) {
                termsCheckbox.classList.add('is-invalid');
                isValid = false;
            }
            
            if (!isValid) {
                event.preventDefault();
                event.stopPropagation();
            }
        });
    }
    
    // Set minimum end date based on start date
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    
    if (startDateInput && endDateInput) {
        startDateInput.addEventListener('change', function() {
            endDateInput.min = this.value;
        });
    }
});
</script>

<?php require_once '../includes/footer.php'; ?>