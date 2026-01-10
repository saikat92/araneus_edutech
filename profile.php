<?php
require_once 'includes/header.php';
$page_title = 'Student Certificate';


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
$student_data = $result->fetch_assoc();

// Check if certificate exists
if (!$student_data) {
    echo '<div class="container py-5">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="alert alert-warning text-center">
                        <h4><i class="fas fa-certificate me-2"></i>Certificate Not Found</h4>
                        <p class="mb-0">The certificate with ID <strong>' . htmlspecialchars($certificate_id) . '</strong> was not found.</p>
                        <a href="../index.php" class="btn btn-primary mt-3">Return to Home</a>
                    </div>
                </div>
            </div>
        </div>';
    require_once 'includes/footer.php';
    exit();
}

// Format dates for display
$start_date = date("d-m-Y", strtotime($student_data['start_date']));
$end_date = date("d-m-Y", strtotime($student_data['end_date']));
$created_date = date("d-m-Y H:i:s", strtotime($student_data['created_at']));

// Close statement
$stmt->close();
?>

<!-- Main Content -->
<main>
    <!-- Breadcrumb Navigation -->
    <div class="container py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="solutions/education.php">Educational Solutions</a></li>
                <li class="breadcrumb-item active" aria-current="page">Certificate Verification</li>
            </ol>
        </nav>
    </div>

    <!-- Profile Section -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-5 fw-bold mb-3 text-primary">Student Certificate Verification</h1>
                    <p class="lead">Official academic record and certification details</p>
                    <div class="verification-badge">
                        <span class="badge bg-success"><i class="fas fa-shield-alt me-2"></i>Verified Certificate</span>
                        <span class="badge bg-primary ms-2">ID: <?php echo htmlspecialchars($student_data['certificate_id']); ?></span>
                    </div>
                </div>
            </div>

            <!-- Profile Card -->
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="profile-card shadow-lg">
                        <!-- Profile Header -->
                        <div class="profile-header">
                            <div class="profile-image-container">
                                <?php if (!empty($student_data['profile_picture']) && file_exists($student_data['profile_picture'])): ?>
                                    <img src="<?php echo htmlspecialchars($student_data['profile_picture']); ?>" 
                                         alt="<?php echo htmlspecialchars($student_data['candidate_name']); ?>"
                                         class="profile-image">
                                <?php else: ?>
                                    <div class="profile-initials">
                                        <?php
                                        $name_parts = explode(' ', $student_data['candidate_name']);
                                        $initials = '';
                                        foreach($name_parts as $part) {
                                            if(!empty($part)) {
                                                $initials .= strtoupper(substr($part, 0, 1));
                                            }
                                        }
                                        $initials = substr($initials, 0, 3);
                                        echo $initials;
                                        ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="profile-info">
                                <h2 class="student-name"><?php echo htmlspecialchars($student_data['candidate_name']); ?></h2>
                                <p class="course-name"><?php echo htmlspecialchars(explode(' on ', $student_data['course_completed'])[0]); ?></p>
                                <p class="student-id"><i class="fas fa-id-card me-2"></i>Candidate ID: <?php echo htmlspecialchars($student_data['candidate_id']); ?></p>
                            </div>
                        </div>

                        <!-- Profile Details -->
                        <div class="profile-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="detail-section">
                                        <h4><i class="fas fa-user-graduate me-2 text-primary"></i>Personal Information</h4>
                                        <div class="detail-item">
                                            <span class="detail-label">Full Name</span>
                                            <span class="detail-value"><?php echo htmlspecialchars($student_data['candidate_name']); ?></span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Father's Name</span>
                                            <span class="detail-value"><?php echo htmlspecialchars($student_data['father_name']); ?></span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Address</span>
                                            <span class="detail-value"><?php echo htmlspecialchars($student_data['address']); ?></span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">GitHub Profile</span>
                                            <span class="detail-value">
                                                <?php if(!empty($student_data['github_link'])): ?>
                                                    <a href="<?php echo htmlspecialchars($student_data['github_link']); ?>" 
                                                       target="_blank" 
                                                       class="github-link">
                                                        <i class="fab fa-github me-1"></i>
                                                        <?php echo htmlspecialchars($student_data['github_link']); ?>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">Not Provided</span>
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="detail-section mt-4">
                                        <h4><i class="fas fa-building me-2 text-primary"></i>Organization Details</h4>
                                        <div class="detail-item">
                                            <span class="detail-label">LLPIN</span>
                                            <span class="detail-value"><?php echo htmlspecialchars($student_data['llpin']); ?></span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Certification</span>
                                            <span class="detail-value text-success fw-bold"><?php echo htmlspecialchars($student_data['certification']); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="detail-section">
                                        <h4><i class="fas fa-book me-2 text-primary"></i>Course Information</h4>
                                        <div class="detail-item">
                                            <span class="detail-label">Course Completed</span>
                                            <span class="detail-value">
                                                <?php 
                                                $course_parts = explode(' on ', $student_data['course_completed']);
                                                if(count($course_parts) > 1) {
                                                    echo htmlspecialchars($course_parts[0]) . ' <span class="text-primary">"' . htmlspecialchars($course_parts[1]) . '"</span>';
                                                } else {
                                                    echo htmlspecialchars($student_data['course_completed']);
                                                }
                                                ?>
                                            </span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Mode</span>
                                            <span class="detail-value"><?php echo htmlspecialchars($student_data['mode']); ?></span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Duration</span>
                                            <span class="detail-value"><?php echo $start_date; ?> to <?php echo $end_date; ?></span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Total Hours</span>
                                            <span class="detail-value badge bg-primary"><?php echo htmlspecialchars($student_data['time_hours']); ?> Hours</span>
                                        </div>
                                    </div>

                                    <div class="detail-section mt-4">
                                        <h4><i class="fas fa-certificate me-2 text-primary"></i>Certificate Details</h4>
                                        <div class="detail-item">
                                            <span class="detail-label">Certificate ID</span>
                                            <span class="detail-value text-primary fw-bold"><?php echo htmlspecialchars($student_data['certificate_id']); ?></span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Issue Date</span>
                                            <span class="detail-value"><?php echo $created_date; ?></span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Verification Status</span>
                                            <span class="detail-value"><span class="badge bg-success">Verified & Valid</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Certificate Preview Section -->
                        <div class="certificate-preview-section">
                            <div class="row align-items-center">
                                <div class="col-lg-8">
                                    <h4><i class="fas fa-qrcode me-2 text-primary"></i>Certificate Verification QR Code</h4>
                                    <p class="text-muted">Scan this QR code to verify the authenticity of this certificate.</p>
                                    <div class="verification-info mt-3">
                                        <p><strong>Verification URL:</strong></p>
                                        <code class="verification-url">
                                            <?php echo SITE_URL; ?>/profile.php?certificate_id=<?php echo urlencode($student_data['certificate_id']); ?>
                                        </code>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-center">
                                    <div class="qr-container">
                                        <?php if(!empty($student_data['qr_code_path']) && file_exists($student_data['qr_code_path'])): ?>
                                            <img src="<?php echo htmlspecialchars($student_data['qr_code_path']); ?>" 
                                                 alt="QR Code for <?php echo htmlspecialchars($student_data['certificate_id']); ?>"
                                                 class="qr-image">
                                            <span id="certificatePath" style="display: none;"><?php echo htmlspecialchars($student_data['qr_code_path']); ?></span>
                                        <?php else: ?>
                                            <div class="qr-placeholder">
                                                <i class="fas fa-qrcode fa-3x text-muted"></i>
                                                <p class="mt-2 text-muted">QR Code Not Available</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="profile-actions text-center py-4">
                            <button class="btn btn-primary btn-lg me-3" onclick="downloadCertificate()">
                                <i class="fas fa-download me-2"></i>Download Certificate
                            </button>
                            <button class="btn btn-outline-primary btn-lg" onclick="window.print()">
                                <i class="fas fa-print me-2"></i>Print Certificate
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Verification Note -->
            <div class="row mt-5">
                <div class="col-lg-8 mx-auto">
                    <div class="alert alert-info">
                        <h5><i class="fas fa-shield-alt me-2"></i>Certificate Verification Note</h5>
                        <p class="mb-0">This certificate has been issued digitally by Araneus Edutech LLP and can be verified using the QR code or verification URL above. For any verification queries, please contact <strong>support@araneusedutech.com</strong>.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Custom CSS for Profile Page -->
<style>
    /* Profile Card */
    .profile-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        border: 1px solid #eaeaea;
    }

    /* Profile Header */
    .profile-header {
        background: linear-gradient(135deg, #FF4500, #FFA500);
        padding: 40px;
        text-align: center;
        color: white;
        position: relative;
    }

    .profile-header:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 20px;
        background: linear-gradient(to bottom, transparent, rgba(0,0,0,0.1));
    }

    .profile-image-container {
        width: 150px;
        height: 150px;
        margin: 0 auto 25px;
        border-radius: 50%;
        border: 5px solid rgba(255, 255, 255, 0.3);
        overflow: hidden;
        background: white;
    }

    .profile-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-initials {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3.5rem;
        font-weight: bold;
        color: #FF4500;
        background: #f8f9fa;
    }

    .student-name {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 10px;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
    }

    .course-name {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 15px;
    }

    .student-id {
        font-size: 1rem;
        background: rgba(255, 255, 255, 0.2);
        padding: 8px 15px;
        border-radius: 50px;
        display: inline-block;
    }

    /* Profile Body */
    .profile-body {
        padding: 40px;
    }

    .detail-section {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 20px;
        border-left: 4px solid #FF4500;
    }

    .detail-section h4 {
        color: #333;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #eaeaea;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 600;
        color: #555;
        flex: 1;
    }

    .detail-value {
        flex: 2;
        text-align: right;
        color: #333;
    }

    .github-link {
        color: #333;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .github-link:hover {
        color: #FF4500;
    }

    /* Certificate Preview */
    .certificate-preview-section {
        background: linear-gradient(to right, #f8f9fa, #e9ecef);
        padding: 30px;
        border-top: 1px solid #dee2e6;
    }

    .qr-container {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        display: inline-block;
    }

    .qr-image {
        width: 200px;
        height: 200px;
        object-fit: contain;
    }

    .qr-placeholder {
        width: 200px;
        height: 200px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border-radius: 10px;
    }

    .verification-url {
        display: block;
        background: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
        margin-top: 10px;
        font-size: 0.9rem;
        word-break: break-all;
        border: 1px solid #dee2e6;
    }

    /* Profile Actions */
    .profile-actions {
        background: #f8f9fa;
        border-top: 1px solid #dee2e6;
    }

    /* Breadcrumb */
    .breadcrumb {
        background: transparent;
        padding: 0.75rem 1rem;
    }

    .breadcrumb-item a {
        color: #FF4500;
        text-decoration: none;
    }

    .breadcrumb-item.active {
        color: #666;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .profile-header {
            padding: 30px 20px;
        }

        .profile-image-container {
            width: 120px;
            height: 120px;
        }

        .profile-initials {
            font-size: 2.5rem;
        }

        .student-name {
            font-size: 1.8rem;
        }

        .profile-body {
            padding: 20px;
        }

        .detail-item {
            flex-direction: column;
        }

        .detail-label, .detail-value {
            text-align: left;
            width: 100%;
        }

        .detail-value {
            margin-top: 5px;
        }

        .certificate-preview-section .row {
            text-align: center;
        }

        .qr-container {
            margin-top: 20px;
        }

        .profile-actions .btn {
            width: 100%;
            margin-bottom: 10px;
        }

        .profile-actions .btn:last-child {
            margin-bottom: 0;
        }
    }

    /* Print Styles */
    @media print {
        .navbar, .footer, .breadcrumb, .profile-actions, .alert {
            display: none !important;
        }

        .profile-card {
            box-shadow: none;
            border: none;
        }

        .profile-header {
            background: #f8f9fa !important;
            color: #333 !important;
        }

        .profile-image-container {
            border-color: #333;
        }

        .profile-initials {
            color: #333;
        }

        .detail-section {
            break-inside: avoid;
        }
    }
</style>

<!-- JavaScript for Certificate Download -->
<script>
    function downloadCertificate() {
        // Get the file path
        const filePath = document.getElementById("certificatePath") ? document.getElementById("certificatePath").textContent.trim() : '';
        
        // Validate file path
        if (!filePath) {
            showMessage('Error: Certificate file not available for download', 'error');
            return;
        }
        
        // Show loading indicator
        const button = event.target;
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Downloading...';
        button.disabled = true;
        
        // Create a download link
        const link = document.createElement('a');
        link.href = filePath;
        
        // Create filename
        const studentName = '<?php echo str_replace(" ", "_", $student_data["candidate_name"]); ?>';
        const certId = '<?php echo $student_data["certificate_id"]; ?>';
        const extension = filePath.split('.').pop();
        link.download = `Certificate_${studentName}_${certId}.${extension}`;
        
        // Trigger download
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        // Show success message
        showMessage('Certificate download started successfully!', 'success');
        
        // Restore button after delay
        setTimeout(() => {
            button.innerHTML = originalText;
            button.disabled = false;
        }, 1500);
    }

    function showMessage(message, type = 'info') {
        // Create message element
        const messageDiv = document.createElement('div');
        messageDiv.className = 'alert-message';
        messageDiv.innerHTML = `
            <div class="alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} 
                        alert-dismissible fade show" role="alert" 
                        style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                <strong>${type === 'success' ? 'Success!' : type === 'error' ? 'Error!' : 'Info:'}</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        // Add to body
        document.body.appendChild(messageDiv);
        
        // Auto remove after 4 seconds
        setTimeout(() => {
            if (messageDiv.parentNode) {
                document.body.removeChild(messageDiv);
            }
        }, 4000);
    }

    // Print optimization
    document.addEventListener('DOMContentLoaded', function() {
        // Add print button event
        const printBtn = document.querySelector('[onclick="window.print()"]');
        if (printBtn) {
            printBtn.addEventListener('click', function() {
                window.print();
            });
        }
    });
</script>

<?php 
require_once 'includes/footer.php'; 
?>