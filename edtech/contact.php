<?php
require_once 'includes/config.php';
$page_title = 'Contact Us';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    $query = "INSERT INTO contact_queries (name, email, phone, subject, message) 
              VALUES ('$name', '$email', '$phone', '$subject', '$message')";
    
    if (mysqli_query($conn, $query)) {
        $success = "Thank you for contacting us! We'll get back to you soon.";
    } else {
        $error = "Something went wrong. Please try again.";
    }
}
?>
<?php include 'header.php'; ?>

<div class="container py-5 mt-5">
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-4 fw-bold mb-4">Contact Us</h1>
            <p class="lead text-muted">
                Have questions? We're here to help. Get in touch with us.
            </p>
        </div>
    </div>

    <!-- Contact Form -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <?php if(isset($success)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $success; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>
                    
                    <form method="POST" class="contact-form">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="subject" class="form-label">Subject *</label>
                                <input type="text" class="form-control" id="subject" name="subject" required>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="message" class="form-label">Message *</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Info -->
    <div class="row mt-5">
        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="contact-icon mb-3">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h5 class="card-title">Our Address</h5>
                    <p class="card-text text-muted">
                        116/56/E/N, East Chandmari<br>
                        Barrackpore, Kolkata - 700122<br>
                        West Bengal, India
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="contact-icon mb-3">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h5 class="card-title">Phone Number</h5>
                    <p class="card-text text-muted">
                        +91 98765 43210<br>
                        +91 98765 43211
                    </p>
                    <a href="tel:+919876543210" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-phone me-1"></i>Call Now
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="contact-icon mb-3">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h5 class="card-title">Email Address</h5>
                    <p class="card-text text-muted">
                        support@araneusedutech.com<br>
                        info@araneusedutech.com
                    </p>
                    <a href="mailto:support@araneusedutech.com" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-envelope me-1"></i>Send Email
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Business Hours -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="mb-3">Business Hours</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="fas fa-clock text-primary me-2"></i>
                                            <strong>Monday - Friday:</strong> 9:00 AM - 6:00 PM
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-clock text-primary me-2"></i>
                                            <strong>Saturday:</strong> 10:00 AM - 4:00 PM
                                        </li>
                                        <li>
                                            <i class="fas fa-clock text-primary me-2"></i>
                                            <strong>Sunday:</strong> Closed
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-0">
                                        <i class="fas fa-info-circle text-primary me-2"></i>
                                        We're available during business hours for calls and emails.
                                        For urgent queries, please call our helpline.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="p-4 bg-light rounded-3">
                                <i class="fas fa-headset display-4 text-primary mb-3"></i>
                                <h5>24/7 Support</h5>
                                <p class="text-muted mb-0">Email support available anytime</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.contact-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #3498db, #2ecc71);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}
</style>

<?php include 'footer.php'; ?>