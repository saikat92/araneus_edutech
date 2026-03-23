<?php
$page_title = "Courses";
require_once '../includes/header.php';

// Helper functions (defined before use)
function getCategoryColor($cat) {
    $map = ['Programming & Data Science'=>'primary','IoT & Embedded Systems'=>'success','Web Development'=>'info','Mobile Development'=>'warning','Cybersecurity'=>'danger','Business'=>'dark'];
    return $map[$cat] ?? 'primary';
}
function truncateText($t,$l){ return mb_strlen($t)<=$l ? $t : mb_substr($t,0,$l).'…'; }
function generateStars($r){
    $f=floor($r); $h=($r-$f)>=.5; $e=5-$f-($h?1:0);
    $s=''; for($i=0;$i<$f;$i++) $s.='<i class="fas fa-star text-warning"></i>';
    if($h) $s.='<i class="fas fa-star-half-alt text-warning"></i>';
    for($i=0;$i<$e;$i++) $s.='<i class="far fa-star text-muted"></i>';
    return $s;
}
function getInitials($n){ $w=explode(' ',$n); $i=''; foreach($w as $word) $i.=strtoupper(substr($word,0,1)); return substr($i,0,2); }

// Fetch categories for filter
$cats = $conn->query("SELECT DISTINCT category FROM courses WHERE is_active=1 ORDER BY category")->fetch_all(MYSQLI_ASSOC);

// Fetch all active courses
$courses = $conn->query("SELECT * FROM courses WHERE is_active=1 ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
$totalCourses = count($courses);
?>

<style>
.courses-hero { background:var(--gradient-color); padding:calc(var(--nav-height) + 60px) 0 70px; position:relative; overflow:hidden; }
.courses-hero::after { content:''; position:absolute; bottom:-1px; left:0; right:0; height:60px; background:#fff; clip-path:ellipse(55% 100% at 50% 100%); }
.filter-bar { background:#fff; border-radius:14px; padding:24px; box-shadow:var(--shadow-md); }
.course-card { border-radius:14px; border:none; box-shadow:var(--shadow-sm); overflow:hidden; transition:var(--transition); }
.course-card:hover { transform:translateY(-6px); box-shadow:var(--shadow-md); }
.course-card .card-img-wrap { position:relative; height:190px; overflow:hidden; }
.course-card .card-img-wrap img { width:100%; height:100%; object-fit:cover; transition:transform .45s; }
.course-card:hover .card-img-wrap img { transform:scale(1.07); }
.instructor-avatar { width:36px; height:36px; border-radius:50%; background:var(--gradient-color); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:.78rem; flex-shrink:0; }
.enroll-btn { background:var(--gradient-color); border:none; font-weight:600; border-radius:6px; transition:var(--transition); }
.enroll-btn:hover { opacity:.88; transform:translateY(-1px); }
.cat-pill { border-radius:22px; padding:8px 18px; font-size:.82rem; font-weight:600; border:1px solid #e0e0e0; background:#fff; cursor:pointer; transition:var(--transition); white-space:nowrap; }
.cat-pill.active,.cat-pill:hover { background:var(--gradient-color); color:#fff; border-color:transparent; }
.why-row { display:flex; gap:16px; align-items:flex-start; }
.why-icon { width:48px; height:48px; border-radius:12px; background:rgba(255,64,0,.08); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.why-icon i { color:var(--primary-color); font-size:18px; }
</style>

<!-- Hero -->
<section class="courses-hero text-center text-white">
    <div class="container position-relative">
        <span class="badge bg-white text-dark px-3 py-2 rounded-pill mb-3" style="color:var(--primary-color)!important;font-weight:700;">
            <?=$totalCourses?> Active Courses
        </span>
        <h1 class="display-4 fw-bold mb-3">Explore Our Courses</h1>
        <p class="lead opacity-85 mb-0" style="max-width:560px;margin:0 auto;">
            Transform your career with industry-relevant programs designed by experts
        </p>
    </div>
</section>

<!-- Stats strip -->
<section class="py-4 bg-white border-bottom">
    <div class="container">
        <div class="row g-0 text-center">
            <?php foreach ([
                ['150+','Avg. Course Hours'],
                ['12',  'Live Projects'],
                ['100%','Practical Training'],
                ['1000+','Students Trained'],
            ] as [$num,$label]): ?>
            <div class="col-6 col-md-3 border-end-md">
                <div class="py-2">
                    <div class="h4 fw-bold mb-0" style="color:var(--primary-color);"><?=$num?></div>
                    <small class="text-muted"><?=$label?></small>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Filter + Grid -->
<section class="section-padding bg-light" id="coursesGrid">
    <div class="container">

        <!-- Search + filter bar -->
        <div class="filter-bar mb-4">
            <div class="row g-3 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="searchCourse" class="form-control border-start-0" placeholder="Search courses…">
                    </div>
                </div>
                <div class="col-md-3">
                    <select id="filterCategory" class="form-select">
                        <option value="">All Categories</option>
                        <?php foreach ($cats as $c): ?>
                        <option value="<?=htmlspecialchars($c['category'])?>"><?=htmlspecialchars($c['category'])?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="filterMode" class="form-select">
                        <option value="">All Modes</option>
                        <option value="Online">Online</option>
                        <option value="Offline">Offline</option>
                        <option value="Hybrid">Hybrid</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100" id="resetFilters">
                        <i class="fas fa-redo me-1"></i>Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- Category pills -->
        <div class="d-flex flex-wrap gap-2 mb-4" id="catPills">
            <span class="cat-pill active" data-cat="">All</span>
            <?php foreach ($cats as $c): ?>
            <span class="cat-pill" data-cat="<?=htmlspecialchars($c['category'])?>"><?=htmlspecialchars($c['category'])?></span>
            <?php endforeach; ?>
        </div>

        <!-- Courses grid -->
        <div class="row g-4" id="coursesContainer">
        <?php if (!empty($courses)):
            foreach ($courses as $course):
                $rating   = round(rand(40,50)/10, 1);
                $students = rand(50, 300);
                $catColor = getCategoryColor($course['category']);
        ?>
        <div class="col-xl-4 col-lg-6 course-item"
             data-title="<?=strtolower(htmlspecialchars($course['title']))?>"
             data-cat="<?=htmlspecialchars($course['category'])?>"
             data-mode="<?=htmlspecialchars($course['mode'] ?? '')?>">
            <div class="course-card card h-100">
                <div class="card-img-wrap">
                    <?php if (!empty($course['image_url'])): ?>
                    <img src="<?=htmlspecialchars($course['image_url'])?>" alt="<?=htmlspecialchars($course['title'])?>">
                    <?php else: ?>
                    <div style="height:100%;background:var(--gradient-color);display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-graduation-cap fa-3x text-white opacity-50"></i>
                    </div>
                    <?php endif; ?>
                    <div style="position:absolute;top:12px;left:12px;">
                        <span class="badge bg-<?=$catColor?> rounded-pill px-3 py-2"><?=htmlspecialchars($course['category'])?></span>
                    </div>
                    <div style="position:absolute;bottom:12px;left:12px;">
                        <span class="badge bg-dark bg-opacity-75 text-white">
                            <i class="fas fa-clock me-1"></i><?=htmlspecialchars($course['duration'])?>
                        </span>
                    </div>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="fw-bold mb-2" style="line-height:1.35;">
                        <a href="#" class="text-dark text-decoration-none stretched-link"
                           data-bs-toggle="modal" data-bs-target="#modal<?=$course['id']?>">
                            <?=htmlspecialchars($course['title'])?>
                        </a>
                    </h5>
                    <p class="text-muted small mb-3 flex-grow-1">
                        <?=truncateText(htmlspecialchars($course['description']), 110)?>
                    </p>
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-2" style="font-size:.8rem;"><?=generateStars($rating)?></div>
                        <span class="small fw-bold text-warning me-1"><?=number_format($rating,1)?></span>
                        <span class="small text-muted">(<?=$students?> students)</span>
                    </div>
                    <div class="d-flex align-items-center mb-3 gap-2">
                        <div class="instructor-avatar"><?=getInitials($course['instructor'])?></div>
                        <div>
                            <div class="text-muted" style="font-size:.7rem;">Instructor</div>
                            <div class="fw-semibold small"><?=htmlspecialchars($course['instructor'])?></div>
                        </div>
                    </div>
                    <div class="border-top pt-3 d-flex justify-content-between align-items-center mt-auto">
                        <span class="h5 fw-bold mb-0" style="color:var(--primary-color);">
                            <?=htmlspecialchars($course['fee']) > 0 ? '₹'.number_format($course['fee'],0) : 'Free'?>
                        </span>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary"
                                    data-bs-toggle="modal" data-bs-target="#modal<?=$course['id']?>">
                                <i class="fas fa-eye me-1"></i>Preview
                            </button>
                            <button class="btn btn-sm enroll-btn text-white"
                                    data-course-id="<?=$course['id']?>"
                                    data-course-title="<?=htmlspecialchars($course['title'])?>">
                                Enroll
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal<?=$course['id']?>" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header text-white" style="background:var(--gradient-color);">
                        <h5 class="modal-title"><i class="fas fa-graduation-cap me-2"></i><?=htmlspecialchars($course['title'])?></h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="row g-0">
                            <div class="col-lg-8 p-4 p-lg-5">
                                <?php if (!empty($course['image_url'])): ?>
                                <img src="<?=htmlspecialchars($course['image_url'])?>" alt="<?=htmlspecialchars($course['title'])?>" class="img-fluid rounded-3 mb-4">
                                <?php endif; ?>
                                <h4 class="fw-bold mb-2">Course Overview</h4>
                                <p class="text-muted mb-4"><?=htmlspecialchars($course['description'])?></p>
                                <h5 class="fw-bold mb-3">What You'll Learn</h5>
                                <div class="row g-2">
                                    <?php foreach (['Hands-on real-world projects','Industry-recognised certificate','Practical skill development','Career & placement support','Portfolio development','Job assistance included'] as $item): ?>
                                    <div class="col-sm-6">
                                        <div class="d-flex gap-2 align-items-center small">
                                            <i class="fas fa-check-circle text-success flex-shrink-0"></i><?=$item?>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php if (!empty($course['tools_provided'])): ?>
                                <div class="alert alert-light border mt-4 small">
                                    <i class="fas fa-tools me-2 text-primary"></i>
                                    <strong>Tools provided:</strong> <?=htmlspecialchars($course['tools_provided'])?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-lg-4 p-4 p-lg-5 bg-light">
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3">Course Details</h6>
                                        <?php foreach ([
                                            ['fas fa-clock',            'Duration',      $course['duration']],
                                            ['fas fa-rupee-sign',       'Fee',           $course['fee']>0 ? '₹'.number_format($course['fee'],0) : 'Free'],
                                            ['fas fa-chalkboard-teacher','Instructor',   $course['instructor']],
                                            ['fas fa-laptop',           'Mode',          $course['mode'] ?? 'Online'],
                                            ['fas fa-certificate',      'Certification', $course['certification_type'] ?? 'Certificate'],
                                            ['fas fa-desktop',          'Format',        $course['program_format'] ?? 'Self-paced'],
                                        ] as [$icon,$label,$val]): ?>
                                        <div class="d-flex gap-3 mb-3">
                                            <i class="<?=$icon?> mt-1 flex-shrink-0" style="color:var(--primary-color);width:16px;"></i>
                                            <div>
                                                <div class="text-muted" style="font-size:.72rem;"><?=$label?></div>
                                                <div class="fw-semibold small"><?=htmlspecialchars($val)?></div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                        <div class="text-center mt-3 d-grid gap-2  ">
                                            <button class="btn btn-primary enroll-btn text-white"
                                            data-course-id="<?=$course['id']?>"
                                            data-course-title="<?=htmlspecialchars($course['title'])?>">
                                                <i class="fas fa-user-plus me-2"></i>Enroll Now
                                            </button>
                                            <?php if (!empty($course['syllabus_file'])): ?>
                                            <a href="<?=SITE_URL.$course['syllabus_file']?>" class="btn btn-outline-primary" download>
                                                    <i class="fas fa-download me-2"></i>Download Syllabus
                                            </a>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="text-center mt-3">
                                            <small class="text-muted"><i class="fas fa-shield-alt me-1"></i>Satisfaction guaranteed</small>
                                        </div>
                                        <!-- Share -->
                                        <?php
                                        $shareUrl   = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                                        $shareTitle = urlencode($course['title']);
                                        ?>
                                        <div class="mt-4 pt-3 border-top text-center">
                                            <small class="text-muted d-block mb-2">Share</small>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?=$shareUrl?>" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="fab fa-facebook-f"></i></a>
                                                <a href="https://twitter.com/intent/tweet?url=<?=$shareUrl?>&text=<?=$shareTitle?>" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="fab fa-twitter"></i></a>
                                                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?=$shareUrl?>" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="fab fa-linkedin-in"></i></a>
                                                <a href="https://wa.me/?text=<?=$shareTitle.' '.$shareUrl?>" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="fab fa-whatsapp"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid gap-2">
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php endforeach;
        else: ?>
        <div class="col-12 text-center py-5">
            <i class="fas fa-book-open fa-4x text-muted mb-3 d-block"></i>
            <h5 class="text-muted">No courses available right now</h5>
            <p class="text-muted small">Check back soon or contact us for updates.</p>
            <a href="contact.php" class="btn btn-primary">Contact Us</a>
        </div>
        <?php endif; ?>
        </div>

        <!-- No results message -->
        <div id="noResults" class="text-center py-5 d-none">
            <i class="fas fa-search fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No courses match your search</h5>
            <button class="btn btn-outline-primary mt-2" id="clearSearch">Clear Filters</button>
        </div>
    </div>
</section>

<!-- Why choose -->
<section class="section-padding">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=700&q=80"
                     alt="Students" class="img-fluid rounded-4 shadow-lg">
            </div>
            <div class="col-lg-6">
                <h2 class="section-title text-start">Why Choose Araneus?</h2>
                <div class="d-flex flex-column gap-3 mt-4">
                    <?php foreach ([
                        ['fas fa-industry',    'Industry-Relevant Curriculum',     'Designed with direct input from professionals and updated every semester.'],
                        ['fas fa-laptop-code', 'Hands-On Projects',                'Every module includes real-world assignments that build your portfolio.'],
                        ['fas fa-user-tie',    'Expert Instructors',               'Learn from working professionals — not just theoretical teachers.'],
                        ['fas fa-briefcase',   'Career Support Included',          'Resume building, interview prep, and job placement assistance.'],
                        ['fas fa-certificate', 'Industry-Recognised Certificate',  'Our certs are respected by employers across India.'],
                    ] as [$icon,$title,$desc]): ?>
                    <div class="why-row">
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
<section class="py-5 text-white text-center" style="background:var(--gradient-color);">
    <div class="container">
        <h3 class="fw-bold mb-2">Ready to Start Learning?</h3>
        <p class="mb-4 opacity-80">Join students who have transformed their careers with our courses.</p>
        <a href="contact.php" class="btn btn-light btn-lg px-5 fw-bold" style="color:var(--primary-color);">Talk to an Advisor</a>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.getElementById('searchCourse');
    var catFilter   = document.getElementById('filterCategory');
    var modeFilter  = document.getElementById('filterMode');
    var items       = document.querySelectorAll('.course-item');
    var noResults   = document.getElementById('noResults');

    function applyFilters() {
        var search = searchInput.value.toLowerCase().trim();
        var cat    = catFilter.value;
        var mode   = modeFilter.value;
        var visible = 0;
        items.forEach(function(item) {
            var titleMatch = !search || item.dataset.title.includes(search);
            var catMatch   = !cat    || item.dataset.cat  === cat;
            var modeMatch  = !mode   || item.dataset.mode === mode;
            var show = titleMatch && catMatch && modeMatch;
            item.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        noResults.classList.toggle('d-none', visible > 0);
    }

    searchInput.addEventListener('input', applyFilters);
    catFilter.addEventListener('change', applyFilters);
    modeFilter.addEventListener('change', applyFilters);

    document.getElementById('resetFilters').addEventListener('click', function() {
        searchInput.value = ''; catFilter.value = ''; modeFilter.value = '';
        document.querySelectorAll('.cat-pill').forEach(p=>p.classList.remove('active'));
        document.querySelector('.cat-pill[data-cat=""]').classList.add('active');
        applyFilters();
    });
    document.getElementById('clearSearch').addEventListener('click', function() {
        document.getElementById('resetFilters').click();
    });

    // Category pills
    document.getElementById('catPills').addEventListener('click', function(e) {
        var pill = e.target.closest('.cat-pill');
        if (!pill) return;
        document.querySelectorAll('.cat-pill').forEach(p=>p.classList.remove('active'));
        pill.classList.add('active');
        catFilter.value = pill.dataset.cat;
        applyFilters();
    });

    // Enroll buttons
    document.querySelectorAll('.enroll-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var courseId    = this.dataset.courseId;
            var courseTitle = this.dataset.courseTitle;
            var loggedIn    = <?=isset($_SESSION['student_id']) ? 'true' : 'false'?>;
            if (!loggedIn) {
                window.location.href = 'login.php?redirect=courses&course_id=' + courseId;
                return;
            }
            if (confirm('Enroll in "' + courseTitle + '"?\n\nYou will be taken to the enrollment page.')) {
                window.location.href = '../portal/enroll.php?course_id=' + courseId;
            }
        });
    });
});
</script>

<?php require_once '../includes/footer.php'; ?>
