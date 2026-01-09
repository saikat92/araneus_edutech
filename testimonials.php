<?php
$page_title = "Testimonials";
require_once 'includes/header.php';

// Database connection
require_once 'includes/database.php';
$database = new Database();
$conn = $database->getConnection();
?>

<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-4">Client Testimonials</h1>
                <p class="lead mb-4">Discover what our clients say about our services and how we've helped transform their educational and business journeys.</p>
                <a href="#testimonials" class="btn btn-primary btn-lg">Read Testimonials</a>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 col-6 mb-4 mb-md-0">
                <div class="stat-box">
                    <h2 class="fw-bold text-primary">150+</h2>
                    <p class="mb-0">Happy Clients</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4 mb-md-0">
                <div class="stat-box">
                    <h2 class="fw-bold text-primary">4.8/5</h2>
                    <p class="mb-0">Average Rating</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-box">
                    <h2 class="fw-bold text-primary">95%</h2>
                    <p class="mb-0">Client Retention</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-box">
                    <h2 class="fw-bold text-primary">100+</h2>
                    <p class="mb-0">Projects Completed</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Grid -->
<section class="section-padding" id="testimonials">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">What Our Clients Say</h2>
            <p class="lead text-muted">Read authentic feedback from our valued clients across different industries</p>
        </div>
        
        <div class="row g-4">
            <?php
            // Fetch testimonials from database
            $query = "SELECT * FROM testimonials WHERE status = 'published' ORDER BY created_at DESC";
            $result = $conn->query($query);
            
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $client_name = htmlspecialchars($row['client_name']);
                    $client_position = htmlspecialchars($row['client_position']);
                    $company = htmlspecialchars($row['company']);
                    $testimonial = htmlspecialchars($row['testimonial']);
                    $rating = (int)$row['rating'];
                    $testimonial_date = date('F Y', strtotime($row['testimonial_date']));
                    $is_featured = (bool)$row['is_featured'];
                    
                    // Generate star rating HTML
                    $stars = '';
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $rating) {
                            $stars .= '<i class="fas fa-star text-warning"></i>';
                        } else {
                            $stars .= '<i class="far fa-star text-warning"></i>';
                        }
                    }
                    
                    // Determine badge for featured testimonials
                    $badge = $is_featured ? '<span class="featured-badge">Featured</span>' : '';
                    
                    // Different card style for featured testimonials
                    $card_class = $is_featured ? 'testimonial-card featured' : 'testimonial-card';
                    
                    echo "
                    <div class='col-lg-4 col-md-6'>
                        <div class='$card_class'>
                            $badge
                            <div class='testimonial-content'>
                                <div class='rating mb-3'>
                                    $stars
                                </div>
                                <p class='testimonial-text'>\"$testimonial\"</p>
                            </div>
                            <div class='testimonial-author'>
                                <div class='author-info'>
                                    <h5 class='mb-1'>$client_name</h5>
                                    <p class='mb-1 text-muted'>$client_position</p>
                                    <p class='company mb-0'><i class='fas fa-building me-1'></i>$company</p>
                                </div>
                                <div class='testimonial-date'>
                                    <i class='far fa-calendar-alt'></i>
                                    <span>$testimonial_date</span>
                                </div>
                            </div>
                        </div>
                    </div>";
                }
            } else {
                // Display sample testimonials if database is empty
                $sample_testimonials = [
                    [
                        'name' => 'Rajesh Kumar',
                        'position' => 'HR Manager',
                        'company' => 'Tech Solutions Inc.',
                        'testimonial' => 'Araneus Edutech provided excellent training for our new hires. The industry-relevant curriculum and expert trainers helped our team get up to speed quickly.',
                        'rating' => 5,
                        'date' => 'May 2023',
                        'featured' => true
                    ],
                    [
                        'name' => 'Priya Sharma',
                        'position' => 'Director',
                        'company' => 'Global Education Trust',
                        'testimonial' => 'Their educational consultancy helped us redesign our curriculum to better align with industry needs. Student placement rates have improved by 40%.',
                        'rating' => 4,
                        'date' => 'June 2023',
                        'featured' => true
                    ],
                    [
                        'name' => 'Amit Patel',
                        'position' => 'CEO',
                        'company' => 'StartUp Innovate',
                        'testimonial' => 'The Salesforce CRM implementation was seamless. The Araneus team provided excellent support throughout the transition process.',
                        'rating' => 5,
                        'date' => 'July 2023',
                        'featured' => true
                    ],
                    [
                        'name' => 'Sneha Verma',
                        'position' => 'Student',
                        'company' => 'University of Technology',
                        'testimonial' => 'The internship program was a game-changer for my career. I gained practical skills that helped me secure a job even before graduation.',
                        'rating' => 5,
                        'date' => 'August 2023',
                        'featured' => false
                    ],
                    [
                        'name' => 'Vikram Singh',
                        'position' => 'Operations Head',
                        'company' => 'Manufacturing Corp Ltd.',
                        'testimonial' => 'Their ERP implementation services transformed our operations. Inventory management and reporting have become much more efficient.',
                        'rating' => 4,
                        'date' => 'September 2023',
                        'featured' => false
                    ],
                    [
                        'name' => 'Anjali Mehta',
                        'position' => 'Training Coordinator',
                        'company' => 'Educational Institute',
                        'testimonial' => 'The faculty development program was excellent. Our teachers are now using modern teaching methodologies that engage students better.',
                        'rating' => 5,
                        'date' => 'October 2023',
                        'featured' => false
                    ]
                ];
                
                foreach ($sample_testimonials as $testimonial) {
                    $stars = '';
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $testimonial['rating']) {
                            $stars .= '<i class="fas fa-star text-warning"></i>';
                        } else {
                            $stars .= '<i class="far fa-star text-warning"></i>';
                        }
                    }
                    
                    $badge = $testimonial['featured'] ? '<span class="featured-badge">Featured</span>' : '';
                    $card_class = $testimonial['featured'] ? 'testimonial-card featured' : 'testimonial-card';
                    
                    echo "
                    <div class='col-lg-4 col-md-6'>
                        <div class='$card_class'>
                            $badge
                            <div class='testimonial-content'>
                                <div class='rating mb-3'>
                                    $stars
                                </div>
                                <p class='testimonial-text'>\"{$testimonial['testimonial']}\"</p>
                            </div>
                            <div class='testimonial-author'>
                                <div class='author-info'>
                                    <h5 class='mb-1'>{$testimonial['name']}</h5>
                                    <p class='mb-1 text-muted'>{$testimonial['position']}</p>
                                    <p class='company mb-0'><i class='fas fa-building me-1'></i>{$testimonial['company']}</p>
                                </div>
                                <div class='testimonial-date'>
                                    <i class='far fa-calendar-alt'></i>
                                    <span>{$testimonial['date']}</span>
                                </div>
                            </div>
                        </div>
                    </div>";
                }
            }
            
            // Close database connection
            $database->close();
            ?>
        </div>
    </div>
</section>

<!-- Video Testimonials -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Video Testimonials</h2>
            <p class="lead text-muted">Hear directly from our clients about their experience working with us</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="video-testimonial">
                    <div class="video-placeholder">
                        <div class="play-button">
                            <i class="fas fa-play"></i>
                        </div>
                        <div class="video-info">
                            <h5>Educational Transformation</h5>
                            <p>Hear from Global Education Trust about our curriculum redesign project</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="video-testimonial">
                    <div class="video-placeholder">
                        <div class="play-button">
                            <i class="fas fa-play"></i>
                        </div>
                        <div class="video-info">
                            <h5>Business Technology Success</h5>
                            <p>Tech Solutions Inc. shares their experience with our CRM implementation</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Client Logos -->
<section class="section-padding">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Trusted By Industry Leaders</h2>
            <p class="lead text-muted">We're proud to work with organizations across various sectors</p>
        </div>
        
        <div class="client-logos">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-2 col-md-3 col-4 mb-4">
                    <div class="client-logo">
                        <img src="https://images.unsplash.com/photo-1545235617-9465d2a55698?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Client 1" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-4 mb-4">
                    <div class="client-logo">
                        <img src="https://images.unsplash.com/photo-1497366754035-f200968a6e72?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Client 2" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-4 mb-4">
                    <div class="client-logo">
                        <img src="https://images.unsplash.com/photo-1556761175-b413da4baf72?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Client 3" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-4 mb-4">
                    <div class="client-logo">
                        <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Client 4" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-4 mb-4">
                    <div class="client-logo">
                        <img src="https://images.unsplash.com/photo-1560179707-f14e90ef3623?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Client 5" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-4 mb-4">
                    <div class="client-logo">
                        <img src="https://images.unsplash.com/photo-1542744095-fcf48d80b0fd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Client 6" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Submit Testimonial Form -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <h2 class="h1 mb-3">Share Your Experience</h2>
                <p class="lead mb-4">Have you worked with us? We'd love to hear about your experience with Araneus Edutech.</p>
                <div class="mb-4">
                    <h5><i class="fas fa-check-circle me-2"></i>Your feedback helps us improve</h5>
                    <h5><i class="fas fa-check-circle me-2"></i>Help others make informed decisions</h5>
                    <h5><i class="fas fa-check-circle me-2"></i>Share your success story</h5>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow">
                    <div class="card-body p-4 p-lg-5">
                        <h3 class="card-title mb-4 text-dark">Submit Your Testimonial</h3>
                        <form id="testimonialForm" method="POST" action="">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label text-dark">Full Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="position" class="form-label text-dark">Position</label>
                                    <input type="text" class="form-control" id="position" name="position">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="company" class="form-label text-dark">Company / Institution</label>
                                <input type="text" class="form-control" id="company" name="company">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label text-dark">Email Address *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="testimonial" class="form-label text-dark">Your Testimonial *</label>
                                <textarea class="form-control" id="testimonial" name="testimonial" rows="4" required></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-dark">Rating</label>
                                <div class="rating-input">
                                    <input type="radio" id="star5" name="rating" value="5">
                                    <label for="star5"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="star4" name="rating" value="4">
                                    <label for="star4"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="star3" name="rating" value="3">
                                    <label for="star3"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="star2" name="rating" value="2">
                                    <label for="star2"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="star1" name="rating" value="1">
                                    <label for="star1"><i class="fas fa-star"></i></label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Submit Testimonial</button>
                            <p class="text-muted small mt-3 mb-0">* By submitting, you agree to have your testimonial displayed on our website.</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Additional CSS for this page -->
<style>
    .hero-section {
        padding: 120px 0 80px;
    }
    
    .stat-box {
        padding: 20px;
    }
    
    .stat-box h2 {
        font-size: 3rem;
        margin-bottom: 10px;
    }
    
    .testimonial-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        padding: 30px;
        height: 100%;
        position: relative;
        transition: transform 0.3s ease;
    }
    
    .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
    }
    
    .testimonial-card.featured {
        border-top: 4px solid var(--primary-color);
    }
    
    .featured-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background-color: var(--primary-color);
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .testimonial-content {
        margin-bottom: 25px;
    }
    
    .rating {
        color: #FFD700;
    }
    
    .testimonial-text {
        font-style: italic;
        line-height: 1.6;
        margin-bottom: 0;
    }
    
    .testimonial-author {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-top: 1px solid #eee;
        padding-top: 20px;
    }
    
    .author-info h5 {
        color: var(--dark-color);
        font-weight: 600;
    }
    
    .company {
        font-size: 0.9rem;
        color: #666;
    }
    
    .testimonial-date {
        text-align: right;
        font-size: 0.85rem;
        color: #999;
    }
    
    .testimonial-date i {
        margin-right: 5px;
    }
    
    .video-testimonial {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .video-placeholder {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1573164713714-d95e436ab99d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80');
        background-size: cover;
        background-position: center;
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        cursor: pointer;
        transition: transform 0.3s ease;
    }
    
    .video-placeholder:hover {
        transform: scale(1.02);
    }
    
    .play-button {
        width: 70px;
        height: 70px;
        background-color: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 100px;
    }
    
    .play-button i {
        color: white;
        font-size: 25px;
        margin-left: 5px;
    }
    
    .video-info {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 20px;
    }
    
    .video-info h5 {
        margin-bottom: 5px;
    }
    
    .video-info p {
        margin-bottom: 0;
        font-size: 0.9rem;
        opacity: 0.9;
    }
    
    .client-logos {
        padding: 20px 0;
    }
    
    .client-logo {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        justify-content: center;
        height: 120px;
        transition: transform 0.3s ease;
    }
    
    .client-logo:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .client-logo img {
        max-height: 60px;
        width: auto;
        filter: grayscale(100%);
        opacity: 0.7;
        transition: all 0.3s ease;
    }
    
    .client-logo:hover img {
        filter: grayscale(0%);
        opacity: 1;
    }
    
    .rating-input {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }
    
    .rating-input input {
        display: none;
    }
    
    .rating-input label {
        color: #ddd;
        cursor: pointer;
        font-size: 1.5rem;
        margin-right: 5px;
        transition: color 0.3s;
    }
    
    .rating-input input:checked ~ label,
    .rating-input label:hover,
    .rating-input label:hover ~ label {
        color: #FFD700;
    }
    
    @media (max-width: 768px) {
        .stat-box h2 {
            font-size: 2.5rem;
        }
        
        .testimonial-author {
            flex-direction: column;
        }
        
        .testimonial-date {
            margin-top: 10px;
            text-align: left;
        }
        
        .video-placeholder {
            height: 250px;
        }
        
        .play-button {
            width: 60px;
            height: 60px;
            margin-bottom: 80px;
        }
    }
</style>

<!-- JavaScript for testimonial submission -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const testimonialForm = document.getElementById('testimonialForm');
    
    testimonialForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form values
        const name = document.getElementById('name').value;
        const position = document.getElementById('position').value;
        const company = document.getElementById('company').value;
        const email = document.getElementById('email').value;
        const testimonial = document.getElementById('testimonial').value;
        const rating = document.querySelector('input[name="rating"]:checked');
        
        // Basic validation
        if (!name || !email || !testimonial) {
            alert('Please fill in all required fields.');
            return;
        }
        
        if (!rating) {
            alert('Please provide a rating.');
            return;
        }
        
        // In a real implementation, you would send this data to the server
        // For now, we'll just show a success message
        alert('Thank you for your testimonial! It will be reviewed and published soon.');
        testimonialForm.reset();
        
        // Reset stars
        document.querySelectorAll('input[name="rating"]').forEach(input => {
            input.checked = false;
        });
    });
    
    // Video placeholder click handler
    document.querySelectorAll('.video-placeholder').forEach(placeholder => {
        placeholder.addEventListener('click', function() {
            alert('In a real implementation, this would play a video testimonial.');
        });
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>