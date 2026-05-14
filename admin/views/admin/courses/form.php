<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><?= isset($course)?'Edit Course':'Add Course' ?></h5>
  <a href="<?= APP_URL ?>/admin/courses" class="btn btn-sm btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i>Back</a>
</div>
<div class="card"><div class="card-body">
<form method="POST" action="<?= APP_URL ?>/admin/courses/<?= isset($course)?$course['id'].'/edit':'create' ?>">
  <div class="row g-3">
    <div class="col-md-8"><label class="form-label fw-semibold">Title *</label>
      <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($course['title']??'') ?>" required></div>
    <div class="col-md-4"><label class="form-label fw-semibold">Category</label>
      <input type="text" name="category" class="form-control" value="<?= htmlspecialchars($course['category']??'') ?>"></div>
    <div class="col-12"><label class="form-label fw-semibold">Description</label>
      <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($course['description']??'') ?></textarea></div>
    <div class="col-md-3"><label class="form-label fw-semibold">Duration</label>
      <input type="text" name="duration" class="form-control" value="<?= htmlspecialchars($course['duration']??'') ?>" placeholder="e.g. 60 Hours"></div>
    <div class="col-md-3"><label class="form-label fw-semibold">Mode</label>
      <select name="mode" class="form-select">
        <?php foreach(['Online','Offline','Hybrid'] as $m): ?>
        <option value="<?= $m ?>" <?= ($course['mode']??'')===$m?'selected':'' ?>><?= $m ?></option>
        <?php endforeach; ?>
      </select></div>
    <div class="col-md-3"><label class="form-label fw-semibold">Fee (₹)</label>
      <input type="number" name="fee" class="form-control" step="0.01" value="<?= $course['fee']??0 ?>"></div>
    <div class="col-md-3"><label class="form-label fw-semibold">Instructor</label>
      <input type="text" name="instructor" class="form-control" value="<?= htmlspecialchars($course['instructor']??'') ?>"></div>
    <div class="col-md-6"><label class="form-label fw-semibold">Program Format</label>
      <input type="text" name="program_format" class="form-control" value="<?= htmlspecialchars($course['program_format']??'') ?>"></div>
    <div class="col-md-6"><label class="form-label fw-semibold">Certification Type</label>
      <input type="text" name="certification_type" class="form-control" value="<?= htmlspecialchars($course['certification_type']??'') ?>"></div>
    <div class="col-12"><label class="form-label fw-semibold">Tools Provided</label>
      <textarea name="tools_provided" class="form-control" rows="2"><?= htmlspecialchars($course['tools_provided']??'') ?></textarea></div>
    <div class="col-md-4"><label class="form-label fw-semibold">Status</label>
      <select name="is_active" class="form-select">
        <option value="1" <?= ($course['is_active']??1)?'selected':'' ?>>Active</option>
        <option value="0" <?= !($course['is_active']??1)?'selected':'' ?>>Inactive</option>
      </select></div>
    <div class="col-12"><button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i>Save Course</button>
      <a href="<?= APP_URL ?>/admin/courses" class="btn btn-outline-secondary ms-2">Cancel</a></div>
  </div>
</form>
</div></div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
