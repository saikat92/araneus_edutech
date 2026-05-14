<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><i class="fa fa-book-open me-2 text-primary"></i>Courses</h5>
  <a href="<?= APP_URL ?>/admin/courses/create" class="btn btn-primary btn-sm"><i class="fa fa-plus me-1"></i>Add Course</a>
</div>
<div class="row g-3">
<?php foreach($courses as $c): ?>
<div class="col-md-6 col-xl-4">
  <div class="card h-100">
    <?php if($c['image_url']): ?><img src="<?= htmlspecialchars($c['image_url']) ?>" class="card-img-top" style="height:140px;object-fit:cover"><?php endif; ?>
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-start mb-2">
        <span class="badge bg-primary-subtle text-primary"><?= htmlspecialchars($c['category']) ?></span>
        <span class="badge <?= $c['is_active']?'bg-success-subtle text-success':'bg-danger-subtle text-danger' ?>"><?= $c['is_active']?'Active':'Inactive' ?></span>
      </div>
      <h6 class="fw-bold"><?= htmlspecialchars($c['title']) ?></h6>
      <p class="text-muted small mb-2"><?= htmlspecialchars(substr($c['description']??'',0,80)) ?>...</p>
      <div class="row g-1 small text-muted mb-3">
        <div class="col-6"><i class="fa fa-clock me-1"></i><?= htmlspecialchars($c['duration']) ?></div>
        <div class="col-6"><i class="fa fa-laptop me-1"></i><?= $c['mode'] ?></div>
        <div class="col-6"><i class="fa fa-indian-rupee-sign me-1"></i><?= number_format($c['fee'],0) ?></div>
        <div class="col-6"><i class="fa fa-user-tie me-1"></i><?= htmlspecialchars($c['instructor']) ?></div>
      </div>
      <div class="d-flex gap-2">
        <a href="<?= APP_URL ?>/admin/courses/<?= $c['id'] ?>/edit" class="btn btn-sm btn-outline-primary flex-grow-1"><i class="fa fa-pen me-1"></i>Edit</a>
        <form method="POST" action="<?= APP_URL ?>/admin/courses/<?= $c['id'] ?>/delete" onsubmit="return confirm('Delete course?')">
          <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>
<?php if(empty($courses)): ?><div class="col-12"><div class="card"><div class="card-body text-center text-muted py-5">No courses yet. <a href="<?= APP_URL ?>/admin/courses/create">Add one</a></div></div></div><?php endif; ?>
</div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
