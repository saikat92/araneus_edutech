<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><?= isset($enrollment)?'Edit Enrollment':'New Enrollment' ?></h5>
  <a href="<?= APP_URL ?>/admin/enrollments" class="btn btn-sm btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i>Back</a>
</div>
<div class="card"><div class="card-body">
<form method="POST" action="<?= APP_URL ?>/admin/enrollments/<?= isset($enrollment)?$enrollment['id'].'/edit':'create' ?>">
  <div class="row g-3">
    <div class="col-md-6"><label class="form-label fw-semibold">Student *</label>
      <select name="student_id" class="form-select" required>
        <option value="">Select Student...</option>
        <?php foreach($students as $s): ?>
        <option value="<?= $s['id'] ?>" <?= ($enrollment['student_id']??'')==$s['id']?'selected':'' ?>>
          <?= htmlspecialchars($s['full_name']) ?> (<?= $s['candidate_id'] ?>)
        </option>
        <?php endforeach; ?>
      </select></div>
    <div class="col-md-6"><label class="form-label fw-semibold">Course *</label>
      <select name="course_id" class="form-select" required>
        <option value="">Select Course...</option>
        <?php foreach($courses as $c): ?>
        <option value="<?= $c['id'] ?>" <?= ($enrollment['course_id']??'')==$c['id']?'selected':'' ?>><?= htmlspecialchars($c['title']) ?></option>
        <?php endforeach; ?>
      </select></div>
    <div class="col-md-4"><label class="form-label fw-semibold">Enrollment Date</label>
      <input type="date" name="enrollment_date" class="form-control" value="<?= $enrollment['enrollment_date']??date('Y-m-d') ?>"></div>
    <div class="col-md-4"><label class="form-label fw-semibold">Completion Date</label>
      <input type="date" name="completion_date" class="form-control" value="<?= $enrollment['completion_date']??'' ?>"></div>
    <div class="col-md-4"><label class="form-label fw-semibold">Status</label>
      <select name="status" class="form-select">
        <?php foreach(['enrolled','in_progress','completed','dropped'] as $st): ?>
        <option value="<?= $st ?>" <?= ($enrollment['status']??'')===$st?'selected':'' ?>><?= ucfirst(str_replace('_',' ',$st)) ?></option>
        <?php endforeach; ?>
      </select></div>
    <div class="col-md-4"><label class="form-label fw-semibold">Grade</label>
      <input type="text" name="grade" class="form-control" value="<?= htmlspecialchars($enrollment['grade']??'') ?>" placeholder="AA, AB, BB..."></div>
    <div class="col-md-4"><label class="form-label fw-semibold">Certificate Issued</label>
      <select name="certificate_issued" class="form-select">
        <option value="0" <?= !($enrollment['certificate_issued']??0)?'selected':'' ?>>No</option>
        <option value="1" <?= ($enrollment['certificate_issued']??0)?'selected':'' ?>>Yes</option>
      </select></div>
    <div class="col-12"><label class="form-label fw-semibold">Notes</label>
      <textarea name="notes" class="form-control" rows="2"><?= htmlspecialchars($enrollment['notes']??'') ?></textarea></div>
    <div class="col-12"><button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i>Save</button>
      <a href="<?= APP_URL ?>/admin/enrollments" class="btn btn-outline-secondary ms-2">Cancel</a></div>
  </div>
</form>
</div></div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
