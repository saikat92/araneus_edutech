    </main>
    
    <!-- Footer -->
    <footer class="footer bg-dark text-white pt-5 pb-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5 class="footer-brand mb-3">ARANEUS Edutech LLP</h5>
                    <p class="text-light">Providing innovative educational and business solutions to help organizations and individuals achieve their goals.</p>
                    <div class="social-icons mt-4">
                        <a href="https://www.facebook.com/araneusedutech" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-x"></i></a>
                        <a href="https://www.linkedin.com/company/araneus-edutech-llp" class="text-white me-3"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://www.instagram.com/araneusedutech" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.youtube.com/araneusedutech" class="text-white me-3"><i class="fab fa-youtube"></i></a>
                    </div>
                    <div class="logo">
                        <img src="<?= SITE_URL; ?>assets/images/msme.png" alt="msme_logo" style="height: 80px; margin-top: 15px;">
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?= SITE_URL; ?>index.php" class="text-white-50 text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="<?= SITE_URL; ?>about.php" class="text-white-50 text-decoration-none">About Us</a></li>
                        <li class="mb-2"><a href="<?= SITE_URL; ?>education.php" class="text-white-50 text-decoration-none">Educational Solutions</a></li>
                        <li class="mb-2"><a href="<?= SITE_URL; ?>courses.php" class="text-white-50 text-decoration-none">Courses</a></li>
                        <li class="mb-2"><a href="<?= SITE_URL; ?>business.php" class="text-white-50 text-decoration-none">Business Solutions</a></li>
                        <li class="mb-2"><a href="<?= SITE_URL; ?>testimonials.php" class="text-white-50 text-decoration-none">Testimonials</a></li>
                        <li class="mb-2"><a href="<?= SITE_URL; ?>blogs.php" class="text-white-50 text-decoration-none">Blogs</a></li>
                        <li class="mb-2"><a href="<?= SITE_URL; ?>events.php" class="text-white-50 text-decoration-none">Events</a></li>
                        <li class="mb-2"><a href="<?= SITE_URL; ?>contact.php" class="text-white-50 text-decoration-none">Contact Us</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="mb-3">Education Solutions</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?= SITE_URL; ?>education.php#training" class="text-white-50 text-decoration-none">Industry Training Courses</a></li>
                        <li class="mb-2"><a href="<?= SITE_URL; ?>education.php#consultancy" class="text-white-50 text-decoration-none">Educational Consultancy</a></li>
                        <li class="mb-2"><a href="<?= SITE_URL; ?>education.php#internship" class="text-white-50 text-decoration-none">Internship Programs</a></li>
                        <li class="mb-2"><a href="<?= SITE_URL; ?>certificates.php" class="text-white-50 text-decoration-none">Certificate Verification</a></li>
                        <li class="mb-2"><a href="<?= SITE_URL; ?>portal/" class="text-white-50 text-decoration-none">Student Portal</a></li>
                    </ul>
                    <h5 class="mb-3">Business Solutions</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?= SITE_URL; ?>business.php#crm" class="text-white-50 text-decoration-none">CRM-Salesforce</a></li>
                        <li class="mb-2"><a href="<?= SITE_URL; ?>business.php#erp" class="text-white-50 text-decoration-none">ERP Solutions</a></li>
                        <li class="mb-2"><a href="<?= SITE_URL; ?>business.php#gst" class="text-white-50 text-decoration-none">GST & E-Invoicing</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="mb-3">Contact Info</h5>
                    <ul class="list-unstyled contact-info">
                        <li class="mb-3">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <span><?php echo SITE_ADDRESS; ?></span>
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-phone me-2"></i>
                            <span><?php echo SITE_PHONE; ?></span>
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-envelope me-2"></i>
                            <span><?php echo SITE_EMAIL; ?></span>
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-id-card me-2"></i>
                            <span>LLPIN: <?php echo SITE_LLPIN; ?></span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <hr class="bg-light">
            
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; <?php echo date('Y'); ?> Araneus Edutech LLP. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-white-50 text-decoration-none me-3">Privacy Policy</a>
                    <a href="#" class="text-white-50 text-decoration-none">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="<?php echo SITE_URL; ?>assets/js/main.js"></script>
    
</body>
</html>