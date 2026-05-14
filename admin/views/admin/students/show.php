<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><?= htmlspecialchars($student['full_name']) ?></h5>
  <div class="d-flex gap-2">
    <a href="<?= APP_URL ?>/admin/students/<?= $student['id'] ?>/edit" class="btn btn-sm btn-primary"><i class="fa fa-pen me-1"></i>Edit</a>
    <a href="<?= APP_URL ?>/admin/students" class="btn btn-sm btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i>Back</a>
  </div>
</div>
<div class="row g-3">
  <div class="col-md-4">
    <div class="card">
      <div class="card-body text-center py-4">
        <?php if(!empty($student['profile_picture']) && file_exists(UPLOAD_PATH.$student['profile_picture'])): ?>
        <img src="<?= APP_URL ?>/assets/uploads/<?= $student['profile_picture'] ?>" class="rounded-circle mb-3" width="90" height="90" style="object-fit:cover">
        <?php else: ?>
        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3" style="width:80px;height:80px;font-size:2rem;color:#fff">
          <?= strtoupper(substr($student['full_name'],0,1)) ?>
        </div>
        <?php endif; ?>
        <h6 class="fw-bold mb-1"><?= htmlspecialchars($student['full_name']) ?></h6>
        <code class="small"><?= htmlspecialchars($student['candidate_id']) ?></code>
        <div class="mt-2"><span class="badge badge-status-<?= $student['status'] ?> px-3"><?= ucfirst($student['status']) ?></span></div>
      </div>
      <ul class="list-group list-group-flush small">
        <li class="list-group-item d-flex justify-content-between"><span class="text-muted">Email</span><span><?= htmlspecialchars($student['email']) ?></span></li>
        <li class="list-group-item d-flex justify-content-between"><span class="text-muted">Phone</span><span><?= htmlspecialchars($student['phone']) ?></span></li>
        <li class="list-group-item d-flex justify-content-between"><span class="text-muted">Father</span><span><?= htmlspecialchars($student['father_name']) ?></span></li>
        <li class="list-group-item d-flex justify-content-between"><span class="text-muted">Qualification</span><span><?= htmlspecialchars($student['highest_qualification']) ?></span></li>
        <li class="list-group-item d-flex justify-content-between"><span class="text-muted">Organization</span><span><?= htmlspecialchars($student['current_organization']) ?></span></li>
        <li class="list-group-item d-flex justify-content-between"><span class="text-muted">Hours</span><span><?= $student['time_hours'] ?>h</span></li>
        <?php if($student['github_link']): ?><li class="list-group-item"><a href="<?= htmlspecialchars($student['github_link']) ?>" target="_blank" class="small"><i class="fa-brands fa-github me-1"></i>GitHub</a></li><?php endif; ?>
      </ul>
    </div>
  </div>
  <div class="col-md-8">
    <!-- Enrollments -->
    <div class="card mb-3">
      <div class="card-header bg-transparent"><h6 class="mb-0 fw-semibold"><i class="fa fa-list-check me-2 text-success"></i>Enrollments</h6></div>
      <div class="table-responsive">
        <table class="table table-sm mb-0">
          <thead><tr><th>Course</th><th>Date</th><th>Status</th><th>Grade</th></tr></thead>
          <tbody>
          <?php foreach($enrollments as $e): ?>
          <tr><td><?= htmlspecialchars($e['course_title']) ?></td><td class="small"><?= $e['enrollment_date'] ?></td>
              <td><span class="badge bg-info-subtle text-info"><?= $e['status'] ?></span></td>
              <td><?= $e['grade']??'—' ?></td></tr>
          <?php endforeach; ?>
          <?php if(empty($enrollments)): ?><tr><td colspan="4" class="text-center text-muted small py-2">No enrollments</td></tr><?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- Submissions -->
    <div class="card">
      <div class="card-header bg-transparent"><h6 class="mb-0 fw-semibold"><i class="fa fa-file-arrow-up me-2 text-warning"></i>Submissions (<?= count($submissions) ?>)</h6></div>
      <div class="table-responsive">
        <table class="table table-sm mb-0">
          <thead><tr><th>Assignment</th><th>Submitted</th><th>Grade</th></tr></thead>
          <tbody>
          <?php foreach($submissions as $s): ?>
          <tr><td class="small"><?= htmlspecialchars(substr($s['assignment_title'],0,45)) ?>...</td>
              <td class="small text-muted"><?= date('d M Y',strtotime($s['submitted_at'])) ?></td>
              <td><?php if($s['grade']): ?><span class="badge bg-success-subtle text-success"><?= $s['grade'] ?></span><?php else: ?><span class="badge bg-warning-subtle text-warning">Pending</span><?php endif; ?></td>
          </tr>
          <?php endforeach; ?>
          <?php if(empty($submissions)): ?><tr><td colspan="3" class="text-center text-muted small py-2">No submissions</td></tr><?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
