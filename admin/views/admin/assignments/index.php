<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><i class="fa fa-pen-to-square me-2 text-warning"></i>Assignments</h5>
  <a href="<?= APP_URL ?>/admin/assignments/create" class="btn btn-primary btn-sm"><i class="fa fa-plus me-1"></i>New Assignment</a>
</div>
<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead><tr><th>Title</th><th>Course</th><th>Due Date</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
      <?php foreach($assignments as $a): $overdue=$a['due_date']&&$a['due_date']<date('Y-m-d'); ?>
      <tr>
        <td><span class="fw-semibold"><?= htmlspecialchars($a['title']) ?></span></td>
        <td><span class="badge bg-primary-subtle text-primary"><?= htmlspecialchars($a['course_title']) ?></span></td>
        <td class="small <?= $overdue?'text-danger fw-semibold':'' ?>"><?= $a['due_date']?date('d M Y',strtotime($a['due_date'])):'-' ?></td>
        <td><?= $overdue?'<span class="badge bg-danger">Overdue</span>':'<span class="badge bg-success-subtle text-success">Active</span>' ?></td>
        <td>
          <a href="<?= APP_URL ?>/admin/assignments/<?= $a['id'] ?>/edit" class="btn btn-sm btn-outline-primary btn-action"><i class="fa fa-pen"></i></a>
          <form method="POST" action="<?= APP_URL ?>/admin/assignments/<?= $a['id'] ?>/delete" class="d-inline" onsubmit="return confirm('Delete assignment?')">
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
