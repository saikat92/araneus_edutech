<?php
$page_title = "Careers";
require_once 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('https://images.unsplash.com/photo-1551836026-d5c2c5af78e4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-4">Join Our Team</h1>
                <p class="lead mb-4">Be part of a dynamic team that's transforming education and business through innovative technology solutions.</p>
                <a href="#openings" class="btn btn-primary btn-lg me-3">View Open Positions</a>
                <a href="#culture" class="btn btn-outline-light btn-lg">Our Culture</a>
            </div>
        </div>
    </div>
</section>

<!-- Why Work With Us -->
<section class="section-padding" id="culture">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Why Work at Araneus Edutech?</h2>
            <p class="lead text-muted">We're building a workplace where innovation, growth, and collaboration thrive</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="culture-card text-center h-100">
                    <div class="culture-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h4 class="my-3">Impactful Work</h4>
                    <p>Contribute to projects that transform education and empower businesses across India and beyond.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="culture-card text-center h-100">
                    <div class="culture-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h4 class="my-3">Continuous Learning</h4>
                    <p>Access to training programs, certifications, and workshops to enhance your skills and career growth.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="culture-card text-center h-100">
                    <div class="culture-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4 class="my-3">Collaborative Culture</h4>
                    <p>Work with talented professionals in a supportive environment that encourages teamwork and innovation.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="culture-card text-center h-100">
                    <div class="culture-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h4 class="my-3">Career Growth</h4>
                    <p>Clear career progression paths with regular performance reviews and opportunities for advancement.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="culture-card text-center h-100">
                    <div class="culture-icon">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                    <h4 class="my-3">Work-Life Balance</h4>
                    <p>Flexible work arrangements and policies that support your professional and personal life.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="culture-card text-center h-100">
                    <div class="culture-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <h4 class="my-3">Recognition & Rewards</h4>
                    <p>Competitive compensation, performance bonuses, and recognition for outstanding contributions.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Current Openings -->
<section class="py-5 bg-light" id="openings">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Current Job Openings</h2>
            <p class="lead text-muted">Explore opportunities to join our growing team</p>
        </div>
        
        <!-- Job Filter -->
        <div class="row mb-5">
            <div class="col-md-8 mx-auto">
                <div class="job-filter">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <select class="form-select" id="departmentFilter">
                                <option value="all">All Departments</option>
                                <option value="education">Educational Solutions</option>
                                <option value="business">Business Solutions</option>
                                <option value="technology">Technology</option>
                                <option value="sales">Sales & Marketing</option>
                                <option value="operations">Operations</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select class="form-select" id="locationFilter">
                                <option value="all">All Locations</option>
                                <option value="kolkata">Kolkata</option>
                                <option value="remote">Remote</option>
                                <option value="hybrid">Hybrid</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Job Listings -->
        <div class="row" id="jobListings">
            <!-- Job 1 -->
            <div class="col-lg-6 mb-4 job-item" data-department="technology" data-location="kolkata">
                <div class="job-card">
                    <div class="job-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h4 class="mb-1">Full Stack Developer</h4>
                                <div class="job-meta">
                                    <span class="badge bg-primary me-2">Technology</span>
                                    <span class="badge bg-secondary me-2">Kolkata</span>
                                    <span class="text-muted"><i class="fas fa-clock me-1"></i> Full-time</span>
                                </div>
                            </div>
                            <div class="job-type">
                                <span class="badge bg-success">Urgent Hiring</span>
                            </div>
                        </div>
                    </div>
                    <div class="job-body">
                        <p class="mb-3">We're looking for a talented Full Stack Developer to join our technology team and help build innovative educational and business solutions.</p>
                        <div class="job-skills mb-3">
                            <span class="skill-tag">PHP</span>
                            <span class="skill-tag">JavaScript</span>
                            <span class="skill-tag">MySQL</span>
                            <span class="skill-tag">React</span>
                            <span class="skill-tag">Bootstrap</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted"><i class="fas fa-calendar me-1"></i> Posted: 2 days ago</small>
                            </div>
                            <div>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#jobModal1">View Details</button>
                                <a href="#apply" class="btn btn-sm btn-primary ms-2">Apply Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Job 2 -->
            <div class="col-lg-6 mb-4 job-item" data-department="education" data-location="hybrid">
                <div class="job-card">
                    <div class="job-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h4 class="mb-1">Educational Consultant</h4>
                                <div class="job-meta">
                                    <span class="badge bg-primary me-2">Educational Solutions</span>
                                    <span class="badge bg-secondary me-2">Hybrid</span>
                                    <span class="text-muted"><i class="fas fa-clock me-1"></i> Full-time</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="job-body">
                        <p class="mb-3">Join our educational solutions team to design and implement innovative learning programs for institutions and students.</p>
                        <div class="job-skills mb-3">
                            <span class="skill-tag">Curriculum Design</span>
                            <span class="skill-tag">Training</span>
                            <span class="skill-tag">Educational Technology</span>
                            <span class="skill-tag">Consulting</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted"><i class="fas fa-calendar me-1"></i> Posted: 1 week ago</small>
                            </div>
                            <div>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#jobModal2">View Details</button>
                                <a href="#apply" class="btn btn-sm btn-primary ms-2">Apply Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Job 3 -->
            <div class="col-lg-6 mb-4 job-item" data-department="business" data-location="remote">
                <div class="job-card">
                    <div class="job-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h4 class="mb-1">Salesforce Consultant</h4>
                                <div class="job-meta">
                                    <span class="badge bg-primary me-2">Business Solutions</span>
                                    <span class="badge bg-secondary me-2">Remote</span>
                                    <span class="text-muted"><i class="fas fa-clock me-1"></i> Full-time</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="job-body">
                        <p class="mb-3">We need an experienced Salesforce Consultant to help clients implement and optimize their CRM solutions.</p>
                        <div class="job-skills mb-3">
                            <span class="skill-tag">Salesforce</span>
                            <span class="skill-tag">CRM</span>
                            <span class="skill-tag">Apex</span>
                            <span class="skill-tag">Lightning</span>
                            <span class="skill-tag">Integration</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted"><i class="fas fa-calendar me-1"></i> Posted: 3 days ago</small>
                            </div>
                            <div>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#jobModal3">View Details</button>
                                <a href="#apply" class="btn btn-sm btn-primary ms-2">Apply Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Job 4 -->
            <div class="col-lg-6 mb-4 job-item" data-department="sales" data-location="kolkata">
                <div class="job-card">
                    <div class="job-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h4 class="mb-1">Business Development Executive</h4>
                                <div class="job-meta">
                                    <span class="badge bg-primary me-2">Sales & Marketing</span>
                                    <span class="badge bg-secondary me-2">Kolkata</span>
                                    <span class="text-muted"><i class="fas fa-clock me-1"></i> Full-time</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="job-body">
                        <p class="mb-3">Join our sales team to help grow our business by identifying new opportunities and building client relationships.</p>
                        <div class="job-skills mb-3">
                            <span class="skill-tag">Business Development</span>
                            <span class="skill-tag">Sales</span>
                            <span class="skill-tag">Client Acquisition</span>
                            <span class="skill-tag">CRM</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted"><i class="fas fa-calendar me-1"></i> Posted: 5 days ago</small>
                            </div>
                            <div>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#jobModal4">View Details</button>
                                <a href="#apply" class="btn btn-sm btn-primary ms-2">Apply Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Job 5 -->
            <div class="col-lg-6 mb-4 job-item" data-department="operations" data-location="kolkata">
                <div class="job-card">
                    <div class="job-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h4 class="mb-1">Project Coordinator</h4>
                                <div class="job-meta">
                                    <span class="badge bg-primary me-2">Operations</span>
                                    <span class="badge bg-secondary me-2">Kolkata</span>
                                    <span class="text-muted"><i class="fas fa-clock me-1"></i> Full-time</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="job-body">
                        <p class="mb-3">Coordinate and manage projects across our educational and business solutions divisions.</p>
                        <div class="job-skills mb-3">
                            <span class="skill-tag">Project Management</span>
                            <span class="skill-tag">Coordination</span>
                            <span class="skill-tag">Communication</span>
                            <span class="skill-tag">Organization</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted"><i class="fas fa-calendar me-1"></i> Posted: 2 weeks ago</small>
                            </div>
                            <div>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#jobModal5">View Details</button>
                                <a href="#apply" class="btn btn-sm btn-primary ms-2">Apply Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Job 6 -->
            <div class="col-lg-6 mb-4 job-item" data-department="education" data-location="remote">
                <div class="job-card">
                    <div class="job-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h4 class="mb-1">Content Developer (Educational)</h4>
                                <div class="job-meta">
                                    <span class="badge bg-primary me-2">Educational Solutions</span>
                                    <span class="badge bg-secondary me-2">Remote</span>
                                    <span class="text-muted"><i class="fas fa-clock me-1"></i> Part-time</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="job-body">
                        <p class="mb-3">Create engaging educational content for our training programs and online learning platforms.</p>
                        <div class="job-skills mb-3">
                            <span class="skill-tag">Content Writing</span>
                            <span class="skill-tag">Curriculum Development</span>
                            <span class="skill-tag">E-learning</span>
                            <span class="skill-tag">Instructional Design</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted"><i class="fas fa-calendar me-1"></i> Posted: 1 week ago</small>
                            </div>
                            <div>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#jobModal6">View Details</button>
                                <a href="#apply" class="btn btn-sm btn-primary ms-2">Apply Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- No Jobs Message (Hidden by default) -->
        <div class="row d-none" id="noJobsMessage">
            <div class="col-md-8 mx-auto text-center">
                <div class="py-5">
                    <i class="fas fa-search fa-4x text-muted mb-4"></i>
                    <h3 class="mb-3">No Open Positions Match Your Criteria</h3>
                    <p class="text-muted mb-4">Try adjusting your filters or check back later for new opportunities.</p>
                    <button type="button" class="btn btn-outline-primary" id="resetFilters">Reset Filters</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Application Process -->
<section class="section-padding">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Our Hiring Process</h2>
            <p class="lead text-muted">We follow a transparent and efficient process to find the right talent</p>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="process-step text-center">
                    <div class="step-number bg-primary text-white">1</div>
                    <h4 class="mt-4 mb-3">Application Review</h4>
                    <p>Our HR team reviews your application and resume to assess fit for the role.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="process-step text-center">
                    <div class="step-number bg-primary text-white">2</div>
                    <h4 class="mt-4 mb-3">Screening Call</h4>
                    <p>A brief phone call to discuss your background and interest in the position.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="process-step text-center">
                    <div class="step-number bg-primary text-white">3</div>
                    <h4 class="mt-4 mb-3">Interviews</h4>
                    <p>Technical and behavioral interviews with team members and hiring managers.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="process-step text-center">
                    <div class="step-number bg-primary text-white">4</div>
                    <h4 class="mt-4 mb-3">Offer & Onboarding</h4>
                    <p>Successful candidates receive an offer and go through our onboarding process.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Application Form -->
<section class="py-5 bg-light" id="apply">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 shadow">
                    <div class="card-header bg-primary text-white py-4">
                        <h3 class="mb-0 text-center">Apply for a Position</h3>
                    </div>
                    <div class="card-body p-4 p-lg-5">
                        <form id="careerApplicationForm" action="process_application.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="firstName" class="form-label">First Name *</label>
                                    <input type="text" class="form-control" id="firstName" name="firstName" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lastName" class="form-label">Last Name *</label>
                                    <input type="text" class="form-control" id="lastName" name="lastName" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Address *</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone Number *</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="position" class="form-label">Position Applying For *</label>
                                <select class="form-select" id="position" name="position" required>
                                    <option value="" selected disabled>Select a position</option>
                                    <option value="Full Stack Developer">Full Stack Developer</option>
                                    <option value="Educational Consultant">Educational Consultant</option>
                                    <option value="Salesforce Consultant">Salesforce Consultant</option>
                                    <option value="Business Development Executive">Business Development Executive</option>
                                    <option value="Project Coordinator">Project Coordinator</option>
                                    <option value="Content Developer (Educational)">Content Developer (Educational)</option>
                                    <option value="Other">Other (Specify in cover letter)</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="experience" class="form-label">Years of Experience *</label>
                                <select class="form-select" id="experience" name="experience" required>
                                    <option value="" selected disabled>Select experience level</option>
                                    <option value="0-1">0-1 years</option>
                                    <option value="1-3">1-3 years</option>
                                    <option value="3-5">3-5 years</option>
                                    <option value="5-10">5-10 years</option>
                                    <option value="10+">10+ years</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="resume" class="form-label">Upload Resume/CV *</label>
                                <input class="form-control" type="file" id="resume" name="resume" accept=".pdf,.doc,.docx" required>
                                <small class="text-muted">Accepted formats: PDF, DOC, DOCX (Max size: 5MB)</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="coverLetter" class="form-label">Cover Letter</label>
                                <textarea class="form-control" id="coverLetter" name="coverLetter" rows="4" placeholder="Tell us why you're interested in this position and what makes you a good fit..."></textarea>
                            </div>
                            
                            <div class="mb-4">
                                <label for="howHeard" class="form-label">How did you hear about us?</label>
                                <select class="form-select" id="howHeard" name="howHeard">
                                    <option value="" selected>Select an option</option>
                                    <option value="LinkedIn">LinkedIn</option>
                                    <option value="Job Portal">Job Portal (Naukri, Indeed, etc.)</option>
                                    <option value="Company Website">Company Website</option>
                                    <option value="Referral">Employee Referral</option>
                                    <option value="Social Media">Social Media</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Submit Application</button>
                            </div>
                            
                            <p class="text-muted mt-3 small">By submitting this application, you agree to our <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">Privacy Policy</a> and consent to the processing of your personal data for recruitment purposes.</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Internship Section -->
<section class="section-padding" style="background: var(--gradient-color); color: white;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <h2 class="h1 mb-3">Internship Opportunities</h2>
                <p class="lead mb-4">Looking for hands-on experience? We offer internship programs for students and recent graduates across various domains.</p>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Technology & Development</li>
                            <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Business & Marketing</li>
                            <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Educational Content</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Design & Animation</li>
                            <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Project Management</li>
                            <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Research & Analysis</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="<?= SITE_URL; ?>education.php#internship" class="btn btn-light btn-lg px-5">Learn About Internships</a>
            </div>
        </div>
    </div>
</section>

<!-- Job Detail Modals -->
<!-- Modal for Job 1 -->
<div class="modal fade" id="jobModal1" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Full Stack Developer - Job Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>Job Description</h4>
                <p>We are seeking a skilled Full Stack Developer to join our technology team. You will be responsible for developing and maintaining web applications for both our educational and business solutions.</p>
                
                <h5 class="mt-4">Responsibilities:</h5>
                <ul>
                    <li>Develop responsive web applications using PHP, JavaScript, and modern frameworks</li>
                    <li>Design and implement database schemas and queries</li>
                    <li>Collaborate with cross-functional teams to define, design, and ship new features</li>
                    <li>Write clean, maintainable, and efficient code</li>
                    <li>Troubleshoot, debug and upgrade existing systems</li>
                    <li>Participate in code reviews and team meetings</li>
                </ul>
                
                <h5 class="mt-4">Requirements:</h5>
                <ul>
                    <li>2+ years of experience in full stack development</li>
                    <li>Proficiency in PHP, JavaScript, HTML, CSS</li>
                    <li>Experience with MySQL or similar databases</li>
                    <li>Familiarity with React.js or similar frontend frameworks</li>
                    <li>Knowledge of RESTful APIs and web services</li>
                    <li>Understanding of version control systems (Git)</li>
                    <li>Excellent problem-solving and communication skills</li>
                </ul>
                
                <h5 class="mt-4">Benefits:</h5>
                <ul>
                    <li>Competitive salary with performance bonuses</li>
                    <li>Health insurance and other benefits</li>
                    <li>Flexible working hours</li>
                    <li>Professional development opportunities</li>
                    <li>Collaborative and innovative work environment</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="#apply" class="btn btn-primary" data-bs-dismiss="modal">Apply Now</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Job 2 -->
<div class="modal fade" id="jobModal2" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Educational Consultant - Job Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>Job Description</h4>
                <p>We are looking for an experienced Educational Consultant to join our team and help design, develop, and implement innovative educational programs and solutions for our clients.</p>
                
                <h5 class="mt-4">Responsibilities:</h5>
                <ul>
                    <li>Consult with educational institutions to assess their needs and challenges</li>
                    <li>Design and develop curriculum aligned with industry requirements</li>
                    <li>Create training programs for faculty and students</li>
                    <li>Evaluate educational technologies and recommend solutions</li>
                    <li>Conduct workshops and training sessions</li>
                    <li>Provide ongoing support and guidance to clients</li>
                </ul>
                
                <h5 class="mt-4">Requirements:</h5>
                <ul>
                    <li>Master's degree in Education, Educational Technology, or related field</li>
                    <li>3+ years of experience in educational consulting or curriculum development</li>
                    <li>Strong understanding of pedagogical theories and practices</li>
                    <li>Experience with e-learning platforms and educational technology</li>
                    <li>Excellent communication and presentation skills</li>
                    <li>Ability to work independently and as part of a team</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="#apply" class="btn btn-primary" data-bs-dismiss="modal">Apply Now</a>
            </div>
        </div>
    </div>
</div>

<!-- Privacy Policy Modal -->
<div class="modal fade" id="privacyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Privacy Policy for Job Applications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>We respect your privacy and are committed to protecting your personal data. The information you provide in your job application will be used solely for recruitment purposes.</p>
                <p>Your data will be stored securely and will not be shared with third parties without your consent, except as required by law or as necessary for the recruitment process.</p>
                <p>If you have any questions about how we handle your personal information, please contact us at <strong>hr@araneusedutech.com</strong>.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Additional CSS for this page -->
<style>
    .hero-section {
        padding: 120px 0 80px;
    }
    
    .culture-card {
        padding: 30px 20px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease;
    }
    
    .culture-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
    }
    
    .culture-icon {
        width: 80px;
        height: 80px;
        background-color: rgba(255, 69, 0, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
    
    .culture-icon i {
        font-size: 35px;
        color: #FF4500;
    }
    
    .job-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        height: 100%;
        transition: transform 0.3s ease;
    }
    
    .job-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .job-header {
        padding: 20px;
        border-bottom: 1px solid #eee;
    }
    
    .job-body {
        padding: 20px;
    }
    
    .job-meta {
        margin-bottom: 10px;
    }
    
    .skill-tag {
        display: inline-block;
        background-color: #f1f1f1;
        color: #555;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        margin-right: 5px;
        margin-bottom: 8px;
    }
    
    .step-number {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: bold;
        margin: 0 auto;
    }
    
    .job-filter {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .form-label {
        font-weight: 600;
        margin-bottom: 8px;
    }
    
    .form-control, .form-select {
        padding: 12px 15px;
        border-radius: 8px;
        border: 1px solid #ddd;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #FF4500;
        box-shadow: 0 0 0 0.2rem rgba(255, 69, 0, 0.25);
    }
    
    @media (max-width: 768px) {
        .hero-section {
            padding: 100px 0 60px;
        }
        
        .job-card {
            margin-bottom: 20px;
        }
    }
</style>

<!-- JavaScript for Job Filtering -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const departmentFilter = document.getElementById('departmentFilter');
        const locationFilter = document.getElementById('locationFilter');
        const jobItems = document.querySelectorAll('.job-item');
        const noJobsMessage = document.getElementById('noJobsMessage');
        const resetFiltersBtn = document.getElementById('resetFilters');
        const jobListings = document.getElementById('jobListings');
        
        function filterJobs() {
            const selectedDepartment = departmentFilter.value;
            const selectedLocation = locationFilter.value;
            let visibleJobs = 0;
            
            jobItems.forEach(item => {
                const department = item.getAttribute('data-department');
                const location = item.getAttribute('data-location');
                
                const departmentMatch = selectedDepartment === 'all' || department === selectedDepartment;
                const locationMatch = selectedLocation === 'all' || location === selectedLocation;
                
                if (departmentMatch && locationMatch) {
                    item.style.display = 'block';
                    visibleJobs++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Show/hide no jobs message
            if (visibleJobs === 0) {
                jobListings.classList.add('d-none');
                noJobsMessage.classList.remove('d-none');
            } else {
                jobListings.classList.remove('d-none');
                noJobsMessage.classList.add('d-none');
            }
        }
        
        // Add event listeners to filters
        departmentFilter.addEventListener('change', filterJobs);
        locationFilter.addEventListener('change', filterJobs);
        
        // Reset filters button
        if (resetFiltersBtn) {
            resetFiltersBtn.addEventListener('click', function() {
                departmentFilter.value = 'all';
                locationFilter.value = 'all';
                filterJobs();
            });
        }
        
        // Initialize filter on page load
        filterJobs();
        
        // Form submission handler
        const applicationForm = document.getElementById('careerApplicationForm');
        if (applicationForm) {
            applicationForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Basic validation
                const resumeInput = document.getElementById('resume');
                const file = resumeInput.files[0];
                
                if (file) {
                    const fileSize = file.size / 1024 / 1024; // in MB
                    if (fileSize > 5) {
                        alert('File size exceeds 5MB limit. Please upload a smaller file.');
                        return;
                    }
                    
                    const validExtensions = ['pdf', 'doc', 'docx'];
                    const fileExtension = file.name.split('.').pop().toLowerCase();
                    
                    if (!validExtensions.includes(fileExtension)) {
                        alert('Please upload a file in PDF, DOC, or DOCX format.');
                        return;
                    }
                }
                
                // Form is valid - in a real application, you would submit to the server here
                // For demo purposes, we'll show a success message
                alert('Thank you for your application! We will review your submission and contact you if there is a match with our requirements.');
                
                // Reset form
                applicationForm.reset();
                
                // Scroll to top
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    });
</script>

<?php require_once 'includes/footer.php'; ?>