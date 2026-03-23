<?php
$page_title = "Home";
require_once '../includes/header.php';

// Fetch stats for counter section
$totalStudents = $conn->query("SELECT COUNT(*) FROM students WHERE status='active'")->fetch_row()[0] ?? 0;
$totalCourses  = $conn->query("SELECT COUNT(*) FROM courses  WHERE is_active=1")->fetch_row()[0] ?? 0;
$avgRating     = $conn->query("SELECT ROUND(AVG(rating),1) FROM testimonials WHERE status='published'")->fetch_row()[0] ?? 4.9;

// Latest 3 blogs
$blogs = $conn->query("SELECT title, slug, excerpt, published_date, category FROM blogs WHERE status='published' ORDER BY published_date DESC LIMIT 3")->fetch_all(MYSQLI_ASSOC);

// Featured testimonial
$testi = $conn->query("SELECT * FROM testimonials WHERE status='published' AND is_featured=1 ORDER BY RAND() LIMIT 1")->fetch_assoc();
if (!$testi) $testi = $conn->query("SELECT * FROM testimonials WHERE status='published' ORDER BY RAND() LIMIT 1")->fetch_assoc();

function stars($n) {
    $h = '';
    for ($i=1; $i<=5; $i++) $h .= $i<=$n ? '<i class="fas fa-star text-warning"></i>' : '<i class="far fa-star text-muted"></i>';
    return $h;
}
$catColors = ['Technology'=>'primary','Education'=>'success','Business'=>'warning','Career'=>'info','General'=>'secondary'];
?>

<style>
/* ── Home-page only styles ── */
.hero-home {
    min-height: 100vh;
    background: linear-gradient(135deg, rgba(26,26,46,.92) 0%, rgba(15,52,96,.88) 60%),
                url('<?= SITE_URL; ?>assets/images/hero-bg.png') center/cover no-repeat;
    display: flex;
    align-items: center;
    padding-top: var(--nav-height);
    position: relative;
    overflow: hidden;
}
.hero-home::before {
    content:'';
    position:absolute;
    inset:0;
    background: radial-gradient(ellipse at 80% 50%, rgba(255,64,0,.18) 0%, transparent 55%);
    pointer-events:none;
}
.hero-badge {
    display:inline-block;
    background:rgba(255,169,0,.18);
    color: var(--secondary-color);
    border:1px solid rgba(255,169,0,.35);
    border-radius:20px;
    font-size:.78rem;
    font-weight:600;
    letter-spacing:.08em;
    padding:5px 16px;
    margin-bottom:20px;
    text-transform:uppercase;
}
.hero-home h1 { font-size:clamp(2.2rem,5vw,3.8rem); line-height:1.15; }
.hero-stat { text-align:center; }
.hero-stat .stat-num { font-size:2rem; font-weight:800; background:var(--gradient-color); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
.hero-stat .stat-label { font-size:.75rem; color:rgba(255,255,255,.6); text-transform:uppercase; letter-spacing:.06em; }
.hero-divider { width:1px; height:40px; background:rgba(255,255,255,.15); }

.feature-card { border-radius:14px; border:1px solid rgba(0,0,0,.06); background:#fff; padding:28px 24px; height:100%; transition:var(--transition); }
.feature-card:hover { transform:translateY(-6px); box-shadow:var(--shadow-md); border-color:rgba(255,64,0,.12); }
.feature-icon { width:56px; height:56px; border-radius:14px; background:rgba(255,64,0,.08); display:flex; align-items:center; justify-content:center; margin-bottom:18px; transition:var(--transition); }
.feature-card:hover .feature-icon { background:rgba(255,64,0,.14); }
.feature-icon i { font-size:22px; color:var(--primary-color); }

.counter-section { background:var(--gradient-color); }
.counter-num { font-size:2.6rem; font-weight:800; }

.solution-tab { border-radius:12px; border:none; padding:28px; height:100%; background:#fff; box-shadow:var(--shadow-sm); }
.solution-tab .icon-wrap { width:52px; height:52px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px; margin-bottom:16px; }

.blog-card { border-radius:12px; overflow:hidden; border:none; box-shadow:var(--shadow-sm); height:100%; transition:var(--transition); }
.blog-card:hover { transform:translateY(-5px); box-shadow:var(--shadow-md); }
.blog-card img { width:100%; height:180px; object-fit:cover; transition:transform .4s; }
.blog-card:hover img { transform:scale(1.04); }

.testi-card { border-radius:16px; background:#fff; padding:32px; box-shadow:var(--shadow-md); position:relative; }
.testi-card::before { content:'\201C'; font-size:100px; line-height:.5; position:absolute; top:20px; left:24px; color:rgba(255,64,0,.08); font-family:Georgia,serif; }

.cta-section { background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 100%); position:relative; overflow:hidden; }
.cta-section::before { content:''; position:absolute; inset:0; background:radial-gradient(ellipse at 30% 50%,rgba(255,64,0,.2),transparent 60%); }
</style>

<!-- ══ HERO ═════════════════════════════════════════════ -->
<section class="hero-home text-white">
    <div class="container position-relative py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <span class="hero-badge"><i class="fas fa-star me-1"></i> Trusted Edutech Partner in Kolkata</span>
                <h1 class="text-white fw-bold mb-4">
                    Transforming Education &amp;<br>
                    <span style="background:var(--gradient-color);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Business with Innovation</span>
                </h1>
                <p class="lead mb-5 opacity-75" style="max-width:520px;">
                    Araneus Edutech LLP delivers industry-aligned training, certification programs, and business technology solutions to help you grow — faster.
                </p>
                <div class="d-flex flex-wrap gap-3 mb-5">
                    <a href="education.php" class="btn btn-primary btn-lg">
                        <i class="fas fa-graduation-cap me-2"></i>Explore Courses
                    </a>
                    <a href="contact.php" class="btn btn-secondary btn-lg">
                        Talk to Us <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
                <!-- Mini stats -->
                <div class="d-flex align-items-center gap-4 flex-wrap">
                    <div class="hero-stat">
                        <div class="stat-num"><?php echo $totalStudents ?: '100'; ?>+</div>
                        <div class="stat-label">Students Trained</div>
                    </div>
                    <div class="hero-divider d-none d-sm-block"></div>
                    <div class="hero-stat">
                        <div class="stat-num"><?php echo $totalCourses ?: '10'; ?>+</div>
                        <div class="stat-label">Active Courses</div>
                    </div>
                    <div class="hero-divider d-none d-sm-block"></div>
                    <div class="hero-stat">
                        <div class="stat-num"><?php echo $avgRating ?: '4.9'; ?><span style="font-size:1.2rem;">/5</span></div>
                        <div class="stat-label">Avg. Rating</div>
                    </div>
                </div>
            </div>
            <!-- Right panel on lg -->
            <div class="col-lg-5 d-none d-lg-flex justify-content-center">
                <div class="bg-white bg-opacity-10 rounded-4 p-4" style="backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.12);max-width:360px;width:100%;">
                    <p class="small text-white opacity-75 text-uppercase fw-bold ls-wide mb-3">Why choose Araneus?</p>
                    <?php foreach ([
                        ['fas fa-certificate',      '#ffa900', 'Industry-recognised certification'],
                        ['fas fa-laptop-code',      '#ff4000', 'Hands-on practical training'],
                        ['fas fa-users',            '#ffa900', 'Expert mentors &amp; small batches'],
                        ['fas fa-briefcase',        '#ff4000', 'Placement &amp; internship support'],
                        ['fas fa-headset',          '#ffa900', '24/7 student support portal'],
                    ] as [$icon, $color, $text]): ?>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div style="width:34px;height:34px;border-radius:8px;background:rgba(255,255,255,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="<?= $icon ?>" style="color:<?= $color ?>;font-size:14px;"></i>
                        </div>
                        <span class="text-white opacity-85 small"><?= $text ?></span>
                    </div>
                    <?php endforeach; ?>
                    <a href="pages/login.php" class="btn btn-primary w-100 mt-2">
                        <i class="fas fa-user-circle me-2"></i>Student Portal Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══ FEATURE CARDS ════════════════════════════════════ -->
<section class="section-padding">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">What We Offer</h2>
            <p class="text-muted">Comprehensive solutions designed for individuals and organisations</p>
        </div>
        <div class="row g-4">
            <?php foreach ([
                ['fas fa-graduation-cap', 'Educational Excellence',  'Industry-aligned training, internships, and certification programs that bridge academia and industry.', 'education.php'],
                ['fas fa-chart-line',     'Business Growth',         'Strategic technology solutions — CRM, ERP, GST, and more — to optimise operations and scale faster.', 'business.php'],
                ['fas fa-users',          'Expert Mentors',          'Learn from industry veterans with decades of combined experience across education and enterprise.', 'about.php'],
                ['fas fa-handshake',      'Client-Centric Approach', 'Every solution is tailored to your goals, not a one-size-fits-all package.', 'contact.php'],
            ] as [$icon, $title, $desc, $link]): ?>
            <div class="col-lg-3 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon"><i class="<?= $icon ?>"></i></div>
                    <h5 class="fw-bold mb-2"><?= $title ?></h5>
                    <p class="text-muted small mb-3" style="line-height:1.7;"><?= $desc ?></p>
                    <a href="<?= $link ?>" class="small fw-semibold" style="color:var(--primary-color);">
                        Learn more <i class="fas fa-arrow-right ms-1" style="font-size:.75rem;"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══ COUNTER BAND ══════════════════════════════════════ -->
<section class="counter-section py-5 text-white">
    <div class="container">
        <div class="row g-4 text-center">
            <?php foreach ([
                [$totalStudents ?: 100, '+', 'Students Trained'],
                [$totalCourses  ?: 10,  '+', 'Active Courses'],
                [5,                     '+', 'Years of Excellence'],
                [$avgRating ?: 4.9,    '/5', 'Average Rating'],
            ] as [$num, $suffix, $label]): ?>
            <div class="col-6 col-md-3">
                <div class="counter-num"><?= $num ?><span style="font-size:1.4rem;"><?= $suffix ?></span></div>
                <div class="small opacity-75 mt-1"><?= $label ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══ SOLUTIONS OVERVIEW ════════════════════════════════ -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Our Solutions</h2>
            <p class="text-muted">Two pillars — education and business — one trusted partner</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="solution-tab">
                    <div class="icon-wrap" style="background:rgba(255,64,0,.1);">
                        <i class="fas fa-graduation-cap" style="color:var(--primary-color);"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-2">Educational Solutions</h3>
                    <p class="text-muted small mb-4">Comprehensive services that bridge the gap between classroom knowledge and industry readiness.</p>
                    <ul class="list-unstyled mb-4">
                        <?php foreach (['Industry-related Training Courses','Educational Consultancy','Internship Programs','Certification Programs','Student Portal Access'] as $item): ?>
                        <li class="mb-2 small"><i class="fas fa-check-circle me-2" style="color:var(--primary-color);"></i><?= $item ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="education.php" class="btn btn-outline-primary btn-sm">Explore Education Solutions <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="solution-tab">
                    <div class="icon-wrap" style="background:rgba(255,169,0,.1);">
                        <i class="fas fa-briefcase" style="color:var(--secondary-color);"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-2">Business Solutions</h3>
                    <p class="text-muted small mb-4">Cutting-edge technology implementations to optimise your operations and drive sustainable growth.</p>
                    <ul class="list-unstyled mb-4">
                        <?php foreach (['CRM – Salesforce Implementation','ERP Solutions (Oracle E-Business Suite)','GST Solutions &amp; E-Invoicing','Transition, Integration &amp; Support','Animation &amp; Graphic Designing'] as $item): ?>
                        <li class="mb-2 small"><i class="fas fa-check-circle me-2" style="color:var(--secondary-color);"></i><?= $item ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="business.php" class="btn btn-outline-primary btn-sm">Explore Business Solutions <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══ TESTIMONIAL SPOTLIGHT ════════════════════════════ -->
<?php if ($testi): ?>
<section class="section-padding">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">What Our Clients Say</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="testi-card text-center">
                    <div class="mb-3"><?= stars($testi['rating']); ?></div>
                    <p class="mb-4" style="font-size:1.05rem;line-height:1.8;color:#3a3a3a;">
                        &ldquo;<?= htmlspecialchars($testi['testimonial']); ?>&rdquo;
                    </p>
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <div style="width:46px;height:46px;border-radius:50%;background:var(--gradient-color);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;">
                            <?= strtoupper(substr($testi['client_name'],0,1)); ?>
                        </div>
                        <div class="text-start">
                            <div class="fw-semibold"><?= htmlspecialchars($testi['client_name']); ?></div>
                            <div class="small text-muted"><?= htmlspecialchars($testi['client_position'] ?? ''); ?><?= $testi['company'] ? ' · ' . htmlspecialchars($testi['company']) : ''; ?></div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <a href="testimonials.php" class="btn btn-outline-primary">Read All Reviews</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ══ LATEST BLOGS ══════════════════════════════════════ -->
<?php if (!empty($blogs)): ?>
<section class="section-padding bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">
            <div>
                <h2 class="section-title text-start" style="margin-bottom:28px;">Latest from Our Blog</h2>
            </div>
            <a href="blogs.php" class="btn btn-outline-primary btn-sm">View All Articles <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="row g-4">
            <?php foreach ($blogs as $b):
                $cc = $catColors[$b['category']] ?? 'secondary'; ?>
            <div class="col-lg-4 col-md-6">
                <div class="blog-card card">
                    <div style="overflow:hidden;">
                        <img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=600&q=60"
                             alt="<?= htmlspecialchars($b['title']); ?>">
                    </div>
                    <div class="card-body p-4">
                        <span class="badge bg-<?= $cc ?> rounded-pill mb-2"><?= htmlspecialchars($b['category'] ?? 'General'); ?></span>
                        <h6 class="fw-bold mb-2" style="line-height:1.4;">
                            <a href="blogs.php?slug=<?= urlencode($b['slug']); ?>" class="text-dark stretched-link text-decoration-none">
                                <?= htmlspecialchars($b['title']); ?>
                            </a>
                        </h6>
                        <p class="text-muted small mb-3" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                            <?= htmlspecialchars($b['excerpt'] ?? ''); ?>
                        </p>
                        <div class="small text-muted">
                            <i class="far fa-calendar me-1"></i><?= date('d M Y', strtotime($b['published_date'])); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ══ CTA ═══════════════════════════════════════════════ -->
<section class="cta-section section-padding text-white text-center position-relative">
    <div class="container position-relative">
        <div class="col-lg-7 mx-auto">
            <h2 class="fw-bold mb-3">Ready to Start Your Journey?</h2>
            <p class="lead mb-5 opacity-75">Whether you're a student looking to upskill or an organisation needing a technology partner — we have a solution for you.</p>
            <div class="d-flex flex-wrap gap-3 justify-content-center">
                <a href="contact.php"   class="btn btn-primary btn-lg px-5">Get In Touch</a>
                <a href="courses.php"   class="btn btn-secondary btn-lg px-5">Browse Courses</a>
            </div>
        </div>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>
