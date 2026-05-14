<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><i class="fa fa-star me-2 text-warning"></i>Testimonials</h5>
  <a href="<?= APP_URL ?>/admin/testimonials/create" class="btn btn-primary btn-sm"><i class="fa fa-plus me-1"></i>Add</a>
</div>
<div class="row g-3">
<?php foreach($testimonials as $t): ?>
<div class="col-md-6">
  <div class="card h-100">
    <div class="card-body">
      <div class="d-flex justify-content-between mb-2">
        <div><?php for($i=0;$i<$t['rating'];$i++) echo '<i class="fa fa-star text-warning" style="font-size:.8rem"></i>'; ?></div>
        <div class="d-flex gap-1">
          <?php if($t['is_featured']): ?><span class="badge bg-warning text-dark">Featured</span><?php endif; ?>
          <span class="badge <?= $t['status']==='published'?'bg-success':'bg-secondary' ?>"><?= $t['status'] ?></span>
        </div>
      </div>
      <p class="small mb-3">"<?= htmlspecialchars(substr($t['testimonial'],0,120)) ?>..."</p>
      <div class="fw-semibold small"><?= htmlspecialchars($t['client_name']) ?></div>
      <div class="text-muted" style="font-size:.75rem"><?= htmlspecialchars($t['client_position']) ?><?= $t['company']?', '.htmlspecialchars($t['company']):'' ?></div>
      <div class="mt-3 d-flex gap-2">
        <a href="<?= APP_URL ?>/admin/testimonials/<?= $t['id'] ?>/edit" class="btn btn-sm btn-outline-primary"><i class="fa fa-pen"></i></a>
        <form method="POST" action="<?= APP_URL ?>/admin/testimonials/<?= $t['id'] ?>/delete" onsubmit="return confirm('Delete?')">
          <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>
</div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
