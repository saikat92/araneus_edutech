<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<h5 class="fw-bold mb-3"><i class="fa fa-envelope me-2 text-teal"></i>Contact Submissions</h5>
<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead><tr><th>Name</th><th>Email</th><th>Subject</th><th>Date</th><th>Status</th><th>Action</th></tr></thead>
      <tbody>
      <?php foreach($contacts as $c): ?>
      <tr class="<?= $c['status']==='new'?'fw-semibold':'' ?>">
        <td><?= htmlspecialchars($c['name']) ?></td>
        <td class="small"><?= htmlspecialchars($c['email']) ?></td>
        <td class="small"><?= htmlspecialchars(substr($c['subject']??'',0,50)) ?></td>
        <td class="small text-muted"><?= date('d M Y',strtotime($c['submission_date'])) ?></td>
        <td><span class="badge <?= $c['status']==='new'?'bg-danger':($c['status']==='replied'?'bg-success':'bg-secondary') ?>"><?= $c['status'] ?></span></td>
        <td><a href="<?= APP_URL ?>/admin/contacts/<?= $c['id'] ?>" class="btn btn-sm btn-outline-primary btn-action"><i class="fa fa-eye"></i></a></td>
      </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
