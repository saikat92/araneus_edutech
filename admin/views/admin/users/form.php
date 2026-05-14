<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><?= isset($user)?'Edit User':'New User' ?></h5>
  <a href="<?= APP_URL ?>/admin/users" class="btn btn-sm btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i>Back</a>
</div>
<div class="card"><div class="card-body" style="max-width:550px">
<form method="POST" action="<?= APP_URL ?>/admin/users/<?= isset($user)?$user['id'].'/edit':'create' ?>">
  <div class="row g-3">
    <div class="col-md-6"><label class="form-label fw-semibold">Full Name *</label><input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($user['full_name']??'') ?>" required></div>
    <div class="col-md-6"><label class="form-label fw-semibold">Username</label><input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']??'') ?>" <?= !isset($user)?'required':'' ?>></div>
    <div class="col-md-6"><label class="form-label fw-semibold">Email *</label><input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']??'') ?>" required></div>
    <div class="col-md-6"><label class="form-label fw-semibold">Role</label>
      <select name="role" class="form-select">
        <option value="staff" <?= ($user['role']??'')==='staff'?'selected':'' ?>>Staff</option>
        <option value="admin" <?= ($user['role']??'')==='admin'?'selected':'' ?>>Admin</option>
      </select></div>
    <div class="col-md-6"><label class="form-label fw-semibold">Status</label>
      <select name="status" class="form-select">
        <option value="active" <?= ($user['status']??'')==='active'?'selected':'' ?>>Active</option>
        <option value="inactive" <?= ($user['status']??'')==='inactive'?'selected':'' ?>>Inactive</option>
      </select></div>
    <div class="col-12"><label class="form-label fw-semibold">Password <?= isset($user)?'(leave blank to keep)':'*' ?></label>
      <input type="password" name="password" class="form-control" <?= !isset($user)?'required':'' ?> minlength="6"></div>
    <div class="col-12"><button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i>Save</button>
      <a href="<?= APP_URL ?>/admin/users" class="btn btn-outline-secondary ms-2">Cancel</a></div>
  </div>
</form>
</div></div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
