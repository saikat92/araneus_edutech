<?php
require_once '../includes/header.php';

$slug = trim($_GET['slug'] ?? '');
if (!$slug) { header('Location: blogs.php'); exit; }

$stmt = $conn->prepare("SELECT * FROM blogs WHERE slug = ? AND status = 'published'");
$stmt->bind_param('s', $slug);
$stmt->execute();
$blog = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$blog) { header('Location: blogs.php'); exit; }

$page_title = htmlspecialchars($blog['title']);

// Related posts — same category, exclude current
$rStmt = $conn->prepare("SELECT id, title, slug, excerpt, published_date, category, featured_image FROM blogs WHERE status='published' AND category = ? AND slug != ? ORDER BY published_date DESC LIMIT 3");
$rStmt->bind_param('ss', $blog['category'], $slug);
$rStmt->execute();
$related = $rStmt->get_result()->fetch_all(MYSQLI_ASSOC);
$rStmt->close();

function blogImg($b) {
    return !empty($b['featured_image']) ? htmlspecialchars($b['featured_image'])
        : 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=900&q=70';
}
$catColors = ['Technology'=>'primary','Education'=>'success','Business'=>'warning','Career'=>'info','General'=>'secondary'];
function catColor($c, $m) { return $m[$c] ?? 'secondary'; }
?>

<!-- Hero banner with post title -->
<section style="background:linear-gradient(rgba(0,0,0,.72),rgba(0,0,0,.72)),url('<?php echo blogImg($blog); ?>');background-size:cover;background-position:center;padding:90px 0 70px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-white text-center">
                <span class="badge bg-<?php echo catColor($blog['category'], $catColors); ?> mb-3 px-3 py-2">
                    <?php echo htmlspecialchars($blog['category'] ?? 'General'); ?>
                </span>
                <h1 class="display-5 fw-bold mb-3"><?php echo htmlspecialchars($blog['title']); ?></h1>
                <div class="d-flex justify-content-center gap-4 opacity-75 small flex-wrap">
                    <span><i class="far fa-user me-1"></i><?php echo htmlspecialchars($blog['author'] ?? 'Araneus Team'); ?></span>
                    <span><i class="far fa-calendar me-1"></i><?php echo date('d F Y', strtotime($blog['published_date'])); ?></span>
                    <?php if ($blog['category']): ?>
                    <span><i class="fas fa-tag me-1"></i><?php echo htmlspecialchars($blog['category']); ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Article body -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <!-- Breadcrumb -->
                <nav class="mb-4" aria-label="breadcrumb">
                    <ol class="breadcrumb small">
                        <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>" class="text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item"><a href="blogs.php" class="text-decoration-none">Blogs</a></li>
                        <li class="breadcrumb-item active text-truncate" style="max-width:220px;"><?php echo htmlspecialchars($blog['title']); ?></li>
                    </ol>
                </nav>

                <!-- Excerpt lead -->
                <?php if ($blog['excerpt']): ?>
                <p class="lead text-muted border-start border-4 ps-3 mb-4" style="border-color:var(--primary-color)!important;">
                    <?php echo htmlspecialchars($blog['excerpt']); ?>
                </p>
                <?php endif; ?>

                <!-- Content — stored as HTML/plain text -->
                <div class="blog-content" style="font-size:16px;line-height:1.85;color:#333;">
                    <?php
                    // If content contains HTML tags render as-is; else convert newlines
                    $content = $blog['content'];
                    echo strip_tags($content, '<p><br><h1><h2><h3><h4><h5><ul><ol><li><strong><em><a><img><blockquote><code><pre><table><thead><tbody><tr><th><td>')
                        ? nl2br($content)
                        : nl2br(htmlspecialchars($content));
                    ?>
                </div>

                <!-- Share bar -->
                <div class="mt-5 pt-4 border-top d-flex align-items-center gap-3 flex-wrap">
                    <span class="text-muted small fw-semibold">Share:</span>
                    <?php
                    $shareUrl = urlencode((isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                    $shareTitle = urlencode($blog['title']);
                    ?>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo $shareUrl; ?>&text=<?php echo $shareTitle; ?>" target="_blank" rel="noopener"
                       class="btn btn-sm btn-outline-secondary"><i class="fab fa-twitter me-1"></i>Twitter</a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $shareUrl; ?>" target="_blank" rel="noopener"
                       class="btn btn-sm btn-outline-secondary"><i class="fab fa-linkedin me-1"></i>LinkedIn</a>
                    <a href="https://wa.me/?text=<?php echo $shareTitle . ' ' . $shareUrl; ?>" target="_blank" rel="noopener"
                       class="btn btn-sm btn-outline-secondary"><i class="fab fa-whatsapp me-1"></i>WhatsApp</a>
                    <a href="blogs.php" class="btn btn-sm btn-outline-primary ms-auto">
                        <i class="fas fa-arrow-left me-1"></i> All Articles
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related articles -->
<?php if (!empty($related)): ?>
<section class="py-5 bg-light">
    <div class="container">
        <h4 class="fw-bold mb-4">Related Articles</h4>
        <div class="row g-4">
            <?php foreach ($related as $r): ?>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm" style="border-radius:12px;overflow:hidden;">
                    <div style="height:160px;overflow:hidden;">
                        <img src="<?php echo blogImg($r); ?>" alt="<?php echo htmlspecialchars($r['title']); ?>"
                             style="width:100%;height:100%;object-fit:cover;">
                    </div>
                    <div class="card-body p-3">
                        <span class="badge bg-<?php echo catColor($r['category'], $catColors); ?> mb-2">
                            <?php echo htmlspecialchars($r['category']); ?>
                        </span>
                        <h6 class="mb-2"><a href="blog-view.php?slug=<?php echo urlencode($r['slug']); ?>"
                               class="text-dark text-decoration-none stretched-link">
                            <?php echo htmlspecialchars($r['title']); ?></a></h6>
                        <small class="text-muted"><?php echo date('d M Y', strtotime($r['published_date'])); ?></small>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<style>
.blog-content h2,.blog-content h3 { margin-top:2rem;margin-bottom:1rem; }
.blog-content ul,.blog-content ol { padding-left:1.5rem;margin-bottom:1rem; }
.blog-content blockquote { border-left:4px solid var(--primary-color);padding:10px 16px;background:#fff8f5;border-radius:0 8px 8px 0;margin:1.5rem 0; }
.blog-content img { max-width:100%;border-radius:8px;margin:1rem 0; }
.blog-content a { color:var(--primary-color); }
</style>

<?php require_once '../includes/footer.php'; ?>
