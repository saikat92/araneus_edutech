<?php
$page_title = "About Us";
require_once '../includes/header.php';
?>

<style>
.about-hero { background: linear-gradient(135deg,rgba(26,26,46,.92) 0%,rgba(15,52,96,.88) 100%), url('https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1400&q=80') center/cover; padding: calc(var(--nav-height) + 70px) 0 80px; color:#fff; }
.experience-badge { position:absolute; bottom:-20px; right:20px; width:110px; height:110px; background:var(--gradient-color); border-radius:50%; display:flex; flex-direction:column; align-items:center; justify-content:center; color:#fff; box-shadow:0 8px 24px rgba(255,64,0,.4); }
.experience-badge .years { font-size:2rem; font-weight:800; line-height:1; }
.experience-badge .text  { font-size:.6rem; text-align:center; line-height:1.2; }
.value-card { background:#fff; border-radius:14px; padding:32px 24px; text-align:center; box-shadow:var(--shadow-sm); transition:var(--transition); border-bottom:3px solid transparent; }
.value-card:hover { transform:translateY(-6px); box-shadow:var(--shadow-md); border-bottom-color:var(--primary-color); }
.value-icon { width:64px; height:64px; border-radius:16px; background:rgba(255,64,0,.08); display:flex; align-items:center; justify-content:center; margin:0 auto 18px; }
.value-icon i { font-size:26px; color:var(--primary-color); }
.team-card { border-radius:16px; overflow:hidden; box-shadow:var(--shadow-sm); transition:var(--transition); background:#fff; }
.team-card:hover { transform:translateY(-6px); box-shadow:var(--shadow-md); }
.team-img { position:relative; overflow:hidden; height:260px; }
.team-img img { width:100%; height:100%; object-fit:cover; transition:transform .4s; }
.team-card:hover .team-img img { transform:scale(1.05); }
.team-social { position:absolute; bottom:0; left:0; right:0; background:linear-gradient(transparent,rgba(0,0,0,.7)); padding:16px; display:flex; gap:10px; justify-content:center; transform:translateY(100%); transition:.3s; }
.team-card:hover .team-social { transform:translateY(0); }
.team-social a { width:34px; height:34px; border-radius:50%; background:rgba(255,255,255,.15); display:flex; align-items:center; justify-content:center; color:#fff; font-size:.8rem; transition:.2s; }
.team-social a:hover { background:var(--primary-color); }
.timeline { position:relative; padding-left:36px; }
.timeline::before { content:''; position:absolute; left:10px; top:0; bottom:0; width:2px; background:linear-gradient(to bottom,var(--primary-color),var(--secondary-color)); border-radius:2px; }
.tl-item { position:relative; padding-bottom:32px; }
.tl-dot { position:absolute; left:-30px; top:4px; width:16px; height:16px; border-radius:50%; background:var(--gradient-color); box-shadow:0 0 0 4px rgba(255,64,0,.15); }
.tl-year { font-size:.78rem; font-weight:700; color:var(--primary-color); text-transform:uppercase; letter-spacing:.06em; margin-bottom:4px; }
.why-item { display:flex; gap:16px; align-items:flex-start; padding:20px; border-radius:12px; background:#fff; box-shadow:var(--shadow-sm); transition:var(--transition); }
.why-item:hover { transform:translateX(4px); box-shadow:var(--shadow-md); }
.why-icon { width:46px; height:46px; border-radius:10px; background:rgba(255,64,0,.08); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.why-icon i { color:var(--primary-color); font-size:18px; }
</style>

<!-- Hero -->
<section class="about-hero text-center">
    <div class="container">
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill mb-3">Est. 2018 · Barrackpore, Kolkata</span>
        <h1 class="display-4 fw-bold mb-4">About Araneus Edutech LLP</h1>
        <p class="lead mb-5 opacity-75" style="max-width:620px;margin:0 auto 32px;">
            Driving innovation in education and business through technology, expertise, and strategic partnerships.
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="#story"   class="btn btn-primary btn-lg">Our Story</a>
            <a href="contact.php" class="btn btn-secondary btn-lg">Get In Touch</a>
        </div>
    </div>
</section>

<!-- Story -->
<section class="section-padding" id="story">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=800&q=80"
                         alt="Araneus Team" class="img-fluid rounded-4 shadow-lg">
                    <div class="experience-badge">
                        <span class="years">9+</span>
                        <span class="text">Years<br>Experience</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h2 class="section-title text-start">Our Journey</h2>
                <p class="lead mb-4">Founded in 2018, Araneus Edutech LLP began with a vision to bridge the gap between academic learning and industry requirements in Kolkata, India.</p>
                <p class="text-muted mb-4">Our name 'Araneus' is derived from the Latin word for spider — symbolising our approach to creating interconnected networks of knowledge, technology, and opportunity. Just as a spider weaves a complex yet purposeful web, we connect educational institutions, businesses, and individuals.</p>
                <div class="row g-3 mt-2">
                    <?php foreach ([
                        ['fas fa-bullseye','Our Vision','To be the leading catalyst for educational and business transformation through innovative technology solutions.'],
                        ['fas fa-rocket',  'Our Mission','To empower individuals and organizations through customized educational programs and business technology solutions.'],
                    ] as [$icon,$title,$desc]): ?>
                    <div class="col-sm-6">
                        <div class="d-flex gap-3">
                            <i class="<?=$icon?> fa-2x mt-1" style="color:var(--primary-color);flex-shrink:0;"></i>
                            <div><h6 class="fw-bold mb-1"><?=$title?></h6><p class="text-muted small mb-0"><?=$desc?></p></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Our Core Values</h2>
            <p class="text-muted">The principles that guide everything we do</p>
        </div>
        <div class="row g-4">
            <?php foreach ([
                ['fas fa-lightbulb',     'Innovation',     'We constantly seek new and better ways to solve challenges, embracing technology and creative thinking.'],
                ['fas fa-handshake',     'Integrity',      'We conduct business with honesty, transparency, and ethical practices, building trust through reliable partnerships.'],
                ['fas fa-users',         'Collaboration',  'We believe in the power of partnership, working closely with clients, institutions, and experts.'],
                ['fas fa-graduation-cap','Excellence',     'We strive for the highest quality in everything — from educational programs to business solutions.'],
            ] as [$icon,$title,$desc]): ?>
            <div class="col-lg-3 col-md-6">
                <div class="value-card">
                    <div class="value-icon"><i class="<?=$icon?>"></i></div>
                    <h5 class="fw-bold mb-2"><?=$title?></h5>
                    <p class="text-muted small mb-0"><?=$desc?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Timeline -->
<section class="section-padding">
    <div class="container">
        <div class="row g-5 align-items-start">
            <div class="col-lg-5">
                <h2 class="section-title text-start">Our Milestones</h2>
                <p class="text-muted mb-4">A journey of continuous growth — from a small consultancy in Barrackpore to a recognised Edutech firm serving clients across India.</p>
                <a href="contact.php" class="btn btn-outline-primary">Work With Us</a>
            </div>
            <div class="col-lg-7">
                <div class="timeline">
                    <?php foreach ([
                        ['2018','Company Founded','Araneus Edutech LLP registered in Barrackpore, Kolkata with a vision to transform education and business through technology.'],
                        ['2019','First Training Batch','Launched first industry-aligned Python & Data Science training program with 20 students.'],
                        ['2020','Business Solutions Division','Expanded into CRM, ERP, and GST solutions, onboarding first corporate clients.'],
                        ['2021','Student Portal Launched','Released the digital student portal for enrollment, assignments, and certificate management.'],
                        ['2022','MSME Recognition','Officially recognised as an MSME entity, strengthening credibility with institutional partners.'],
                        ['2023','Pan-India Reach','Extended client base beyond West Bengal to serve students and businesses across India.'],
                        ['2024','Expanded Course Catalogue','Added 5+ new industry programs including IoT, Embedded Systems, and Full Stack Development.'],
                    ] as [$year,$title,$desc]): ?>
                    <div class="tl-item">
                        <div class="tl-dot"></div>
                        <div class="tl-year"><?=$year?></div>
                        <h6 class="fw-bold mb-1"><?=$title?></h6>
                        <p class="text-muted small mb-0"><?=$desc?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Meet Our Leadership</h2>
            <p class="text-muted">Experienced professionals driving our vision forward</p>
        </div>
        <div class="row g-4 justify-content-center">
            <?php foreach ([
                ['https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=500&q=80','Rajesh Sharma','Founder & CEO','15+ years in education technology and business consulting.'],
                ['https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=500&q=80','Priya Patel','Director of Education','12 years of academic leadership, overseeing all educational programs.'],
                ['https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=500&q=80','Amit Kumar','Head of Business Solutions','Expert in ERP, CRM, and custom software solutions.'],
            ] as [$img,$name,$role,$bio]): ?>
            <div class="col-lg-4 col-md-6">
                <div class="team-card">
                    <div class="team-img">
                        <img src="<?=$img?>" alt="<?=$name?>">
                        <div class="team-social">
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="mailto:<?=SITE_EMAIL?>"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                    <div class="p-4">
                        <h5 class="fw-bold mb-1"><?=$name?></h5>
                        <p class="small mb-2" style="color:var(--primary-color);font-weight:600;"><?=$role?></p>
                        <p class="text-muted small mb-0"><?=$bio?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-5">
            <div class="d-inline-block bg-white rounded-4 shadow-sm px-5 py-4">
                <i class="fas fa-users fa-2x mb-3" style="color:var(--primary-color);"></i>
                <h5 class="fw-bold mb-1">25+ Dedicated Professionals</h5>
                <p class="text-muted small mb-0">Technology experts, educational consultants, trainers, and support staff working together.</p>
            </div>
        </div>
    </div>
</section>

<!-- Why choose us -->
<section class="section-padding">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5">
                <h2 class="section-title text-start">Why Choose Araneus?</h2>
                <p class="text-muted mb-4">What sets us apart in the educational consultancy and business technology landscape.</p>
                <a href="contact.php" class="btn btn-primary px-4">Start Your Journey</a>
            </div>
            <div class="col-lg-7">
                <div class="d-flex flex-column gap-3">
                    <?php foreach ([
                        ['fas fa-certificate',    'Industry-Recognised Certifications', 'Our programs are aligned with industry standards ensuring your credentials hold real-world value.'],
                        ['fas fa-user-tie',        'Expert-Led Training',               'Every course is designed and delivered by working professionals — not just academics.'],
                        ['fas fa-laptop-code',     '100% Practical Approach',           'Hands-on projects, live assignments, and real datasets — learn by doing.'],
                        ['fas fa-headset',         'Dedicated Support',                 'Personal mentors, student portal access, and post-completion career guidance included.'],
                        ['fas fa-rupee-sign',      'Affordable Fees',                   'High-quality education shouldn\'t break the bank. Transparent pricing with no hidden costs.'],
                    ] as [$icon,$title,$desc]): ?>
                    <div class="why-item">
                        <div class="why-icon"><i class="<?=$icon?>"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1"><?=$title?></h6>
                            <p class="text-muted small mb-0"><?=$desc?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-5 text-white text-center" style="background:linear-gradient(135deg,#1a1a2e,#0f3460);position:relative;overflow:hidden;">
    <div class="container position-relative">
        <h2 class="fw-bold mb-3">Ready to Work With Us?</h2>
        <p class="lead mb-4 opacity-75">Let's build something great together.</p>
        <a href="contact.php" class="btn btn-primary btn-lg px-5 me-2">Get In Touch</a>
        <a href="courses.php" class="btn btn-secondary btn-lg px-5">Our Courses</a>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>
