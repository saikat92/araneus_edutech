<?php
$page_title = "Home";
require_once '../includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1>Transforming Education & Business with Innovative Solutions</h1>
                <p class="lead">Araneus Edutech LLP provides cutting-edge educational and business consultancy services to help organizations and individuals achieve their goals through technology and expertise.</p>
                <div class="mt-4">
                    <a href="education.php" class="btn btn-primary btn-lg me-3">Educational Solutions</a>
                    <a href="business.php" class="btn btn-secondary btn-lg">Business Solutions</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <h2 class="section-title text-start">About Araneus Edutech</h2>
                <p class="mb-4">Araneus Edutech LLP is a premier consultancy firm based in Kolkata, India, specializing in both educational and business solutions. With our team of experienced professionals, we bridge the gap between academic knowledge and industry requirements.</p>
                <p class="mb-4">We are committed to delivering innovative, customized solutions that drive growth, enhance efficiency, and create sustainable value for our clients across various sectors.</p>
                <a href="about.php" class="btn btn-primary">Learn More About Us</a>
            </div>
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body text-center p-4">
                                <div class="card-icon">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <h4 class="card-title">Educational Excellence</h4>
                                <p class="card-text">Comprehensive educational solutions including training, consultancy, and internships.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body text-center p-4">
                                <div class="card-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h4 class="card-title">Business Growth</h4>
                                <p class="card-text">Strategic business solutions to optimize operations and drive sustainable growth.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body text-center p-4">
                                <div class="card-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h4 class="card-title">Expert Team</h4>
                                <p class="card-text">Industry veterans and subject matter experts with decades of combined experience.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body text-center p-4">
                                <div class="card-icon">
                                    <i class="fas fa-handshake"></i>
                                </div>
                                <h4 class="card-title">Client-Centric</h4>
                                <p class="card-text">Tailored solutions designed to meet the specific needs and goals of each client.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Solutions Overview -->
<section class="section-padding bg-light">
    <div class="container">
        <h2 class="section-title">Our Solutions</h2>
        
        <div class="row">
            <div class="col-lg-6 mb-5">
                <div class="solution-item">
                    <h3><i class="fas fa-graduation-cap text-primary me-3"></i> Educational Solutions</h3>
                    <p>Comprehensive educational services designed to bridge the gap between academia and industry.</p>
                    <ul class="list-unstyled mt-4">
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Industry-related Training Courses</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Educational Consultancy</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Internship Programs</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Certification Programs</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Student Portal Access</li>
                    </ul>
                    <a href="education.php" class="btn btn-outline-primary mt-3">Explore Educational Solutions</a>
                </div>
            </div>
            
            <div class="col-lg-6 mb-5">
                <div class="solution-item">
                    <h3><i class="fas fa-briefcase text-primary me-3"></i> Business Solutions</h3>
                    <p>Cutting-edge business technology solutions to optimize operations and drive growth.</p>
                    <ul class="list-unstyled mt-4">
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> CRM-Salesforce Implementation</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> ERP Solutions (Oracle E-Business Suite)</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> GST Solutions & E-Invoicing</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Transition, Integration & Support</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Animation & Graphic Designing</li>
                    </ul>
                    <a href="business.php" class="btn btn-outline-primary mt-3">Explore Business Solutions</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section-padding" style="background: var(--gradient-color); color: white;">
    <div class="container text-center">
        <h2 class="mb-4">Ready to Transform Your Educational or Business Journey?</h2>
        <p class="lead mb-5">Contact us today to discuss how our solutions can help you achieve your goals.</p>
        <a href="contact.php" class="btn btn-light btn-lg">Get In Touch</a>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>