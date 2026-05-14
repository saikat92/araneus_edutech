<!DOCTYPE html><html lang="en"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Setup Admin — Araneus Edutech</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
body{background:linear-gradient(135deg,#1a2744 0%,#243460 100%);min-height:100vh;display:flex;align-items:center;justify-content:center;}
.setup-card{background:#fff;border-radius:16px;padding:2.5rem;max-width:480px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,.3);}
.brand-icon{width:60px;height:60px;background:linear-gradient(135deg,#4f8ef7,#1a2744);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;}
</style></head><body>
<div class="setup-card">
  <div class="text-center mb-4">
    <div class="brand-icon"><i class="fa-solid fa-spider text-white fa-xl"></i></div>
    <h4 class="fw-bold text-dark mb-0">Create Admin Account</h4>
    <p class="text-muted small mt-1">One-time setup for Araneus Edutech Admin</p>
  </div>
  <?php if (!empty($errors)): foreach($errors as $e): ?>
  <div class="alert alert-danger py-2 small"><?= htmlspecialchars($e) ?></div>
  <?php endforeach; endif; ?>
  <form method="POST" action="<?= APP_URL ?>/setup">
    <div class="mb-3">
      <label class="form-label fw-semibold">Full Name</label>
      <div class="input-group"><span class="input-group-text"><i class="fa fa-user"></i></span>
      <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($old['full_name']??'') ?>" required></div>
    </div>
    <div class="mb-3">
      <label class="form-label fw-semibold">Username</label>
      <div class="input-group"><span class="input-group-text"><i class="fa fa-at"></i></span>
      <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($old['username']??'') ?>" required></div>
    </div>
    <div class="mb-3">
      <label class="form-label fw-semibold">Email</label>
      <div class="input-group"><span class="input-group-text"><i class="fa fa-envelope"></i></span>
      <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($old['email']??'') ?>" required></div>
    </div>
    <div class="mb-3">
      <label class="form-label fw-semibold">Password</label>
      <div class="input-group"><span class="input-group-text"><i class="fa fa-lock"></i></span>
      <input type="password" name="password" class="form-control" required minlength="6"></div>
    </div>
    <div class="mb-4">
      <label class="form-label fw-semibold">Confirm Password</label>
      <div class="input-group"><span class="input-group-text"><i class="fa fa-lock"></i></span>
      <input type="password" name="confirm_password" class="form-control" required></div>
    </div>
    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
      <i class="fa fa-shield-halved me-2"></i>Create Admin Account
    </button>
  </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body></html>
