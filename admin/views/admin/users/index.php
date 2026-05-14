<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><i class="fa fa-users-gear me-2 text-primary"></i>Admin Users</h5>
  <a href="<?= APP_URL ?>/admin/users/create" class="btn btn-primary btn-sm"><i class="fa fa-plus me-1"></i>New User</a>
</div>
<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead><tr><th>Name</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th><th>Last Login</th><th>Actions</th></tr></thead>
      <tbody>
      <?php foreach($users as $u): ?>
      <tr>
        <td class="fw-semibold"><?= htmlspecialchars($u['full_name']) ?></td>
        <td><code><?= htmlspecialchars($u['username']) ?></code></td>
        <td class="small text-muted"><?= htmlspecialchars($u['email']) ?></td>
        <td><span class="badge <?= $u['role']==='admin'?'bg-danger':'bg-info' ?>"><?= ucfirst($u['role']) ?></span></td>
        <td><span class="badge badge-status-<?= $u['status'] ?>"><?= ucfirst($u['status']) ?></span></td>
        <td class="small text-muted"><?= $u['last_login']?date('d M Y H:i',strtotime($u['last_login'])):'Never' ?></td>
        <td>
          <a href="<?= APP_URL ?>/admin/users/<?= $u['id'] ?>/edit" class="btn btn-sm btn-outline-primary btn-action"><i class="fa fa-pen"></i></a>
          <?php if($u['id']!==$_SESSION['user_id']): ?>
          <form method="POST" action="<?= APP_URL ?>/admin/users/<?= $u['id'] ?>/delete" class="d-inline" onsubmit="return confirm('Delete user?')">
            <button class="btn btn-sm btn-outline-danger btn-action"><i class="fa fa-trash"></i></button>
          </form>
          <?php endif; ?>
        </td>
      </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
