<?php
$page_title = "Our Work & Reviews";
require_once '../includes/header.php';

// ── Fetch live testimonials ────────────────────────────────────
$testimonials = [];
$tResult = $conn->query(
    "SELECT * FROM testimonials WHERE status = 'published'
     ORDER BY is_featured DESC, testimonial_date DESC"
);
if ($tResult && $tResult->num_rows > 0) {
    while ($row = $tResult->fetch_assoc()) $testimonials[] = $row;
}

// Rating stats
$total     = count($testimonials);
$avgRating = $total
    ? round(array_sum(array_column($testimonials, 'rating')) / $total, 1)
    : 4.8;
$dist = [5=>0,4=>0,3=>0,2=>0,1=>0];
foreach ($testimonials as $t) $dist[(int)$t['rating']]++;

// ── Fetch projects from DB ────────────────────────────────────
$projects = [];
$pResult  = $conn->query(
    "SELECT * FROM projects WHERE status = 'published' ORDER BY sort_order ASC, id ASC"
);
if ($pResult && $pResult->num_rows > 0) {
    while ($row = $pResult->fetch_assoc()) {
        // Decode media JSON back to array
        $row['media'] = json_decode($row['media'] ?? '[]', true) ?: [];
        // Decode tags string to array
        $row['tags']  = array_map('trim', explode(',', $row['tags'] ?? ''));
        $projects[]   = $row;
    }
}

// ── Helpers ────────────────────────────────────────────────────
function stars($n) {
    $h = '';
    for ($i = 1; $i <= 5; $i++)
        $h .= $i <= $n
            ? '<i class="fas fa-star text-warning"></i>'
            : '<i class="far fa-star text-warning"></i>';
    return $h;
}
function initials($name) {
    $parts = explode(' ', trim($name));
    return strtoupper(substr($parts[0],0,1).(isset($parts[1])?substr($parts[1],0,1):''));
}
$palette = ['#ff4000','#0f3460','#1d9e75','#e6ac00','#6f42c1','#c74634','#00a1e0'];
$catIcons = [
    'Web Development'  => 'fas fa-code',
    'EdTech Platform'  => 'fas fa-graduation-cap',
    'Business Solutions'=> 'fas fa-briefcase',
    'ERP Solutions'    => 'fas fa-server',
    'Compliance Tech'  => 'fas fa-file-invoice',
    'default'          => 'fas fa-layer-group',
];
?>

<style>
/* ══ PAGE-LEVEL STYLES ════════════════════════════════════════ */

/* Hero */
.work-hero {
    background: linear-gradient(135deg, rgba(26,26,46,.93) 0%, rgba(15,52,96,.9) 60%),
                url('https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1600&q=80')
                center/cover no-repeat;
    padding: calc(var(--nav-height) + 80px) 0 80px;
    color: #fff;
    position: relative;
    overflow: hidden;
}
.work-hero::before {
    content:''; position:absolute; inset:0;
    background: radial-gradient(ellipse at 80% 30%, rgba(255,64,0,.18) 0%, transparent 55%);
}
.hero-pill {
    display:inline-block;
    background: rgba(255,169,0,.18);
    color: var(--secondary-color);
    border: 1px solid rgba(255,169,0,.35);
    border-radius: 20px;
    font-size: .78rem; font-weight: 600;
    letter-spacing: .08em; text-transform: uppercase;
    padding: 5px 16px; margin-bottom: 18px;
}

/* ── PROJECTS ── */
.projects-section { background: #f0f2f5; }

/* Filter pills */
.filter-pill {
    border: 1px solid #ddd; background: #fff;
    border-radius: 22px; padding: 7px 18px;
    font-size: .82rem; font-weight: 600; cursor: pointer;
    transition: var(--transition); white-space: nowrap;
    color: #555;
}
.filter-pill.active, .filter-pill:hover {
    background: var(--gradient-color); color: #fff; border-color: transparent;
}

/* Project card */
.proj-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 16px rgba(0,0,0,.07);
    transition: var(--transition);
    height: 100%;
    display: flex; flex-direction: column;
}
.proj-card:hover { transform: translateY(-6px); box-shadow: 0 14px 40px rgba(0,0,0,.12); }

.proj-img-wrap {
    position: relative;
    height: 210px;
    overflow: hidden;
    background: #f0f0f0;
}
.proj-img-wrap img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform .45s ease;
}
.proj-card:hover .proj-img-wrap img { transform: scale(1.07); }

.proj-cat-badge {
    position: absolute; top: 14px; left: 14px;
    font-size: .72rem; font-weight: 700;
    padding: 4px 12px; border-radius: 20px;
    color: #fff;
}

.proj-overlay {
    position: absolute; inset: 0;
    background: rgba(0,0,0,.55);
    display: flex; align-items: center; justify-content: center; gap: 10px;
    opacity: 0; transition: opacity .3s;
}
.proj-card:hover .proj-overlay { opacity: 1; }
.proj-overlay-btn {
    padding: 8px 16px; border-radius: 8px; font-size: .8rem; font-weight: 600;
    background: #fff; color: #1a1a2e; border: none; cursor: pointer;
    text-decoration: none; transition: .15s;
    display: flex; align-items: center; gap: 6px;
}
.proj-overlay-btn:hover { background: var(--primary-color); color: #fff; }

.proj-body { padding: 22px; flex: 1; display: flex; flex-direction: column; }
.proj-title { font-size: .97rem; font-weight: 700; margin-bottom: 8px; color: #1a1a2e; line-height: 1.35; }
.proj-desc  { font-size: .81rem; color: #666; line-height: 1.65; flex: 1; margin-bottom: 14px; }

.proj-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 16px; }
.proj-tag {
    font-size: .69rem; font-weight: 600;
    padding: 3px 10px; border-radius: 20px;
    background: #f0f2f5; color: #555;
}

.proj-links { display: flex; gap: 8px; flex-wrap: wrap; }
.proj-link {
    font-size: .78rem; font-weight: 600;
    padding: 6px 14px; border-radius: 8px;
    border: 1.5px solid rgba(0,0,0,.12);
    text-decoration: none; color: #444;
    display: inline-flex; align-items: center; gap: 6px;
    transition: var(--transition);
}
.proj-link:hover { background: var(--primary-color); color: #fff; border-color: var(--primary-color); }
.proj-link .link-icon-img { color: inherit; }

/* ── STATS STRIP ── */
.stats-strip { background: var(--gradient-color); }
.stat-num { font-size: 2.4rem; font-weight: 800; }

/* ── RATING BARS ── */
.rbar-track { background: rgba(255,255,255,.25); border-radius: 4px; height: 8px; flex: 1; }
.rbar-fill  { height: 8px; border-radius: 4px; background: #fff; transition: width 1.2s ease; }
.score-ring {
    width: 110px; height: 110px; border-radius: 50%;
    border: 4px solid rgba(255,255,255,.4);
    display: flex; flex-direction: column;
    align-items: center; justify-content: center; background: rgba(255,255,255,.1);
}

/* ── TESTIMONIAL CARDS ── */
.tcard {
    background: #fff; border-radius: 14px;
    box-shadow: 0 2px 14px rgba(0,0,0,.06);
    padding: 28px; height: 100%;
    transition: var(--transition); position: relative;
    display: flex; flex-direction: column;
}
.tcard:hover { transform: translateY(-5px); box-shadow: 0 12px 32px rgba(0,0,0,.1); }
.tcard.featured { border-top: 4px solid var(--primary-color); }
.tcard .quote-mark {
    font-size: 56px; line-height: .7;
    color: rgba(255,64,0,.12);
    font-family: Georgia, serif;
    position: absolute; top: 16px; left: 18px;
}
.tcard-text { font-style: italic; font-size: .88rem; line-height: 1.75; color: #444; flex: 1; margin-bottom: 20px; }
.tcard-author { display: flex; align-items: center; gap: 12px; padding-top: 16px; border-top: 1px solid #f0f0f0; }
.tcard-avatar {
    width: 44px; height: 44px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-weight: 700; font-size: .85rem; flex-shrink: 0;
}
.tcard-name { font-weight: 700; font-size: .88rem; margin-bottom: 2px; }
.tcard-role { font-size: .75rem; color: #888; }
.featured-badge {
    position: absolute; top: 14px; right: 14px;
    background: var(--primary-color); color: #fff;
    padding: 3px 10px; border-radius: 20px;
    font-size: .7rem; font-weight: 700;
}
.filter-chip {
    border-radius: 20px; padding: 5px 16px; font-size: .82rem;
    font-weight: 600; border: 1px solid #dee2e6; background: #fff;
    cursor: pointer; transition: var(--transition); user-select: none;
}
.filter-chip.active, .filter-chip:hover {
    background: var(--gradient-color); color: #fff; border-color: transparent;
}

/* ── VIDEO TESTIMONIAL ── */
.video-wrap {
    position: relative; border-radius: 14px; overflow: hidden; cursor: pointer;
}
.video-thumb {
    width: 100%; height: 280px; object-fit: cover;
    filter: brightness(.75);
    transition: filter .3s;
}
.video-wrap:hover .video-thumb { filter: brightness(.6); }
.play-btn {
    position: absolute; top: 50%; left: 50%;
    transform: translate(-50%,-65%);
    width: 60px; height: 60px; border-radius: 50%;
    background: var(--primary-color);
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 6px 24px rgba(255,64,0,.45);
    transition: transform .25s, box-shadow .25s;
}
.video-wrap:hover .play-btn { transform: translate(-50%,-65%) scale(1.1); }
.play-btn i { color:#fff; font-size:1.2rem; margin-left:4px; }
.video-caption {
    position: absolute; bottom: 0; left: 0; right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,.75));
    color: #fff; padding: 20px 18px 14px;
}
.video-caption h6 { font-weight: 700; margin-bottom: 3px; }
.video-caption p { font-size: .78rem; opacity: .85; margin: 0; }

/* ── CLIENT LOGOS ── */
.client-logo {
    background: #fff; border-radius: 10px; height: 90px;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 2px 10px rgba(0,0,0,.06); padding: 16px;
    transition: var(--transition);
}
.client-logo:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,.1); }
.client-logo img { max-height: 50px; width: auto; filter: grayscale(100%); opacity: .65; transition: .3s; }
.client-logo:hover img { filter: grayscale(0%); opacity: 1; }

/* ── SUBMIT FORM ── */
.cta-band { background: var(--gradient-color); }
.rating-input { display:flex; flex-direction:row-reverse; justify-content:flex-end; }
.rating-input input { display:none; }
.rating-input label { color:#ddd; cursor:pointer; font-size:1.4rem; margin-right:4px; transition:color .2s; }
.rating-input input:checked ~ label,
.rating-input label:hover,
.rating-input label:hover ~ label { color:#FFD700; }
</style>

<!-- ══════════════ HERO ══════════════════════════════════════ -->
<section class="work-hero text-center">
    <div class="container position-relative">
        <span class="hero-pill"><i class="fas fa-layer-group me-2"></i>Our Portfolio &amp; Reviews</span>
        <h1 class="display-4 fw-bold text-white mb-4">
            Work We're Proud Of.<br>
            <span style="background:var(--gradient-color);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                Clients Who Prove It.
            </span>
        </h1>
        <p class="lead mb-5" style="color:rgba(255,255,255,.72);max-width:580px;margin-left:auto;margin-right:auto;">
            Explore our completed projects across EdTech, ERP, CRM, and web development — then hear what our clients say about working with us.
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="#projects" class="btn btn-primary btn-lg">
                <i class="fas fa-briefcase me-2"></i>View Projects
            </a>
            <a href="#reviews" class="btn btn-secondary btn-lg">
                <i class="fas fa-star me-2"></i>Read Reviews
            </a>
        </div>
    </div>
</section>

<!-- ══════════════ STATS STRIP ════════════════════════════════ -->
<section class="stats-strip py-4 text-white text-center">
    <div class="container">
        <div class="row g-0">
            <?php foreach ([
                [count($projects),            'Projects Delivered'],
                [$total ?: '150+',            'Happy Clients'],
                [number_format($avgRating,1).'/5','Avg. Rating'],
                ['95%',                        'Client Retention'],
            ] as [$num, $label]): ?>
            <div class="col-6 col-md-3">
                <div class="py-2">
                    <div class="stat-num"><?= $num ?></div>
                    <div style="font-size:.78rem;opacity:.8;"><?= $label ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════════ PROJECTS ══════════════════════════════════ -->
<section class="projects-section section-padding" id="projects">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="section-title">Our Work</h2>
            <p class="text-muted lead">Delivering end-to-end solutions across education, enterprise, and technology</p>
        </div>

        <!-- Category filter pills -->
        <?php
        $allCats = array_unique(array_column($projects, 'category'));
        sort($allCats);
        ?>
        <div class="d-flex flex-wrap gap-2 justify-content-center mb-5" id="projFilter">
            <span class="filter-pill active" data-cat="">All Projects</span>
            <?php foreach ($allCats as $cat): ?>
            <span class="filter-pill" data-cat="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></span>
            <?php endforeach; ?>
        </div>

        <!-- Projects grid -->
        <div class="row g-4" id="projGrid">
            <?php foreach ($projects as $i => $proj):
                $accentColor = $proj['color'] ?? $palette[$i % count($palette)];
                $catIcon     = $catIcons[$proj['category']] ?? $catIcons['default'];
            ?>
            <div class="col-lg-4 col-md-6 proj-item" data-cat="<?= htmlspecialchars($proj['category']) ?>">
                <div class="proj-card">

                    <!-- Image + overlay -->
                    <div class="proj-img-wrap">
                        <img src="<?= htmlspecialchars($proj['image_url']) ?>"
                             alt="<?= htmlspecialchars($proj['title']) ?>"
                             onerror="this.src='https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=800&q=60'">

                        <span class="proj-cat-badge"
                              style="background:<?= $accentColor ?>;">
                            <i class="<?= $catIcon ?> me-1"></i><?= htmlspecialchars($proj['category']) ?>
                        </span>

                        <!-- Hover overlay with quick links -->
                        <div class="proj-overlay">
                            <?php foreach ($proj['media'] as $m):
                                $icon = match($m['type']) {
                                    'video' => 'fas fa-play',
                                    'link'  => 'fas fa-external-link-alt',
                                    default => 'fas fa-image',
                                };
                            ?>
                            <?php if ($m['type'] === 'video'): ?>
                            <button class="proj-overlay-btn video-trigger"
                                    data-video="<?= htmlspecialchars($m['url']) ?>"
                                    data-title="<?= htmlspecialchars($proj['title']) ?>">
                                <i class="<?= $icon ?>"></i><?= htmlspecialchars($m['label']) ?>
                            </button>
                            <?php elseif ($m['url'] !== '#'): ?>
                            <a href="<?= htmlspecialchars($m['url']) ?>"
                               target="_blank" rel="noopener"
                               class="proj-overlay-btn">
                                <i class="<?= $icon ?>"></i><?= htmlspecialchars($m['label']) ?>
                            </a>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Card body -->
                    <div class="proj-body">
                        <h5 class="proj-title"><?= htmlspecialchars($proj['title']) ?></h5>
                        <p class="proj-desc"><?= htmlspecialchars($proj['description']) ?></p>

                        <div class="proj-tags">
                            <?php foreach ($proj['tags'] as $tag): ?>
                            <span class="proj-tag"><?= htmlspecialchars($tag) ?></span>
                            <?php endforeach; ?>
                        </div>

                        <div class="proj-links">
                            <?php foreach ($proj['media'] as $m):
                                if ($m['type'] === 'video'): ?>
                                <button class="proj-link video-trigger"
                                        data-video="<?= htmlspecialchars($m['url']) ?>"
                                        data-title="<?= htmlspecialchars($proj['title']) ?>">
                                    <i class="fas fa-play" style="color:<?= $accentColor ?>;"></i>
                                    <?= htmlspecialchars($m['label']) ?>
                                </button>
                                <?php elseif ($m['url'] !== '#'): ?>
                                <a href="<?= htmlspecialchars($m['url']) ?>"
                                   target="_blank" rel="noopener"
                                   class="proj-link">
                                    <i class="fas fa-external-link-alt" style="color:<?= $accentColor ?>;"></i>
                                    <?= htmlspecialchars($m['label']) ?>
                                </a>
                                <?php else: ?>
                                <span class="proj-link" style="cursor:default;opacity:.5;">
                                    <i class="fas fa-lock" style="color:#aaa;"></i>
                                    <?= htmlspecialchars($m['label']) ?> (Private)
                                </span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div id="noProjResults" class="text-center py-5 d-none">
            <i class="fas fa-filter fa-2x text-muted mb-3 d-block opacity-30"></i>
            <p class="text-muted">No projects in this category.</p>
        </div>

    </div>
</section>

<!-- ══════════════ REVIEWS HEADER BAND ════════════════════════ -->
<section class="py-5 text-white" style="background:linear-gradient(135deg,#1a1a2e,#0f3460);" id="reviews">
    <div class="container">
        <div class="row align-items-center g-5">
            <!-- Score ring -->
            <div class="col-md-4 text-center">
                <div class="score-ring mx-auto mb-3">
                    <div style="font-size:2.4rem;font-weight:800;"><?= number_format($avgRating,1) ?></div>
                    <div style="font-size:.72rem;opacity:.75;">out of 5</div>
                </div>
                <div><?= str_repeat('<i class="fas fa-star text-warning"></i>', (int)round($avgRating)) ?></div>
                <div style="font-size:.8rem;opacity:.65;margin-top:6px;"><?= $total ?: '150+' ?> reviews</div>
            </div>
            <!-- Rating bars -->
            <div class="col-md-4">
                <?php foreach ([5,4,3,2,1] as $r):
                    $pct = $total ? round($dist[$r]/$total*100) : 0;
                ?>
                <div class="d-flex align-items-center gap-2 mb-2 small">
                    <span style="width:10px;text-align:right;opacity:.75;"><?= $r ?></span>
                    <i class="fas fa-star text-warning" style="font-size:.7rem;"></i>
                    <div class="rbar-track">
                        <div class="rbar-fill" style="width:0%" data-w="<?= $pct ?>%"></div>
                    </div>
                    <span style="width:22px;opacity:.6;font-size:.75rem;"><?= $dist[$r] ?: 0 ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <!-- Text -->
            <div class="col-md-4">
                <h3 class="fw-bold text-white mb-2">What Our Clients Say</h3>
                <p style="color:rgba(255,255,255,.65);font-size:.9rem;">
                    Authentic reviews from students, corporate clients, and institutional partners who've worked with Araneus Edutech.
                </p>
                <a href="#submitReview" class="btn btn-primary btn-sm px-4">
                    <i class="fas fa-pen me-1"></i> Share Your Experience
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════ REVIEWS GRID ═══════════════════════════════ -->
<section class="section-padding bg-light">
    <div class="container">

        <!-- Rating filter chips -->
        <div class="d-flex flex-wrap gap-2 justify-content-center mb-4" id="ratingFilter">
            <span class="filter-chip active" data-rating="0">All</span>
            <?php foreach ([5,4,3] as $r): ?>
            <span class="filter-chip" data-rating="<?= $r ?>">
                <i class="fas fa-star text-warning me-1" style="font-size:.75rem;"></i><?= $r ?> Stars
                (<?= $dist[$r] ?: 0 ?>)
            </span>
            <?php endforeach; ?>
            <span class="filter-chip" data-rating="-1">
                <i class="fas fa-award me-1 text-warning"></i>Featured
            </span>
        </div>

        <?php
        // Fallback samples if DB is empty
        if (empty($testimonials)) {
            $testimonials = [
                ['client_name'=>'Rajesh Kumar',   'client_position'=>'HR Manager',        'company'=>'Tech Solutions Inc.',   'testimonial'=>'Araneus Edutech provided excellent training for our new hires. The industry-relevant curriculum and expert trainers helped our team get up to speed quickly.','rating'=>5,'testimonial_date'=>'2023-05-01','is_featured'=>1],
                ['client_name'=>'Priya Sharma',   'client_position'=>'Director',           'company'=>'Global Education Trust','testimonial'=>'Their educational consultancy helped us redesign our curriculum to better align with industry needs. Student placement rates have improved by 40%.','rating'=>4,'testimonial_date'=>'2023-06-01','is_featured'=>1],
                ['client_name'=>'Amit Patel',     'client_position'=>'CEO',                'company'=>'StartUp Innovate',      'testimonial'=>'The Salesforce CRM implementation was seamless. The Araneus team provided excellent support throughout the transition process.','rating'=>5,'testimonial_date'=>'2023-07-01','is_featured'=>1],
                ['client_name'=>'Sneha Verma',    'client_position'=>'Student',            'company'=>'University of Technology','testimonial'=>'The internship program was a game-changer for my career. I gained practical skills that helped me secure a job even before graduation.','rating'=>5,'testimonial_date'=>'2023-08-01','is_featured'=>0],
                ['client_name'=>'Vikram Singh',   'client_position'=>'Operations Head',    'company'=>'Manufacturing Corp Ltd.','testimonial'=>'Their ERP implementation services transformed our operations. Inventory management and reporting have become much more efficient.','rating'=>4,'testimonial_date'=>'2023-09-01','is_featured'=>0],
                ['client_name'=>'Anjali Mehta',   'client_position'=>'Training Coordinator','company'=>'Educational Institute', 'testimonial'=>'The faculty development program was excellent. Our teachers are now using modern teaching methodologies that engage students better.','rating'=>5,'testimonial_date'=>'2023-10-01','is_featured'=>0],
            ];
        }
        ?>

        <div class="row g-4" id="testimonialsGrid">
            <?php foreach ($testimonials as $i => $t):
                $color = $palette[$i % count($palette)];
                $featured = (bool)$t['is_featured'];
            ?>
            <div class="col-lg-4 col-md-6 tcard-wrap"
                 data-rating="<?= (int)$t['rating'] ?>"
                 data-featured="<?= $featured ? '1' : '0' ?>">
                <div class="tcard <?= $featured ? 'featured' : '' ?>">
                    <?php if ($featured): ?>
                    <span class="featured-badge">Featured</span>
                    <?php endif; ?>
                    <div class="quote-mark">&ldquo;</div>

                    <div style="margin-bottom:12px;"><?= stars((int)$t['rating']) ?></div>

                    <p class="tcard-text"><?= htmlspecialchars($t['testimonial']) ?></p>

                    <div class="tcard-author">
                        <div class="tcard-avatar" style="background:<?= $color ?>;">
                            <?= initials($t['client_name']) ?>
                        </div>
                        <div>
                            <div class="tcard-name"><?= htmlspecialchars($t['client_name']) ?></div>
                            <div class="tcard-role">
                                <?= htmlspecialchars($t['client_position'] ?? '') ?>
                                <?php if ($t['company']): ?>
                                &nbsp;·&nbsp;
                                <span style="color:var(--primary-color);"><?= htmlspecialchars($t['company']) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if (!empty($t['testimonial_date'])): ?>
                        <div class="ms-auto text-muted" style="font-size:.72rem;flex-shrink:0;">
                            <?= date('M Y', strtotime($t['testimonial_date'])) ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div id="noReviews" class="text-center py-5 d-none">
            <i class="fas fa-filter fa-2x text-muted mb-3 d-block opacity-30"></i>
            <p class="text-muted">No reviews match this filter.</p>
        </div>
    </div>
</section>

<!-- ══════════════ VIDEO TESTIMONIALS ════════════════════════ -->
<section class="section-padding">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Video Testimonials</h2>
            <p class="lead text-muted">Hear directly from our clients about their experience with us</p>
        </div>
        <div class="row g-4">
            <?php foreach ([
                ['https://images.unsplash.com/photo-1573164713714-d95e436ab99d?auto=format&fit=crop&w=800&q=80',
                 '', 'Educational Transformation', 'Global Education Trust on our curriculum redesign project'],
                ['https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=800&q=80',
                 '', 'CRM Implementation Success', 'Tech Solutions Inc. on their Salesforce journey with us'],
            ] as [$thumb, $videoUrl, $title, $subtitle]): ?>
            <div class="col-lg-6">
                <div class="video-wrap video-trigger"
                     data-video="<?= htmlspecialchars($videoUrl) ?>"
                     data-title="<?= htmlspecialchars($title) ?>">
                    <img src="<?= $thumb ?>" alt="<?= htmlspecialchars($title) ?>" class="video-thumb">
                    <div class="play-btn"><i class="fas fa-play"></i></div>
                    <div class="video-caption">
                        <h6><?= htmlspecialchars($title) ?></h6>
                        <p><?= htmlspecialchars($subtitle) ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════════ CLIENT LOGOS ═══════════════════════════════ -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Trusted By</h2>
            <p class="lead text-muted">Organisations across education, manufacturing, and technology</p>
        </div>
        <div class="row g-3 justify-content-center align-items-center">
            <?php foreach ([
                ['https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT7M8t2nRwZ3YT3EWuH9UplHRqpMstm0xI0dg&s', 'Client 1'],
                ['https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS_GylGW8wjYID3Y3LVCo4FSqBEgmjVjH6VGw&s', 'Client 2'],
                ['https://d2lk14jtvqry1q.cloudfront.net/media/large_217_c53d2207b0_6f9a255794.png', 'Techno India'],
                ['https://www.eduopinions.com/wp-content/uploads/2022/05/Techno-India-University.jpg', 'Techno India University'],
                ['https://plastwork.in/assets/img/loading_logo.jpeg', 'Plastwork'],
                ['https://devtiplast.com/wp-content/uploads/2026/01/cropped-cropped-WhatsApp-Image-2025-12-20-at-1.00.20-PM.jpeg', 'Devtiplast'],
            ] as [$src, $alt]): ?>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="client-logo">
                    <img src="<?= htmlspecialchars($src) ?>" alt="<?= htmlspecialchars($alt) ?>" class="img-fluid">
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════════ SUBMIT REVIEW ══════════════════════════════ -->
<section class="cta-band py-5 text-white" id="submitReview">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <h2 class="fw-bold mb-3">Share Your Experience</h2>
                <p class="lead mb-4 opacity-80">Have you worked with us? Your honest review helps others make better decisions and helps us keep improving.</p>
                <?php foreach ([
                    'Your feedback drives our improvement',
                    'Help others choose the right partner',
                    'Share your success story with the community',
                ] as $point): ?>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="fas fa-check-circle"></i>
                    <span style="font-size:.9rem;"><?= $point ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="col-lg-7">
                <div class="card border-0 shadow-lg" style="border-radius:16px;overflow:hidden;">
                    <div class="card-body p-4 p-lg-5">
                        <h4 class="fw-bold text-dark mb-4">Submit Your Testimonial</h4>

                        <?php
                        // ── Handle form submission ──────────────────
                        $formSuccess = '';
                        $formError   = '';
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_testimonial'])) {
                            $tName     = trim($_POST['name']        ?? '');
                            $tPosition = trim($_POST['position']    ?? '');
                            $tCompany  = trim($_POST['company']     ?? '');
                            $tEmail    = trim($_POST['email']       ?? '');
                            $tText     = trim($_POST['testimonial'] ?? '');
                            $tRating   = intval($_POST['rating']    ?? 5);
                            $tDate     = date('Y-m-d');
                            $tStatus   = 'not published'; // pending review

                            if (!$tName || !$tEmail || !$tText) {
                                $formError = "Please fill in all required fields.";
                            } elseif (!filter_var($tEmail, FILTER_VALIDATE_EMAIL)) {
                                $formError = "Please enter a valid email address.";
                            } else {
                                $ins = $conn->prepare("
                                    INSERT INTO testimonials
                                        (client_name, client_position, company, testimonial,
                                         rating, testimonial_date, is_featured, status)
                                    VALUES (?, ?, ?, ?, ?, ?, 0, 'not published')
                                ");
                                $ins->bind_param("ssssii",
                                    $tName, $tPosition, $tCompany, $tText, $tRating, $tDate
                                );
                                // Note: email not in table — just ignore (log or discard)
                                if ($ins->execute()) {
                                    $formSuccess = "Thank you, {$tName}! Your testimonial has been submitted and will be reviewed before publishing.";
                                } else {
                                    $formError = "Submission failed: " . $conn->error;
                                }
                                $ins->close();
                            }
                        }
                        ?>

                        <?php if ($formSuccess): ?>
                        <div class="alert alert-success rounded-3">
                            <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($formSuccess) ?>
                        </div>
                        <?php else: ?>

                        <?php if ($formError): ?>
                        <div class="alert alert-danger rounded-3 small">
                            <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($formError) ?>
                        </div>
                        <?php endif; ?>

                        <form method="POST">
                            <input type="hidden" name="submit_testimonial" value="1">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label text-dark small fw-semibold">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" name="name"
                                           value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-dark small fw-semibold">Position</label>
                                    <input type="text" class="form-control form-control-sm" name="position"
                                           value="<?= htmlspecialchars($_POST['position'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-dark small fw-semibold">Company / Institution</label>
                                    <input type="text" class="form-control form-control-sm" name="company"
                                           value="<?= htmlspecialchars($_POST['company'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-dark small fw-semibold">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control form-control-sm" name="email"
                                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-dark small fw-semibold">Your Review <span class="text-danger">*</span></label>
                                    <textarea class="form-control form-control-sm" name="testimonial"
                                              rows="4" required><?= htmlspecialchars($_POST['testimonial'] ?? '') ?></textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-dark small fw-semibold">Rating</label>
                                    <div class="rating-input">
                                        <?php for ($r = 5; $r >= 1; $r--): ?>
                                        <input type="radio" id="star<?= $r ?>" name="rating"
                                               value="<?= $r ?>" <?= ($r === 5 ? 'checked' : '') ?>>
                                        <label for="star<?= $r ?>"><i class="fas fa-star"></i></label>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-paper-plane me-2"></i>Submit Review
                                    </button>
                                    <p class="text-muted small mt-2 mb-0">
                                        Reviews are published after admin approval.
                                    </p>
                                </div>
                            </div>
                        </form>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════ VIDEO MODAL ════════════════════════════════ -->
<div class="modal fade" id="videoModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg bg-dark" style="border-radius:14px;overflow:hidden;">
            <div class="modal-header border-0 pb-0" style="background:#000;">
                <h6 class="modal-title text-white fw-bold" id="videoModalTitle"></h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0" id="videoModalBody" style="background:#000;min-height:300px;display:flex;align-items:center;justify-content:center;">
                <div class="text-center text-muted p-5">
                    <i class="fas fa-film fa-3x mb-3 d-block opacity-30"></i>
                    <p class="small mb-0">Add a YouTube or video URL to the project's media array to embed it here.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Animate rating bars ── */
    setTimeout(function () {
        document.querySelectorAll('.rbar-fill').forEach(function (b) {
            b.style.width = b.dataset.w;
        });
    }, 400);

    /* ── Project category filter ── */
    document.getElementById('projFilter').addEventListener('click', function (e) {
        var pill = e.target.closest('.filter-pill');
        if (!pill) return;
        document.querySelectorAll('#projFilter .filter-pill').forEach(p => p.classList.remove('active'));
        pill.classList.add('active');
        var cat = pill.dataset.cat;
        var vis = 0;
        document.querySelectorAll('.proj-item').forEach(function (item) {
            var show = !cat || item.dataset.cat === cat;
            item.style.display = show ? '' : 'none';
            if (show) vis++;
        });
        document.getElementById('noProjResults').classList.toggle('d-none', vis > 0);
    });

    /* ── Review rating filter ── */
    document.getElementById('ratingFilter').addEventListener('click', function (e) {
        var chip = e.target.closest('.filter-chip');
        if (!chip) return;
        document.querySelectorAll('#ratingFilter .filter-chip').forEach(c => c.classList.remove('active'));
        chip.classList.add('active');
        var r = parseInt(chip.dataset.rating);
        var vis = 0;
        document.querySelectorAll('.tcard-wrap').forEach(function (card) {
            var show;
            if (r === 0)  show = true;
            else if (r === -1) show = card.dataset.featured === '1';
            else show = parseInt(card.dataset.rating) === r;
            card.style.display = show ? '' : 'none';
            if (show) vis++;
        });
        document.getElementById('noReviews').classList.toggle('d-none', vis > 0);
    });

    /* ── Video modal ── */
    var videoModal     = new bootstrap.Modal(document.getElementById('videoModal'));
    var videoModalBody = document.getElementById('videoModalBody');
    var videoModalTitle= document.getElementById('videoModalTitle');

    document.querySelectorAll('.video-trigger').forEach(function (el) {
        el.addEventListener('click', function () {
            var url   = this.dataset.video;
            var title = this.dataset.title || 'Video';
            videoModalTitle.textContent = title;

            if (url && url !== '') {
                // Convert YouTube watch URLs to embed
                var embedUrl = url
                    .replace('watch?v=', 'embed/')
                    .replace('youtu.be/', 'www.youtube.com/embed/');
                videoModalBody.innerHTML =
                    '<iframe src="' + embedUrl + '?autoplay=1" width="100%" height="420"' +
                    ' frameborder="0" allow="autoplay;encrypted-media" allowfullscreen></iframe>';
            } else {
                videoModalBody.innerHTML =
                    '<div class="text-center text-muted p-5">' +
                    '<i class="fas fa-film fa-3x mb-3 d-block opacity-30"></i>' +
                    '<p class="small mb-0">Add a YouTube URL to the project\'s media array to embed it here.</p>' +
                    '</div>';
            }
            videoModal.show();
        });
    });

    // Clear iframe on modal close to stop autoplay
    document.getElementById('videoModal').addEventListener('hidden.bs.modal', function () {
        videoModalBody.innerHTML = '';
    });

});
</script>

<?php $conn->close(); require_once '../includes/footer.php'; ?>
