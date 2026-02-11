<?php
session_start();

class Auth {
    private $db;
    private $conn;
    
    public function __construct() {
        require_once __DIR__ . '/../includes/database.php';
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    /**
     * Student Registration
     */
    public function registerStudent($data) {
        $response = ['success' => false, 'message' => ''];
        
        try {
            // Validate required fields
            $required = ['candidate_id', 'full_name', 'email', 'password', 'father_name', 
                        'course_completed', 'certification', 'mode', 'time_hours', 
                        'start_date', 'end_date', 'address'];
            
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    $response['message'] = "Please fill in all required fields";
                    return $response;
                }
            }
            
            // Check if candidate_id already exists
            $stmt = $this->conn->prepare("SELECT id FROM students WHERE candidate_id = ? OR email = ?");
            $stmt->bind_param("ss", $data['candidate_id'], $data['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $response['message'] = "Candidate ID or Email already exists";
                $stmt->close();
                return $response;
            }
            $stmt->close();
            
            // Hash password
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            
            // Generate verification token
            $verificationToken = bin2hex(random_bytes(32));
            
            // Prepare SQL
            $sql = "INSERT INTO students (
                candidate_id, full_name, email, password, father_name, 
                course_completed, certification, mode, time_hours, 
                start_date, end_date, llpin, address, github_link, 
                status, verification_token
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', ?)";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param(
                "ssssssssiisssss",
                $data['candidate_id'],
                $data['full_name'],
                $data['email'],
                $hashedPassword,
                $data['father_name'],
                $data['course_completed'],
                $data['certification'],
                $data['mode'],
                $data['time_hours'],
                $data['start_date'],
                $data['end_date'],
                $data['llpin'] ?? null,
                $data['address'],
                $data['github_link'] ?? null,
                $verificationToken
            );
            
            if ($stmt->execute()) {
                $studentId = $stmt->insert_id;
                
                // Send verification email
                $this->sendVerificationEmail($data['email'], $data['full_name'], $verificationToken);
                
                $response['success'] = true;
                $response['message'] = "Registration successful! Please check your email to verify your account.";
                $response['student_id'] = $studentId;
            } else {
                $response['message'] = "Registration failed: " . $stmt->error;
            }
            
            $stmt->close();
            
        } catch (Exception $e) {
            $response['message'] = "Registration error: " . $e->getMessage();
        }
        
        return $response;
    }
    
    /**
     * Student Login
     */
    public function loginStudent($candidateId, $password) {
        $response = ['success' => false, 'message' => ''];
        
        try {
            $stmt = $this->conn->prepare("
                SELECT id, candidate_id, full_name, email, password, status, email_verified 
                FROM students 
                WHERE candidate_id = ? 
                AND status != 'inactive'
            ");
            $stmt->bind_param("s", $candidateId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 1) {
                $student = $result->fetch_assoc();
                
                // Check if email is verified
                if (!$student['email_verified']) {
                    $response['message'] = "Please verify your email before logging in.";
                    $stmt->close();
                    return $response;
                }
                
                // Verify password
                if (password_verify($password, $student['password'])) {
                    // Update last login
                    $updateStmt = $this->conn->prepare("UPDATE students SET last_login = NOW() WHERE id = ?");
                    $updateStmt->bind_param("i", $student['id']);
                    $updateStmt->execute();
                    $updateStmt->close();
                    
                    // Set session variables
                    $_SESSION['student_id'] = $student['id'];
                    $_SESSION['candidate_id'] = $student['candidate_id'];
                    $_SESSION['student_name'] = $student['full_name'];
                    $_SESSION['student_email'] = $student['email'];
                    $_SESSION['logged_in'] = true;
                    $_SESSION['user_role'] = 'student';
                    
                    $response['success'] = true;
                    $response['message'] = "Login successful!";
                    $response['redirect'] = "../portal/dashboard.php";
                } else {
                    $response['message'] = "Invalid Candidate ID or Password";
                }
            } else {
                $response['message'] = "Invalid Candidate ID or Password";
            }
            
            $stmt->close();
            
        } catch (Exception $e) {
            $response['message'] = "Login error: " . $e->getMessage();
        }
        
        return $response;
    }
    
    /**
     * Admin/Staff Login
     */
    public function loginUser($username, $password) {
        $response = ['success' => false, 'message' => ''];
        
        try {
            $stmt = $this->conn->prepare("
                SELECT id, username, password_hash, email, role, full_name, status 
                FROM users 
                WHERE username = ? AND status = 'active'
            ");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                
                // Verify password
                if (password_verify($password, $user['password_hash'])) {
                    // Update last login
                    $updateStmt = $this->conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                    $updateStmt->bind_param("i", $user['id']);
                    $updateStmt->execute();
                    $updateStmt->close();
                    
                    // Set session variables
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['user_name'] = $user['full_name'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_role'] = $user['role'];
                    $_SESSION['logged_in'] = true;
                    
                    $response['success'] = true;
                    $response['message'] = "Login successful!";
                    $response['redirect'] = ($user['role'] == 'admin') ? "../admin/dashboard.php" : "../staff/dashboard.php";
                } else {
                    $response['message'] = "Invalid username or password";
                }
            } else {
                $response['message'] = "Invalid username or password";
            }
            
            $stmt->close();
            
        } catch (Exception $e) {
            $response['message'] = "Login error: " . $e->getMessage();
        }
        
        return $response;
    }
    
    /**
     * Verify Email
     */
    public function verifyEmail($token) {
        $response = ['success' => false, 'message' => ''];
        
        try {
            $stmt = $this->conn->prepare("
                SELECT id, full_name, email 
                FROM students 
                WHERE verification_token = ? AND email_verified = 0
            ");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 1) {
                $student = $result->fetch_assoc();
                
                // Update verification status
                $updateStmt = $this->conn->prepare("
                    UPDATE students 
                    SET email_verified = 1, verification_token = NULL, status = 'active' 
                    WHERE id = ?
                ");
                $updateStmt->bind_param("i", $student['id']);
                
                if ($updateStmt->execute()) {
                    $response['success'] = true;
                    $response['message'] = "Email verified successfully! You can now login.";
                } else {
                    $response['message'] = "Verification failed. Please try again.";
                }
                
                $updateStmt->close();
            } else {
                $response['message'] = "Invalid or expired verification token";
            }
            
            $stmt->close();
            
        } catch (Exception $e) {
            $response['message'] = "Verification error: " . $e->getMessage();
        }
        
        return $response;
    }
    
    /**
     * Forgot Password
     */
    public function forgotPassword($email) {
        $response = ['success' => false, 'message' => ''];
        
        try {
            // Check if email exists in students table
            $stmt = $this->conn->prepare("SELECT id, full_name FROM students WHERE email = ? AND status = 'active'");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                
                // Generate reset token
                $resetToken = bin2hex(random_bytes(32));
                $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
                
                // Store reset token
                $updateStmt = $this->conn->prepare("
                    UPDATE students 
                    SET reset_token = ?, reset_expiry = ? 
                    WHERE id = ?
                ");
                $updateStmt->bind_param("ssi", $resetToken, $expiry, $user['id']);
                
                if ($updateStmt->execute()) {
                    // Send reset email
                    $resetLink = "http://" . $_SERVER['HTTP_HOST'] . "/pages/reset-password.php?token=" . $resetToken;
                    
                    // In production, use a proper email sending library
                    $subject = "Password Reset Request - Araneus Edutech";
                    $message = "Dear " . $user['full_name'] . ",\n\n";
                    $message .= "You have requested to reset your password. Click the link below to reset:\n";
                    $message .= $resetLink . "\n\n";
                    $message .= "This link will expire in 1 hour.\n\n";
                    $message .= "If you didn't request this, please ignore this email.\n";
                    
                    // For demo, we'll just return the link
                    $response['success'] = true;
                    $response['message'] = "Password reset link sent to your email.";
                    $response['demo_link'] = $resetLink; // Remove in production
                } else {
                    $response['message'] = "Failed to process reset request";
                }
                
                $updateStmt->close();
            } else {
                $response['message'] = "No account found with this email";
            }
            
            $stmt->close();
            
        } catch (Exception $e) {
            $response['message'] = "Error: " . $e->getMessage();
        }
        
        return $response;
    }
    
    /**
     * Reset Password
     */
    public function resetPassword($token, $newPassword) {
        $response = ['success' => false, 'message' => ''];
        
        try {
            $stmt = $this->conn->prepare("
                SELECT id FROM students 
                WHERE reset_token = ? 
                AND reset_expiry > NOW() 
                AND status = 'active'
            ");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 1) {
                $student = $result->fetch_assoc();
                
                // Hash new password
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                
                // Update password and clear reset token
                $updateStmt = $this->conn->prepare("
                    UPDATE students 
                    SET password = ?, reset_token = NULL, reset_expiry = NULL 
                    WHERE id = ?
                ");
                $updateStmt->bind_param("si", $hashedPassword, $student['id']);
                
                if ($updateStmt->execute()) {
                    $response['success'] = true;
                    $response['message'] = "Password reset successfully!";
                } else {
                    $response['message'] = "Failed to reset password";
                }
                
                $updateStmt->close();
            } else {
                $response['message'] = "Invalid or expired reset token";
            }
            
            $stmt->close();
            
        } catch (Exception $e) {
            $response['message'] = "Error: " . $e->getMessage();
        }
        
        return $response;
    }
    
    /**
     * Check if user is logged in
     */
    public function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }
    
    /**
     * Get current user role
     */
    public function getUserRole() {
        return $_SESSION['user_role'] ?? null;
    }
    
    /**
     * Get current student ID
     */
    public function getStudentId() {
        return $_SESSION['student_id'] ?? null;
    }
    
    /**
     * Logout
     */
    public function logout() {
        session_destroy();
        return ['success' => true, 'message' => 'Logged out successfully'];
    }
    
    /**
     * Send verification email
     */
    private function sendVerificationEmail($email, $name, $token) {
        // In production, use PHPMailer or similar
        $verificationLink = "http://" . $_SERVER['HTTP_HOST'] . "/pages/verify-email.php?token=" . $token;
        
        $subject = "Verify Your Email - Araneus Edutech Student Portal";
        $message = "Dear " . $name . ",\n\n";
        $message .= "Thank you for registering with Araneus Edutech!\n";
        $message .= "Please click the link below to verify your email address:\n";
        $message .= $verificationLink . "\n\n";
        $message .= "This link will expire in 24 hours.\n\n";
        $message .= "If you didn't create an account, please ignore this email.\n";
        
        // For demo purposes, we'll just log it
        error_log("Verification email to: $email");
        error_log("Verification link: $verificationLink");
        
        return true;
    }
}
?>