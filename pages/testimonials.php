<?php
$page_title = "Testimonials";
require_once '../includes/header.php';

// Fetch all published testimonials
$stmt = $conn->prepare("SELECT * FROM testimonials WHERE status = 'published' ORDER BY is_featured DESC, testimonial_date DESC");
$stmt->execute();
$result      = $stmt->get_result();
$testimonials = [];
while ($row = $result->fetch_assoc()) $testimonials[] = $row;
$stmt->close();

$featured  = array_filter($testimonials, fn($t) => $t['is_featured']);
$regular   = array_filter($testimonials, fn($t) => !$t['is_featured']);

// Stats
$total     = count($testimonials);
$avgRating = $total ? round(array_sum(array_column($testimonials,'rating')) / $total, 1) : 0;
$fiveStars = count(array_filter($testimonials, fn($t) => $t['rating'] == 5));

function stars($n) {
    $html = '';
    for ($i = 1; $i <= 5; $i++)
        $html .= $i <= $n
            ? '<i class="fas fa-star text-warning"></i>'
            : '<i class="far fa-star" style="color:#ccc;"></i>';
    return $html;
}

function initials($name) {
    $parts = explode(' ', trim($name));
    return strtoupper(substr($parts[0],0,1) . (isset($parts[1]) ? substr($parts[1],0,1) : ''));
}

// Palette for avatar backgrounds
$avatarColors = ['#FF4500','#FF8C00','#e55d2b','#c94a1a','#e07020','#d45500','#f07030'];
?>

<!-- Hero -->
<section class="hero-section" style="background:linear-gradient(rgba(0,0,0,.75),rgba(0,0,0,.75)),url('https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1400&q=80');background-size:cover;background-position:center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center text-white">
                <p class="text-warning fw-semibold mb-2 text-uppercase ls-1">What People Say</p>
                <h1 class="display-4 fw-bold mb-3">Real Stories.<br>Real Results.</h1>
                <p class="lead mb-4 opacity-75">Hear directly from students and clients who have experienced the Araneus difference.</p>
                <a href="#testimonials" class="btn btn-primary btn-lg px-5">Read Testimonials</a>
            </div>
        </div>
    </div>
</section>

<!-- Stats bar -->
<section class="py-4 border-bottom">
    <div class="container">
        <div class="row text-center g-0">
            <div class="col-4 border-end">
                <div class="py-2">
                    <div class="h2 fw-bold text-primary mb-0"><?php echo $total; ?>+</div>
                    <small class="text-muted">Happy Clients</small>
                </div>
            </div>
            <div class="col-4 border-end">
                <div class="py-2">
                    <div class="h2 fw-bold text-warning mb-0"><?php echo number_format($avgRating,1); ?><span class="fs-5">/5</span></div>
                    <small class="text-muted">Average Rating</small>
                </div>
            </div>
            <div class="col-4">
                <div class="py-2">
                    <div class="h2 fw-bold text-success mb-0"><?php echo $fiveStars; ?></div>
                    <small class="text-muted">5-Star Reviews</small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured testimonials -->
<?php if (!empty($featured)): ?>
<section class="section-padding bg-light" id="testimonials">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Featured Stories</h2>
            <p class="lead text-muted">Highlighted experiences from our most valued clients</p>
        </div>
        <div class="row g-4 justify-content-center">
        <?php foreach ($featured as $i => $t):
            $color = $avatarColors[$i % count($avatarColors)]; ?>
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow" style="border-left:4px solid var(--primary-color)!important;border-radius:12px;overflow:hidden;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3 text-white fw-bold flex-shrink-0"
                                 style="width:52px;height:52px;background:<?php echo $color; ?>;font-size:18px;">
                                <?php echo initials($t['client_name']); ?>
                            </div>
                            <div>
                                <div class="fw-semibold mb-0"><?php echo htmlspecialchars($t['client_name']); ?></div>
                                <div class="small text-muted"><?php echo htmlspecialchars($t['client_position']); ?>
                                    <?php if ($t['company']): ?> &middot; <?php echo htmlspecialchars($t['company']); ?><?php endif; ?>
                                </div>
                            </div>
                            <span class="badge ms-auto" style="background:var(--primary-color);">Featured</span>
                        </div>
                        <div class="mb-3"><?php echo stars($t['rating']); ?></div>
                        <p class="mb-3" style="font-size:15px;line-height:1.7;color:#444;">
                            &ldquo;<?php echo htmlspecialchars($t['testimonial']); ?>&rdquo;
                        </p>
                        <?php if ($t['testimonial_date']): ?>
                        <small class="text-muted"><i class="far fa-calendar-alt me-1"></i><?php echo date('F Y', strtotime($t['testimonial_date'])); ?></small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- All testimonials grid -->
<?php if (!empty($regular)): ?>
<section class="section-padding">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">More Reviews</h2>
            <p class="lead text-muted">Authentic feedback from clients across different fields</p>
        </div>

        <!-- Rating filter -->
        <div class="d-flex justify-content-center gap-2 mb-5 flex-wrap" id="ratingFilter">
            <button class="btn btn-sm btn-primary active-filter" data-rating="0">All</button>
            <button class="btn btn-sm btn-outline-warning" data-rating="5"><i class="fas fa-star text-warning"></i> 5 Stars</button>
            <button class="btn btn-sm btn-outline-warning" data-rating="4"><i class="fas fa-star text-warning"></i> 4 Stars</button>
        </div>

        <div class="row g-4" id="testimonialsGrid">
        <?php foreach ($regular as $i => $t):
            $color = $avatarColors[$i % count($avatarColors)]; ?>
            <div class="col-lg-4 col-md-6 tcard" data-rating="<?php echo $t['rating']; ?>">
                <div class="card h-100 border-0 shadow-sm" style="border-radius:12px;">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="mb-3"><?php echo stars($t['rating']); ?></div>
                        <p class="flex-grow-1 mb-4" style="font-size:14px;line-height:1.7;color:#555;">
                            &ldquo;<?php echo htmlspecialchars($t['testimonial']); ?>&rdquo;
                        </p>
                        <div class="d-flex align-items-center mt-auto">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3 text-white fw-bold flex-shrink-0"
                                 style="width:44px;height:44px;background:<?php echo $color; ?>;font-size:15px;">
                                <?php echo initials($t['client_name']); ?>
                            </div>
                            <div>
                                <div class="fw-semibold small"><?php echo htmlspecialchars($t['client_name']); ?></div>
                                <div class="text-muted" style="font-size:12px;">
                                    <?php echo htmlspecialchars($t['client_position'] ?? ''); ?>
                                    <?php if ($t['company']): ?><br><?php echo htmlspecialchars($t['company']); ?><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        </div>

        <?php if (empty($regular) && empty($featured)): ?>
        <div class="text-center py-5 text-muted">
            <i class="fas fa-comment-slash fa-3x mb-3"></i>
            <p>No testimonials yet. Check back soon.</p>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<!-- CTA -->
<section class="py-5" style="background:linear-gradient(135deg,var(--primary-color),var(--secondary-color));">
    <div class="container text-center text-white">
        <h3 class="fw-bold mb-2">Ready to Start Your Journey?</h3>
        <p class="mb-4 opacity-75">Join hundreds of satisfied clients and students who trust Araneus Edutech.</p>
        <a href="contact.php" class="btn btn-light px-5 fw-semibold" style="color:var(--primary-color);">Get in Touch</a>
    </div>
</section>

<style>
.active-filter { background:var(--primary-color)!important;border-color:var(--primary-color)!important;color:#fff!important; }
.ls-1 { letter-spacing:.08em; }
</style>
<script>
document.getElementById('ratingFilter').addEventListener('click', function(e) {
    const btn = e.target.closest('[data-rating]');
    if (!btn) return;
    document.querySelectorAll('#ratingFilter button').forEach(b => b.classList.remove('active-filter','btn-warning'));
    btn.classList.add('active-filter');
    const r = parseInt(btn.dataset.rating);
    document.querySelectorAll('.tcard').forEach(c => {
        c.style.display = (r === 0 || parseInt(c.dataset.rating) === r) ? '' : 'none';
    });
});
</script>

<?php require_once '../includes/footer.php'; ?>
