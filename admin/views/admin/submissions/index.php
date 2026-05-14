<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><i class="fa fa-file-arrow-up me-2 text-info"></i>Submissions</h5>
</div>
<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead><tr><th>Student</th><th>Assignment</th><th>Course</th><th>Submitted</th><th>Grade</th><th>Action</th></tr></thead>
      <tbody>
      <?php foreach($submissions as $s): ?>
      <tr>
        <td class="fw-semibold"><?= htmlspecialchars($s['full_name']) ?><br><code class="small"><?= $s['candidate_id'] ?></code></td>
        <td class="small"><?= htmlspecialchars(substr($s['assignment_title'],0,40)) ?>...</td>
        <td><span class="badge bg-primary-subtle text-primary small"><?= htmlspecialchars($s['course_title']) ?></span></td>
        <td class="small text-muted"><?= date('d M Y H:i',strtotime($s['submitted_at'])) ?></td>
        <td><?php if($s['grade']): ?><span class="badge bg-success"><?= htmlspecialchars($s['grade']) ?></span><?php else: ?><span class="badge bg-warning text-dark">Pending</span><?php endif; ?></td>
        <td><a href="<?= APP_URL ?>/admin/submissions/<?= $s['id'] ?>" class="btn btn-sm btn-outline-primary btn-action"><i class="fa fa-eye"></i> Review</a></td>
      </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
