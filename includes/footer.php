    </main>

<!-- ══════════════════════════════════════════════════════
     FOOTER
══════════════════════════════════════════════════════ -->
<footer class="footer text-white pt-5 pb-4">
    <div class="container">
        <div class="row g-4">

            <!-- Col 1: Brand -->
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <img src="<?= SITE_URL; ?>assets/images/icon.png" alt="Araneus Logo" style="width:38px;height:38px;object-fit:contain;">
                    <span class="footer-brand">ARANEUS</span>
                </div>
                <p class="text-white-50 small mb-4" style="line-height:1.75;">
                    Premier educational and business consultancy based in Kolkata, India — bridging the gap between academia and industry through technology and expertise.
                </p>
                <div class="social-icons d-flex gap-2 mb-4">
                    <a href="https://www.facebook.com/araneusedutech"  title="Facebook"  target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.linkedin.com/company/araneus-edutech-llp" title="LinkedIn" target="_blank" rel="noopener"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://www.instagram.com/araneusedutech" title="Instagram" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.youtube.com/araneusedutech"   title="YouTube"   target="_blank" rel="noopener"><i class="fab fa-youtube"></i></a>
                </div>
                <img src="<?= SITE_URL; ?>assets/images/msme.png" alt="MSME Logo" style="height:60px;opacity:.85;">
            </div>

            <!-- Col 2: Quick Links -->
            <div class="col-lg-2 col-md-6 col-6">
                <h5>Quick Links</h5>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="<?= SITE_URL; ?>"                              class="text-white-50">Home</a></li>
                    <li class="mb-2"><a href="<?= SITE_URL; ?>pages/about.php"               class="text-white-50">About Us</a></li>
                    <li class="mb-2"><a href="<?= SITE_URL; ?>pages/courses.php"             class="text-white-50">Courses</a></li>
                    <li class="mb-2"><a href="<?= SITE_URL; ?>pages/testimonials.php"        class="text-white-50">Reviews</a></li>
                    <li class="mb-2"><a href="<?= SITE_URL; ?>pages/blogs.php"               class="text-white-50">Blog</a></li>
                    <li class="mb-2"><a href="<?= SITE_URL; ?>pages/career.php"              class="text-white-50">Careers</a></li>
                    <li class="mb-2"><a href="<?= SITE_URL; ?>pages/contact.php"             class="text-white-50">Contact</a></li>
                    <li class="mb-2"><a href="<?= SITE_URL; ?>portal/dashboard.php"          class="text-white-50">Student Portal</a></li>
                    <li class="mb-2"><a href="<?= SITE_URL; ?>pages/certificates.php"          class="text-white-50">Certificate Verification</a></li>
                </ul>
            </div>

            <!-- Col 3: Services -->
            <div class="col-lg-3 col-md-6 col-6">
                <h5>Our Services</h5>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="<?= SITE_URL; ?>pages/education.php#training"    class="text-white-50">Industry Training</a></li>
                    <li class="mb-2"><a href="<?= SITE_URL; ?>pages/education.php#consultancy" class="text-white-50">Educational Consultancy</a></li>
                    <li class="mb-2"><a href="<?= SITE_URL; ?>pages/education.php#internship"  class="text-white-50">Internship Programs</a></li>
                    <li class="mb-2"><a href="<?= SITE_URL; ?>pages/certificates.php"          class="text-white-50">Certificate Verification</a></li>
                    <li class="mb-2"><a href="<?= SITE_URL; ?>pages/business.php#crm"          class="text-white-50">CRM – Salesforce</a></li>
                    <li class="mb-2"><a href="<?= SITE_URL; ?>pages/business.php#erp"          class="text-white-50">ERP Solutions</a></li>
                    <li class="mb-2"><a href="<?= SITE_URL; ?>pages/business.php#gst"          class="text-white-50">GST &amp; E-Invoicing</a></li>
                </ul>
            </div>

            <!-- Col 4: Contact -->
            <div class="col-lg-3 col-md-6">
                <h5>Contact Us</h5>
                <ul class="list-unstyled contact-info small text-white-50">
                    <li class="mb-3">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><?php echo SITE_ADDRESS; ?></span>
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-phone"></i>
                        <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', SITE_PHONE); ?>" class="text-white-50"><?php echo SITE_PHONE; ?></a>
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:<?php echo SITE_EMAIL; ?>" class="text-white-50"><?php echo SITE_EMAIL; ?></a>
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-id-card"></i>
                        <span>LLPIN: <?php echo SITE_LLPIN; ?></span>
                    </li>
                </ul>

                <!-- Mini CTA -->
                <a href="<?= SITE_URL; ?>pages/contact.php"
                   class="btn btn-primary btn-sm mt-1 w-100">
                    <i class="fas fa-paper-plane me-1"></i> Get In Touch
                </a>
            </div>

        </div><!-- /.row -->

        <hr class="mt-4 mb-3">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <small class="text-white-50">
                    &copy; <?php echo date('Y'); ?> Araneus Edutech LLP. All rights reserved.
                </small>
            </div>
            <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                <small>
                    <a href="#" class="text-white-50 me-3 footer-bottom">Privacy Policy</a>
                    <a href="#" class="text-white-50 footer-bottom">Terms of Service</a>
                </small>
            </div>
        </div>

    </div>
</footer>

<!-- Back-to-top button -->
<button id="backToTop" title="Back to top"
        style="display:none;position:fixed;bottom:24px;right:24px;z-index:999;
               width:42px;height:42px;border-radius:50%;border:none;
               background:var(--gradient-color);color:#fff;font-size:16px;
               box-shadow:0 4px 14px rgba(255,64,0,.4);cursor:pointer;
               transition:all .25s;">
    <i class="fas fa-chevron-up"></i>
</button>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script src="<?php echo SITE_URL; ?>assets/js/main.js"></script>

<script>
// ── Navbar: shrink on scroll + add scrolled class ──────────
(function() {
    var nav = document.getElementById('mainNav');
    function handleScroll() {
        if (window.scrollY > 40) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }
    }
    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll();
})();

// ── Back-to-top button ─────────────────────────────────────
(function() {
    var btn = document.getElementById('backToTop');
    window.addEventListener('scroll', function() {
        btn.style.display = window.scrollY > 400 ? 'block' : 'none';
    }, { passive: true });
    btn.addEventListener('click', function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
})();
</script>

</body>
</html>
