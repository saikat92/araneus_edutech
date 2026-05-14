<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><i class="fa fa-building me-2 text-warning"></i>Clients <span class="badge bg-secondary ms-1"><?= $total ?></span></h5>
  <a href="<?= APP_URL ?>/admin/clients/create" class="btn btn-primary btn-sm"><i class="fa fa-plus me-1"></i>Add Client</a>
</div>
<div class="card mb-3"><div class="card-body py-2">
  <form method="GET" class="row g-2 align-items-center">
    <div class="col-md-5"><div class="input-group input-group-sm"><span class="input-group-text"><i class="fa fa-search"></i></span>
      <input type="text" name="q" class="form-control" placeholder="Name, email, phone..." value="<?= htmlspecialchars($q) ?>"></div></div>
    <div class="col-auto"><button class="btn btn-primary btn-sm">Search</button><a href="<?= APP_URL ?>/admin/clients" class="btn btn-outline-secondary btn-sm ms-1">Reset</a></div>
  </form>
</div></div>
<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead><tr><th>Name</th><th>Type</th><th>Email</th><th>Phone</th><th>City</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
      <?php foreach($clients as $c): ?>
      <tr>
        <td><a href="<?= APP_URL ?>/admin/clients/<?= $c['id'] ?>" class="fw-semibold text-decoration-none"><?= htmlspecialchars($c['client_name']) ?></a>
          <?php if($c['contact_person']): ?><br><small class="text-muted"><?= htmlspecialchars($c['contact_person']) ?></small><?php endif; ?></td>
        <td><span class="badge bg-secondary-subtle text-secondary"><?= ucfirst($c['client_type']) ?></span></td>
        <td class="small text-muted"><?= htmlspecialchars($c['email']) ?></td>
        <td class="small"><?= htmlspecialchars($c['phone']) ?></td>
        <td class="small"><?= htmlspecialchars($c['city']) ?></td>
        <td><span class="badge badge-status-<?= $c['status'] ?>"><?= ucfirst($c['status']) ?></span></td>
        <td>
          <a href="<?= APP_URL ?>/admin/clients/<?= $c['id'] ?>" class="btn btn-sm btn-outline-info btn-action"><i class="fa fa-eye"></i></a>
          <a href="<?= APP_URL ?>/admin/clients/<?= $c['id'] ?>/edit" class="btn btn-sm btn-outline-primary btn-action"><i class="fa fa-pen"></i></a>
          <form method="POST" action="<?= APP_URL ?>/admin/clients/<?= $c['id'] ?>/delete" class="d-inline" onsubmit="return confirm('Delete client?')">
            <button class="btn btn-sm btn-outline-danger btn-action"><i class="fa fa-trash"></i></button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
