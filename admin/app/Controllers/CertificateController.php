<?php
namespace App\Controllers;
use App\Core\Controller;

class CertificateController extends Controller {
    public function __construct() { $this->requireAuth(); }

    public function index(): void {
        $db   = \App\Core\Database::getInstance();
        $page = max(1, (int)$this->get('page', 1));
        $limit = 15; $offset = ($page - 1) * $limit;

        $certs = $db->fetchAll("
            SELECT c.*, s.full_name, s.candidate_id, s.email
            FROM certificates c
            JOIN students s ON s.id = c.student_id
            ORDER BY c.created_at DESC
            LIMIT $limit OFFSET $offset
        ");
        $total = $db->count("SELECT COUNT(*) FROM certificates");
        $pages = ceil($total / $limit);

        $this->view('admin/certificates/index',
            compact('certs', 'total', 'pages', 'page') + ['title' => 'Certificates']);
    }

    public function create(): void {
        $db       = \App\Core\Database::getInstance();
        $students = $db->fetchAll("
            SELECT s.id, s.full_name, s.candidate_id,
                   e.id as enrollment_id, c.title as course_title,
                   e.enrollment_date, e.completion_date, s.time_hours, e.status as enroll_status
            FROM students s
            LEFT JOIN enrollments e ON e.student_id = s.id
            LEFT JOIN courses c ON c.id = e.course_id
            WHERE s.status = 'active'
            ORDER BY s.full_name
        ");
        $this->view('admin/certificates/form',
            ['title' => 'Generate Certificate', 'cert' => null, 'students' => $students]);
    }

    public function store(): void {
        $db        = \App\Core\Database::getInstance();
        $studentId = (int)$this->post('student_id');
        $student   = $db->fetch("SELECT * FROM students WHERE id=?", [$studentId]);

        if (!$student) {
            $this->setFlash('danger', 'Student not found.');
            $this->redirect('/admin/certificates/create');
        }

        // Generate Certificate ID
        $certId  = $this->generateCertId($this->post('cert_prefix', 'PP'));

        // Handle QR upload
        $qrPath = $this->handleQRUpload($certId);

        $id = $db->insert('certificates', [
            'certificate_id'   => $certId,
            'student_id'       => $studentId,
            'enrollment_id'    => (int)$this->post('enrollment_id') ?: null,
            'certificate_type' => $this->post('certificate_type', 'participation'),
            'program_name'     => trim($this->post('program_name')),
            'project_name'     => trim($this->post('project_name')),
            'start_date'       => $this->post('start_date') ?: null,
            'end_date'         => $this->post('end_date') ?: null,
            'duration'         => trim($this->post('duration')),
            'mode'             => $this->post('mode', 'Offline'),
            'director_name'    => trim($this->post('director_name', 'Shubhajit Kantossan')),
            'coordinator_name' => trim($this->post('coordinator_name', 'Mayukh Maitha')),
            'issued_date'      => date('Y-m-d'),
            'qr_code_path'     => $qrPath,
            'status'           => 'issued',
        ]);

        $this->setFlash('success', "Certificate $certId generated.");
        $this->redirect('/admin/certificates/' . $id);
    }

    public function show(string $id): void {
        $db   = \App\Core\Database::getInstance();
        $cert = $db->fetch("
            SELECT c.*, s.full_name, s.candidate_id, s.email
            FROM certificates c
            JOIN students s ON s.id = c.student_id
            WHERE c.id = ?
        ", [(int)$id]);

        if (!$cert) { $this->setFlash('danger', 'Certificate not found.'); $this->redirect('/admin/certificates'); }
        $this->view('admin/certificates/show', compact('cert') + ['title' => 'Certificate ' . $cert['certificate_id']]);
    }

    public function print(string $id): void {
        $db   = \App\Core\Database::getInstance();
        $cert = $db->fetch("
            SELECT c.*, s.full_name, s.candidate_id, s.email
            FROM certificates c
            JOIN students s ON s.id = c.student_id
            WHERE c.id = ?
        ", [(int)$id]);

        if (!$cert) die('Certificate not found.');
        // Render standalone print view (no layout)
        require APP_ROOT . '/views/admin/certificates/print.php';
        exit;
    }

    public function revoke(string $id): void {
        \App\Core\Database::getInstance()->update('certificates', ['status' => 'revoked'], 'id=?', [(int)$id]);
        $this->setFlash('success', 'Certificate revoked.');
        $this->redirect('/admin/certificates/' . $id);
    }

    public function delete(string $id): void {
        \App\Core\Database::getInstance()->delete('certificates', 'id=?', [(int)$id]);
        $this->setFlash('success', 'Certificate deleted.');
        $this->redirect('/admin/certificates');
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    private function generateCertId(string $prefix): string {
        $mon  = date('m');
        $yr   = date('y');
        $rand = mt_rand(100000, 999999);
        $id   = strtoupper($prefix) . "/$mon/$yr/$rand";
        // Ensure uniqueness
        $db = \App\Core\Database::getInstance();
        while ($db->fetch("SELECT id FROM certificates WHERE certificate_id=?", [$id])) {
            $rand = mt_rand(100000, 999999);
            $id   = strtoupper($prefix) . "/$mon/$yr/$rand";
        }
        return $id;
    }

    private function handleQRUpload(string $certId): string {
        $dir = UPLOAD_PATH . 'qrcodes/';
        if (!is_dir($dir)) mkdir($dir, 0755, true);

        // If a file was uploaded, save it
        if (!empty($_FILES['qr_image']['tmp_name']) && $_FILES['qr_image']['error'] === UPLOAD_ERR_OK) {
            $ext      = strtolower(pathinfo($_FILES['qr_image']['name'], PATHINFO_EXTENSION));
            $allowed  = ['png', 'jpg', 'jpeg'];
            if (!in_array($ext, $allowed)) {
                // Invalid type — fall through to API fallback
            } else {
                $filename = 'qr_' . preg_replace('/[^a-zA-Z0-9]/', '_', $certId) . '.' . $ext;
                $dest     = $dir . $filename;
                if (move_uploaded_file($_FILES['qr_image']['tmp_name'], $dest)) {
                    return 'qrcodes/' . $filename;
                }
            }
        }

        // No upload — fallback: fetch from free API and cache it
        $filename = 'qr_' . preg_replace('/[^a-zA-Z0-9]/', '_', $certId) . '.png';
        $dest     = $dir . $filename;
        $verifyUrl = 'https://araneus.plastwork.in/admin/verify/' . $certId;
        $apiUrl   = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&ecc=H&color=003333&bgcolor=ffffff&data='
                . urlencode($verifyUrl);
        $img = @file_get_contents($apiUrl);
        if ($img) file_put_contents($dest, $img);

        return 'qrcodes/' . $filename;
    }

    public function replaceQR(string $id): void {
        $db   = \App\Core\Database::getInstance();
        $cert = $db->fetch("SELECT * FROM certificates WHERE id=?", [(int)$id]);
        if (!$cert) { $this->redirect('/admin/certificates'); }

        $dir = UPLOAD_PATH . 'qrcodes/';
        if (!is_dir($dir)) mkdir($dir, 0755, true);

        if (!empty($_FILES['qr_image']['tmp_name']) && $_FILES['qr_image']['error'] === UPLOAD_ERR_OK) {
            $ext     = strtolower(pathinfo($_FILES['qr_image']['name'], PATHINFO_EXTENSION));
            $allowed = ['png','jpg','jpeg'];
            if (in_array($ext, $allowed)) {
                // Delete old QR file if exists
                if ($cert['qr_code_path'] && file_exists(UPLOAD_PATH . $cert['qr_code_path'])) {
                    @unlink(UPLOAD_PATH . $cert['qr_code_path']);
                }
                $filename = 'qr_' . preg_replace('/[^a-zA-Z0-9]/', '_', $cert['certificate_id']) . '.' . $ext;
                $dest     = $dir . $filename;
                if (move_uploaded_file($_FILES['qr_image']['tmp_name'], $dest)) {
                    $db->update('certificates', ['qr_code_path' => 'qrcodes/'.$filename], 'id=?', [(int)$id]);
                    $this->setFlash('success', 'QR code updated.');
                }
            }
        }
        $this->redirect('/admin/certificates/' . $id);
    }
}