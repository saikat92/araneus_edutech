<?php
require_once '../controller/Auth.php';
require_once '../controller/StudentController.php';

$auth    = new Auth();
$student = new StudentController();

if (!$auth->isLoggedIn() || $auth->getUserRole() !== 'student') {
    header("Location: ../pages/login.php");
    exit();
}

$db   = new Database();
$conn = $db->getConnection();

$studentId   = $auth->getStudentId();
$studentData = $student->getStudentById($studentId);

// Enrollments
$enrollmentStmt = $conn->prepare("
    SELECT e.*, c.title AS course_name
    FROM enrollments e
    LEFT JOIN courses c ON e.course_id = c.id
    WHERE e.student_id = ?
    ORDER BY e.enrollment_date DESC
");
$enrollmentStmt->bind_param("i", $studentId);
$enrollmentStmt->execute();
$enrollments = $enrollmentStmt->get_result();
$enrollmentStmt->close();

// Certificates count
$certStmt = $conn->prepare("SELECT COUNT(*) as cert_count FROM enrollments WHERE student_id = ? AND certificate_issued = 1");
$certStmt->bind_param("i", $studentId);
$certStmt->execute();
$certCount = $certStmt->get_result()->fetch_assoc()['cert_count'];
$certStmt->close();

// Pending assignments
$assignStmt = $conn->prepare("
    SELECT COUNT(*) as pending
    FROM assignments a
    LEFT JOIN submissions s ON a.id = s.assignment_id AND s.student_id = ?
    WHERE a.due_date >= CURDATE() AND s.id IS NULL
");
$assignStmt->bind_param("i", $studentId);
$assignStmt->execute();
$pendingAssignments = $assignStmt->get_result()->fetch_assoc()['pending'] ?? 0;
$assignStmt->close();

// Active page detection for nav highlight
$currentPage = basename($_SERVER['PHP_SELF']);

function portalNavActive($page) {
    global $currentPage;
    return $currentPage === $page ? 'active' : '';
}

// Avatar URL helper
function avatarUrl($studentData) {
    if (!empty($studentData['profile_picture'])) {
        return SITE_URL . 'uploads/profile_pictures/' . htmlspecialchars($studentData['profile_picture']);
    }
    return null;
}

function studentInitials($name) {
    $parts = explode(' ', trim($name));
    return strtoupper(substr($parts[0],0,1) . (isset($parts[1]) ? substr($parts[1],0,1) : ''));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Araneus Portal – <?php echo htmlspecialchars($page_title ?? 'Student Portal'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/css/style.css">
    <link rel="icon" type="image/x-icon" href="<?php echo SITE_URL; ?>assets/images/icon.png">
    <style>
        /* ══ PORTAL LAYOUT ══════════════════════════════════════════ */
        :root {
            --portal-sidebar-width: 240px;
            --portal-topbar-height: 60px;
            --portal-bg: #f0f2f5;
            --portal-card-radius: 14px;
            --portal-primary: #ff4000;
            --portal-secondary: #ffa900;
            --portal-gradient: linear-gradient(135deg, #ff4000 0%, #ffa900 100%);
            --portal-sidebar-bg: #1a1a2e;
            --portal-sidebar-active: rgba(255,64,0,.15);
            --portal-sidebar-text: rgba(255,255,255,.7);
            --portal-shadow: 0 2px 16px rgba(0,0,0,.07);
        }

        * { box-sizing: border-box; }
        body { background: var(--portal-bg); font-family: 'Poppins', sans-serif; margin: 0; padding: 0; }

        /* ── Sidebar ── */
        .portal-sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--portal-sidebar-width);
            background: var(--portal-sidebar-bg);
            display: flex; flex-direction: column;
            z-index: 1000;
            transition: transform .28s cubic-bezier(.4,0,.2,1);
            overflow-y: auto;
            scrollbar-width: none;
        }
        .portal-sidebar::-webkit-scrollbar { display: none; }

        .sidebar-brand {
            display: flex; align-items: center; gap: 10px;
            padding: 20px 18px 16px;
            border-bottom: 1px solid rgba(255,255,255,.07);
            text-decoration: none;
        }
        .sidebar-brand img { width: 34px; height: 34px; object-fit: contain; flex-shrink: 0; }
        .sidebar-brand-name { font-family: 'Montserrat', sans-serif; font-weight: 800; font-size: .95rem;
            background: var(--portal-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .sidebar-brand-sub  { font-size: .6rem; color: rgba(255,255,255,.4); letter-spacing: .06em; text-transform: uppercase; display: block; margin-top: -2px; }

        /* Student mini-card */
        .sidebar-user {
            display: flex; align-items: center; gap: 10px;
            padding: 14px 18px;
            border-bottom: 1px solid rgba(255,255,255,.07);
            margin-bottom: 8px;
        }
        .sidebar-avatar {
            width: 38px; height: 38px; border-radius: 50%; flex-shrink: 0;
            object-fit: cover;
            background: var(--portal-gradient);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: .82rem;
            overflow: hidden;
        }
        .sidebar-user-name  { font-size: .82rem; font-weight: 600; color: #fff; line-height: 1.3; }
        .sidebar-user-id    { font-size: .68rem; color: rgba(255,255,255,.4); }

        /* Nav groups */
        .sidebar-section-label {
            font-size: .62rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase;
            color: rgba(255,255,255,.3); padding: 8px 18px 4px;
        }

        .sidebar-nav { list-style: none; padding: 0 10px; margin: 0 0 6px; }
        .sidebar-nav li a {
            display: flex; align-items: center; gap: 11px;
            padding: 9px 12px; border-radius: 8px;
            color: var(--portal-sidebar-text);
            font-size: .82rem; font-weight: 500;
            text-decoration: none; transition: all .18s;
            position: relative;
        }
        .sidebar-nav li a i { width: 18px; text-align: center; font-size: .85rem; flex-shrink: 0; }
        .sidebar-nav li a:hover { background: rgba(255,255,255,.06); color: #fff; }
        .sidebar-nav li a.active {
            background: var(--portal-sidebar-active);
            color: #fff;
            font-weight: 600;
        }
        .sidebar-nav li a.active::before {
            content: '';
            position: absolute; left: 0; top: 20%; bottom: 20%;
            width: 3px; border-radius: 2px;
            background: var(--portal-gradient);
        }
        .sidebar-nav li a.active i { color: var(--portal-primary); }

        /* Badge on nav */
        .nav-badge {
            margin-left: auto;
            font-size: .65rem; font-weight: 700;
            background: var(--portal-primary); color: #fff;
            border-radius: 10px; padding: 1px 7px; min-width: 20px; text-align: center;
        }

        .sidebar-footer {
            margin-top: auto;
            border-top: 1px solid rgba(255,255,255,.07);
            padding: 12px 10px;
        }
        .sidebar-footer a {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px; border-radius: 8px;
            color: rgba(255,255,255,.5); font-size: .82rem;
            text-decoration: none; transition: all .18s;
        }
        .sidebar-footer a:hover { background: rgba(255,64,0,.12); color: #ff6a3d; }

        /* ── Topbar ── */
        .portal-topbar {
            position: fixed; top: 0;
            left: var(--portal-sidebar-width); right: 0;
            height: var(--portal-topbar-height);
            background: #fff;
            border-bottom: 1px solid rgba(0,0,0,.06);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 24px;
            z-index: 900;
            box-shadow: var(--portal-shadow);
        }

        .topbar-left { display: flex; align-items: center; gap: 14px; }
        .topbar-hamburger {
            display: none;
            background: none; border: none; padding: 6px 8px;
            border-radius: 8px; cursor: pointer; color: #555;
            font-size: 1.1rem;
        }
        .topbar-page-title { font-size: .95rem; font-weight: 700; color: #1a1a2e; }

        .topbar-right { display: flex; align-items: center; gap: 12px; }

        .topbar-icon-btn {
            position: relative;
            width: 36px; height: 36px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            background: #f5f5f5; border: none; cursor: pointer;
            color: #555; font-size: .9rem; transition: all .18s;
            text-decoration: none;
        }
        .topbar-icon-btn:hover { background: rgba(255,64,0,.08); color: var(--portal-primary); }
        .topbar-notif-dot {
            position: absolute; top: 5px; right: 5px;
            width: 8px; height: 8px; border-radius: 50%;
            background: var(--portal-primary); border: 2px solid #fff;
        }

        /* Topbar avatar dropdown */
        .topbar-avatar-wrap { position: relative; }
        .topbar-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            object-fit: cover; cursor: pointer;
            background: var(--portal-gradient);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: .78rem;
            border: 2px solid rgba(255,64,0,.25);
            overflow: hidden;
        }

        /* ── Main content ── */
        .portal-main {
            margin-left: var(--portal-sidebar-width);
            padding-top: var(--portal-topbar-height);
            min-height: 100vh;
        }
        .portal-content { padding: 24px; }

        /* ── Cards ── */
        .p-card {
            background: #fff;
            border-radius: var(--portal-card-radius);
            box-shadow: var(--portal-shadow);
            border: none;
            overflow: hidden;
        }
        .p-card-header {
            padding: 16px 20px;
            border-bottom: 1px solid rgba(0,0,0,.05);
            display: flex; align-items: center; justify-content: space-between;
            background: #fff;
        }
        .p-card-header h5 { font-size: .9rem; font-weight: 700; margin: 0; color: #1a1a2e; }
        .p-card-body { padding: 20px; }

        /* ── Stat cards ── */
        .stat-tile {
            background: #fff;
            border-radius: var(--portal-card-radius);
            padding: 20px;
            box-shadow: var(--portal-shadow);
            display: flex; align-items: center; gap: 16px;
            transition: transform .22s, box-shadow .22s;
        }
        .stat-tile:hover { transform: translateY(-3px); box-shadow: 0 8px 28px rgba(0,0,0,.1); }
        .stat-tile-icon {
            width: 52px; height: 52px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; flex-shrink: 0;
        }
        .stat-tile-num  { font-size: 1.7rem; font-weight: 800; line-height: 1; margin-bottom: 3px; }
        .stat-tile-label { font-size: .75rem; color: #888; font-weight: 500; }

        /* ── Breadcrumb ── */
        .portal-breadcrumb {
            font-size: .78rem; color: #888;
            display: flex; align-items: center; gap: 6px;
            margin-bottom: 20px;
        }
        .portal-breadcrumb a { color: #888; text-decoration: none; }
        .portal-breadcrumb a:hover { color: var(--portal-primary); }
        .portal-breadcrumb .sep { color: #ccc; }
        .portal-breadcrumb .current { color: #333; font-weight: 500; }

        /* ── Tabs ── */
        .portal-tabs .nav-link {
            font-size: .82rem; font-weight: 600; color: #888;
            border: none; border-bottom: 2px solid transparent;
            padding: 10px 16px; background: none; border-radius: 0;
        }
        .portal-tabs .nav-link.active { color: var(--portal-primary); border-bottom-color: var(--portal-primary); }
        .portal-tabs .nav-link:hover { color: #333; }

        /* ── Overlay for mobile sidebar ── */
        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.4); z-index: 999;
        }
        .sidebar-overlay.active { display: block; }

        /* ── Responsive ── */
        @media (max-width: 991px) {
            .portal-sidebar {
                transform: translateX(-100%);
            }
            .portal-sidebar.open {
                transform: translateX(0);
            }
            .portal-topbar { left: 0; }
            .portal-main   { margin-left: 0; }
            .topbar-hamburger { display: flex; }
            .portal-content { padding: 16px; }
        }
        @media (max-width: 575px) {
            .portal-content { padding: 12px; }
            .stat-tile { padding: 14px; gap: 12px; }
            .stat-tile-num { font-size: 1.4rem; }
        }
    </style>
</head>
<body>

<!-- ══ SIDEBAR ══════════════════════════════════════════════ -->
<aside class="portal-sidebar" id="portalSidebar">

    <!-- Brand -->
    <a class="sidebar-brand" href="dashboard.php">
        <img src="<?= SITE_URL ?>assets/images/icon.png" alt="Araneus">
        <div>
            <div class="sidebar-brand-name">ARANEUS</div>
            <span class="sidebar-brand-sub">Student Portal</span>
        </div>
    </a>

    <!-- Student mini-card -->
    <div class="sidebar-user">
        <?php $avatarUrl = avatarUrl($studentData); ?>
        <div class="sidebar-avatar">
            <?php if ($avatarUrl): ?>
                <img src="<?= $avatarUrl ?>" alt="avatar" style="width:100%;height:100%;object-fit:cover;">
            <?php else: ?>
                <?= studentInitials($studentData['full_name']) ?>
            <?php endif; ?>
        </div>
        <div>
            <div class="sidebar-user-name"><?= htmlspecialchars(explode(' ', $studentData['full_name'])[0]) ?></div>
            <div class="sidebar-user-id"><?= htmlspecialchars($studentData['candidate_id']) ?></div>
        </div>
    </div>

    <!-- Main nav -->
    <div class="sidebar-section-label">Main</div>
    <ul class="sidebar-nav">
        <li><a href="dashboard.php" class="<?= portalNavActive('dashboard.php') ?>">
            <i class="fas fa-th-large"></i> Dashboard
        </a></li>
        <li><a href="courses.php" class="<?= portalNavActive('courses.php') ?>">
            <i class="fas fa-book-open"></i> My Courses
        </a></li>
        <li><a href="assignments.php" class="<?= portalNavActive('assignments.php') ?>">
            <i class="fas fa-tasks"></i> Assignments
            <?php if ($pendingAssignments > 0): ?><span class="nav-badge"><?= $pendingAssignments ?></span><?php endif; ?>
        </a></li>
        <li><a href="grades.php" class="<?= portalNavActive('grades.php') ?>">
            <i class="fas fa-chart-bar"></i> Grades
        </a></li>
    </ul>

    <div class="sidebar-section-label">Profile</div>
    <ul class="sidebar-nav">
        <li><a href="certificates.php" class="<?= portalNavActive('certificates.php') ?>">
            <i class="fas fa-certificate"></i> Certificates
            <?php if ($certCount > 0): ?><span class="nav-badge"><?= $certCount ?></span><?php endif; ?>
        </a></li>
        <li><a href="profile.php" class="<?= portalNavActive('profile.php') ?>">
            <i class="fas fa-user-circle"></i> My Profile
        </a></li>
    </ul>

    <div class="sidebar-section-label">Support</div>
    <ul class="sidebar-nav">
        <li><a href="<?= SITE_URL ?>pages/contact.php">
            <i class="fas fa-headset"></i> Contact Support
        </a></li>
        <li><a href="<?= SITE_URL ?>">
            <i class="fas fa-globe"></i> Main Website
        </a></li>
    </ul>

    <!-- Logout at bottom -->
    <div class="sidebar-footer">
        <a href="logout.php">
            <i class="fas fa-sign-out-alt"></i> Sign Out
        </a>
    </div>
</aside>

<!-- Overlay for mobile -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ══ TOPBAR ════════════════════════════════════════════════ -->
<header class="portal-topbar">
    <div class="topbar-left">
        <button class="topbar-hamburger" id="hamburgerBtn">
            <i class="fas fa-bars"></i>
        </button>
        <span class="topbar-page-title"><?= htmlspecialchars($page_title ?? 'Dashboard') ?></span>
    </div>
    <div class="topbar-right">
        <!-- Notifications -->
        <a href="assignments.php" class="topbar-icon-btn" title="Pending assignments">
            <i class="fas fa-bell"></i>
            <?php if ($pendingAssignments > 0): ?><span class="topbar-notif-dot"></span><?php endif; ?>
        </a>
        <!-- Profile dropdown -->
        <div class="dropdown topbar-avatar-wrap">
            <button class="topbar-avatar dropdown-toggle" style="border:none;" data-bs-toggle="dropdown" aria-expanded="false">
                <?php if ($avatarUrl): ?>
                    <img src="<?= $avatarUrl ?>" alt="avatar" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                <?php else: ?>
                    <?= studentInitials($studentData['full_name']) ?>
                <?php endif; ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius:12px;min-width:200px;padding:8px;">
                <li class="px-3 py-2 border-bottom mb-1">
                    <div class="fw-bold small"><?= htmlspecialchars($studentData['full_name']) ?></div>
                    <div class="text-muted" style="font-size:.75rem;"><?= htmlspecialchars($studentData['email']) ?></div>
                </li>
                <li><a class="dropdown-item rounded" href="profile.php" style="font-size:.83rem;padding:8px 12px;">
                    <i class="fas fa-user me-2 text-muted"></i>My Profile</a></li>
                <li><a class="dropdown-item rounded" href="dashboard.php" style="font-size:.83rem;padding:8px 12px;">
                    <i class="fas fa-th-large me-2 text-muted"></i>Dashboard</a></li>
                <li><hr class="dropdown-divider my-1"></li>
                <li><a class="dropdown-item rounded text-danger" href="logout.php" style="font-size:.83rem;padding:8px 12px;">
                    <i class="fas fa-sign-out-alt me-2"></i>Sign Out</a></li>
            </ul>
        </div>
    </div>
</header>

<!-- ══ MAIN CONTENT WRAPPER ════════════════════════════════ -->
<main class="portal-main">
<div class="portal-content">

<script>
// Sidebar toggle
document.addEventListener('DOMContentLoaded', function() {
    var sidebar  = document.getElementById('portalSidebar');
    var overlay  = document.getElementById('sidebarOverlay');
    var hamburger = document.getElementById('hamburgerBtn');
    hamburger.addEventListener('click', function() {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('active');
    });
    overlay.addEventListener('click', function() {
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
    });
});
</script>
