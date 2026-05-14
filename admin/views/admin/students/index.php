<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><i class="fa fa-user-graduate me-2 text-primary"></i>Students <span class="badge bg-secondary ms-1"><?= $total ?></span></h5>
  <a href="<?= APP_URL ?>/admin/students/create" class="btn btn-primary btn-sm"><i class="fa fa-plus me-1"></i>Add Student</a>
</div>
<div class="card mb-3">
  <div class="card-body py-2">
    <form method="GET" class="row g-2 align-items-center">
      <div class="col-md-5"><div class="input-group input-group-sm"><span class="input-group-text"><i class="fa fa-search"></i></span>
        <input type="text" name="search" class="form-control" placeholder="Name, email, ID, phone..." value="<?= htmlspecialchars($search) ?>"></div></div>
      <div class="col-md-3">
        <select name="status" class="form-select form-select-sm">
          <option value="">All Status</option>
          <?php foreach(['active','inactive','pending'] as $st): ?>
          <option value="<?= $st ?>" <?= $status===$st?'selected':'' ?>><?= ucfirst($st) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-auto"><button class="btn btn-primary btn-sm">Filter</button>
        <a href="<?= APP_URL ?>/admin/students" class="btn btn-outline-secondary btn-sm ms-1">Reset</a></div>
    </form>
  </div>
</div>
<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead><tr><th>Candidate ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Hours</th><th>Status</th><th>Joined</th><th>Actions</th></tr></thead>
      <tbody>
      <?php foreach($students as $s): ?>
      <tr>
        <td><code class="small"><?= htmlspecialchars($s['candidate_id']) ?></code></td>
        <td><a href="<?= APP_URL ?>/admin/students/<?= $s['id'] ?>" class="fw-semibold text-decoration-none"><?= htmlspecialchars($s['full_name']) ?></a></td>
        <td class="text-muted small"><?= htmlspecialchars($s['email']) ?></td>
        <td class="small"><?= htmlspecialchars($s['phone']) ?></td>
        <td><?= $s['time_hours'] ?>h</td>
        <td><span class="badge badge-status-<?= $s['status'] ?>"><?= ucfirst($s['status']) ?></span></td>
        <td class="text-muted small"><?= date('d M Y',strtotime($s['created_at'])) ?></td>
        <td>
          <a href="<?= APP_URL ?>/admin/students/<?= $s['id'] ?>" class="btn btn-sm btn-outline-info btn-action" title="View"><i class="fa fa-eye"></i></a>
          <a href="<?= APP_URL ?>/admin/students/<?= $s['id'] ?>/edit" class="btn btn-sm btn-outline-primary btn-action" title="Edit"><i class="fa fa-pen"></i></a>
          <form method="POST" action="<?= APP_URL ?>/admin/students/<?= $s['id'] ?>/delete" class="d-inline" onsubmit="return confirm('Delete this student?')">
            <button class="btn btn-sm btn-outline-danger btn-action" title="Delete"><i class="fa fa-trash"></i></button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php if(empty($students)): ?><tr><td colspan="8" class="text-center text-muted py-4">No students found</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
  <?php if($pages>1): ?>
  <div class="card-footer d-flex justify-content-between align-items-center">
    <small class="text-muted">Page <?= $page ?> of <?= $pages ?></small>
    <nav><ul class="pagination pagination-sm mb-0">
      <?php for($i=1;$i<=$pages;$i++): ?>
      <li class="page-item <?= $i===$page?'active':'' ?>">
        <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&status=<?= urlencode($status) ?>"><?= $i ?></a>
      </li><?php endfor; ?>
    </ul></nav>
  </div>
  <?php endif; ?>
</div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
