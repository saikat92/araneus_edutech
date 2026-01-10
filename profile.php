<?php
require_once 'includes/config.php';
$page_title = 'Certificates';


$certificate_id = isset($_GET['certificate_id']) ? $_GET['certificate_id'] : '';

$qry = "SELECT * FROM students WHERE certificate_id = '$certificate_id' LIMIT 0,1";

$result = mysqli_query($conn, $qry);
$student_data = mysqli_fetch_assoc($result);

print_r($student_data);

// Format dates for display
$start_date = date("d-m-Y", strtotime($student_data['start_date']));
$end_date = date("d-m-Y", strtotime($student_data['end_date']));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="logo.png" type="image/x-icon">
    <title>Student Profile - <?php echo htmlspecialchars($student_data['candidate_name']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        /* Same CSS as previous profile page, but dynamic */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .header h1 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            color: #2c3e50;
            font-size: 2.8rem;
            margin-bottom: 10px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .header p {
            color: #7f8c8d;
            font-size: 1.1rem;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .profile-card {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 30px;
            display: flex;
            flex-direction: column;
        }
        
        @media (min-width: 992px) {
            .profile-card {
                flex-direction: row;
            }
        }
        
        .profile-header {
            background: linear-gradient(to right, #3498db, #2c3e50);
            color: white;
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        
        @media (min-width: 992px) {
            .profile-header {
                flex: 0 0 35%;
                padding: 40px 30px;
            }
        }
        
        .profile-picture {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            border: 5px solid rgba(255, 255, 255, 0.3);
            overflow: hidden;
            position: relative;
        }

        .profile-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .initials-avatar {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: white;
            font-size: 4rem;
        }

        .initials-text {
            line-height: 1;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .profile-picture {
                width: 150px;
                height: 150px;
            }
            
            .initials-avatar {
                font-size: 3rem;
            }
        }

        /* Hover effect for profile picture */
        .profile-picture:hover .profile-image {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }

        /* Add some animation */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .profile-image, .initials-avatar {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        .profile-picture i {
            font-size: 6rem;
            color: #3498db;
        }
        
        .student-name {
            font-family: 'Poppins', sans-serif;
            font-size: 2.2rem;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .course-name {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 20px;
            max-width: 300px;
        }
        
        .verified-badge {
            background-color: #2ecc71;
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 10px;
        }
        
        .profile-details {
            padding: 30px;
            flex: 1;
        }
        
        @media (min-width: 992px) {
            .profile-details {
                padding: 40px;
            }
        }
        
        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }
        
        .detail-item {
            margin-bottom: 10px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .detail-item:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            color: #7f8c8d;
            font-size: 0.95rem;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .detail-value {
            font-size: 1.2rem;
            color: #2c3e50;
            font-weight: 500;
        }
        
        .certificate-id {
            color: #e74c3c;
            font-weight: 600;
        }
        
        .candidate-id {
            color: #3498db;
            font-weight: 600;
        }
        
        .course-highlight {
            color: #9b59b6;
            font-style: italic;
            font-weight: 500;
        }
        
        .company-name {
            color: #27ae60;
            font-weight: 600;
        }
        
        .footer {
            text-align: center;
            margin-top: 40px;
            color: #7f8c8d;
            font-size: 0.9rem;
            padding: 20px;
            border-top: 1px solid #ddd;
        }
        
        .github-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #333;
            text-decoration: none;
            background-color: #f5f5f5;
            padding: 10px 20px;
            border-radius: 8px;
            margin-top: 5px;
            transition: all 0.3s ease;
        }
        
        .github-link:hover {
            background-color: #3498db;
            color: white;
            transform: translateY(-2px);
        }
        
        .qr-section {
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 15px;
            margin-top: 30px;
            text-align: center;
        }
        
        .qr-code {
            width: 80%;
            height: auto;
            margin: 20px auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .qr-code img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .qr-placeholder {
            text-align: center;
        }
        
        .qr-placeholder i {
            font-size: 3rem;
            color: #3498db;
            margin-bottom: 15px;
        }
        
        .print-btn {
            background: linear-gradient(to right, #3498db, #2980b9);
            color: white;
            border: none;
            padding: 14px 30px;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
            transition: all 0.3s ease;
        }
        
        .print-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 15px rgba(52, 152, 219, 0.3);
        }
        
        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .logo-icon {
            font-size: 2.5rem;
            color: #3498db;
        }
        
        .logo-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: #2c3e50;
        }
        
        .msme-badge {
            background-color: #f39c12;
            color: white;
            font-size: 0.8rem;
            padding: 4px 12px;
            border-radius: 4px;
            margin-left: 10px;
        }
        
        .back-btn {
            background-color: #7f8c8d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .back-btn:hover {
            background-color: #95a5a6;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .header h1 {
                font-size: 2.2rem;
            }
            
            .student-name {
                font-size: 1.8rem;
            }
            
            .details-grid {
                grid-template-columns: 1fr;
            }
            
            .profile-picture {
                width: 150px;
                height: 150px;
            }
            
            .profile-picture i {
                font-size: 5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header with company logo -->
        <div class="header">
            <div class="logo">
                <i class="fas fa-graduation-cap logo-icon"></i>
                <div class="logo-text">Araneus Edutech LLP.<span class="msme-badge">MSME Com.</span></div>
            </div>
            <h1>Student Profile & Certificate</h1>
            <p>Official academic record and certification details</p>
        </div>
        
        <!-- Main Profile Card -->
        <div class="profile-card">
            <div class="profile-header">
               <div class="profile-picture">
                    <?php
                    if (!empty($student_data['profile_picture']) && file_exists($student_data['profile_picture'])) {
                        // Display actual profile picture
                        echo '<img src="' . htmlspecialchars($student_data['profile_picture']) . '" 
                                    alt="' . htmlspecialchars($student_data['candidate_name']) . '"
                                    class="profile-image">';
                    } else {
                        // Generate initials as fallback
                        $name_parts = explode(' ', $student_data['candidate_name']);
                        $initials = '';
                        foreach($name_parts as $part) {
                            if(!empty($part)) {
                                $initials .= strtoupper(substr($part, 0, 1));
                            }
                        }
                        // Limit to 2-3 initials
                        $initials = substr($initials, 0, 3);
                        
                        // Display initials with color based on name
                        $colors = ['#3498db', '#2ecc71', '#9b59b6', '#e74c3c', '#f39c12', '#1abc9c'];
                        $colorIndex = hexdec(substr(md5($student_data['candidate_name']), 0, 6)) % count($colors);
                        $bgColor = $colors[$colorIndex];
                        
                        echo '<div class="initials-avatar" style="background-color: ' . $bgColor . '">';
                        echo '<span class="initials-text">' . $initials . '</span>';
                        echo '</div>';
                    }
                    ?>
                </div>
                <h2 class="student-name"><?php echo htmlspecialchars($student_data['candidate_name']); ?></h2>
                <p class="course-name"><?php echo htmlspecialchars(explode(' on ', $student_data['course_completed'])[0]); ?></p>
                <div class="verified-badge">
                    <i class="fas fa-check-circle"></i>
                    Verified Certificate
                </div>
            </div>
            
            <!-- Profile Details Section -->
            <div class="profile-details">
                <div style="margin-bottom: 20px;">
                    <button class="back-btn" onclick="window.location.href='certificates.php'">
                        <i class="fas fa-arrow-left"></i>
                        Back to Search
                    </button>
                    <!-- <button class="print-btn" onclick="window.print()">
                        <i class="fas fa-print"></i>
                        Print Certificate
                    </button> -->
                </div>
                
                <div class="details-grid">
                    <div class="detail-group">
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-id-card"></i>
                                Candidate ID
                            </div>
                            <div class="detail-value candidate-id"><?php echo htmlspecialchars($student_data['candidate_id']); ?></div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-certificate"></i>
                                Certificate ID
                            </div>
                            <div class="detail-value certificate-id"><?php echo htmlspecialchars($student_data['certificate_id']); ?></div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-user"></i>
                                Candidate Name
                            </div>
                            <div class="detail-value"><?php echo htmlspecialchars($student_data['candidate_name']); ?></div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-user-friends"></i>
                                Father Name
                            </div>
                            <div class="detail-value"><?php echo htmlspecialchars($student_data['father_name']); ?></div>
                        </div>
                    </div>
                    
                    <div class="detail-group">
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-book"></i>
                                Course Completed
                            </div>
                            <div class="detail-value">
                                <?php 
                                $course_parts = explode(' on ', $student_data['course_completed']);
                                if(count($course_parts) > 1) {
                                    echo htmlspecialchars($course_parts[0]) . ' on <span class="course-highlight">"' . htmlspecialchars($course_parts[1]) . '"</span>';
                                } else {
                                    echo htmlspecialchars($student_data['course_completed']);
                                }
                                ?>
                            </div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-award"></i>
                                Certification
                            </div>
                            <div class="detail-value company-name"><?php echo htmlspecialchars($student_data['certification']); ?></div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-laptop-house"></i>
                                Mode
                            </div>
                            <div class="detail-value"><?php echo htmlspecialchars($student_data['mode']); ?></div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-clock"></i>
                                Time
                            </div>
                            <div class="detail-value"><?php echo htmlspecialchars($student_data['time_hours']); ?> Hours</div>
                        </div>
                    </div>
                    
                    <div class="detail-group">
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-calendar-alt"></i>
                                Duration
                            </div>
                            <div class="detail-value"><?php echo $start_date; ?> to <?php echo $end_date; ?></div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-building"></i>
                                LLPIN
                            </div>
                            <div class="detail-value"><?php echo htmlspecialchars($student_data['llpin']); ?></div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-map-marker-alt"></i>
                                Address
                            </div>
                            <div class="detail-value"><?php echo htmlspecialchars($student_data['address']); ?></div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fab fa-github"></i>
                                GitHub Link
                            </div>
                            <div>
                                <?php if(!empty($student_data['github_link'])): ?>
                                    <a href="<?php echo htmlspecialchars($student_data['github_link']); ?>" 
                                       target="_blank" 
                                       class="github-link">
                                        <i class="fab fa-github"></i>
                                        View GitHub Profile
                                    </a>
                                <?php else: ?>
                                    <span class="detail-value">Not Provided</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- certificate Section -->
                <div class="qr-section">
                    <h3>Certificate Verification</h3>
                    <div class="qr-code">
                        <?php if(!empty($student_data['qr_code_path']) && file_exists($student_data['qr_code_path'])): ?>
                            <img src="<?php echo htmlspecialchars($student_data['qr_code_path']); ?>" 
                                 alt="Certificate for <?php echo htmlspecialchars($student_data['certificate_id']); ?>">
                                 <span id="certificatePath" style="display: none;"><?php echo htmlspecialchars($student_data['qr_code_path']); ?></span>
                        <?php else: ?>
                            <div class="qr-placeholder">
                                <i class="fas fa-qrcode"></i>
                                <div>Certificate Not Available</div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <p><small>Preview of your certificate. You can download by clicking the button.</small></p>
                </div>
                
                <!-- Print Button -->
                <div style="text-align: center; margin-top: 30px;">
                    <button class="print-btn" onclick="downloadCertificate()">
                        <i class="fas fa-download"></i>
                        Download Certificate
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>© <?php echo date('Y'); ?> Araneus Edutech LLP. All rights reserved. | This is an official student profile record.</p>
            <p>For verification queries, contact: araneusedutech@gmail.com | Phone: +91-9330109583</p>
            <p>Certificate ID: <?php echo htmlspecialchars($student_data['certificate_id']); ?> | Generated on: <?php echo date('d-m-Y H:i:s'); ?></p>
        </div>
    </div>
    
    <script>

        function downloadCertificate() {
        // Get the file path
        const filePath = document.getElementById("certificatePath").textContent.trim();
        console.log(filePath);
        // Validate file path
        if (!filePath) {
            showMessage('Error: No file path available', 'error');
            return;
        }
        
        // Show loading indicator
        const originalText = event.target.innerHTML;
        event.target.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Downloading...';
        event.target.disabled = true;
        
        // Check if file exists (for same-origin files)
        fetch(filePath, { method: 'HEAD' })
            .then(response => {
                if (response.ok) {
                    // File exists, proceed with download
                    const link = document.createElement('a');
                    link.href = filePath;
                    
                    // Create a nice filename
                    const studentName = '<?php echo str_replace(" ", "_", $student_data["candidate_name"]); ?>';
                    const certId = '<?php echo $student_data["certificate_id"]; ?>';
                    const extension = filePath.split('.').pop();
                    link.download = `${studentName}_${certId}_Certificate.${extension}`;
                    
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    
                    showMessage('Certificate download started!', 'success');
                } else {
                    showMessage('File not found or inaccessible', 'error');
                }
            })
            .catch(error => {
                // If fetch fails (cross-origin issues), try direct download
                console.log('Trying direct download...');
                const link = document.createElement('a');
                link.href = filePath;
                link.download = 'certificate.' + filePath.split('.').pop();
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                
                showMessage('Download initiated', 'info');
            })
            .finally(() => {
                // Restore button state
                setTimeout(() => {
                    event.target.innerHTML = originalText;
                    event.target.disabled = false;
                }, 1000);
            });
        }

        function showMessage(message, type = 'info') {
            // Create message element
            const messageDiv = document.createElement('div');
            messageDiv.textContent = message;
            messageDiv.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 12px 20px;
                border-radius: 8px;
                color: white;
                z-index: 1000;
                animation: slideIn 0.3s ease-out;
                font-family: Arial, sans-serif;
                font-size: 14px;
            `;
            
            // Set color based on type
            if (type === 'success') {
                messageDiv.style.backgroundColor = '#2ecc71';
            } else if (type === 'error') {
                messageDiv.style.backgroundColor = '#e74c3c';
            } else {
                messageDiv.style.backgroundColor = '#3498db';
            }
            
            // Add animation styles if not already present
            if (!document.querySelector('#message-animation')) {
                const style = document.createElement('style');
                style.id = 'message-animation';
                style.textContent = `
                    @keyframes slideIn {
                        from { transform: translateX(100%); opacity: 0; }
                        to { transform: translateX(0); opacity: 1; }
                    }
                    @keyframes slideOut {
                        from { transform: translateX(0); opacity: 1; }
                        to { transform: translateX(100%); opacity: 0; }
                    }
                `;
                document.head.appendChild(style);
            }
            
            document.body.appendChild(messageDiv);
            
            // Remove message after 3 seconds
            setTimeout(() => {
                messageDiv.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => {
                    if (messageDiv.parentNode) {
                        document.body.removeChild(messageDiv);
                    }
                }, 300);
            }, 3000);
        }
    </script>
</body>
</html>