<?php
$page_title = "Contact Us";
require_once  __DIR__ . '/../assets/_header.php';

// Handle form submission
$formSubmitted = false;
$errorMsg = '';
$successMsg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Basic validation
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($subject)) {
        $errors[] = "Subject is required";
    }
    
    if (empty($message)) {
        $errors[] = "Message is required";
    }
    
    // If no errors, process the form
    if (empty($errors)) {
        try {
            // Connect to database
            require_once __DIR__ . '/../core/connection.php';
            $db = new Database();
            $conn = $db->getConnection();
            
            // Prepare SQL statement
            $stmt = $conn->prepare("INSERT INTO contact_submissions (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);
            
            if ($stmt->execute()) {
                // Send email notification (you would configure this for your server)
                $to = COMPANY_CUSTOM_MAIL;
                $email_subject = "New Contact Form Submission: " . $subject;
                $email_body = "You have received a new message from your website contact form.\n\n";
                $email_body .= "Name: $name\n";
                $email_body .= "Email: $email\n";
                $email_body .= "Phone: $phone\n";
                $email_body .= "Subject: $subject\n";
                $email_body .= "Message:\n$message\n";
                $headers = "From: noreply@araneusedutech.com\r\n";
                $headers .= "Reply-To: $email\r\n";
                
                // For demonstration, we'll just log that we would send an email
                // mail($to, $email_subject, $email_body, $headers);
                
                $formSubmitted = true;
                $successMsg = "Thank you for contacting us! We will get back to you soon.";
                
                // Clear form fields
                $name = $email = $phone = $subject = $message = '';
            } else {
                $errorMsg = "There was an error submitting your form. Please try again.";
            }
            
            $stmt->close();
            $db->close();
            
        } catch (Exception $e) {
            $errorMsg = "There was an error processing your request. Please try again later.";
        }
    } else {
        $errorMsg = implode("<br>", $errors);
    }
}
?>

<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1497366754035-f200968a6e72?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80');">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-4">Get In Touch</h1>
                <p class="lead mb-4">Have questions about our services? Ready to start your journey with us? Contact our team for personalized assistance.</p>
                <div class="d-flex justify-content-center flex-wrap">
                    <div class="contact-badge me-4 mb-3">
                        <i class="fas fa-phone me-2"></i> <?php echo COMPANY_PHONE; ?>
                    </div>
                    <div class="contact-badge me-4 mb-3">
                        <i class="fas fa-envelope me-2"></i> <?php echo COMPANY_CUSTOM_MAIL; ?>
                    </div>
                    <div class="contact-badge mb-3">
                        <i class="fas fa-map-marker-alt me-2"></i> Kolkata, India
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-5 mb-lg-0">
                <h2 class="h1 mb-4">Send Us a Message</h2>
                <p class="lead mb-5">Fill out the form below and our team will get back to you within 24 hours.</p>
                
                <!-- Messages -->
                <?php if ($formSubmitted && $successMsg): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> <?php echo $successMsg; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
                
                <?php if ($errorMsg): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> <?php echo $errorMsg; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
                
                <!-- Contact Form -->
                <form id="contactForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
                                <div class="invalid-feedback">Please enter your name.</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                                <div class="invalid-feedback">Please enter a valid email address.</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($phone ?? ''); ?>">
                                <div class="invalid-feedback">Please enter a valid phone number.</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="subject" class="form-label">Subject *</label>
                                <select class="form-select" id="subject" name="subject" required>
                                    <option value="" disabled selected>Select a subject</option>
                                    <option value="General Inquiry" <?php echo (isset($subject) && $subject == 'General Inquiry') ? 'selected' : ''; ?>>General Inquiry</option>
                                    <option value="Educational Solutions" <?php echo (isset($subject) && $subject == 'Educational Solutions') ? 'selected' : ''; ?>>Educational Solutions</option>
                                    <option value="Business Solutions" <?php echo (isset($subject) && $subject == 'Business Solutions') ? 'selected' : ''; ?>>Business Solutions</option>
                                    <option value="Training Programs" <?php echo (isset($subject) && $subject == 'Training Programs') ? 'selected' : ''; ?>>Training Programs</option>
                                    <option value="Internship Program" <?php echo (isset($subject) && $subject == 'Internship Program') ? 'selected' : ''; ?>>Internship Program</option>
                                    <option value="Partnership" <?php echo (isset($subject) && $subject == 'Partnership') ? 'selected' : ''; ?>>Partnership</option>
                                    <option value="Other" <?php echo (isset($subject) && $subject == 'Other') ? 'selected' : ''; ?>>Other</option>
                                </select>
                                <div class="invalid-feedback">Please select a subject.</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="form-group">
                            <label for="message" class="form-label">Your Message *</label>
                            <textarea class="form-control" id="message" name="message" rows="6" required><?php echo htmlspecialchars($message ?? ''); ?></textarea>
                            <div class="invalid-feedback">Please enter your message.</div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="privacyPolicy" name="privacyPolicy" required>
                            <label class="form-check-label" for="privacyPolicy">
                                I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">Privacy Policy</a> and consent to Araneus Edutech LLP contacting me regarding my inquiry.
                            </label>
                            <div class="invalid-feedback">You must agree to the privacy policy before submitting.</div>
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Send Message <i class="fas fa-paper-plane ms-2"></i></button>
                    </div>
                </form>
            </div>
            
            <div class="col-lg-4">
                <!-- Contact Info Card -->
                <div class="contact-info-card mb-5">
                    <div class="card border-0 shadow-lg">
                        <div class="card-body p-4">
                            <h3 class="card-title mb-4">Contact Information</h3>
                            
                            <div class="contact-info-item mb-4">
                                <div class="contact-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="contact-details">
                                    <h5>Address</h5>
                                    <p class="mb-0"><?php echo COMPANY_ADDRESS; ?></p>
                                </div>
                            </div>
                            
                            <div class="contact-info-item mb-4">
                                <div class="contact-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="contact-details">
                                    <h5>Phone</h5>
                                    <p class="mb-0">
                                        <a href="tel:+919876543210" class="text-decoration-none"><?php echo COMPANY_PHONE; ?></a>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="contact-info-item mb-4">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="contact-details">
                                    <h5>Email</h5>
                                    <p class="mb-0">
                                        <a href="mailto:<?php echo COMPANY_CUSTOM_MAIL; ?>" class="text-decoration-none"><?php echo COMPANY_CUSTOM_MAIL; ?></a>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="contact-info-item mb-4">
                                <div class="contact-icon">
                                    <i class="fas fa-id-card"></i>
                                </div>
                                <div class="contact-details">
                                    <h5>LLPIN</h5>
                                    <p class="mb-0"><?php echo COMPANY_LLPIN; ?></p>
                                </div>
                            </div>
                            
                            <div class="contact-info-item">
                                <div class="contact-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="contact-details">
                                    <h5>Business Hours</h5>
                                    <p class="mb-0">Monday - Friday: 9:00 AM - 6:00 PM</p>
                                    <p class="mb-0">Saturday: 10:00 AM - 4:00 PM</p>
                                    <p class="mb-0">Sunday: Closed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Links Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h4 class="card-title mb-3">Quick Links</h4>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <a href="solutions/education.php" class="text-decoration-none">
                                    <i class="fas fa-arrow-right text-primary me-2"></i> Educational Solutions
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="solutions/business.php" class="text-decoration-none">
                                    <i class="fas fa-arrow-right text-primary me-2"></i> Business Solutions
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="about.php" class="text-decoration-none">
                                    <i class="fas fa-arrow-right text-primary me-2"></i> About Our Company
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="testimonials.php" class="text-decoration-none">
                                    <i class="fas fa-arrow-right text-primary me-2"></i> Client Testimonials
                                </a>
                            </li>
                            <li>
                                <a href="faq.php" class="text-decoration-none">
                                    <i class="fas fa-arrow-right text-primary me-2"></i> Frequently Asked Questions
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Map Section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="p-4">
                                    <h3 class="mb-3">Visit Our Office</h3>
                                    <p class="mb-4">Our office is conveniently located in Barrackpore, Kolkata. Feel free to visit us during business hours for a consultation.</p>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <h5><i class="fas fa-train text-primary me-2"></i> By Train</h5>
                                            <p class="small mb-0">Nearest station: Barrackpore Railway Station (5 minutes by auto)</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h5><i class="fas fa-bus text-primary me-2"></i> By Bus</h5>
                                            <p class="small mb-0">Multiple bus routes available via BT Road and Barrackpore Trunk Road</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h5><i class="fas fa-car text-primary me-2"></i> By Car</h5>
                                            <p class="small mb-0">Ample parking space available near our office</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h5><i class="fas fa-taxi text-primary me-2"></i> By Taxi/Auto</h5>
                                            <p class="small mb-0">Available throughout Kolkata and surrounding areas</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="map-container">
                                    <!-- Google Maps Embed -->
                                    <iframe 
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3682.0673447734724!2d88.36368877488891!3d22.64713603197478!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f89c5d5c5c5c5d%3A0x5c5c5c5c5c5c5c5c!2sBarrackpore%2C%20Kolkata%2C%20West%20Bengal%2C%20India!5e0!3m2!1sen!2sin!4v1692356789012!5m2!1sen!2sin" 
                                        width="100%" 
                                        height="300" 
                                        style="border:0;" 
                                        allowfullscreen="" 
                                        loading="lazy" 
                                        referrerpolicy="no-referrer-when-downgrade">
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- FAQ Section -->
        <div class="row mt-5">
            <div class="col-12">
                <h2 class="section-title mb-4">Frequently Asked Questions</h2>
                
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                What is the typical response time for inquiries?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We strive to respond to all inquiries within 24 hours during business days. For urgent matters, please call us directly at <?php echo COMPANY_PHONE; ?>.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                Do you offer free consultations?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, we offer free initial consultations for both educational and business solutions. You can schedule a consultation by filling out our contact form or calling our office.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                What are your business hours?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Our office is open Monday through Friday from 9:00 AM to 6:00 PM, and Saturdays from 10:00 AM to 4:00 PM. We are closed on Sundays and public holidays.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                                Can I visit your office without an appointment?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                While walk-ins are welcome, we highly recommend scheduling an appointment to ensure that the appropriate team member is available to assist you with your specific needs.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive">
                                Do you provide services outside of Kolkata?
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, we provide services throughout India and internationally. Many of our training programs and consultations are available online, and we travel for business solutions implementation when required.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Privacy Policy Modal -->
<div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="privacyModalLabel">Privacy Policy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>At Araneus Edutech LLP, we are committed to protecting your privacy. This privacy policy explains how we collect, use, and protect your personal information.</p>
                
                <h6>Information We Collect</h6>
                <p>We collect information that you provide directly to us, such as when you fill out our contact form, including your name, email address, phone number, and any messages you send us.</p>
                
                <h6>How We Use Your Information</h6>
                <p>We use the information we collect to respond to your inquiries, provide services, improve our offerings, and communicate with you about our services and promotions.</p>
                
                <h6>Data Security</h6>
                <p>We implement appropriate security measures to protect your personal information from unauthorized access, alteration, disclosure, or destruction.</p>
                
                <h6>Contact Information</h6>
                <p>If you have any questions about our privacy policy, please contact us at <?php echo COMPANY_CUSTOM_MAIL; ?>.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Additional CSS for Contact Page -->
<style>
    .hero-section {
        padding: 120px 0 60px;
    }
    
    .contact-badge {
        background-color: rgba(255, 255, 255, 0.2);
        padding: 10px 20px;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
    }
    
    .contact-info-card .card {
        border-radius: 15px;
        overflow: hidden;
    }
    
    .contact-info-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 20px;
    }
    
    .contact-icon {
        width: 50px;
        height: 50px;
        background-color: rgba(255, 69, 0, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        flex-shrink: 0;
    }
    
    .contact-icon i {
        color: var(--primary-color);
        font-size: 1.2rem;
    }
    
    .contact-details h5 {
        margin-bottom: 5px;
        color: var(--dark-color);
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-control, .form-select {
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(255, 69, 0, 0.25);
    }
    
    .form-label {
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--dark-color);
    }
    
    .map-container {
        height: 100%;
    }
    
    .map-container iframe {
        height: 100%;
        min-height: 300px;
        border: none;
    }
    
    .accordion-button {
        font-weight: 600;
        background-color: #f8f9fa;
    }
    
    .accordion-button:not(.collapsed) {
        background-color: rgba(255, 69, 0, 0.1);
        color: var(--primary-color);
    }
    
    .accordion-button:focus {
        box-shadow: 0 0 0 0.2rem rgba(255, 69, 0, 0.25);
        border-color: var(--primary-color);
    }
    
    @media (max-width: 768px) {
        .contact-badge {
            width: 100%;
            justify-content: center;
            margin-right: 0;
        }
        
        .map-container iframe {
            min-height: 250px;
        }
    }
</style>

<!-- JavaScript for form validation -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const phoneInput = document.getElementById('phone');
    
    // Phone number validation (optional, but if provided, validate)
    phoneInput.addEventListener('input', function(e) {
        // Allow only numbers, spaces, plus, and dash
        this.value = this.value.replace(/[^\d\s+\-]/g, '');
    });
    
    // Form validation
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        form.classList.add('was-validated');
    }, false);
    
    // Auto-resize textarea
    const textarea = document.getElementById('message');
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
});
</script>

<?php require_once  __DIR__ . '/../assets/_footer.php'; ?>