</div><!-- /.portal-content -->
</main><!-- /.portal-main -->

<footer style="margin-left:var(--portal-sidebar-width);background:#fff;border-top:1px solid rgba(0,0,0,.05);padding:14px 24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;" id="portalFooter">
    <span style="font-size:.75rem;color:#aaa;">&copy; <?= date('Y') ?> Araneus Edutech LLP. All rights reserved.</span>
    <a href="<?= SITE_URL ?>pages/contact.php" style="font-size:.75rem;color:#aaa;text-decoration:none;">Need help? Contact Support</a>
</footer>

<script>
// Keep footer margin responsive (matches sidebar)
(function(){
    function adjustFooter(){
        var f = document.getElementById('portalFooter');
        if(window.innerWidth <= 991) { f.style.marginLeft = '0'; }
        else { f.style.marginLeft = 'var(--portal-sidebar-width)'; }
    }
    adjustFooter();
    window.addEventListener('resize', adjustFooter);
})();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= SITE_URL ?>assets/js/main.js"></script>
</body>
</html>
