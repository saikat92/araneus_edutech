<?php
$page_title = "Contact Us";
require_once '../includes/header.php';
// $conn is available from header.php via database.php — no need to re-connect

$successMsg = '';
$errorMsg   = '';
$formData   = ['name'=>'','email'=>'','phone'=>'','subject'=>'','message'=>''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name']    ?? '');
    $email   = trim($_POST['email']   ?? '');
    $phone   = trim($_POST['phone']   ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    $errors = [];
    if (!$name)                                     $errors[] = "Your name is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "A valid email address is required.";
    if (!$subject)                                  $errors[] = "Subject is required.";
    if (!$message)                                  $errors[] = "Message cannot be empty.";

    if (empty($errors)) {
        // Use the $conn already established by header.php — no new Database() needed
        $stmt = $conn->prepare("INSERT INTO contact_submissions (name, email, phone, subject, message) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);

        if ($stmt->execute()) {
            // Notify site admin
            @mail(
                SITE_EMAIL,
                "New Contact Form: $subject",
                "Name: $name\nEmail: $email\nPhone: $phone\nSubject: $subject\n\nMessage:\n$message",
                "From: noreply@araneusedutech.com\r\nReply-To: $email"
            );
            $successMsg = "Thank you, $name! We've received your message and will get back to you within 24 hours.";
            $formData   = ['name'=>'','email'=>'','phone'=>'','subject'=>'','message'=>''];
        } else {
            $errorMsg = "There was a problem saving your message. Please try again.";
            $formData = compact('name','email','phone','subject','message');
        }
        $stmt->close();
    } else {
        $errorMsg = implode('<br>', $errors);
        $formData = compact('name','email','phone','subject','message');
    }
}
?>

<!-- Hero -->
<section class="hero-section" style="background:linear-gradient(rgba(0,0,0,.7),rgba(0,0,0,.7)),url('https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1400&q=80');background-size:cover;background-position:center;">
    <div class="container">
        <div class="col-lg-8 mx-auto text-center text-white">
            <h1 class="display-4 fw-bold mb-3">Get In Touch</h1>
            <p class="lead mb-4 opacity-75">Have questions? Ready to start your journey? Our team is here to help.</p>
            <div class="d-flex justify-content-center flex-wrap gap-4">
                <span class="bg-white bg-opacity-10 rounded px-3 py-2 small">
                    <i class="fas fa-phone me-2 text-warning"></i><?php echo SITE_PHONE; ?>
                </span>
                <span class="bg-white bg-opacity-10 rounded px-3 py-2 small">
                    <i class="fas fa-envelope me-2 text-warning"></i><?php echo SITE_EMAIL; ?>
                </span>
                <span class="bg-white bg-opacity-10 rounded px-3 py-2 small">
                    <i class="fas fa-map-marker-alt me-2 text-warning"></i>Barrackpore, Kolkata
                </span>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="section-padding">
    <div class="container">
        <div class="row g-5">

            <!-- Form -->
            <div class="col-lg-7">
                <h2 class="h3 fw-bold mb-1">Send Us a Message</h2>
                <p class="text-muted mb-4">Fill in the form and we'll respond within 24 hours.</p>

                <?php if ($successMsg): ?>
                <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
                    <i class="fas fa-check-circle fa-lg"></i>
                    <span><?php echo htmlspecialchars($successMsg); ?></span>
                </div>
                <?php endif; ?>
                <?php if ($errorMsg): ?>
                <div class="alert alert-danger d-flex align-items-start gap-2 mb-4">
                    <i class="fas fa-exclamation-circle fa-lg mt-1 flex-shrink-0"></i>
                    <span><?php echo $errorMsg; ?></span>
                </div>
                <?php endif; ?>

                <form method="POST" class="contact-form" novalidate>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control"
                                   value="<?php echo htmlspecialchars($formData['name']); ?>"
                                   placeholder="Arnab Das" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control"
                                   value="<?php echo htmlspecialchars($formData['email']); ?>"
                                   placeholder="arnab@example.com" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Phone Number</label>
                            <input type="tel" name="phone" class="form-control"
                                   value="<?php echo htmlspecialchars($formData['phone']); ?>"
                                   placeholder="+91 98765 43210">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Subject <span class="text-danger">*</span></label>
                            <select name="subject" class="form-select" required>
                                <option value="">Select a subject…</option>
                                <?php
                                $subjects = ['Course Enquiry','Admission','Business Solutions','Technical Support','Billing / Payment','Partnership','Other'];
                                foreach ($subjects as $s):
                                ?>
                                <option value="<?php echo $s; ?>" <?php echo $formData['subject'] === $s ? 'selected' : ''; ?>>
                                    <?php echo $s; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold">Message <span class="text-danger">*</span></label>
                            <textarea name="message" class="form-control" rows="5" required
                                      placeholder="Tell us how we can help…"><?php echo htmlspecialchars($formData['message']); ?></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary px-5 py-2">
                                <i class="fas fa-paper-plane me-2"></i>Send Message
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Contact info -->
            <div class="col-lg-5">
                <h2 class="h3 fw-bold mb-1">Contact Details</h2>
                <p class="text-muted mb-4">Reach us directly or visit our office.</p>

                <div class="d-flex flex-column gap-3 mb-4">
                    <div class="d-flex align-items-start gap-3 p-3 rounded-3 bg-light">
                        <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0"
                             style="width:44px;height:44px;background:rgba(255,69,0,.1);">
                            <i class="fas fa-map-marker-alt" style="color:var(--primary-color);"></i>
                        </div>
                        <div>
                            <div class="fw-semibold small mb-1">Office Address</div>
                            <div class="text-muted small"><?php echo SITE_ADDRESS; ?><br>LLPIN: <?php echo SITE_LLPIN; ?></div>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3 p-3 rounded-3 bg-light">
                        <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0"
                             style="width:44px;height:44px;background:rgba(255,69,0,.1);">
                            <i class="fas fa-phone" style="color:var(--primary-color);"></i>
                        </div>
                        <div>
                            <div class="fw-semibold small mb-1">Phone</div>
                            <a href="tel:<?php echo SITE_PHONE; ?>" class="text-muted small text-decoration-none">
                                <?php echo SITE_PHONE; ?>
                            </a>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3 p-3 rounded-3 bg-light">
                        <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0"
                             style="width:44px;height:44px;background:rgba(255,69,0,.1);">
                            <i class="fas fa-envelope" style="color:var(--primary-color);"></i>
                        </div>
                        <div>
                            <div class="fw-semibold small mb-1">Email</div>
                            <a href="mailto:<?php echo SITE_EMAIL; ?>" class="text-muted small text-decoration-none">
                                <?php echo SITE_EMAIL; ?>
                            </a>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3 p-3 rounded-3 bg-light">
                        <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0"
                             style="width:44px;height:44px;background:rgba(255,69,0,.1);">
                            <i class="fas fa-clock" style="color:var(--primary-color);"></i>
                        </div>
                        <div>
                            <div class="fw-semibold small mb-1">Business Hours</div>
                            <div class="text-muted small">Mon – Sat: 9:00 AM – 6:00 PM<br>Sunday: Closed</div>
                        </div>
                    </div>
                </div>

                <!-- Google Maps embed -->
                <div class="rounded-3 overflow-hidden shadow-sm">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3679.5!2d88.365!3d22.755!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjLCsDQ1JzE4LjAiTiA4OMKwMjEnNTQuMCJF!5e0!3m2!1sen!2sin!4v1"
                        width="100%" height="220" style="border:0;display:block;" allowfullscreen loading="lazy">
                    </iframe>
                </div>
            </div>

        </div>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>
