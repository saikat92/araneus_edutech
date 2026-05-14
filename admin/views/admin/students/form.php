<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><?= $action==='create'?'Add Student':'Edit Student' ?></h5>
  <a href="<?= APP_URL ?>/admin/students" class="btn btn-sm btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i>Back</a>
</div>
<div class="card">
  <div class="card-body">
    <form method="POST" action="<?= APP_URL ?>/admin/students/<?= $action==='create'?'create':($student['id'].'/edit') ?>">
      <div class="row g-3">
        <div class="col-md-4"><label class="form-label fw-semibold">Candidate ID <span class="text-danger">*</span></label>
          <input type="text" name="candidate_id" class="form-control" value="<?= htmlspecialchars($student['candidate_id']??'') ?>" required></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
          <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($student['full_name']??'') ?>" required></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Father's Name</label>
          <input type="text" name="father_name" class="form-control" value="<?= htmlspecialchars($student['father_name']??'') ?>"></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
          <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($student['email']??'') ?>" required></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Phone</label>
          <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($student['phone']??'') ?>"></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Status</label>
          <select name="status" class="form-select">
            <?php foreach(['pending','active','inactive'] as $st): ?>
            <option value="<?= $st ?>" <?= ($student['status']??'')===$st?'selected':'' ?>><?= ucfirst($st) ?></option>
            <?php endforeach; ?>
          </select></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Qualification</label>
          <input type="text" name="highest_qualification" class="form-control" value="<?= htmlspecialchars($student['highest_qualification']??'') ?>"></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Organization</label>
          <input type="text" name="current_organization" class="form-control" value="<?= htmlspecialchars($student['current_organization']??'') ?>"></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Training Hours</label>
          <input type="number" name="time_hours" class="form-control" value="<?= $student['time_hours']??0 ?>"></div>
        <div class="col-md-6"><label class="form-label fw-semibold">GitHub Link</label>
          <input type="url" name="github_link" class="form-control" value="<?= htmlspecialchars($student['github_link']??'') ?>"></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Password <?= $action==='create'?'<span class="text-danger">*</span>':' (leave blank to keep)' ?></label>
          <input type="password" name="password" class="form-control" <?= $action==='create'?'required':'' ?> minlength="6"></div>
        <div class="col-12"><label class="form-label fw-semibold">Address</label>
          <textarea name="address" class="form-control" rows="2"><?= htmlspecialchars($student['address']??'') ?></textarea></div>
        <div class="col-12 d-flex gap-2">
          <button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i>Save</button>
          <a href="<?= APP_URL ?>/admin/students" class="btn btn-outline-secondary">Cancel</a>
        </div>
      </div>
    </form>
  </div>
</div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
