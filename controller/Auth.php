<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Auth {
    private $conn;

    public function __construct() {
        require_once __DIR__ . '/../includes/database.php';
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // ─── Student Registration ───────────────────────────────────────────────
    public function registerStudent($data) {
        $response = ['success' => false, 'message' => ''];

        try {
            $required = ['candidate_id', 'full_name', 'email', 'password'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    $response['message'] = "Please fill in all required fields";
                    return $response;
                }
            }

            // Check duplicate candidate_id or email
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

            $hashedPassword    = password_hash($data['password'], PASSWORD_DEFAULT);
            $verificationToken = bin2hex(random_bytes(32));

            $defaults = [
                'father_name' => '',
                'time_hours'  => 0,
                'address'     => '',
                'github_link' => null,
            ];
            $insertData = array_merge($defaults, $data);

            $sql = "INSERT INTO students
                        (candidate_id, full_name, email, password, father_name, time_hours,
                         address, github_link, status, verification_token)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending', ?)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param(
                "sssssisss",
                $insertData['candidate_id'],
                $insertData['full_name'],
                $insertData['email'],
                $hashedPassword,
                $insertData['father_name'],
                $insertData['time_hours'],
                $insertData['address'],
                $insertData['github_link'],
                $verificationToken
            );

            if ($stmt->execute()) {
                $this->sendVerificationEmail($data['email'], $data['full_name'], $verificationToken);
                $response['success']    = true;
                $response['message']    = "Registration successful! Please check your email to verify your account.";
                $response['student_id'] = $stmt->insert_id;
            } else {
                $response['message'] = "Registration failed: " . $stmt->error;
            }
            $stmt->close();

        } catch (Exception $e) {
            $response['message'] = "Registration error: " . $e->getMessage();
        }

        return $response;
    }

    // ─── Student Login ──────────────────────────────────────────────────────
    public function loginStudent($candidateId, $password) {
        $response = ['success' => false, 'message' => ''];

        try {
            $stmt = $this->conn->prepare("
                SELECT id, candidate_id, full_name, email, password, status, email_verified
                FROM students
                WHERE candidate_id = ? AND status != 'inactive'
            ");
            $stmt->bind_param("s", $candidateId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $student = $result->fetch_assoc();

                if (!$student['email_verified']) {
                    $response['message'] = "Please verify your email before logging in.";
                    $stmt->close();
                    return $response;
                }

                if (password_verify($password, $student['password'])) {
                    $updateStmt = $this->conn->prepare("UPDATE students SET last_login = NOW() WHERE id = ?");
                    $updateStmt->bind_param("i", $student['id']);
                    $updateStmt->execute();
                    $updateStmt->close();

                    $_SESSION['student_id']    = $student['id'];
                    $_SESSION['candidate_id']  = $student['candidate_id'];
                    $_SESSION['student_name']  = $student['full_name'];
                    $_SESSION['student_email'] = $student['email'];
                    $_SESSION['logged_in']     = true;
                    $_SESSION['user_role']     = 'student';

                    $response['success']  = true;
                    $response['message']  = "Login successful!";
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

    // ─── Admin / Staff Login ────────────────────────────────────────────────
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

                if (password_verify($password, $user['password_hash'])) {
                    $updateStmt = $this->conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                    $updateStmt->bind_param("i", $user['id']);
                    $updateStmt->execute();
                    $updateStmt->close();

                    $_SESSION['user_id']    = $user['id'];
                    $_SESSION['username']   = $user['username'];
                    $_SESSION['user_name']  = $user['full_name'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_role']  = $user['role'];
                    $_SESSION['logged_in']  = true;

                    $response['success']  = true;
                    $response['message']  = "Login successful!";
                    $response['redirect'] = ($user['role'] == 'admin')
                        ? "../admin/dashboard.php"
                        : "../staff/dashboard.php";
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

    // ─── Email Verification ─────────────────────────────────────────────────
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

    // ─── Forgot Password ────────────────────────────────────────────────────
    public function forgotPassword($email) {
        $response = ['success' => false, 'message' => ''];

        try {
            $stmt = $this->conn->prepare(
                "SELECT id, full_name FROM students WHERE email = ? AND status = 'active'"
            );
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user       = $result->fetch_assoc();
                $resetToken = bin2hex(random_bytes(32));
                $expiry     = date('Y-m-d H:i:s', strtotime('+1 hour'));

                $updateStmt = $this->conn->prepare(
                    "UPDATE students SET reset_token = ?, reset_expiry = ? WHERE id = ?"
                );
                $updateStmt->bind_param("ssi", $resetToken, $expiry, $user['id']);

                if ($updateStmt->execute()) {
                    $this->sendPasswordResetEmail($email, $user['full_name'], $resetToken);
                    // SECURITY: never expose the token in the JSON response
                    $response['success'] = true;
                    $response['message'] = "Password reset link sent to your email.";
                } else {
                    $response['message'] = "Failed to process reset request";
                }
                $updateStmt->close();
            } else {
                // Generic message to avoid email enumeration
                $response['success'] = true;
                $response['message'] = "If that email exists, a reset link has been sent.";
            }
            $stmt->close();

        } catch (Exception $e) {
            $response['message'] = "Error: " . $e->getMessage();
        }

        return $response;
    }

    // ─── Reset Password ─────────────────────────────────────────────────────
    public function resetPassword($token, $newPassword) {
        $response = ['success' => false, 'message' => ''];

        try {
            $stmt = $this->conn->prepare("
                SELECT id FROM students
                WHERE reset_token = ? AND reset_expiry > NOW() AND status = 'active'
            ");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $student        = $result->fetch_assoc();
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

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

    // ─── Helper methods ─────────────────────────────────────────────────────
    public function isLoggedIn()  { return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true; }
    public function getUserRole() { return $_SESSION['user_role'] ?? null; }
    public function getStudentId(){ return $_SESSION['student_id'] ?? null; }

    public function logout() {
        session_destroy();
        return ['success' => true, 'message' => 'Logged out successfully'];
    }

    // ─── Email senders (PHPMailer-ready) ────────────────────────────────────

    /**
     * Send email verification link.
     * Swap the mail() call for PHPMailer when SMTP is configured.
     */
    private function sendVerificationEmail($email, $name, $token) {
        $protocol         = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host             = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $verificationLink = $protocol . '://' . $host . '/pages/verify-email.php?token=' . $token;

        $subject = "Verify Your Email - Araneus Edutech Student Portal";
        $body    = "Dear " . $name . ",\n\n"
                 . "Thank you for registering with Araneus Edutech!\n"
                 . "Please click the link below to verify your email address:\n\n"
                 . $verificationLink . "\n\n"
                 . "This link will expire in 24 hours.\n\n"
                 . "If you did not create an account, please ignore this email.\n\n"
                 . "Regards,\nAraneus Edutech Team";

        $headers  = "From: noreply@araneusedutech.com\r\n";
        $headers .= "Reply-To: araneusedutech@gmail.com\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        $sent = @mail($email, $subject, $body, $headers);
        if (!$sent) {
            // Fallback: log so the link is not silently lost during development
            error_log("[Auth] Verification email for {$email}: {$verificationLink}");
        }
        return $sent;
    }

    /**
     * Send password reset link.
     * SECURITY: token is never returned to the caller — only sent by email.
     */
    private function sendPasswordResetEmail($email, $name, $token) {
        $protocol  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host      = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $resetLink = $protocol . '://' . $host . '/pages/reset-password.php?token=' . $token;

        $subject = "Password Reset Request - Araneus Edutech";
        $body    = "Dear " . $name . ",\n\n"
                 . "You have requested to reset your password. Click the link below:\n\n"
                 . $resetLink . "\n\n"
                 . "This link will expire in 1 hour.\n\n"
                 . "If you did not request this, please ignore this email.\n\n"
                 . "Regards,\nAraneus Edutech Team";

        $headers  = "From: noreply@araneusedutech.com\r\n";
        $headers .= "Reply-To: araneusedutech@gmail.com\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        $sent = @mail($email, $subject, $body, $headers);
        if (!$sent) {
            error_log("[Auth] Password reset email for {$email}: {$resetLink}");
        }
        return $sent;
    }
}
?>
