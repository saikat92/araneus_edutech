<!DOCTYPE html><html lang="en"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Login — Araneus Edutech Admin</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
body{background:linear-gradient(135deg,#1a2744 0%,#243460 100%);min-height:100vh;display:flex;align-items:center;justify-content:center;}
.login-card{background:#fff;border-radius:16px;padding:2.5rem;max-width:420px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,.3);}
.brand-icon{width:60px;height:60px;background:linear-gradient(135deg,#4f8ef7,#1a2744);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;}
</style></head><body>
<div class="login-card">
  <div class="text-center mb-4">
    <div class="brand-icon"><i class="fa-solid fa-spider text-white fa-xl"></i></div>
    <h4 class="fw-bold text-dark mb-0">Araneus Admin</h4>
    <p class="text-muted small mt-1">Sign in to your dashboard</p>
  </div>
  <?php if (!empty($error)): ?>
  <div class="alert alert-danger py-2 small"><i class="fa fa-triangle-exclamation me-1"></i><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <?php if (!empty($_SESSION['flash'])): $f=$_SESSION['flash'];unset($_SESSION['flash']); ?>
  <div class="alert alert-<?= $f['type'] ?> py-2 small"><?= htmlspecialchars($f['message']) ?></div>
  <?php endif; ?>
  <form method="POST" action="<?= APP_URL ?>/login">
    <div class="mb-3">
      <label class="form-label fw-semibold">Username</label>
      <div class="input-group"><span class="input-group-text"><i class="fa fa-user"></i></span>
      <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($old['username']??'') ?>" autofocus required></div>
    </div>
    <div class="mb-4">
      <label class="form-label fw-semibold">Password</label>
      <div class="input-group"><span class="input-group-text"><i class="fa fa-lock"></i></span>
      <input type="password" name="password" class="form-control" required></div>
    </div>
    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
      <i class="fa fa-right-to-bracket me-2"></i>Sign In
    </button>
  </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body></html>
