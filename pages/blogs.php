<?php
$page_title = "Blogs & Insights";
require_once '../includes/header.php';

$search   = trim($_GET['search']   ?? '');
$category = trim($_GET['category'] ?? '');
$limit    = 6;
$page     = max(1, intval($_GET['page'] ?? 1));
$offset   = ($page - 1) * $limit;

// Build parameterised query
$where  = "WHERE status = 'published'";
$params = [];
$types  = '';

if ($search !== '') {
    $where   .= " AND (title LIKE ? OR excerpt LIKE ? OR content LIKE ?)";
    $s        = "%$search%";
    $params   = array_merge($params, [$s, $s, $s]);
    $types   .= 'sss';
}
if ($category !== '') {
    $where  .= " AND category = ?";
    $params[] = $category;
    $types   .= 's';
}

// Total count
$cStmt = $conn->prepare("SELECT COUNT(*) FROM blogs $where");
if ($types) $cStmt->bind_param($types, ...$params);
$cStmt->execute();
$total_blogs = $cStmt->get_result()->fetch_row()[0];
$total_pages = ceil($total_blogs / $limit);
$cStmt->close();

// Blog list
$params2   = array_merge($params, [$limit, $offset]);
$types2    = $types . 'ii';
$bStmt     = $conn->prepare("SELECT * FROM blogs $where ORDER BY published_date DESC LIMIT ? OFFSET ?");
$bStmt->bind_param($types2, ...$params2);
$bStmt->execute();
$blogs     = $bStmt->get_result()->fetch_all(MYSQLI_ASSOC);
$bStmt->close();

// Categories
$cats = $conn->query("SELECT DISTINCT category FROM blogs WHERE status='published' AND category IS NOT NULL ORDER BY category")->fetch_all(MYSQLI_ASSOC);

// Hero featured (latest 1)
$hero = $conn->query("SELECT * FROM blogs WHERE status='published' ORDER BY published_date DESC LIMIT 1")->fetch_assoc();

// Category colours
$catColors = ['Technology'=>'primary','Education'=>'success','Business'=>'warning','Career'=>'info','General'=>'secondary'];
function catColor($c, $map) { return $map[$c] ?? 'secondary'; }

function blogImg($b) {
    return !empty($b['featured_image']) ? htmlspecialchars($b['featured_image'])
        : 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=600&q=60';
}
?>

<!-- Hero with featured post -->
<section class="hero-section position-relative overflow-hidden" style="padding:0;min-height:480px;display:flex;align-items:center;">
    <div class="position-absolute w-100 h-100" style="background:linear-gradient(rgba(0,0,0,.7),rgba(0,0,0,.75)),url('<?php echo blogImg($hero); ?>');background-size:cover;background-position:center;"></div>
    <div class="container position-relative text-white py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <span class="badge bg-primary mb-3 px-3 py-2">Latest Post</span>
                <h1 class="display-5 fw-bold mb-3"><?php echo htmlspecialchars($hero['title'] ?? 'Blogs & Insights'); ?></h1>
                <p class="lead mb-4 opacity-75"><?php echo htmlspecialchars(substr($hero['excerpt'] ?? '', 0, 140)); ?></p>
                <?php if ($hero): ?>
                <a href="blog-view.php?slug=<?php echo urlencode($hero['slug']); ?>" class="btn btn-primary btn-lg me-2">Read Article</a>
                <?php endif; ?>
                <a href="#articles" class="btn btn-outline-light btn-lg">Browse All</a>
            </div>
        </div>
    </div>
</section>

<!-- Search + filter bar -->
<section class="py-4 bg-light border-bottom sticky-top" style="top:56px;z-index:100;" id="articles">
    <div class="container">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Search articles…" value="<?php echo htmlspecialchars($search); ?>">
                </div>
            </div>
            <div class="col-md-4">
                <select name="category" class="form-select" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    <?php foreach ($cats as $c): ?>
                    <option value="<?php echo htmlspecialchars($c['category']); ?>"
                        <?php echo $category === $c['category'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($c['category']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100" type="submit">Search</button>
            </div>
        </form>
    </div>
</section>

<!-- Blog grid -->
<section class="section-padding">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 mb-0">
                <?php if ($search || $category): ?>
                    Results <?php echo $search ? "for &ldquo;<em>".htmlspecialchars($search)."</em>&rdquo;" : ''; ?>
                    <?php echo $category ? " in <em>".htmlspecialchars($category)."</em>" : ''; ?>
                <?php else: ?>
                    All Articles
                <?php endif; ?>
            </h2>
            <span class="text-muted small"><?php echo $total_blogs; ?> article<?php echo $total_blogs != 1 ? 's' : ''; ?></span>
        </div>

        <?php if (empty($blogs)): ?>
        <div class="text-center py-5">
            <i class="fas fa-search fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No articles found.</h5>
            <a href="blogs.php" class="btn btn-outline-primary mt-2">Clear filters</a>
        </div>
        <?php else: ?>
        <div class="row g-4">
            <?php foreach ($blogs as $b):
                $cc = catColor($b['category'], $catColors); ?>
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm" style="border-radius:12px;overflow:hidden;">
                    <div class="position-relative" style="height:200px;overflow:hidden;">
                        <img src="<?php echo blogImg($b); ?>" alt="<?php echo htmlspecialchars($b['title']); ?>"
                             style="width:100%;height:100%;object-fit:cover;transition:transform .4s;">
                        <span class="badge bg-<?php echo $cc; ?> position-absolute top-0 start-0 m-2">
                            <?php echo htmlspecialchars($b['category'] ?? 'General'); ?>
                        </span>
                    </div>
                    <div class="card-body d-flex flex-column p-4">
                        <div class="d-flex gap-3 text-muted small mb-2">
                            <span><i class="far fa-calendar me-1"></i><?php echo date('d M Y', strtotime($b['published_date'])); ?></span>
                            <span><i class="far fa-user me-1"></i><?php echo htmlspecialchars($b['author'] ?? 'Araneus Team'); ?></span>
                        </div>
                        <h5 class="mb-2" style="line-height:1.4;">
                            <a href="blog-view.php?slug=<?php echo urlencode($b['slug']); ?>" class="text-dark text-decoration-none stretched-link">
                                <?php echo htmlspecialchars($b['title']); ?>
                            </a>
                        </h5>
                        <p class="text-muted small flex-grow-1 mb-3" style="display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">
                            <?php echo htmlspecialchars($b['excerpt'] ?? ''); ?>
                        </p>
                        <a href="blog-view.php?slug=<?php echo urlencode($b['slug']); ?>"
                           class="btn btn-outline-primary btn-sm align-self-start">
                            Read More <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <nav class="mt-5 d-flex justify-content-center">
            <ul class="pagination">
                <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page-1; ?>&search=<?php echo urlencode($search); ?>&category=<?php echo urlencode($category); ?>">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
                <?php endif; ?>
                <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                <li class="page-item <?php echo $p === $page ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $p; ?>&search=<?php echo urlencode($search); ?>&category=<?php echo urlencode($category); ?>"><?php echo $p; ?></a>
                </li>
                <?php endfor; ?>
                <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page+1; ?>&search=<?php echo urlencode($search); ?>&category=<?php echo urlencode($category); ?>">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<style>
.card:hover img { transform:scale(1.05); }
.page-item.active .page-link { background:var(--primary-color);border-color:var(--primary-color); }
.page-link { color:var(--primary-color); }
</style>

<?php require_once '../includes/footer.php'; ?>
