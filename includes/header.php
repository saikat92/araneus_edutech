<?php
require_once __DIR__ . '/database.php';

// Active link helper
function isActive($path) {
    $current = $_SERVER['REQUEST_URI'] ?? '';
    return (strpos($current, $path) !== false) ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Araneus Edutech LLP – <?php echo htmlspecialchars($page_title ?? 'Professional Consultancy'); ?></title>

    <!-- SEO -->
    <meta name="description" content="Araneus Edutech LLP – Premier educational and business consultancy in Kolkata, India.">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/css/style.css">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo SITE_URL; ?>assets/images/icon.png">
</head>
<body>

<!-- ══════════════════════════════════════════════════════
     NAVBAR
══════════════════════════════════════════════════════ -->
<nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
    <div class="container">

        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?= SITE_URL; ?>">
            <img src="<?php echo SITE_URL; ?>assets/images/icon.png"
                 alt="Araneus Edutech Logo"
                 class="navbar-brand-logo">
            <div>
                <span class="brand-text">ARANEUS</span>
                <span class="brand-subtitle">Edutech LLP</span>
            </div>
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link <?= isActive('/index') ?: (($_SERVER['REQUEST_URI'] ?? '') === '/' ? 'active' : ''); ?>"
                       href="<?= SITE_URL; ?>">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= isActive('about'); ?>"
                       href="<?= SITE_URL; ?>pages/about.php">About</a>
                </li>

                <!-- Solutions dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= isActive('education') ?: isActive('business'); ?>"
                       href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Solutions
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="<?= SITE_URL; ?>pages/education.php">
                                <i class="fas fa-graduation-cap me-2 text-primary" style="font-size:.85rem;"></i>
                                Educational Solutions
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= SITE_URL; ?>pages/business.php">
                                <i class="fas fa-briefcase me-2 text-primary" style="font-size:.85rem;"></i>
                                Business Solutions
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <a class="dropdown-item" href="<?= SITE_URL; ?>pages/courses.php">
                                <i class="fas fa-book-open me-2 text-primary" style="font-size:.85rem;"></i>
                                All Courses
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= isActive('testimonials'); ?>"
                       href="<?= SITE_URL; ?>pages/testimonials.php">Reviews</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= isActive('blogs') ?: isActive('blog-view'); ?>"
                       href="<?= SITE_URL; ?>pages/blogs.php">Blog</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= isActive('career'); ?>"
                       href="<?= SITE_URL; ?>pages/career.php">Careers</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= isActive('contact'); ?>"
                       href="<?= SITE_URL; ?>pages/contact.php">Contact</a>
                </li>

                <!-- Student Portal CTA -->
                <li class="nav-item ms-lg-2">
                    <a class="nav-link nav-cta" href="<?= SITE_URL; ?>pages/login.php">
                        <i class="fas fa-user-circle me-1"></i> Student Login
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<main>
