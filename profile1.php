<?php
require_once 'includes/header.php';
$page_title = 'Certificates';

// Get certificate ID from URL
$certificate_id = isset($_GET['certificate_id']) ? $_GET['certificate_id'] : '';

// Validate certificate ID
if (empty($certificate_id)) {
    echo '<div class="container py-5">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="alert alert-danger text-center">
                        <h4><i class="fas fa-exclamation-triangle me-2"></i>Certificate ID Required</h4>
                        <p class="mb-0">Please provide a valid certificate ID in the URL.</p>
                    </div>
                </div>
            </div>
        </div>';
    require_once 'includes/footer.php';
    exit();
}

// Use prepared statement to prevent SQL injection
$qry = "SELECT * FROM students WHERE certificate_id = ? LIMIT 1";
$stmt = $conn->prepare($qry);
$stmt->bind_param("s", $certificate_id);
$stmt->execute();
$result = $stmt->get_result();
$certificate = $result->fetch_assoc();

// Check if certificate exists
if (!$certificate) {
    echo '<div class="container py-5">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="alert alert-warning text-center">
                        <h4><i class="fas fa-certificate me-2"></i>Certificate Not Found</h4>
                        <p class="mb-0">The certificate with ID <strong>' . htmlspecialchars($certificate_id) . '</strong> was not found.</p>
                    </div>
                </div>
            </div>
        </div>';
    require_once 'includes/footer.php';
    exit();
}

// Close statement
$stmt->close();
?>

<!-- Certificate Display Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Certificate Actions -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-0">Certificate Verification</h1>
                        <p class="text-muted mb-0">Certificate ID: <?php echo htmlspecialchars($certificate_id); ?></p>
                    </div>
                    <div class="btn-group">
                        <button id="printCertificate" class="btn btn-primary">
                            <i class="fas fa-print me-2"></i>Print Certificate
                        </button>
                        <button id="downloadCertificate" class="btn btn-outline-primary">
                            <i class="fas fa-download me-2"></i>Download
                        </button>
                    </div>
                </div>
                
                <!-- Certificate Container -->
                <div class="certificate-container" id="certificateView">
                    <!-- Certificate Border Design -->
                    <div class="certificate-border">
                        <!-- Top Border -->
                        <div class="certificate-border-top"></div>
                        
                        <!-- Certificate Content -->
                        <div class="certificate-content p-4 p-md-5">
                            <!-- Certificate Header -->
                            <div class="text-center mb-4">
                                <div class="institution-logo mb-3">
                                    <div class="logo-circle bg-primary text-white d-inline-flex align-items-center justify-content-center">
                                        <i class="fas fa-graduation-cap fa-3x"></i>
                                    </div>
                                </div>
                                <h2 class="institution-name">ARANEUS Edutech LLP</h2>
                                <p class="institution-subtitle text-muted mb-4">
                                    116/56/E/N, East Chandmari, Barrackpore, Kolkata - 700122<br>
                                    LLPIN: AAP-3776 | support@araneusedutech.com
                                </p>
                            </div>
                            
                            <!-- Certificate Title -->
                            <div class="text-center mb-5">
                                <h1 class="certificate-title">CERTIFICATE OF COMPLETION</h1>
                                <div class="title-underline mx-auto"></div>
                                <p class="certificate-subtitle">This is to certify that</p>
                            </div>
                            
                            <!-- Student Name -->
                            <div class="text-center mb-4">
                                <h2 class="student-name"><?php echo htmlspecialchars($certificate['candidate_name'] ?? 'Student Name'); ?></h2>
                            </div>
                            
                            <!-- Certificate Body -->
                            <div class="certificate-body text-center mb-5">
                                <p class="certificate-text lead">
                                    has successfully completed the 
                                    <strong class="course-name"><?php echo htmlspecialchars($certificate['course_completed'] ?? 'Course Name'); ?></strong>
                                    <?php if (isset($certificate['time_hours'])): ?>
                                        , a <?php echo htmlspecialchars($certificate['time_hours']); ?> program,
                                    <?php endif; ?>
                                    offered by Araneus Edutech LLP.
                                </p>
                                
                                <?php if (isset($certificate['grade']) && !empty($certificate['grade'])): ?>
                                    <p class="grade-info">
                                        <strong>Grade Achieved:</strong> 
                                        <span class="badge bg-success"><?php echo htmlspecialchars($certificate['grade']); ?></span>
                                    </p>
                                <?php endif; ?>
                                
                                <?php if (isset($certificate['course_completed']) && !empty($certificate['course_completed'])): ?>
                                    <p class="certificate-description mt-3">
                                        <?php echo htmlspecialchars($certificate['course_completed']); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Certificate Footer -->
                            <div class="certificate-footer mt-4">
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        <div class="signature-box">
                                            <div class="signature-line mb-2"></div>
                                            <p class="mb-1"><strong>Date of Completion</strong></p>
                                            <p class="text-muted"><?php echo isset($certificate['end_date']) ? date('F d, Y', strtotime($certificate['end_date'])) : date('F d, Y'); ?></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4 text-center">
                                        <div class="signature-box">
                                            <div class="signature-line mb-2"></div>
                                            <p class="mb-1"><strong>Authorized Signature</strong></p>
                                            <p class="text-muted">Director, Araneus Edutech LLP</p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4 text-center">
                                        <div class="signature-box">
                                            <div class="signature-line mb-2"></div>
                                            <p class="mb-1"><strong>Certificate ID</strong></p>
                                            <p class="text-muted"><?php echo htmlspecialchars($certificate_id); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Verification Info -->
                            <div class="verification-info mt-5 pt-3 border-top text-center">
                                <p class="text-muted small">
                                    <i class="fas fa-shield-alt me-1"></i>
                                    This certificate can be verified online at:<br>
                                    <a href="<?php echo SITE_URL; ?>/profile.php?certificate_id=<?php echo urlencode($certificate_id); ?>">
                                        <?php echo SITE_URL; ?>/profile.php?certificate_id=<?php echo htmlspecialchars($certificate_id); ?>
                                    </a>
                                </p>
                            </div>
                        </div>
                        
                        <!-- Bottom Border -->
                        <div class="certificate-border-bottom"></div>
                    </div>
                </div>
                
                <!-- Certificate Details Card -->
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Certificate Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Certificate ID:</th>
                                            <td><?php echo htmlspecialchars($certificate_id); ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Student Name:</th>
                                            <td><?php echo htmlspecialchars($certificate['candidate_name'] ?? 'N/A'); ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Course Name:</th>
                                            <td><?php echo htmlspecialchars($certificate['course_completed'] ?? 'N/A'); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Completion Date:</th>
                                            <td><?php echo isset($certificate['end_date']) ? date('F d, Y', strtotime($certificate['end_date'])) : 'N/A'; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Issued Date:</th>
                                            <td><?php echo isset($certificate['start_date']) ? date('F d, Y', strtotime($certificate['start_date'])) : date('F d, Y'); ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Status:</th>
                                            <td><span class="badge bg-success">Verified</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- QR Code for Verification -->
                        <div class="text-center mt-4">
                            <div class="qr-code-container d-inline-block p-3 bg-white border rounded">
                                <div id="qrcode"></div>
                                <p class="small text-muted mt-2 mb-0">Scan to verify certificate</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Verification Instructions -->
                <div class="alert alert-info mt-4">
                    <h5><i class="fas fa-shield-alt me-2"></i>Certificate Verification</h5>
                    <p class="mb-2">This certificate has been digitally issued by Araneus Edutech LLP and can be verified using:</p>
                    <ul class="mb-0">
                        <li>Certificate ID: <code><?php echo htmlspecialchars($certificate_id); ?></code></li>
                        <li>Verification URL: <code><?php echo SITE_URL; ?>/profile.php?certificate_id=<?php echo htmlspecialchars($certificate_id); ?></code></li>
                        <li>QR Code (above)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Certificate CSS -->
<style>
    /* Certificate Container */
    .certificate-container {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 5px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 20px;
    }
    
    /* Certificate Border */
    .certificate-border {
        position: relative;
        border: 3px solid #FF4500;
        border-radius: 8px;
    }
    
    .certificate-border-top,
    .certificate-border-bottom {
        height: 20px;
        background: linear-gradient(90deg, #FF4500, #FFA500);
        width: 100%;
    }
    
    /* Certificate Content */
    .certificate-content {
        background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), 
                    url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><path fill="none" stroke="%23FF4500" stroke-width="0.5" opacity="0.1" d="M0,0 L100,0 L100,100 L0,100 Z M20,20 L80,20 L80,80 L20,80 Z"/><path fill="none" stroke="%23FFA500" stroke-width="0.3" opacity="0.1" d="M10,10 L90,10 L90,90 L10,90 Z"/></svg>');
        background-size: 200px;
    }
    
    /* Institution Logo */
    .logo-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 3px solid #FF4500;
    }
    
    .institution-name {
        font-family: 'Georgia', serif;
        font-weight: bold;
        color: #333;
        font-size: 2.2rem;
        margin-bottom: 5px;
    }
    
    .institution-subtitle {
        font-size: 0.9rem;
        line-height: 1.4;
    }
    
    /* Certificate Title */
    .certificate-title {
        font-family: 'Times New Roman', serif;
        font-weight: bold;
        color: #FF4500;
        font-size: 2.8rem;
        letter-spacing: 2px;
        margin-bottom: 10px;
    }
    
    .title-underline {
        width: 200px;
        height: 3px;
        background: linear-gradient(to right, #FF4500, #FFA500);
        margin-bottom: 15px;
    }
    
    .certificate-subtitle {
        font-size: 1.2rem;
        color: #666;
        font-style: italic;
    }
    
    /* Student Name */
    .student-name {
        font-family: 'Georgia', serif;
        font-size: 2.5rem;
        color: #333;
        padding: 15px 30px;
        background-color: rgba(255, 69, 0, 0.05);
        border-radius: 8px;
        display: inline-block;
        border-left: 4px solid #FF4500;
        border-right: 4px solid #FFA500;
    }
    
    /* Certificate Body */
    .certificate-text {
        font-size: 1.2rem;
        line-height: 1.6;
        color: #444;
        max-width: 800px;
        margin: 0 auto;
    }
    
    .course-name {
        color: #FF4500;
        font-weight: bold;
    }
    
    .grade-info {
        font-size: 1.1rem;
        margin-top: 15px;
    }
    
    .grade-info .badge {
        font-size: 1rem;
        padding: 5px 15px;
    }
    
    .certificate-description {
        font-size: 1rem;
        color: #666;
        font-style: italic;
        border-left: 3px solid #FFA500;
        padding-left: 15px;
    }
    
    /* Certificate Footer */
    .certificate-footer {
        margin-top: 40px;
    }
    
    .signature-box {
        padding: 15px;
    }
    
    .signature-line {
        width: 150px;
        height: 2px;
        background-color: #333;
        margin: 0 auto;
    }
    
    /* QR Code */
    .qr-code-container {
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }
    
    #qrcode {
        width: 150px;
        height: 150px;
        margin: 0 auto;
    }
    
    /* Print Styles */
    @media print {
        body * {
            visibility: hidden;
        }
        
        .certificate-container,
        .certificate-container * {
            visibility: visible;
        }
        
        .certificate-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            box-shadow: none;
            border: none;
        }
        
        .btn-group,
        .card,
        .alert,
        .navbar,
        .footer {
            display: none !important;
        }
        
        .certificate-content {
            background: white !important;
        }
    }
</style>

<!-- JavaScript for Certificate Actions -->
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.0/build/qrcode.min.js"></script>
<script>
    // Generate QR Code
    document.addEventListener('DOMContentLoaded', function() {
        // Generate QR Code
        const verificationUrl = '<?php echo SITE_URL . "/profile.php?certificate_id=" . urlencode($certificate_id); ?>';
        const qrcode = new QRCode(document.getElementById("qrcode"), {
            text: verificationUrl,
            width: 150,
            height: 150,
            colorDark: "#FF4500",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
        
        // Print Certificate
        document.getElementById('printCertificate').addEventListener('click', function() {
            window.print();
        });
        
        // Download Certificate as PDF (simulated)
        document.getElementById('downloadCertificate').addEventListener('click', function() {
            const button = this;
            const originalHTML = button.innerHTML;
            
            // Change button state
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Preparing Download...';
            button.disabled = true;
            
            // Simulate download process
            setTimeout(function() {
                // Create a temporary link for download
                const element = document.createElement('a');
                const certificateElement = document.getElementById('certificateView');
                
                // Create a canvas for the certificate
                html2canvas(certificateElement, {
                    scale: 2,
                    useCORS: true,
                    backgroundColor: '#ffffff'
                }).then(canvas => {
                    const link = document.createElement('a');
                    link.download = 'Certificate-<?php echo htmlspecialchars($certificate_id); ?>.png';
                    link.href = canvas.toDataURL('image/png');
                    link.click();
                    
                    // Reset button
                    button.innerHTML = originalHTML;
                    button.disabled = false;
                    
                    // Show success message
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-success alert-dismissible fade show mt-3';
                    alertDiv.innerHTML = `
                        <i class="fas fa-check-circle me-2"></i>
                        Certificate downloaded successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    document.querySelector('.certificate-container').parentNode.insertBefore(alertDiv, document.querySelector('.certificate-container').nextSibling);
                });
            }, 1000);
        });
    });
    
    // Add html2canvas for downloading certificate as image
    document.write('<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"><\/script>');
</script>

<?php 
require_once 'includes/footer.php'; 
?>