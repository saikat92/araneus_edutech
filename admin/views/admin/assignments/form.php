<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><?= isset($assignment)?'Edit Assignment':'New Assignment' ?></h5>
  <a href="<?= APP_URL ?>/admin/assignments" class="btn btn-sm btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i>Back</a>
</div>
<div class="card"><div class="card-body">
<form method="POST" action="<?= APP_URL ?>/admin/assignments/<?= isset($assignment)?$assignment['id'].'/edit':'create' ?>">
  <div class="row g-3">
    <div class="col-md-8"><label class="form-label fw-semibold">Title *</label>
      <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($assignment['title']??'') ?>" required></div>
    <div class="col-md-4"><label class="form-label fw-semibold">Due Date</label>
      <input type="date" name="due_date" class="form-control" value="<?= $assignment['due_date']??'' ?>"></div>
    <div class="col-md-6"><label class="form-label fw-semibold">Course *</label>
      <select name="course_id" class="form-select" required>
        <?php foreach($courses as $c): ?>
        <option value="<?= $c['id'] ?>" <?= ($assignment['course_id']??'')==$c['id']?'selected':'' ?>><?= htmlspecialchars($c['title']) ?></option>
        <?php endforeach; ?>
      </select></div>
    <div class="col-12"><label class="form-label fw-semibold">Description</label>
      <textarea name="description" class="form-control" rows="5"><?= htmlspecialchars($assignment['description']??'') ?></textarea></div>
    <div class="col-12"><button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i>Save</button>
      <a href="<?= APP_URL ?>/admin/assignments" class="btn btn-outline-secondary ms-2">Cancel</a></div>
  </div>
</form>
</div></div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
