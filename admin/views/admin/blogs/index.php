<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><i class="fa fa-blog me-2 text-info"></i>Blog Posts</h5>
  <a href="<?= APP_URL ?>/admin/blogs/create" class="btn btn-primary btn-sm"><i class="fa fa-plus me-1"></i>New Post</a>
</div>
<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead><tr><th>Title</th><th>Author</th><th>Category</th><th>Status</th><th>Published</th><th>Actions</th></tr></thead>
      <tbody>
      <?php foreach($blogs as $b): ?>
      <tr>
        <td class="fw-semibold"><?= htmlspecialchars($b['title']) ?><br><small class="text-muted font-monospace">/<?= $b['slug'] ?></small></td>
        <td class="small"><?= htmlspecialchars($b['author']) ?></td>
        <td><span class="badge bg-secondary-subtle text-secondary"><?= htmlspecialchars($b['category']) ?></span></td>
        <td><span class="badge <?= $b['status']==='published'?'bg-success':'bg-warning text-dark' ?>"><?= ucfirst($b['status']) ?></span></td>
        <td class="small text-muted"><?= $b['published_date']??'-' ?></td>
        <td>
          <a href="<?= APP_URL ?>/admin/blogs/<?= $b['id'] ?>/edit" class="btn btn-sm btn-outline-primary btn-action"><i class="fa fa-pen"></i></a>
          <form method="POST" action="<?= APP_URL ?>/admin/blogs/<?= $b['id'] ?>/delete" class="d-inline" onsubmit="return confirm('Delete post?')">
            <button class="btn btn-sm btn-outline-danger btn-action"><i class="fa fa-trash"></i></button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
