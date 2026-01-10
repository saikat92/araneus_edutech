<?php
$page_title = "Blogs & Insights";
require_once 'includes/header.php';

// Include database connection
require_once 'includes/database.php';
$db = new Database();
$conn = $db->getConnection();

// Handle blog search
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';

// Pagination setup
$limit = 6; // Number of blogs per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Build query for fetching blogs
$query = "SELECT * FROM blogs WHERE status = 'published'";
$count_query = "SELECT COUNT(*) as total FROM blogs WHERE status = 'published'";

if (!empty($search_query)) {
    $search_term = $conn->real_escape_string($search_query);
    $query .= " AND (title LIKE '%$search_term%' OR excerpt LIKE '%$search_term%' OR content LIKE '%$search_term%')";
    $count_query .= " AND (title LIKE '%$search_term%' OR excerpt LIKE '%$search_term%' OR content LIKE '%$search_term%')";
}

if (!empty($category_filter)) {
    $category = $conn->real_escape_string($category_filter);
    $query .= " AND category = '$category'";
    $count_query .= " AND category = '$category'";
}

$query .= " ORDER BY published_date DESC LIMIT $limit OFFSET $offset";

// Execute queries
$result = $conn->query($query);
$count_result = $conn->query($count_query);
$total_blogs = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_blogs / $limit);

// Get distinct categories for filter
$categories_result = $conn->query("SELECT DISTINCT category FROM blogs WHERE status = 'published' AND category IS NOT NULL ORDER BY category");
$categories = [];
while ($row = $categories_result->fetch_assoc()) {
    $categories[] = $row['category'];
}

// Get featured blogs (most recent 3)
$featured_query = "SELECT * FROM blogs WHERE status = 'published' ORDER BY published_date DESC LIMIT 3";
$featured_result = $conn->query($featured_query);
?>

<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-4">Blogs & Insights</h1>
                <p class="lead mb-4">Stay updated with the latest trends, insights, and best practices in education, technology, and business from our industry experts.</p>
                
                <!-- Search Bar -->
                <div class="row justify-content-center mt-5">
                    <div class="col-lg-8">
                        <form method="GET" action="" class="blog-search-form">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-lg" name="search" placeholder="Search blogs..." value="<?php echo htmlspecialchars($search_query); ?>">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Blogs -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Featured Insights</h2>
            <p class="lead text-muted">Discover our most popular and recent articles</p>
        </div>
        
        <div class="row">
            <?php if ($featured_result->num_rows > 0): ?>
                <?php while ($featured = $featured_result->fetch_assoc()): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="blog-card featured-blog">
                            <div class="blog-image">
                                <?php if (!empty($featured['featured_image'])): ?>
                                    <img src="<?php echo $featured['featured_image']; ?>" alt="<?php echo htmlspecialchars($featured['title']); ?>" class="img-fluid">
                                <?php else: ?>
                                    <img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="<?php echo htmlspecialchars($featured['title']); ?>" class="img-fluid">
                                <?php endif; ?>
                                <div class="blog-category">
                                    <span class="badge bg-primary"><?php echo htmlspecialchars($featured['category'] ?? 'General'); ?></span>
                                </div>
                            </div>
                            <div class="blog-content p-4">
                                <div class="blog-meta mb-3">
                                    <span class="text-muted"><i class="far fa-calendar me-1"></i> <?php echo date('F j, Y', strtotime($featured['published_date'])); ?></span>
                                    <span class="text-muted ms-3"><i class="far fa-user me-1"></i> <?php echo htmlspecialchars($featured['author'] ?? 'Araneus Team'); ?></span>
                                </div>
                                <h4 class="blog-title">
                                    <a href="#" class="text-dark text-decoration-none"><?php echo htmlspecialchars($featured['title']); ?></a>
                                </h4>
                                <p class="blog-excerpt"><?php echo htmlspecialchars(substr($featured['excerpt'], 0, 120)) . '...'; ?></p>
                                <a href="#" class="btn btn-outline-primary btn-sm">Read More <i class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <h5>No featured blogs available at the moment.</h5>
                        <p>Check back soon for new insights and articles.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <!-- Main Blog Content -->
            <div class="col-lg-8 mb-5 mb-lg-0">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h3">Latest Articles</h2>
                    <div class="text-muted">
                        <?php echo $total_blogs; ?> article<?php echo $total_blogs != 1 ? 's' : ''; ?> found
                        <?php if (!empty($search_query)): ?>
                            for "<?php echo htmlspecialchars($search_query); ?>"
                        <?php endif; ?>
                    </div>
                </div>
                
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($blog = $result->fetch_assoc()): ?>
                        <div class="blog-card-horizontal mb-4">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <div class="blog-image">
                                        <?php if (!empty($blog['featured_image'])): ?>
                                            <img src="<?php echo $blog['featured_image']; ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>" class="img-fluid">
                                        <?php else: ?>
                                            <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="<?php echo htmlspecialchars($blog['title']); ?>" class="img-fluid">
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="blog-content p-4">
                                        <div class="blog-meta mb-2">
                                            <span class="badge bg-primary mb-2"><?php echo htmlspecialchars($blog['category'] ?? 'General'); ?></span>
                                            <span class="text-muted ms-2"><i class="far fa-calendar me-1"></i> <?php echo date('F j, Y', strtotime($blog['published_date'])); ?></span>
                                            <span class="text-muted ms-3"><i class="far fa-user me-1"></i> <?php echo htmlspecialchars($blog['author'] ?? 'Araneus Team'); ?></span>
                                        </div>
                                        <h4 class="blog-title">
                                            <a href="#" class="text-dark text-decoration-none"><?php echo htmlspecialchars($blog['title']); ?></a>
                                        </h4>
                                        <p class="blog-excerpt text-muted"><?php echo htmlspecialchars(substr($blog['excerpt'], 0, 150)) . '...'; ?></p>
                                        <a href="#" class="btn btn-outline-primary btn-sm">Read More <i class="fas fa-arrow-right ms-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    
                    <!-- Pagination -->
                    <?php if ($total_pages > 1): ?>
                        <nav aria-label="Blog pagination">
                            <ul class="pagination justify-content-center">
                                <?php if ($page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?php echo $page-1; ?><?php echo !empty($search_query) ? '&search=' . urlencode($search_query) : ''; ?><?php echo !empty($category_filter) ? '&category=' . urlencode($category_filter) : ''; ?>" aria-label="Previous">
                                            <span aria-hidden="true">&laquo; Previous</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                
                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $i; ?><?php echo !empty($search_query) ? '&search=' . urlencode($search_query) : ''; ?><?php echo !empty($category_filter) ? '&category=' . urlencode($category_filter) : ''; ?>">
                                            <?php echo $i; ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                                
                                <?php if ($page < $total_pages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?php echo $page+1; ?><?php echo !empty($search_query) ? '&search=' . urlencode($search_query) : ''; ?><?php echo !empty($category_filter) ? '&category=' . urlencode($category_filter) : ''; ?>" aria-label="Next">
                                            <span aria-hidden="true">Next &raquo;</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                    
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-newspaper fa-4x text-muted mb-4"></i>
                        <h3>No blogs found</h3>
                        <p class="text-muted mb-4">
                            <?php if (!empty($search_query)): ?>
                                No articles found for "<?php echo htmlspecialchars($search_query); ?>". Try a different search term.
                            <?php else: ?>
                                No articles are available at the moment. Check back soon!
                            <?php endif; ?>
                        </p>
                        <?php if (!empty($search_query)): ?>
                            <a href="blogs.php" class="btn btn-primary">View All Blogs</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Categories -->
                <div class="sidebar-widget mb-5">
                    <h4 class="widget-title mb-4">Categories</h4>
                    <div class="list-group">
                        <a href="blogs.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center <?php echo empty($category_filter) ? 'active' : ''; ?>">
                            All Categories
                            <span class="badge bg-primary rounded-pill"><?php echo $total_blogs; ?></span>
                        </a>
                        <?php foreach ($categories as $category): ?>
                            <?php 
                            // Get count for this category
                            $cat_count_query = $conn->query("SELECT COUNT(*) as count FROM blogs WHERE category = '$category' AND status = 'published'");
                            $cat_count = $cat_count_query->fetch_assoc()['count'];
                            ?>
                            <a href="?category=<?php echo urlencode($category); ?><?php echo !empty($search_query) ? '&search=' . urlencode($search_query) : ''; ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center <?php echo $category_filter == $category ? 'active' : ''; ?>">
                                <?php echo htmlspecialchars($category); ?>
                                <span class="badge bg-primary rounded-pill"><?php echo $cat_count; ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Popular Tags -->
                <div class="sidebar-widget mb-5">
                    <h4 class="widget-title mb-4">Popular Tags</h4>
                    <div class="tags-container">
                        <a href="?search=education" class="tag">Education</a>
                        <a href="?search=technology" class="tag">Technology</a>
                        <a href="?search=business" class="tag">Business</a>
                        <a href="?search=training" class="tag">Training</a>
                        <a href="?search=crm" class="tag">CRM</a>
                        <a href="?search=erp" class="tag">ERP</a>
                        <a href="?search=digital transformation" class="tag">Digital Transformation</a>
                        <a href="?search=career" class="tag">Career</a>
                        <a href="?search=industry" class="tag">Industry 4.0</a>
                        <a href="?search=innovation" class="tag">Innovation</a>
                    </div>
                </div>
                
                <!-- Newsletter Subscription -->
                <div class="sidebar-widget mb-5">
                    <div class="newsletter-card bg-primary text-white p-4 rounded">
                        <h4 class="widget-title text-white mb-3">Stay Updated</h4>
                        <p class="mb-4">Subscribe to our newsletter to receive the latest insights and updates directly in your inbox.</p>
                        <form id="newsletter-form" class="newsletter-form">
                            <div class="mb-3">
                                <input type="email" class="form-control" placeholder="Your email address" required>
                            </div>
                            <button type="submit" class="btn btn-light w-100">Subscribe</button>
                        </form>
                    </div>
                </div>
                
                <!-- Recent Posts -->
                <div class="sidebar-widget">
                    <h4 class="widget-title mb-4">Recent Posts</h4>
                    <?php 
                    $recent_query = "SELECT id, title, published_date FROM blogs WHERE status = 'published' ORDER BY published_date DESC LIMIT 5";
                    $recent_result = $conn->query($recent_query);
                    ?>
                    <?php if ($recent_result->num_rows > 0): ?>
                        <div class="recent-posts">
                            <?php while ($recent = $recent_result->fetch_assoc()): ?>
                                <div class="recent-post-item mb-3 pb-3 border-bottom">
                                    <h6 class="mb-1">
                                        <a href="#" class="text-dark text-decoration-none"><?php echo htmlspecialchars($recent['title']); ?></a>
                                    </h6>
                                    <small class="text-muted">
                                        <i class="far fa-calendar me-1"></i> <?php echo date('M j, Y', strtotime($recent['published_date'])); ?>
                                    </small>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5" style="background: var(--gradient-color); color: white;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <h2 class="h1 mb-3">Have Insights to Share?</h2>
                <p class="lead mb-0">We welcome guest contributions from industry experts. Share your knowledge with our community.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="contact.php" class="btn btn-light btn-lg px-5">Write for Us</a>
            </div>
        </div>
    </div>
</section>

<!-- Additional CSS for this page -->
<style>
    .hero-section {
        padding: 120px 0 80px;
    }
    
    .blog-search-form .input-group {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }
    
    .blog-search-form .form-control {
        border: none;
        padding: 15px 20px;
        font-size: 1rem;
    }
    
    .blog-search-form .btn {
        padding: 15px 30px;
        border-radius: 0;
    }
    
    .blog-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease;
        height: 100%;
    }
    
    .featured-blog:hover {
        transform: translateY(-10px);
    }
    
    .blog-card .blog-image {
        position: relative;
        height: 220px;
        overflow: hidden;
    }
    
    .blog-card .blog-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .featured-blog:hover .blog-image img {
        transform: scale(1.05);
    }
    
    .blog-category {
        position: absolute;
        top: 15px;
        left: 15px;
    }
    
    .blog-content {
        padding: 25px;
    }
    
    .blog-meta {
        font-size: 0.85rem;
    }
    
    .blog-title {
        font-size: 1.25rem;
        margin-bottom: 15px;
        line-height: 1.4;
    }
    
    .blog-title a {
        color: inherit;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .blog-title a:hover {
        color: var(--primary-color);
    }
    
    .blog-excerpt {
        color: #666;
        margin-bottom: 20px;
        line-height: 1.6;
    }
    
    .blog-card-horizontal {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }
    
    .blog-card-horizontal:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .blog-card-horizontal .blog-image {
        height: 100%;
        min-height: 200px;
    }
    
    .blog-card-horizontal .blog-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    /* Sidebar Styles */
    .sidebar-widget {
        padding: 25px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .widget-title {
        position: relative;
        padding-bottom: 10px;
        font-weight: 600;
    }
    
    .widget-title:after {
        content: '';
        position: absolute;
        width: 40px;
        height: 3px;
        background-color: var(--primary-color);
        bottom: 0;
        left: 0;
    }
    
    .list-group-item.active {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    .tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    
    .tag {
        display: inline-block;
        padding: 5px 12px;
        background-color: #f8f9fa;
        border-radius: 20px;
        font-size: 0.85rem;
        color: #555;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .tag:hover {
        background-color: var(--primary-color);
        color: white;
    }
    
    .newsletter-card {
        border: none;
    }
    
    .newsletter-form .form-control {
        border-radius: 5px;
        padding: 12px 15px;
        border: none;
    }
    
    .newsletter-form .btn {
        border-radius: 5px;
        padding: 12px;
        font-weight: 600;
    }
    
    .recent-post-item:last-child {
        border-bottom: none !important;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    /* Pagination */
    .pagination .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    .pagination .page-link {
        color: var(--primary-color);
        border: 1px solid #dee2e6;
        padding: 10px 15px;
    }
    
    .pagination .page-link:hover {
        background-color: #f8f9fa;
        color: var(--primary-color);
    }
    
    @media (max-width: 768px) {
        .blog-card-horizontal .blog-image {
            height: 200px;
        }
        
        .hero-section {
            padding: 100px 0 60px;
        }
        
        .blog-card .blog-image {
            height: 180px;
        }
    }
</style>

<!-- JavaScript for Newsletter Form -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Newsletter form submission
    const newsletterForm = document.getElementById('newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const emailInput = this.querySelector('input[type="email"]');
            const email = emailInput.value.trim();
            
            if (email) {
                // In a real application, you would send this to a server
                // For now, show a success message
                alert('Thank you for subscribing to our newsletter! You will receive updates shortly.');
                emailInput.value = '';
                
                // You could add AJAX submission here
                // Example:
                // fetch('subscribe.php', {
                //     method: 'POST',
                //     headers: {
                //         'Content-Type': 'application/json',
                //     },
                //     body: JSON.stringify({ email: email })
                // })
                // .then(response => response.json())
                // .then(data => {
                //     alert(data.message);
                //     emailInput.value = '';
                // })
                // .catch(error => {
                //     console.error('Error:', error);
                //     alert('An error occurred. Please try again.');
                // });
            }
        });
    }
    
    // Search form enhancement
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            if (this.value.trim() === '') {
                // Optional: Clear search when input is empty
                // You could add auto-submit or suggestions here
            }
        });
    }
});
</script>

<?php 
$conn->close();
require_once 'includes/footer.php'; 
?>