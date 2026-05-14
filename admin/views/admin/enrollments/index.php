<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><i class="fa fa-list-check me-2 text-success"></i>Enrollments <span class="badge bg-secondary ms-1"><?= $total ?></span></h5>
  <a href="<?= APP_URL ?>/admin/enrollments/create" class="btn btn-primary btn-sm"><i class="fa fa-plus me-1"></i>New Enrollment</a>
</div>
<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead><tr><th>Student</th><th>Candidate ID</th><th>Course</th><th>Date</th><th>Status</th><th>Grade</th><th>Actions</th></tr></thead>
      <tbody>
      <?php foreach($enrollments as $e): ?>
      <tr>
        <td class="fw-semibold"><?= htmlspecialchars($e['full_name']) ?></td>
        <td><code class="small"><?= htmlspecialchars($e['candidate_id']) ?></code></td>
        <td class="small"><?= htmlspecialchars($e['course_title']) ?></td>
        <td class="small text-muted"><?= $e['enrollment_date'] ?></td>
        <td><span class="badge bg-info-subtle text-info"><?= $e['status'] ?></span></td>
        <td><?= $e['grade']??'—' ?></td>
        <td>
          <a href="<?= APP_URL ?>/admin/enrollments/<?= $e['id'] ?>/edit" class="btn btn-sm btn-outline-primary btn-action"><i class="fa fa-pen"></i></a>
          <form method="POST" action="<?= APP_URL ?>/admin/enrollments/<?= $e['id'] ?>/delete" class="d-inline" onsubmit="return confirm('Remove enrollment?')">
            <button class="btn btn-sm btn-outline-danger btn-action"><i class="fa fa-trash"></i></button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php if(empty($enrollments)): ?><tr><td colspan="7" class="text-center text-muted py-4">No enrollments</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
  <?php if($pages>1): ?>
  <div class="card-footer"><nav><ul class="pagination pagination-sm mb-0">
    <?php for($i=1;$i<=$pages;$i++): ?><li class="page-item <?= $i===$page?'active':'' ?>"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li><?php endfor; ?>
  </ul></nav></div>
  <?php endif; ?>
</div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
