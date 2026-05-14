<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><?= isset($blog)?'Edit Post':'New Blog Post' ?></h5>
  <a href="<?= APP_URL ?>/admin/blogs" class="btn btn-sm btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i>Back</a>
</div>
<div class="card"><div class="card-body">
<form method="POST" action="<?= APP_URL ?>/admin/blogs/<?= isset($blog)?$blog['id'].'/edit':'create' ?>">
  <div class="row g-3">
    <div class="col-md-8"><label class="form-label fw-semibold">Title *</label>
      <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($blog['title']??'') ?>" required></div>
    <div class="col-md-2"><label class="form-label fw-semibold">Category</label>
      <input type="text" name="category" class="form-control" value="<?= htmlspecialchars($blog['category']??'') ?>"></div>
    <div class="col-md-2"><label class="form-label fw-semibold">Status</label>
      <select name="status" class="form-select">
        <option value="draft" <?= ($blog['status']??'')==='draft'?'selected':'' ?>>Draft</option>
        <option value="published" <?= ($blog['status']??'')==='published'?'selected':'' ?>>Published</option>
      </select></div>
    <div class="col-md-4"><label class="form-label fw-semibold">Author</label>
      <input type="text" name="author" class="form-control" value="<?= htmlspecialchars($blog['author']??'') ?>"></div>
    <div class="col-12"><label class="form-label fw-semibold">Excerpt</label>
      <textarea name="excerpt" class="form-control" rows="2"><?= htmlspecialchars($blog['excerpt']??'') ?></textarea></div>
    <div class="col-12"><label class="form-label fw-semibold">Content *</label>
      <textarea name="content" class="form-control" rows="12" required><?= htmlspecialchars($blog['content']??'') ?></textarea></div>
    <div class="col-12"><button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i>Save Post</button>
      <a href="<?= APP_URL ?>/admin/blogs" class="btn btn-outline-secondary ms-2">Cancel</a></div>
  </div>
</form>
</div></div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
