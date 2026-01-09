<?php
$page_title = "Educational Solutions";
require_once 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url(assets/images/edu_hero_bg.png);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-4">Educational Solutions</h1>
                <p class="lead mb-4">Bridging the gap between academia and industry with innovative, career-focused educational programs and services designed for tomorrow's professionals.</p>
                <a href="#solutions" class="btn btn-primary btn-lg me-3">Explore Solutions</a>
                <a href="../contact.php" class="btn btn-outline-light btn-lg">Get Started</a>
            </div>
        </div>
    </div>
</section>

<!-- Quick Stats -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 col-6 mb-4 mb-md-0">
                <div class="stat-box">
                    <h2 class="fw-bold text-primary">500+</h2>
                    <p class="mb-0">Students Trained</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4 mb-md-0">
                <div class="stat-box">
                    <h2 class="fw-bold text-primary">50+</h2>
                    <p class="mb-0">Industry Partners</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-box">
                    <h2 class="fw-bold text-primary">95%</h2>
                    <p class="mb-0">Placement Rate</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-box">
                    <h2 class="fw-bold text-primary">100+</h2>
                    <p class="mb-0">Certifications Issued</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Solutions Section -->
<section class="section-padding" id="solutions">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Our Educational Solutions</h2>
            <p class="lead text-muted">Comprehensive services designed to empower students and educational institutions</p>
        </div>
        
        <!-- Industry Training -->
        <div class="row solution-card align-items-center mb-5" id="training">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="pe-lg-4">
                    <h3 class="h2 mb-3">Industry-related Training Courses</h3>
                    <p class="mb-4">Our specialized training programs are designed in collaboration with industry experts to ensure students gain relevant, practical skills that employers are looking for.</p>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="training-category">
                                <h5><i class="fas fa-code text-primary me-2"></i> Technology</h5>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-angle-right text-secondary me-2"></i> Full Stack Development</li>
                                    <li><i class="fas fa-angle-right text-secondary me-2"></i> Data Science & Analytics</li>
                                    <li><i class="fas fa-angle-right text-secondary me-2"></i> Cybersecurity Fundamentals</li>
                                    <li><i class="fas fa-angle-right text-secondary me-2"></i> Cloud Computing</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="training-category">
                                <h5><i class="fas fa-briefcase text-primary me-2"></i> Business</h5>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-angle-right text-secondary me-2"></i> Digital Marketing</li>
                                    <li><i class="fas fa-angle-right text-secondary me-2"></i> Business Analytics</li>
                                    <li><i class="fas fa-angle-right text-secondary me-2"></i> Project Management</li>
                                    <li><i class="fas fa-angle-right text-secondary me-2"></i> Financial Analysis</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <a href="<?= SITE_URL; ?>contact.php" class="btn btn-outline-primary px-4">Enquire About Training</a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="icon-box-large text-center">
                    <div class="icon-large bg-secondary-light">
                        <i class="fas fa-laptop-code text-primary"></i>
                    </div>
                    <h4 class="mt-4 mb-3">Industry Training</h4>
                    <p>Skill development programs aligned with industry requirements</p>
                </div>
            </div>
        </div>
        
        <!-- Internship -->
        <div class="row solution-card align-items-center mb-5" id="internship">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="pe-lg-4">
                    <h3 class="h2 mb-3">Internship Programs</h3>
                    <p class="mb-4">Gain hands-on industry experience through our structured internship programs that bridge the gap between academic learning and professional work environments.</p>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="internship-highlight">
                                <h5><i class="fas fa-calendar-alt text-primary me-2"></i> Program Duration</h5>
                                <p>Flexible programs from 4 weeks to 6 months to suit academic schedules</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="internship-highlight">
                                <h5><i class="fas fa-certificate text-primary me-2"></i> Certification</h5>
                                <p>Industry-recognized certificates upon successful completion</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="internship-highlight">
                                <h5><i class="fas fa-tasks text-primary me-2"></i> Real Projects</h5>
                                <p>Work on actual industry projects with measurable outcomes</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="internship-highlight">
                                <h5><i class="fas fa-briefcase text-primary me-2"></i> Placement Assistance</h5>
                                <p>Dedicated support for job placements post-internship</p>
                            </div>
                        </div>
                    </div>
                    
                    <a href="../contact.php" class="btn btn-primary mt-4 px-4">Apply for Internship</a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="icon-box-large text-center">
                    <div class="icon-large bg-secondary-light">
                        <i class="fas fa-briefcase text-primary"></i>
                    </div>
                    <h4 class="mt-4 mb-3">Internship Programs</h4>
                    <p>Hands-on industry experience for career readiness</p>
                </div>
            </div>
        </div>
        
        <!-- Educational Consultancy -->
        <div class="row solution-card align-items-center mb-5" id="consultancy">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="icon-box-large text-center">
                    <div class="icon-large bg-primary-light">
                        <i class="fas fa-chalkboard-teacher text-primary"></i>
                    </div>
                    <h4 class="mt-4 mb-3">Educational Consultancy</h4>
                    <p>Strategic guidance for institutions and students</p>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="ps-lg-4">
                    <h3 class="h2 mb-3">Comprehensive Educational Consultancy</h3>
                    <p class="mb-4">We work with educational institutions and students to develop strategies that enhance learning outcomes and career prospects.</p>
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="consultancy-service">
                                <div class="service-icon">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <h5>Curriculum Design</h5>
                                <p>Developing industry-aligned curricula that prepare students for real-world challenges.</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="consultancy-service">
                                <div class="service-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h5>Faculty Development</h5>
                                <p>Training and development programs for educators to enhance teaching methodologies.</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="consultancy-service">
                                <div class="service-icon">
                                    <i class="fas fa-university"></i>
                                </div>
                                <h5>Institutional Planning</h5>
                                <p>Strategic planning for educational institutions to improve infrastructure and outcomes.</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="consultancy-service">
                                <div class="service-icon">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <h5>Career Counseling</h5>
                                <p>Personalized guidance for students on career paths and higher education options.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Certification Programs -->
        <div class="row solution-card align-items-center" id="certification">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="icon-box-large text-center">
                    <div class="icon-large bg-primary-light">
                        <i class="fas fa-certificate text-primary"></i>
                    </div>
                    <h4 class="mt-4 mb-3">Certification Programs</h4>
                    <p>Industry-recognized credentials to validate skills</p>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="ps-lg-4">
                    <h3 class="h2 mb-3">Industry-Recognized Certification Programs</h3>
                    <p class="mb-4">Validate your skills with our certification programs that are recognized by industry leaders and enhance your employability.</p>
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="certification-card">
                                <div class="cert-icon">
                                    <i class="fas fa-code"></i>
                                </div>
                                <div class="cert-content">
                                    <h5>Technology Certifications</h5>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-angle-right text-secondary me-2"></i> Full Stack Developer</li>
                                        <li><i class="fas fa-angle-right text-secondary me-2"></i> Data Science Professional</li>
                                        <li><i class="fas fa-angle-right text-secondary me-2"></i> Cloud Practitioner</li>
                                        <li><i class="fas fa-angle-right text-secondary me-2"></i> Cybersecurity Specialist</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="certification-card">
                                <div class="cert-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="cert-content">
                                    <h5>Business Certifications</h5>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-angle-right text-secondary me-2"></i> Digital Marketing Expert</li>
                                        <li><i class="fas fa-angle-right text-secondary me-2"></i> Business Analytics Professional</li>
                                        <li><i class="fas fa-angle-right text-secondary me-2"></i> Project Management Professional</li>
                                        <li><i class="fas fa-angle-right text-secondary me-2"></i> Salesforce Administrator</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-info-circle fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="alert-heading">Digital Badges & Verification</h5>
                                <p class="mb-0">All certifications include verifiable digital badges that can be shared on LinkedIn and other professional platforms.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Portal -->
        <div class="row solution-card align-items-center mb-5" id="portal">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="icon-box-large text-center">
                    <div class="icon-large bg-primary-light">
                        <i class="fas fa-user-graduate text-primary"></i>
                    </div>
                    <h4 class="mt-4 mb-3">Student Portal</h4>
                    <p>Access learning resources, track progress, and manage your educational journey</p>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="ps-lg-4">
                    <h3 class="h2 mb-3">Interactive Student Portal</h3>
                    <p class="mb-4">Our comprehensive student portal provides a centralized platform for students to access course materials, submit assignments, track their progress, and interact with instructors and peers.</p>
                    <div class="feature-list mb-4">
                        <div class="feature-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Personalized learning dashboard</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Access to course materials & resources</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Progress tracking and analytics</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Interactive discussion forums</span>
                        </div>
                    </div>
                    <a href="student_portal.php" target="_blank" class="btn btn-primary px-4">Access Portal <i class="fas fa-external-link-alt ms-2"></i></a>
                </div>
            </div>
        </div>
        
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <h2 class="h1 mb-3">Start Your Educational Journey With Us</h2>
                <p class="lead mb-0">Whether you're a student looking to enhance your skills or an institution seeking to improve outcomes, we have solutions tailored for you.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="../contact.php" class="btn btn-light btn-lg px-5">Get Started <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Additional CSS for this page -->
<style>
    .hero-section {
        padding: 120px 0 80px;
    }
    
    .stat-box {
        padding: 20px;
    }
    
    .stat-box h2 {
        font-size: 3rem;
        margin-bottom: 10px;
    }
    
    .solution-card {
        padding: 40px;
        border-radius: 10px;
        background-color: #fff;
        box-shadow: 0 5px 30px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .solution-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }
    
    .icon-large {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    
    .icon-large i {
        font-size: 50px;
    }
    
    .bg-primary-light {
        background-color: rgba(255, 69, 0, 0.1);
    }
    
    .bg-secondary-light {
        background-color: rgba(255, 165, 0, 0.1);
    }
    
    .feature-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }
    
    .feature-item {
        display: flex;
        align-items: center;
    }
    
    .training-category, .consultancy-service, .internship-highlight {
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 8px;
        height: 100%;
    }
    
    .consultancy-service {
        text-align: center;
        padding: 25px 20px;
    }
    
    .service-icon {
        width: 60px;
        height: 60px;
        background-color: rgba(255, 69, 0, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
    }
    
    .service-icon i {
        font-size: 25px;
        color: #FF4500;
    }
    
    .certification-card {
        display: flex;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 8px;
        height: 100%;
    }
    
    .cert-icon {
        width: 60px;
        height: 60px;
        background-color: rgba(255, 69, 0, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        flex-shrink: 0;
    }
    
    .cert-icon i {
        font-size: 25px;
        color: #FF4500;
    }
    
    @media (max-width: 768px) {
        .feature-list {
            grid-template-columns: 1fr;
        }
        
        .solution-card {
            padding: 25px;
        }
        
        .stat-box h2 {
            font-size: 2.5rem;
        }
    }
</style>

<?php require_once 'includes/footer.php'; ?>