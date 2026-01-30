<?php
require_once __DIR__ . '/../core/connection.php';
?>

</main>

<!-- Footer -->
<footer class="footer bg-dark text-white pt-5 pb-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="footer-brand mb-3"><?= COMPANY_NAME; ?></h5>
                <p class="text-light">Delivering innovative educational and business solutions to help organizations and individuals achieve their goals.</p>

                <div class="social-icons mt-4">
                    <button onclick="window.open('<?= COMPANY_FACEBOOK; ?>','_blank')">
                        <i class="fab fa-facebook-f"></i>
                    </button>

                    <button onclick="window.open('<?= COMPANY_INSTAGRAM; ?>','_blank')">
                        <i class="fab fa-instagram"></i>
                    </button>

                    <button onclick="window.open('<?= COMPANY_GITHUB; ?>','_blank')">
                        <i class="fab fa-github"></i>
                    </button>

                    <button onclick="window.open('<?= COMPANY_LINKEDIN; ?>','_blank')">
                        <i class="fab fa-linkedin-in"></i>
                    </button>

                    <button onclick="window.open('<?= COMPANY_YOUTUBE; ?>','_blank')">
                        <i class="fab fa-youtube"></i>
                    </button>
                </div>

                <div class="logo">
                    <img src="<?= DOMAIN; ?>assets/images/logos/wb-msme-in.png" alt="msme_logo" style="height: 100px; width: auto; margin-top: 30px;">
                </div>
            </div>

            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="mb-3">Site Pages</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <button class="footer-btn" onclick="location.href='<?= DOMAIN; ?>'">Home</button>
                    </li>
                    <li class="mb-2">
                        <button class="footer-btn" onclick="location.href='<?= DOMAIN; ?>pages/about.php'">About</button>
                    </li>
                    <li class="mb-2">
                        <button class="footer-btn" onclick="location.href='<?= DOMAIN; ?>pages/education.php'">Solutions</button>
                    </li>
                    <li class="mb-2">
                        <button class="footer-btn" onclick="location.href='<?= DOMAIN; ?>pages/courses.php'">Courses</button>
                    </li>
                    <li class="mb-2">
                        <button class="footer-btn" onclick="location.href='<?= DOMAIN; ?>pages/blogs.php'">Blogs</button>
                    </li>
                    <li class="mb-2">
                        <button class="footer-btn" onclick="location.href='<?= DOMAIN; ?>pages/testimonials.php'">Testimonials</button>
                    </li>
                    <li class="mb-2">
                        <button class="footer-btn" onclick="location.href='<?= DOMAIN; ?>pages/career.php'">Career</button>
                    </li>
                    <li class="mb-2">
                        <button class="footer-btn" onclick="location.href='<?= DOMAIN; ?>pages/contact.php'">Let’s Talk</button>
                    </li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="mb-3">Education Solutions</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <button class="footer-btn" onclick="location.href='<?= DOMAIN; ?>pages/education.php#training'">Industry Training Courses</button>
                    </li>
                    <li class="mb-2">
                        <button class="footer-btn" onclick="location.href='<?= DOMAIN; ?>pages/education.php#workshops'">Educational Consultancy</button>
                    </li>
                    <li class="mb-2">
                        <button class="footer-btn" onclick="location.href='<?= DOMAIN; ?>pages/education.php#consultancy'">Internship Programs</button>
                    </li>
                    <li class="mb-2">
                        <button class="footer-btn" onclick="location.href='<?= DOMAIN; ?>pages/certificates.php'">Certificates Verification</button>
                    </li>
                    <li class="mb-2">
                        <button class="footer-btn" onclick="location.href='<?= DOMAIN; ?>pages/student_portal.php'">Student Portal</button>
                    </li>
                </ul>
                <h5 class="mb-3">Business Solutions</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <button class="footer-btn" onclick="location.href='<?= DOMAIN; ?>pages/business.php#crm'">CRM-Salesforce</button>
                    </li>
                    <li class="mb-2">
                        <button class="footer-btn" onclick="location.href='<?= DOMAIN; ?>pages/business.php#erp'">ERP Solutions</button>
                    </li>
                    <li class="mb-2">
                        <button class="footer-btn" onclick="location.href='<?= DOMAIN; ?>pages/business.php#gst'">GST & E-Invoicing</button>
                    </li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="mb-3">Need help? Contact us!</h5>
                <ul class="list-unstyled contact-info">
                    <li class="mb-3">
                        <button class="contact-btn"
                            onclick="window.open('<?= COMPANY_ADDRESS_GMAP; ?>','_blank')">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <span><?= COMPANY_ADDRESS; ?></span>
                        </button>
                    </li>

                    <li class="mb-3">
                        <button class="contact-btn"
                            onclick="window.open('tel:<?= preg_replace('/\s+/', '', COMPANY_PHONE); ?>')">
                            <i class="fas fa-phone me-2"></i>
                            <span><?= COMPANY_PHONE; ?></span>
                        </button>
                    </li>

                    <li class="mb-3">
                        <button class="contact-btn"
                            onclick="window.open('mailto:<?= COMPANY_CUSTOM_MAIL; ?>')">
                            <i class="fas fa-envelope me-2"></i>
                            <span><?= COMPANY_CUSTOM_MAIL; ?></span>
                        </button>
                    </li>

                    <li class="mb-3">
                        <button class="contact-btn" disabled>
                            <i class="fas fa-id-card me-2"></i>
                            <span class="llpin-label">LLPIN:</span>
                            <span><?= COMPANY_LLPIN; ?></span>
                        </button>
                    </li>
                </ul>
            </div>

            <hr class="bg-light">

            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">
                        &copy; <?php
                                $start = (int) WEB_INDEXY;
                                echo $start . ' - ' . substr($start + 1, -2);
                                ?> Araneus Edutech LLP. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <button class="footer-btn footer-inline-btn me-3"
                        onclick="location.href='<?= DOMAIN; ?>pages/privacy-policy.php'">
                        Privacy Policy
                    </button>

                    <button class="footer-btn footer-inline-btn"
                        onclick="location.href='<?= DOMAIN; ?>pages/terms-of-service.php'">
                        Terms of Service
                    </button>
                </div>
            </div>
        </div>
</footer>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script src="<?php echo DOMAIN; ?>assets/js/main.js"></script>

</body>

</html>