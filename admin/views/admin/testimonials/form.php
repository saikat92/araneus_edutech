<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><?= isset($testimonial)?'Edit Testimonial':'Add Testimonial' ?></h5>
  <a href="<?= APP_URL ?>/admin/testimonials" class="btn btn-sm btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i>Back</a>
</div>
<div class="card"><div class="card-body">
<form method="POST" action="<?= APP_URL ?>/admin/testimonials/<?= isset($testimonial)?$testimonial['id'].'/edit':'create' ?>">
  <div class="row g-3">
    <div class="col-md-4"><label class="form-label fw-semibold">Client Name *</label><input type="text" name="client_name" class="form-control" value="<?= htmlspecialchars($testimonial['client_name']??'') ?>" required></div>
    <div class="col-md-4"><label class="form-label fw-semibold">Position</label><input type="text" name="client_position" class="form-control" value="<?= htmlspecialchars($testimonial['client_position']??'') ?>"></div>
    <div class="col-md-4"><label class="form-label fw-semibold">Company</label><input type="text" name="company" class="form-control" value="<?= htmlspecialchars($testimonial['company']??'') ?>"></div>
    <div class="col-md-2"><label class="form-label fw-semibold">Rating</label>
      <select name="rating" class="form-select">
        <?php for($i=5;$i>=1;$i--): ?><option value="<?= $i ?>" <?= ($testimonial['rating']??5)==$i?'selected':'' ?>><?= $i ?> Stars</option><?php endfor; ?>
      </select></div>
    <div class="col-md-2"><label class="form-label fw-semibold">Featured</label>
      <select name="is_featured" class="form-select">
        <option value="0" <?= !($testimonial['is_featured']??0)?'selected':'' ?>>No</option>
        <option value="1" <?= ($testimonial['is_featured']??0)?'selected':'' ?>>Yes</option>
      </select></div>
    <div class="col-md-2"><label class="form-label fw-semibold">Status</label>
      <select name="status" class="form-select">
        <option value="published" <?= ($testimonial['status']??'')==='published'?'selected':'' ?>>Published</option>
        <option value="not published" <?= ($testimonial['status']??'')==='not published'?'selected':'' ?>>Hidden</option>
      </select></div>
    <div class="col-12"><label class="form-label fw-semibold">Testimonial *</label><textarea name="testimonial" class="form-control" rows="4" required><?= htmlspecialchars($testimonial['testimonial']??'') ?></textarea></div>
    <div class="col-12"><button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i>Save</button><a href="<?= APP_URL ?>/admin/testimonials" class="btn btn-outline-secondary ms-2">Cancel</a></div>
  </div>
</form>
</div></div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
