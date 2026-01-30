<?php
require_once './core/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize database connection
    $db = new Database();
    $conn = $db->getConnection();
    
    // Get form data
    $firstName = $conn->real_escape_string($_POST['firstName']);
    $lastName = $conn->real_escape_string($_POST['lastName']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $position = $conn->real_escape_string($_POST['position']);
    $experience = $conn->real_escape_string($_POST['experience']);
    $coverLetter = $conn->real_escape_string($_POST['coverLetter'] ?? '');
    $howHeard = $conn->real_escape_string($_POST['howHeard'] ?? '');
    
    // Handle file upload
    $resumePath = '';
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] === 0) {
        $uploadDir = 'uploads/resumes/';
        
        // Create directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Generate unique filename
        $fileName = time() . '_' . basename($_FILES['resume']['name']);
        $targetPath = $uploadDir . $fileName;
        
        // Validate file type
        $allowedTypes = ['pdf', 'doc', 'docx'];
        $fileExtension = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
        
        if (in_array($fileExtension, $allowedTypes)) {
            // Validate file size (5MB max)
            if ($_FILES['resume']['size'] <= 5 * 1024 * 1024) {
                if (move_uploaded_file($_FILES['resume']['tmp_name'], $targetPath)) {
                    $resumePath = $targetPath;
                }
            }
        }
    }
    
    // Insert into database
    $sql = "INSERT INTO career_applications (first_name, last_name, email, phone, position, experience, resume_path, cover_letter, how_heard) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $firstName, $lastName, $email, $phone, $position, $experience, $resumePath, $coverLetter, $howHeard);
    
    if ($stmt->execute()) {
        // Send email notification
        $to = COMPANY_CUSTOM_MAIL;
        $subject = 'New Job Application: ' . $position;
        $message = "A new job application has been submitted:\n\n";
        $message .= "Name: $firstName $lastName\n";
        $message .= "Email: $email\n";
        $message .= "Phone: $phone\n";
        $message .= "Position: $position\n";
        $message .= "Experience: $experience years\n";
        $message .= "How they heard about us: $howHeard\n\n";
        $message .= "Cover Letter:\n$coverLetter";
        
        $headers = "From: " . COMPANY_CUSTOM_MAIL . "\r\n";
        $headers .= "Reply-To: $email\r\n";
        
        mail($to, $subject, $message, $headers);
        
        // Redirect with success message
        header('Location: career.php?success=1');
        exit();
    } else {
        // Redirect with error message
        header('Location: career.php?error=1');
        exit();
    }
    
    $stmt->close();
    $db->close();
} else {
    header('Location: career.php');
    exit();
}
?>