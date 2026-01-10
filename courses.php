<?php
require_once 'includes/header.php';
$page_title = 'Courses - Araneus Edutech LLP';
?>


<!-- Hero Section -->
<section class="courses-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-4 text-dark">Explore Our Courses</h1>
                <p class="lead mb-5">
                    Transform your career with industry-relevant programs designed by experts
                </p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="#coursesGrid" class="btn btn-light btn-lg">
                        <i class="fas fa-graduation-cap me-2"></i>View Courses
                    </a>
                    <a href="#categories" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-filter me-2"></i>Browse Categories
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3 col-6">
                <div class="text-center">
                    <div class="stat-number display-6 fw-bold text-primary mb-2" data-count="150">0</div>
                    <p class="text-muted mb-0">Hours Avg. Course</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="text-center">
                    <div class="stat-number display-6 fw-bold text-primary mb-2" data-count="12">0</div>
                    <p class="text-muted mb-0">Live Projects</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="text-center">
                    <div class="stat-number display-6 fw-bold text-primary mb-2" data-count="100">0</div>
                    <p class="text-muted mb-0">% Practical</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="text-center">
                    <div class="stat-number display-6 fw-bold text-primary mb-2" data-count="1000">0</div>
                    <p class="text-muted mb-0">Students Trained</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Advanced Course Filter -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="card shadow border-0">
            <div class="card-body p-4">
                <h3 class="card-title mb-4">Find Your Perfect Course</h3>
                <form id="advancedFilterForm">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-primary"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" id="searchCourse" placeholder="Search courses...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select form-select-lg" id="filterCategory">
                                <option value="">All Categories</option>
                                <?php
                                $cat_query = "SELECT DISTINCT category FROM courses WHERE is_active = 1";
                                $cat_result = mysqli_query($conn, $cat_query);
                                while($cat = mysqli_fetch_assoc($cat_result)):
                                ?>
                                <option value="<?php echo htmlspecialchars($cat['category']); ?>">
                                    <?php echo htmlspecialchars($cat['category']); ?>
                                </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select form-select-lg" id="filterDuration">
                                <option value="">Duration</option>
                                <option value="short">Short (< 50 hrs)</option>
                                <option value="medium">Medium (50-100 hrs)</option>
                                <option value="long">Long (100+ hrs)</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select form-select-lg" id="sortCourses">
                                <option value="newest">Newest</option>
                                <option value="price_low">Price: Low to High</option>
                                <option value="price_high">Price: High to Low</option>
                                <option value="popular">Most Popular</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Price Range Filter -->
                    <div class="row mt-4" id="priceFilterSection" style="display: none;">
                        <div class="col-md-6">
                            <label class="form-label">Price Range: ₹<span id="priceValue">0 - 50000</span></label>
                            <div class="d-flex align-items-center">
                                <input type="range" class="form-range" id="priceRange" min="0" max="50000" step="5000">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex gap-3 mt-4">
                                <button type="button" class="btn btn-primary" id="applyFilters">
                                    <i class="fas fa-filter me-2"></i>Apply Filters
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="resetFilters">
                                    <i class="fas fa-redo me-2"></i>Reset
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Filter Toggle -->
                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-link text-decoration-none" id="toggleAdvancedFilters">
                            <i class="fas fa-sliders-h me-2"></i>Advanced Filters
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Courses Grid -->
<section class="py-5" id="coursesGrid">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="section-title text-center">Featured Courses</h2>
                <p class="text-center text-muted lead">
                    Industry-designed programs with hands-on projects and certification
                </p>
            </div>
        </div>

        <div class="row g-4" id="coursesContainer">
            <?php
            $query = "SELECT * FROM courses WHERE is_active = 1 ORDER BY created_at DESC";
            $result = mysqli_query($conn, $query);
            
            if(mysqli_num_rows($result) > 0):
                while($course = mysqli_fetch_assoc($result)):
                    // Calculate rating (placeholder - you can add rating field to database)
                    $rating = rand(40, 50) / 10;
                    $students = rand(50, 500);
            ?>
            <div class="col-xl-4 col-lg-6">
                <div class="card course-card h-100 border-0 shadow-lg hover-lift">
                    <!-- Course Badge -->
                    <div class="position-absolute top-0 start-0 m-3">
                        <span class="badge bg-<?php echo getCategoryColor($course['category']); ?> fs-6 py-2 px-3">
                            <?php echo htmlspecialchars($course['category']); ?>
                        </span>
                    </div>
                    
                    <!-- Course Image -->
                    <div class="card-img-top position-relative">
                        <img src="<?php echo htmlspecialchars($course['image_url']); ?>" 
                             class="img-fluid course-image" 
                             alt="<?php echo htmlspecialchars($course['title']); ?>"
                             style="height: 200px; width: 100%; object-fit: cover;">
                        <div class="course-overlay"></div>
                        
                        <!-- Course Duration -->
                        <div class="position-absolute bottom-0 start-0 m-3">
                            <span class="badge bg-dark bg-opacity-75 text-white">
                                <i class="fas fa-clock me-1"></i>
                                <?php echo htmlspecialchars($course['duration']); ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="card-body p-4">
                        <!-- Course Title -->
                        <h3 class="h5 card-title fw-bold mb-3">
                            <a href="#" class="text-dark text-decoration-none stretched-link" 
                               data-bs-toggle="modal" 
                               data-bs-target="#courseModal<?php echo $course['id']; ?>">
                                <?php echo htmlspecialchars($course['title']); ?>
                            </a>
                        </h3>
                        
                        <!-- Course Description -->
                        <p class="card-text text-muted mb-4">
                            <?php echo truncateText(htmlspecialchars($course['description']), 120); ?>
                        </p>
                        
                        <!-- Course Rating -->
                        <div class="d-flex align-items-center mb-3">
                            <div class="rating-stars me-2">
                                <?php echo generateStars($rating); ?>
                            </div>
                            <span class="text-warning fw-bold"><?php echo number_format($rating, 1); ?></span>
                            <span class="text-muted ms-2">(<?php echo $students; ?> students)</span>
                        </div>
                        
                        <!-- Course Instructor -->
                        <div class="d-flex align-items-center mb-4">
                            <div class="avatar-sm me-2">
                                <div class="avatar-initials bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 40px; height: 40px;">
                                    <?php echo getInitials($course['instructor']); ?>
                                </div>
                            </div>
                            <div>
                                <div class="text-muted small">Instructor</div>
                                <div class="fw-bold"><?php echo htmlspecialchars($course['instructor']); ?></div>
                            </div>
                        </div>
                        
                        <!-- Course Footer -->
                        <div class="border-top pt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="h4 fw-bold text-primary">₹<?php echo number_format($course['fee'], 0); ?></span>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#courseModal<?php echo $course['id']; ?>">
                                        <i class="fas fa-eye me-1"></i>Preview
                                    </button>
                                    <button class="btn btn-sm btn-primary enroll-btn"
                                            data-course-id="<?php echo $course['id']; ?>"
                                            data-course-title="<?php echo htmlspecialchars($course['title']); ?>">
                                        <i class="fas fa-shopping-cart me-1"></i>Enroll
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Modal -->
            <div class="modal fade" id="courseModal<?php echo $course['id']; ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">
                                <i class="fas fa-graduation-cap me-2"></i>
                                <?php echo htmlspecialchars($course['title']); ?>
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-0">
                            <div class="row g-0">
                                <!-- Left Column - Course Details -->
                                <div class="col-lg-8 p-5">
                                    <!-- Course Image -->
                                    <div class="mb-4">
                                        <img src="<?php echo htmlspecialchars($course['image_url']); ?>" 
                                             class="img-fluid rounded-3" 
                                             alt="<?php echo htmlspecialchars($course['title']); ?>">
                                    </div>
                                    
                                    <!-- Course Description -->
                                    <div class="mb-4">
                                        <h4 class="mb-3">Course Overview</h4>
                                        <p class="text-muted"><?php echo htmlspecialchars($course['description']); ?></p>
                                    </div>
                                    
                                    <!-- Course Highlights -->
                                    <div class="mb-4">
                                        <h4 class="mb-3">What You'll Learn</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <ul class="list-unstyled">
                                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Hands-on projects</li>
                                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Industry certification</li>
                                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Practical skills</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <ul class="list-unstyled">
                                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Career support</li>
                                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Portfolio development</li>
                                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Job assistance</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Right Column - Course Info & Enrollment -->
                                <div class="col-lg-4 bg-light p-5">
                                    <!-- Course Details Card -->
                                    <div class="card border-0 shadow-sm mb-4">
                                        <div class="card-body">
                                            <h5 class="card-title mb-4">Course Details</h5>
                                            <ul class="list-unstyled mb-0">
                                                <li class="mb-3 d-flex">
                                                    <i class="fas fa-clock text-primary me-3 mt-1"></i>
                                                    <div>
                                                        <small class="text-muted">Duration</small>
                                                        <div class="fw-bold"><?php echo htmlspecialchars($course['duration']); ?></div>
                                                    </div>
                                                </li>
                                                <li class="mb-3 d-flex">
                                                    <i class="fas fa-rupee-sign text-primary me-3 mt-1"></i>
                                                    <div>
                                                        <small class="text-muted">Fee</small>
                                                        <div class="fw-bold">₹<?php echo number_format($course['fee'], 0); ?></div>
                                                    </div>
                                                </li>
                                                <li class="mb-3 d-flex">
                                                    <i class="fas fa-chalkboard-teacher text-primary me-3 mt-1"></i>
                                                    <div>
                                                        <small class="text-muted">Instructor</small>
                                                        <div class="fw-bold"><?php echo htmlspecialchars($course['instructor']); ?></div>
                                                    </div>
                                                </li>
                                                <li class="mb-3 d-flex">
                                                    <i class="fas fa-tags text-primary me-3 mt-1"></i>
                                                    <div>
                                                        <small class="text-muted">Category</small>
                                                        <div class="fw-bold"><?php echo htmlspecialchars($course['category']); ?></div>
                                                    </div>
                                                </li>
                                                <li class="mb-3 d-flex">
                                                    <i class="fas fa-certificate text-primary me-3 mt-1"></i>
                                                    <div>
                                                        <small class="text-muted">Certification</small>
                                                        <div class="fw-bold"><?php echo htmlspecialchars($course['certification_type']); ?></div>
                                                    </div>
                                                </li>
                                                <li class="mb-3 d-flex">
                                                    <i class="fas fa-laptop-code text-primary me-3 mt-1"></i>
                                                    <div>
                                                        <small class="text-muted">Format</small>
                                                        <div class="fw-bold"><?php echo htmlspecialchars($course['program_format']); ?></div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <!-- Enrollment CTA -->
                                    <div class="d-grid gap-3">
                                        <button class="btn btn-primary btn-lg enroll-btn"
                                                data-course-id="<?php echo $course['id']; ?>"
                                                data-course-title="<?php echo htmlspecialchars($course['title']); ?>">
                                            <i class="fas fa-shopping-cart me-2"></i>Enroll Now
                                        </button>
                                        <a href="#" class="btn btn-outline-primary">
                                            <i class="fas fa-download me-2"></i>Download Syllabus
                                        </a>
                                        <div class="text-center">
                                            <small class="text-muted">
                                                <i class="fas fa-shield-alt me-1"></i>
                                                7-day money-back guarantee
                                            </small>
                                        </div>
                                    </div>
                                    
                                    <!-- Share Options -->
                                    <div class="mt-4 pt-3 border-top text-center">
                                        <small class="text-muted d-block mb-2">Share this course</small>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="#" class="btn btn-sm btn-outline-secondary">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-outline-secondary">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-outline-secondary">
                                                <i class="fab fa-linkedin-in"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-outline-secondary">
                                                <i class="fab fa-whatsapp"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                endwhile;
            else:
            ?>
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-book-open display-1 text-muted mb-4"></i>
                        <h3 class="h4 text-muted mb-3">No Courses Available</h3>
                        <p class="text-muted mb-4">We're currently updating our course catalog. Check back soon!</p>
                        <a href="#" class="btn btn-primary">
                            <i class="fas fa-bell me-2"></i>Notify Me
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Load More Button -->
        <div class="text-center mt-5">
            <button class="btn btn-outline-primary btn-lg" id="loadMoreCourses">
                <i class="fas fa-sync-alt me-2"></i>Load More Courses
            </button>
        </div>
    </div>
</section>

<!-- Course Categories -->
<section class="py-5 bg-light" id="categories">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="section-title">Browse by Category</h2>
                <p class="text-muted lead">Find courses that match your career goals</p>
            </div>
        </div>
        
        <div class="row g-4">
            <?php
            $categories = [
                ['name' => 'Programming', 'icon' => 'fa-code', 'courses' => 8, 'color' => 'primary'],
                ['name' => 'Data Science', 'icon' => 'fa-chart-line', 'courses' => 6, 'color' => 'success'],
                ['name' => 'Web Development', 'icon' => 'fa-laptop-code', 'courses' => 10, 'color' => 'info'],
                ['name' => 'Mobile Development', 'icon' => 'fa-mobile-alt', 'courses' => 5, 'color' => 'warning'],
                ['name' => 'IoT & Embedded', 'icon' => 'fa-microchip', 'courses' => 4, 'color' => 'danger'],
                ['name' => 'Cybersecurity', 'icon' => 'fa-shield-alt', 'courses' => 3, 'color' => 'dark'],
                ['name' => 'Game Development', 'icon' => 'fa-gamepad', 'courses' => 2, 'color' => 'purple'],
                ['name' => 'Business & Marketing', 'icon' => 'fa-briefcase', 'courses' => 7, 'color' => 'teal']
            ];
            
            foreach($categories as $category):
            ?>
            <div class="col-md-3 col-6">
                <a href="#" class="category-card card text-decoration-none h-100 border-0 shadow-sm hover-scale">
                    <div class="card-body text-center p-4">
                        <div class="category-icon mb-3">
                            <i class="fas <?php echo $category['icon']; ?> fa-3x text-<?php echo $category['color']; ?>"></i>
                        </div>
                        <h5 class="card-title mb-2"><?php echo $category['name']; ?></h5>
                        <p class="text-muted mb-0"><?php echo $category['courses']; ?> Courses</p>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="pe-lg-5">
                    <h2 class="display-6 fw-bold mb-4">Why Choose Araneus Edutech?</h2>
                    <div class="mb-4">
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-success fa-2x"></i>
                            </div>
                            <div class="ms-4">
                                <h5>Industry-Relevant Curriculum</h5>
                                <p class="text-muted">Courses designed with input from industry experts and updated regularly.</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-success fa-2x"></i>
                            </div>
                            <div class="ms-4">
                                <h5>Hands-On Projects</h5>
                                <p class="text-muted">Learn by doing with real-world projects that build your portfolio.</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-success fa-2x"></i>
                            </div>
                            <div class="ms-4">
                                <h5>Career Support</h5>
                                <p class="text-muted">Resume building, interview preparation, and job placement assistance.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Students Learning" 
                         class="img-fluid rounded-3 shadow-lg">
                    <div class="position-absolute bottom-0 start-0 translate-middle-y">
                        <div class="card border-0 shadow-lg">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-award fa-2x text-warning"></i>
                                    </div>
                                    <div class="ms-3">
                                        <div class="h5 mb-0">1000+</div>
                                        <small class="text-muted">Students Certified</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5" style="background: var(--gradient-color); color: white;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="text-white mb-3">Ready to Start Your Learning Journey?</h3>
                <p class="text-light mb-0">Join thousands of students who have transformed their careers with our courses.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="contact.php" class="btn btn-light btn-lg">
                    <i class="fas fa-comments me-2"></i>Contact Advisor
                </a>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; 

// Helper Functions
function getCategoryColor($category) {
    $colors = [
        'Programming & Data Science' => 'primary',
        'IoT & Embedded Systems' => 'success',
        'Web Development' => 'info',
        'Mobile Development' => 'warning',
        'Cybersecurity' => 'danger',
        'Business' => 'dark'
    ];
    return $colors[$category] ?? 'primary';
}

function truncateText($text, $length) {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . '...';
}

function generateStars($rating) {
    $fullStars = floor($rating);
    $halfStar = ($rating - $fullStars) >= 0.5;
    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
    
    $stars = '';
    for ($i = 0; $i < $fullStars; $i++) {
        $stars .= '<i class="fas fa-star text-warning"></i>';
    }
    if ($halfStar) {
        $stars .= '<i class="fas fa-star-half-alt text-warning"></i>';
    }
    for ($i = 0; $i < $emptyStars; $i++) {
        $stars .= '<i class="far fa-star text-warning"></i>';
    }
    return $stars;
}

function getInitials($name) {
    $words = explode(' ', $name);
    $initials = '';
    foreach ($words as $word) {
        $initials .= strtoupper(substr($word, 0, 1));
    }
    return substr($initials, 0, 2);
}
?>

<!-- Additional CSS -->
<style>
    .courses-hero {
        background: linear-gradient(135deg, #ff4000 0%, #ffa900 100%);
        padding: 120px 0 80px;
        margin-top: 80px;
        position: relative;
        overflow: hidden;
    }

    .courses-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,186.7C384,213,480,235,576,213.3C672,192,768,128,864,128C960,128,1056,192,1152,208C1248,224,1344,192,1392,176L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
        background-size: cover;
        background-position: bottom;
    }

    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
    }

    .hover-scale {
        transition: transform 0.3s ease;
    }

    .hover-scale:hover {
        transform: scale(1.05);
    }

    .course-image {
        transition: transform 0.5s ease;
    }

    .course-card:hover .course-image {
        transform: scale(1.1);
    }

    .course-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, transparent 50%, rgba(0,0,0,0.3));
        border-radius: 0.375rem 0.375rem 0 0;
    }

    .category-card {
        transition: all 0.3s ease;
        background: white;
    }

    .category-card:hover {
        background: linear-gradient(135deg, #3498db 0%, #2ecc71 100%);
        color: white !important;
    }

    .category-card:hover .text-muted {
        color: rgba(255,255,255,0.8) !important;
    }

    .category-card:hover .text-primary,
    .category-card:hover .text-success,
    .category-card:hover .text-info,
    .category-card:hover .text-warning,
    .category-card:hover .text-danger,
    .category-card:hover .text-dark,
    .category-card:hover .text-purple,
    .category-card:hover .text-teal {
        color: white !important;
    }

    .bg-purple {
        background-color: #6f42c1 !important;
    }

    .bg-teal {
        background-color: #20c997 !important;
    }

    .text-purple {
        color: #6f42c1 !important;
    }

    .text-teal {
        color: #20c997 !important;
    }

    .empty-state {
        padding: 3rem;
        background: #f8f9fa;
        border-radius: 1rem;
    }

    .rating-stars {
        font-size: 0.9rem;
    }

    .avatar-initials {
        font-weight: bold;
        font-size: 0.9rem;
    }

    .section-title {
        position: relative;
        padding-bottom: 1rem;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: linear-gradient(to right, #3498db, #2ecc71);
    }

    .stat-number {
        font-family: 'Montserrat', sans-serif;
    }

    /* Animation for counters */
    @keyframes countUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .stat-number.animated {
        animation: countUp 0.6s ease-out;
    }
</style>

<!-- JavaScript for Interactive Features -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animated counters
    const counters = document.querySelectorAll('.stat-number');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-count'));
        let current = 0;
        const increment = target / 50;
        
        const updateCounter = () => {
            if (current < target) {
                current += increment;
                counter.textContent = Math.ceil(current);
                setTimeout(updateCounter, 20);
            } else {
                counter.textContent = target;
            }
        };
        
        // Start when in viewport
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    counter.classList.add('animated');
                    updateCounter();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        observer.observe(counter);
    });
    
    // Advanced filter toggle
    const toggleBtn = document.getElementById('toggleAdvancedFilters');
    const priceFilter = document.getElementById('priceFilterSection');
    
    toggleBtn.addEventListener('click', function() {
        if (priceFilter.style.display === 'none') {
            priceFilter.style.display = 'block';
            toggleBtn.innerHTML = '<i class="fas fa-times me-2"></i>Hide Filters';
        } else {
            priceFilter.style.display = 'none';
            toggleBtn.innerHTML = '<i class="fas fa-sliders-h me-2"></i>Advanced Filters';
        }
    });
    
    // Price range display
    const priceRange = document.getElementById('priceRange');
    const priceValue = document.getElementById('priceValue');
    
    priceRange.addEventListener('input', function() {
        const maxPrice = parseInt(this.value);
        priceValue.textContent = `0 - ${maxPrice}`;
    });
    
    // Course filter functionality
    const searchInput = document.getElementById('searchCourse');
    const categoryFilter = document.getElementById('filterCategory');
    const durationFilter = document.getElementById('filterDuration');
    const sortFilter = document.getElementById('sortCourses');
    const applyBtn = document.getElementById('applyFilters');
    const resetBtn = document.getElementById('resetFilters');
    const coursesContainer = document.getElementById('coursesContainer');
    
    function filterCourses() {
        const searchTerm = searchInput.value.toLowerCase();
        const category = categoryFilter.value;
        const duration = durationFilter.value;
        const sortBy = sortFilter.value;
        
        // In a real implementation, this would be an AJAX call
        // For now, we'll just show a loading state
        coursesContainer.innerHTML = `
            <div class="col-12 text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3 text-muted">Loading courses...</p>
            </div>
        `;
        
        // Simulate API call delay
        setTimeout(() => {
            location.reload(); // In production, update with filtered results
        }, 1000);
    }
    
    applyBtn.addEventListener('click', filterCourses);
    resetBtn.addEventListener('click', function() {
        searchInput.value = '';
        categoryFilter.value = '';
        durationFilter.value = '';
        sortFilter.value = 'newest';
        priceRange.value = 50000;
        priceValue.textContent = '0 - 50000';
        filterCourses();
    });
    
    // Enrollment functionality
    const enrollButtons = document.querySelectorAll('.enroll-btn');
    enrollButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const courseId = this.getAttribute('data-course-id');
            const courseTitle = this.getAttribute('data-course-title');
            
            if (!<?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>) {
                // Redirect to login if not logged in
                window.location.href = 'pages/auth/login.php?redirect=courses&course_id=' + courseId;
                return;
            }
            
            // Show enrollment confirmation
            Swal.fire({
                title: 'Enroll in ' + courseTitle,
                html: `
                    <p>Are you sure you want to enroll in this course?</p>
                    <div class="alert alert-info mt-3">
                        <i class="fas fa-info-circle me-2"></i>
                        You will be redirected to the payment page.
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Enroll Now',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#3498db'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to payment/enrollment page
                    window.location.href = 'enroll.php?course_id=' + courseId;
                }
            });
        });
    });
    
    // Load more courses
    const loadMoreBtn = document.getElementById('loadMoreCourses');
    let currentPage = 1;
    
    loadMoreBtn.addEventListener('click', function() {
        currentPage++;
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
        this.disabled = true;
        
        // Simulate loading more courses
        setTimeout(() => {
            // In production, this would be an AJAX call
            Swal.fire({
                title: 'More Courses',
                text: 'In production, this would load more courses from the server.',
                icon: 'info',
                confirmButtonText: 'OK'
            });
            
            this.innerHTML = '<i class="fas fa-sync-alt me-2"></i>Load More Courses';
            this.disabled = false;
        }, 1500);
    });
    
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<!-- SweetAlert2 for better alerts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>