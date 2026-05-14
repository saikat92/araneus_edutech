<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0">Submission Review</h5>
  <a href="<?= APP_URL ?>/admin/submissions" class="btn btn-sm btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i>Back</a>
</div>
<div class="row g-3">
  <div class="col-md-7">
    <div class="card mb-3"><div class="card-header bg-transparent"><h6 class="mb-0 fw-semibold">Assignment</h6></div>
      <div class="card-body">
        <h6><?= htmlspecialchars($submission['assignment_title']) ?></h6>
        <span class="badge bg-primary-subtle text-primary mb-2"><?= htmlspecialchars($submission['course_title']) ?></span>
        <p class="text-muted small mb-0"><?= nl2br(htmlspecialchars($submission['assignment_desc'])) ?></p>
      </div>
    </div>
    <div class="card"><div class="card-header bg-transparent"><h6 class="mb-0 fw-semibold">Student Submission</h6></div>
      <div class="card-body">
        <?php if($submission['submission_file']): ?>
        <div class="alert alert-info small"><i class="fa fa-file me-2"></i>
          <a href="<?= APP_URL ?>/assets/uploads/<?= htmlspecialchars($submission['submission_file']) ?>" target="_blank">
            <?= htmlspecialchars($submission['submission_file']) ?>
          </a>
        </div>
        <?php else: ?><p class="text-muted small">No file submitted</p><?php endif; ?>
        <small class="text-muted">Submitted: <?= date('d M Y H:i',strtotime($submission['submitted_at'])) ?></small>
      </div>
    </div>
  </div>
  <div class="col-md-5">
    <div class="card mb-3"><div class="card-body">
      <h6 class="fw-bold"><?= htmlspecialchars($submission['full_name']) ?></h6>
      <code><?= htmlspecialchars($submission['candidate_id']) ?></code>
      <p class="text-muted small mt-1 mb-0"><?= htmlspecialchars($submission['email']) ?></p>
    </div></div>
    <div class="card"><div class="card-header bg-transparent"><h6 class="mb-0 fw-semibold"><i class="fa fa-star me-2 text-warning"></i>Grade This Submission</h6></div>
      <div class="card-body">
        <?php if($submission['grade']): ?>
        <div class="alert alert-success small mb-3"><i class="fa fa-check me-1"></i>Already graded: <strong><?= $submission['grade'] ?></strong></div>
        <?php endif; ?>
        <form method="POST" action="<?= APP_URL ?>/admin/submissions/<?= $submission['id'] ?>/grade">
          <div class="mb-3"><label class="form-label fw-semibold">Grade</label>
            <input type="text" name="grade" class="form-control" value="<?= htmlspecialchars($submission['grade']??'') ?>" placeholder="A+, AA, BB, 85%..."></div>
          <div class="mb-3"><label class="form-label fw-semibold">Feedback</label>
            <textarea name="feedback" class="form-control" rows="4"><?= htmlspecialchars($submission['feedback']??'') ?></textarea></div>
          <button type="submit" class="btn btn-success w-100"><i class="fa fa-check me-1"></i>Submit Grade</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
