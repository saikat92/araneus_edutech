<?php
$page_title = "Educational Solutions";
require_once '../includes/header.php';

$totalStudents = $conn->query("SELECT COUNT(*) FROM students WHERE status='active'")->fetch_row()[0] ?? 0;
$totalCerts    = $conn->query("SELECT COUNT(*) FROM certificates WHERE status='active'")->fetch_row()[0] ?? 0;
$totalCourses  = $conn->query("SELECT COUNT(*) FROM courses WHERE is_active=1")->fetch_row()[0] ?? 0;
?>

<style>
.edu-hero { background:linear-gradient(135deg,rgba(15,52,96,.94) 0%,rgba(26,26,46,.9) 100%),url('../assets/images/edu_hero_bg.png') center/cover; padding:calc(var(--nav-height) + 70px) 0 80px; color:#fff; }
.stat-pill { background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.15); border-radius:12px; padding:20px 28px; text-align:center; backdrop-filter:blur(6px); }
.stat-pill .num { font-size:2.2rem; font-weight:800; background:var(--gradient-color); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
.sol-card { background:#fff; border-radius:16px; padding:36px 32px; box-shadow:var(--shadow-sm); border-top:4px solid var(--primary-color); transition:var(--transition); }
.sol-card:hover { transform:translateY(-6px); box-shadow:var(--shadow-md); }
.sol-icon { width:64px; height:64px; border-radius:16px; background:rgba(255,64,0,.08); display:flex; align-items:center; justify-content:center; margin-bottom:20px; }
.sol-icon i { font-size:26px; color:var(--primary-color); }
.check-list li { display:flex; gap:10px; align-items:flex-start; margin-bottom:10px; font-size:.9rem; }
.check-list li i { color:var(--primary-color); margin-top:2px; flex-shrink:0; }
.cat-badge { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:8px; background:#f8f9fa; border:1px solid #e9ecef; font-size:.82rem; font-weight:500; margin:4px; transition:var(--transition); cursor:default; }
.cat-badge:hover { background:rgba(255,64,0,.07); border-color:rgba(255,64,0,.2); color:var(--primary-color); }
.cert-card { background:#f8f9fa; border-radius:12px; padding:20px; display:flex; gap:14px; align-items:flex-start; }
.cert-icon-sm { width:44px; height:44px; border-radius:10px; background:rgba(255,64,0,.1); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.cert-icon-sm i { color:var(--primary-color); font-size:18px; }
</style>

<!-- Hero -->
<section class="edu-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill mb-3">Educational Solutions</span>
                <h1 class="display-4 fw-bold mb-4">Bridging Academia &amp; Industry</h1>
                <p class="lead opacity-75 mb-5">Career-focused programs and services designed for tomorrow's professionals — practical, industry-aligned, and results-driven.</p>
                <div class="d-flex gap-3 justify-content-center flex-wrap mb-5">
                    <a href="#solutions" class="btn btn-primary btn-lg">Explore Solutions</a>
                    <a href="contact.php" class="btn btn-secondary btn-lg">Get Started</a>
                </div>
                <!-- Stats row -->
                <div class="row g-3 justify-content-center">
                    <?php foreach ([
                        [$totalStudents ?: '500+', 'Students Trained'],
                        [$totalCourses  ?: '10+',  'Active Courses'],
                        ['95%',                    'Placement Rate'],
                        [$totalCerts    ?: '100+', 'Certs Issued'],
                    ] as [$num,$label]): ?>
                    <div class="col-6 col-md-3">
                        <div class="stat-pill">
                            <div class="num"><?=$num?></div>
                            <div class="small opacity-75"><?=$label?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Solutions -->
<section class="section-padding" id="solutions">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Our Educational Solutions</h2>
            <p class="text-muted">Comprehensive services empowering students and institutions</p>
        </div>

        <!-- Industry Training -->
        <div class="row g-4 mb-5 align-items-center" id="training">
            <div class="col-lg-5">
                <div class="sol-card">
                    <div class="sol-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    <h3 class="h4 fw-bold mb-3">Industry Training Courses</h3>
                    <p class="text-muted mb-4">Hands-on, project-based training programs designed with direct input from industry professionals to make you job-ready from day one.</p>
                    <div class="row g-2">
                        <?php foreach (['Python & Data Science','Embedded Systems','IoT Development','Full Stack Web Dev','Machine Learning','Graphic Design'] as $c): ?>
                        <div class="col-auto"><span class="cat-badge"><i class="fas fa-circle" style="font-size:6px;color:var(--primary-color);"></i><?=$c?></span></div>
                        <?php endforeach; ?>
                    </div>
                    <a href="courses.php" class="btn btn-outline-primary mt-4">View All Courses</a>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="row g-3">
                    <?php foreach ([
                        ['fas fa-laptop-code','Practical Projects','Every module includes real-world assignments and live projects.'],
                        ['fas fa-user-tie',   'Expert Instructors','Learn from working professionals with industry experience.'],
                        ['fas fa-certificate','Certification',      'Earn an industry-recognised certificate on completion.'],
                        ['fas fa-headset',    'Mentorship',         'Dedicated mentor support throughout your learning journey.'],
                    ] as [$icon,$title,$desc]): ?>
                    <div class="col-sm-6">
                        <div class="d-flex gap-3 p-3 bg-white rounded-3 shadow-sm h-100">
                            <div style="width:38px;height:38px;border-radius:8px;background:rgba(255,64,0,.08);display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="<?=$icon?>" style="color:var(--primary-color);"></i></div>
                            <div><h6 class="fw-bold mb-1 small"><?=$title?></h6><p class="text-muted mb-0" style="font-size:.8rem;"><?=$desc?></p></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Consultancy -->
        <div class="row g-4 mb-5 align-items-center flex-lg-row-reverse" id="consultancy">
            <div class="col-lg-5">
                <div class="sol-card">
                    <div class="sol-icon"><i class="fas fa-school"></i></div>
                    <h3 class="h4 fw-bold mb-3">Educational Consultancy</h3>
                    <p class="text-muted mb-4">Strategic guidance for institutions and students navigating the complex landscape of modern education and career development.</p>
                    <ul class="list-unstyled check-list">
                        <?php foreach (['Curriculum design & review','Institution accreditation support','Career path counselling','Higher education planning','Study abroad guidance','Skill gap assessment'] as $item): ?>
                        <li><i class="fas fa-check-circle"></i><?=$item?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="col-lg-7">
                <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=700&q=80"
                     alt="Educational Consultancy" class="img-fluid rounded-4 shadow">
            </div>
        </div>

        <!-- Internship -->
        <div class="row g-4 mb-5 align-items-center" id="internship">
            <div class="col-lg-5">
                <div class="sol-card">
                    <div class="sol-icon"><i class="fas fa-briefcase"></i></div>
                    <h3 class="h4 fw-bold mb-3">Internship Programs</h3>
                    <p class="text-muted mb-4">Gain real industry experience through structured internship placements with our network of corporate partners.</p>
                    <div class="row g-3">
                        <?php foreach ([
                            ['1–3 months','Short-term exposure to professional environments'],
                            ['3–6 months','Deep-dive project-based industry placement'],
                            ['Paid','Merit-based stipend for outstanding interns'],
                            ['Certificate','Completion certificate & LinkedIn endorsement'],
                        ] as [$badge,$desc]): ?>
                        <div class="col-12">
                            <div class="d-flex align-items-center gap-3">
                                <span class="badge rounded-pill px-3 py-2" style="background:var(--gradient-color);font-size:.8rem;"><?=$badge?></span>
                                <span class="text-muted small"><?=$desc?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="contact.php" class="btn btn-outline-primary mt-4">Apply for Internship</a>
                </div>
            </div>
            <div class="col-lg-7">
                <img src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?auto=format&fit=crop&w=700&q=80"
                     alt="Internship" class="img-fluid rounded-4 shadow">
            </div>
        </div>

        <!-- Certifications -->
        <div class="row g-4 mb-5 align-items-center flex-lg-row-reverse" id="certification">
            <div class="col-lg-5">
                <div class="sol-card">
                    <div class="sol-icon"><i class="fas fa-certificate"></i></div>
                    <h3 class="h4 fw-bold mb-3">Certification Programs</h3>
                    <p class="text-muted mb-4">Industry-recognised credentials with verifiable digital badges that enhance your professional profile.</p>
                    <div class="row g-2">
                        <?php foreach ([
                            ['fas fa-code',       'Technology','Full Stack · Data Science · Cloud · Cybersecurity'],
                            ['fas fa-chart-line', 'Business',  'Digital Marketing · Analytics · Project Management'],
                        ] as [$icon,$title,$list]): ?>
                        <div class="col-12">
                            <div class="cert-card">
                                <div class="cert-icon-sm"><i class="<?=$icon?>"></i></div>
                                <div><h6 class="fw-bold mb-1 small"><?=$title?> Certifications</h6><p class="text-muted mb-0" style="font-size:.8rem;"><?=$list?></p></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="certificates.php" class="btn btn-outline-primary mt-4"><i class="fas fa-search me-2"></i>Verify a Certificate</a>
                </div>
            </div>
            <div class="col-lg-7">
                <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b6f57?auto=format&fit=crop&w=700&q=80"
                     alt="Certifications" class="img-fluid rounded-4 shadow">
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-5 text-white" style="background:var(--gradient-color);">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-2">Start Your Educational Journey With Us</h2>
                <p class="lead mb-0 opacity-85">Whether you're a student or an institution — we have a solution tailored for you.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="contact.php" class="btn btn-light btn-lg px-5" style="color:var(--primary-color);font-weight:700;">
                    Get Started <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>
