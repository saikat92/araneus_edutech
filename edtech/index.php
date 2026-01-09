<?php
require_once 'includes/config.php';
$page_title = 'Home';
?>
<?php include 'header.php'; ?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-bg"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-text fade-in-up">
                    <span class="badge">Certificate Verification Portal</span>
                    <h1>Verify & Download Your <span class="highlight">Official Certificate</span></h1>
                    <p class="lead mb-4 text-muted">
                        Secure verification system ensuring authenticity of your credentials. 
                        Enter your Certificate ID to access official certificates from Araneus Edutech LLP.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#verify" class="cta-button">
                            <i class="fas fa-shield-alt"></i>
                            Verify Certificate
                        </a>
                        <a href="courses.php" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-book-open"></i>
                            Browse Courses
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image fade-in-up">
                    <img src="https://images.unsplash.com/photo-1586281380349-632531db7ed4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Certificate Illustration" 
                         class="img-fluid rounded-4 shadow-lg">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features py-5 bg-white">
    <div class="container">
        <h2 class="section-title text-center">Why Verify With Us</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card fade-in-up">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="h4 mb-3">Secure Verification</h3>
                    <p class="text-muted">
                        Advanced security measures ensure certificate authenticity and prevent fraud.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card fade-in-up">
                    <div class="feature-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3 class="h4 mb-3">Instant Access</h3>
                    <p class="text-muted">
                        Immediate access to certificates with no waiting time. Download instantly.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card fade-in-up">
                    <div class="feature-icon">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <h3 class="h4 mb-3">QR Code Verification</h3>
                    <p class="text-muted">
                        Unique QR codes for each certificate for quick verification anytime, anywhere.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="how-it-works py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center">How To Verify</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center fade-in-up">
                    <div class="step-number d-inline-flex align-items-center justify-content-center mb-3">
                        1
                    </div>
                    <h3 class="h5 mb-3">Locate Certificate ID</h3>
                    <p class="text-muted">
                        Find unique Certificate ID on your certificate or email.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center fade-in-up">
                    <div class="step-number d-inline-flex align-items-center justify-content-center mb-3">
                        2
                    </div>
                    <h3 class="h5 mb-3">Enter Certificate ID</h3>
                    <p class="text-muted">
                        Enter ID in verification form (Format: PP/11/25/252608).
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center fade-in-up">
                    <div class="step-number d-inline-flex align-items-center justify-content-center mb-3">
                        3
                    </div>
                    <h3 class="h5 mb-3">Download Certificate</h3>
                    <p class="text-muted">
                        View and download high-quality PDF for printing or sharing.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Verification Form -->
<section class="verification-section" id="verify">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="verification-box fade-in-up">
                    <h2 class="text-center mb-4">Verify Your Certificate</h2>
                    <p class="text-center mb-5">
                        Enter your Certificate ID below to access and download your official certificate
                    </p>
                    
                    <form class="verification-form" id="certificateForm" action="pages/profile.php" method="GET">
                        <div class="input-group mb-4">
                            <input type="text" 
                                   class="form-control form-control-lg" 
                                   name="certificate_id"
                                   placeholder="Enter Certificate ID (e.g., PP/11/25/252608)" 
                                   required>
                            <button class="btn btn-success btn-lg" type="submit">
                                <i class="fas fa-search me-2"></i>Verify
                            </button>
                        </div>
                    </form>
                    
                    <div class="text-center mt-4">
                        <p class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Need help? Contact: support@araneusedutech.com
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Popular Courses Preview -->
<section class="py-5 bg-white">
    <div class="container">
        <h2 class="section-title text-center">Popular Courses</h2>
        <div class="row g-4">
            <?php
            $courses_query = "SELECT * FROM courses WHERE is_active = 1 ORDER BY id DESC LIMIT 3";
            $courses_result = mysqli_query($conn, $courses_query);
            
            if(mysqli_num_rows($courses_result) > 0):
                while($course = mysqli_fetch_assoc($courses_result)):
            ?>
            <div class="col-md-4">
                <div class="card course-card h-100">
                    <img src="<?php echo $course['image_url'] ?: 'https://images.unsplash.com/photo-1501504905252-473c47e087f8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'; ?>" 
                         class="card-img-top course-image" 
                         alt="<?php echo $course['title']; ?>">
                    <div class="card-body">
                        <span class="badge bg-primary mb-2"><?php echo $course['category']; ?></span>
                        <h5 class="card-title"><?php echo $course['title']; ?></h5>
                        <p class="card-text text-muted"><?php echo substr($course['description'], 0, 100) . '...'; ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-primary fw-bold">₹<?php echo $course['fee']; ?></span>
                            <a href="pages/courses.php" class="btn btn-sm btn-outline-primary">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                endwhile;
            else:
            ?>
            <div class="col-12">
                <div class="text-center py-5">
                    <p class="text-muted">Courses coming soon!</p>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <div class="text-center mt-5">
            <a href="pages/courses.php" class="btn btn-primary btn-lg">
                View All Courses <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>