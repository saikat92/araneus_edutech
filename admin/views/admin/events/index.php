<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><i class="fa fa-calendar-days me-2 text-primary"></i>Events</h5>
  <a href="<?= APP_URL ?>/admin/events/create" class="btn btn-primary btn-sm"><i class="fa fa-plus me-1"></i>Add Event</a>
</div>
<div class="row g-3">
<?php foreach($events as $e): ?>
<div class="col-md-6">
  <div class="card h-100">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-start">
        <span class="badge bg-primary-subtle text-primary"><?= ucfirst($e['event_type']) ?></span>
        <span class="badge <?= $e['is_upcoming']?'bg-success':'bg-secondary' ?>"><?= $e['is_upcoming']?'Upcoming':'Past' ?></span>
      </div>
      <h6 class="fw-bold mt-2"><?= htmlspecialchars($e['title']) ?></h6>
      <p class="text-muted small mb-2"><?= htmlspecialchars(substr($e['description']??'',0,100)) ?>...</p>
      <div class="small text-muted"><i class="fa fa-calendar me-1"></i><?= $e['event_date'] ?> <?= $e['event_time'] ?>
        <span class="ms-3"><i class="fa fa-map-pin me-1"></i><?= htmlspecialchars($e['venue']) ?></span></div>
      <div class="mt-3 d-flex gap-2">
        <a href="<?= APP_URL ?>/admin/events/<?= $e['id'] ?>/edit" class="btn btn-sm btn-outline-primary"><i class="fa fa-pen me-1"></i>Edit</a>
        <form method="POST" action="<?= APP_URL ?>/admin/events/<?= $e['id'] ?>/delete" onsubmit="return confirm('Delete?')">
          <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>
</div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
