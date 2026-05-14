<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= htmlspecialchars($title??'Admin') ?> — Araneus Edutech</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
:root{--sidebar-w:240px;--topbar-h:56px;--brand:#1a2744;--brand-light:#243460;--accent:#4f8ef7;}
body{background:#f0f2f7;font-size:.9rem;}
#sidebar{width:var(--sidebar-w);min-height:100vh;background:var(--brand);position:fixed;top:0;left:0;z-index:1030;display:flex;flex-direction:column;transition:transform .25s;}
#sidebar .brand{height:var(--topbar-h);background:var(--brand-light);display:flex;align-items:center;padding:0 1rem;color:#fff;font-weight:700;font-size:1rem;letter-spacing:.03em;gap:.6rem;}
#sidebar .brand span{color:var(--accent);}
.nav-section{font-size:.65rem;color:#7a8ab5;text-transform:uppercase;letter-spacing:.08em;padding:.9rem 1rem .3rem;}
#sidebar .nav-link{color:#b0bcd8;padding:.45rem 1rem;border-radius:6px;margin:.1rem .6rem;display:flex;align-items:center;gap:.6rem;font-size:.82rem;transition:background .15s,color .15s;}
#sidebar .nav-link:hover,#sidebar .nav-link.active{background:rgba(79,142,247,.18);color:#fff;}
#sidebar .nav-link i{width:18px;text-align:center;font-size:.85rem;}
#main{margin-left:var(--sidebar-w);min-height:100vh;display:flex;flex-direction:column;}
#topbar{height:var(--topbar-h);background:#fff;border-bottom:1px solid #e3e8f0;display:flex;align-items:center;padding:0 1.5rem;gap:1rem;position:sticky;top:0;z-index:1020;}
#topbar .page-title{font-weight:600;color:#1a2744;font-size:.95rem;}
.content{padding:1.5rem;flex:1;}
.card{border:none;border-radius:12px;box-shadow:0 1px 6px rgba(0,0,0,.06);}
.stat-card .icon-box{width:46px;height:46px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;}
.badge-status-active{background:#d1fae5;color:#065f46;}
.badge-status-inactive{background:#fee2e2;color:#991b1b;}
.badge-status-pending{background:#fef9c3;color:#92400e;}
.table th{font-size:.75rem;text-transform:uppercase;letter-spacing:.05em;color:#6b7280;font-weight:600;border-bottom:2px solid #e5e7eb;}
.table td{vertical-align:middle;}
.btn-action{padding:.2rem .5rem;font-size:.78rem;}
.sidebar-footer{margin-top:auto;padding:.8rem .6rem;}
@media(max-width:768px){#sidebar{transform:translateX(-100%);}#sidebar.show{transform:translateX(0);}#main{margin-left:0;}}
.flash-alert{position:fixed;top:70px;right:20px;z-index:9999;min-width:280px;animation:slideIn .3s ease;}
@keyframes slideIn{from{transform:translateX(120%);opacity:0;}to{transform:translateX(0);opacity:1;}}
</style>
</head>
<body>
<div id="sidebar">
  <div class="brand"><i class="fa-solid fa-spider"></i> Araneus <span>Admin</span></div>
  <nav class="py-2 flex-grow-1 overflow-auto">
    <div class="nav-section">Main</div>
    <a href="<?= APP_URL ?>/admin/dashboard" class="nav-link <?= strpos($_SERVER['REQUEST_URI'],'dashboard')!==false?'active':'' ?>"><i class="fa fa-gauge-high"></i> Dashboard</a>

    <div class="nav-section">Education</div>
    <a href="<?= APP_URL ?>/admin/students"    class="nav-link <?= strpos($_SERVER['REQUEST_URI'],'/students')!==false?'active':'' ?>"><i class="fa fa-user-graduate"></i> Students</a>
    <a href="<?= APP_URL ?>/admin/courses"     class="nav-link <?= strpos($_SERVER['REQUEST_URI'],'/courses')!==false?'active':'' ?>"><i class="fa fa-book-open"></i> Courses</a>
    <a href="<?= APP_URL ?>/admin/enrollments" class="nav-link <?= strpos($_SERVER['REQUEST_URI'],'/enrollments')!==false?'active':'' ?>"><i class="fa fa-list-check"></i> Enrollments</a>
    <a href="<?= APP_URL ?>/admin/assignments"  class="nav-link <?= strpos($_SERVER['REQUEST_URI'],'/assignments')!==false?'active':'' ?>"><i class="fa fa-pen-to-square"></i> Assignments</a>
    <a href="<?= APP_URL ?>/admin/submissions"  class="nav-link <?= strpos($_SERVER['REQUEST_URI'],'/submissions')!==false?'active':'' ?>"><i class="fa fa-file-arrow-up"></i> Submissions</a>
    <a href="<?= APP_URL ?>/admin/certificates" class="nav-link <?= strpos($_SERVER['REQUEST_URI'],'/certificates')!==false?'active':'' ?>"><i class="fa fa-certificate"></i> Certificates
</a>

    <div class="nav-section">Business</div>
    <a href="<?= APP_URL ?>/admin/clients"   class="nav-link <?= strpos($_SERVER['REQUEST_URI'],'/clients')!==false?'active':'' ?>"><i class="fa fa-building"></i> Clients</a>
    <a href="<?= APP_URL ?>/admin/invoices"  class="nav-link <?= strpos($_SERVER['REQUEST_URI'],'/invoices')!==false?'active':'' ?>"><i class="fa fa-file-invoice"></i> Invoices</a>
    <a href="<?= APP_URL ?>/admin/payments"  class="nav-link <?= strpos($_SERVER['REQUEST_URI'],'/payments')!==false?'active':'' ?>"><i class="fa fa-credit-card"></i> Payments</a>
    <a href="<?= APP_URL ?>/admin/accounts"  class="nav-link <?= strpos($_SERVER['REQUEST_URI'],'/accounts')!==false?'active':'' ?>"><i class="fa fa-scale-balanced"></i> Accounts</a>

    <div class="nav-section">Content</div>
    <a href="<?= APP_URL ?>/admin/blogs"          class="nav-link <?= strpos($_SERVER['REQUEST_URI'],'/blogs')!==false?'active':'' ?>"><i class="fa fa-blog"></i> Blogs</a>
    <a href="<?= APP_URL ?>/admin/events"         class="nav-link <?= strpos($_SERVER['REQUEST_URI'],'/events')!==false?'active':'' ?>"><i class="fa fa-calendar-days"></i> Events</a>
    <a href="<?= APP_URL ?>/admin/testimonials"   class="nav-link <?= strpos($_SERVER['REQUEST_URI'],'/testimonials')!==false?'active':'' ?>"><i class="fa fa-star"></i> Testimonials</a>
    <a href="<?= APP_URL ?>/admin/projects"       class="nav-link <?= strpos($_SERVER['REQUEST_URI'],'/projects')!==false?'active':'' ?>"><i class="fa fa-layer-group"></i> Projects</a>
    <a href="<?= APP_URL ?>/admin/careers"        class="nav-link <?= strpos($_SERVER['REQUEST_URI'],'/careers')!==false?'active':'' ?>"><i class="fa fa-briefcase"></i> Careers</a>
    <a href="<?= APP_URL ?>/admin/contacts"       class="nav-link <?= strpos($_SERVER['REQUEST_URI'],'/contacts')!==false?'active':'' ?>"><i class="fa fa-envelope"></i> Contacts</a>

    <div class="nav-section">System</div>
    <a href="<?= APP_URL ?>/admin/reports" class="nav-link <?= strpos($_SERVER['REQUEST_URI'],'/reports')!==false?'active':'' ?>"><i class="fa fa-chart-bar"></i> Reports</a>
    <a href="<?= APP_URL ?>/admin/users"   class="nav-link <?= strpos($_SERVER['REQUEST_URI'],'/users')!==false?'active':'' ?>"><i class="fa fa-users-gear"></i> Users</a>
    <a href="<?= APP_URL ?>/admin/settings" class="nav-link <?= strpos($_SERVER['REQUEST_URI'],'/settings')!==false?'active':'' ?>"><i class="fa fa-gear"></i> Settings</a>
  </nav>
  <div class="sidebar-footer">
    <a href="<?= APP_URL ?>/logout" class="nav-link text-danger"><i class="fa fa-right-from-bracket"></i> Logout</a>
  </div>
</div>

<div id="main">
<div id="topbar">
  <button class="btn btn-sm btn-light d-md-none" onclick="document.getElementById('sidebar').classList.toggle('show')"><i class="fa fa-bars"></i></button>
  <span class="page-title"><?= htmlspecialchars($title??'') ?></span>
  <div class="ms-auto d-flex align-items-center gap-3">
    <span class="text-muted small"><i class="fa fa-user-circle me-1"></i><?= htmlspecialchars($_SESSION['user_name']??'Admin') ?></span>
    <a href="<?= APP_URL ?>/logout" class="btn btn-sm btn-outline-danger"><i class="fa fa-right-from-bracket"></i></a>
  </div>
</div>
<?php if (!empty($_SESSION['flash'])): $f=$_SESSION['flash']; unset($_SESSION['flash']); ?>
<div class="flash-alert alert alert-<?= $f['type'] ?> alert-dismissible shadow" role="alert">
  <?= htmlspecialchars($f['message']) ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>
<div class="content">
