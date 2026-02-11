<?php include 'database.php';


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <title>Araneus Edutech LLP - <?php echo $page_title ?? 'Professional Consultancy'; ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/css/style.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo SITE_URL; ?>assets/images/icon.png">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
        <div class="container">
            <!-- navbar brand logo image -->
            <img src="<?php echo SITE_URL; ?>assets/images/icon.png" alt="Araneus Edutech Logo" class="navbar-brand-logo px-1" width="70" />
            <a class="navbar-brand" href="index.php">
                <span class="brand-text">ARANEUS</span>
                <span class="brand-subtitle">Edutech LLP</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= SITE_URL; ?>">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= SITE_URL; ?>pages/about.php">ABOUT</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="solutionsDropdown" role="button" data-bs-toggle="dropdown">
                            SOLUTIONS
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= SITE_URL; ?>pages/education.php">Educational Solutions</a></li>
                            <li><a class="dropdown-item" href="<?= SITE_URL; ?>pages/business.php">Business Solutions</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= SITE_URL; ?>pages/testimonials.php">TESTIMONIALS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= SITE_URL; ?>pages/blogs.php">BLOGS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= SITE_URL; ?>pages/career.php">CAREER</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= SITE_URL; ?>pages/contact.php">CONTACT US</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link btn-contact" href="contact.php">CONTACT US</a>
                    </li> -->
                </ul>
            </div>
        </div>
    </nav>
    
    <main>