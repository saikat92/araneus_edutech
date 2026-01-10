<?php
require_once 'includes/header.php';
$page_title = 'Certificates';
?>


<div class="container py-5 mt-5">
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-4 fw-bold mb-4">Certificate Verification</h1>
            <p class="lead text-muted">
                Verify and download your certificates with our secure verification system.
            </p>
        </div>
    </div>

    <!-- Verification Box -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <div class="card border-primary shadow-lg">
                <div class="card-body p-5">
                    <h2 class="card-title text-center mb-4">Verify Certificate</h2>
                    <p class="text-center text-muted mb-5">
                        Enter your Certificate ID received in mail to verify and download your certificate
                    </p>
                    
                    <form action="profile.php" method="GET" class="needs-validation" novalidate>
                        <div class="input-group input-group-lg mb-4">
                            <input type="text" 
                                   class="form-control" 
                                   name="certificate_id"
                                   placeholder="Enter Certificate ID" 
                                   required>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search me-2"></i>Verify
                            </button>
                        </div>
                    </form>
                    
                    <div class="text-center">
                        <p class="text-muted mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Example: PP/11/25/252608
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Certificate Features -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="text-center mb-5">Certificate Features</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="text-center p-4">
                        <div class="feature-icon-lg mb-4">
                            <i class="fas fa-qrcode"></i>
                        </div>
                        <h4>QR Code Verification</h4>
                        <p class="text-muted">Scan QR code to verify certificate authenticity instantly.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-4">
                        <div class="feature-icon-lg mb-4">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4>Secure & Tamper-proof</h4>
                        <p class="text-muted">Digital signatures and encryption prevent tampering.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-4">
                        <div class="feature-icon-lg mb-4">
                            <i class="fas fa-download"></i>
                        </div>
                        <h4>Easy Download</h4>
                        <p class="text-muted">Download high-quality PDF certificates for printing.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Verification Steps -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title mb-4">How to Verify Certificate</h3>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="step-card text-center p-4">
                                <div class="step-number">1</div>
                                <h5 class="mt-3 mb-2">Enter Certificate ID</h5>
                                <p class="text-muted">Enter the unique Certificate ID in the verification box.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="step-card text-center p-4">
                                <div class="step-number">2</div>
                                <h5 class="mt-3 mb-2">System Verification</h5>
                                <p class="text-muted">Our system verifies the certificate against our database.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="step-card text-center p-4">
                                <div class="step-number">3</div>
                                <h5 class="mt-3 mb-2">View & Download</h5>
                                <p class="text-muted">View certificate details and download PDF format.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .feature-icon-lg {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #3498db, #2ecc71);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
    }

    .step-card {
        border: 1px solid #e9ecef;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .step-card:hover {
        border-color: #3498db;
        transform: translateY(-5px);
    }

    .step-number {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #3498db, #2ecc71);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
    }
</style>

<?php require_once 'includes/footer.php'; 
?>