<footer class="footer bg-dark text-white">
    <div class="container">
        <div class="text-center mt-3">
            <p class="text-white-50 mb-0 p-3">&copy; <?php echo date('Y'); ?> ARANEUS Edutech LLP. All rights reserved.</p>
        </div>
    </div>
</footer>    
<!-- Dashboard CSS -->
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
        background-color: beige !important;
    }

    .dashboard-header {
        background: linear-gradient(135deg, #FF4500 0%, #FFA500 100%);
    }
    
    .stat-card {
        border: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        background-color: rgba(255, 69, 0, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    
    .profile-avatar .avatar-placeholder {
        background: linear-gradient(135deg, #FF4500 0%, #FFA500 100%);
    }
    
    .table th {
        font-weight: 600;
        color: #555;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .progress {
        background-color: #e9ecef;
    }
    
    .progress-bar {
        background-color: #FF4500;
    }
    
    @media (max-width: 768px) {
        .dashboard-header {
            text-align: center;
        }
        
        .dashboard-header .text-md-end {
            text-align: center !important;
            margin-top: 15px;
        }
    }
</style>

   <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="<?php echo SITE_URL; ?>assets/js/main.js"></script>
    
</body>
</html>