<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><?= isset($event)?'Edit Event':'New Event' ?></h5>
  <a href="<?= APP_URL ?>/admin/events" class="btn btn-sm btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i>Back</a>
</div>
<div class="card"><div class="card-body">
<form method="POST" action="<?= APP_URL ?>/admin/events/<?= isset($event)?$event['id'].'/edit':'create' ?>">
  <div class="row g-3">
    <div class="col-md-8"><label class="form-label fw-semibold">Title *</label><input type="text" name="title" class="form-control" value="<?= htmlspecialchars($event['title']??'') ?>" required></div>
    <div class="col-md-4"><label class="form-label fw-semibold">Type</label>
      <select name="event_type" class="form-select">
        <?php foreach(['webinar','workshop','seminar','conference'] as $t): ?>
        <option value="<?= $t ?>" <?= ($event['event_type']??'')===$t?'selected':'' ?>><?= ucfirst($t) ?></option>
        <?php endforeach; ?>
      </select></div>
    <div class="col-md-4"><label class="form-label fw-semibold">Date</label><input type="date" name="event_date" class="form-control" value="<?= $event['event_date']??'' ?>"></div>
    <div class="col-md-4"><label class="form-label fw-semibold">Time</label><input type="time" name="event_time" class="form-control" value="<?= $event['event_time']??'' ?>"></div>
    <div class="col-md-4"><label class="form-label fw-semibold">Status</label>
      <select name="is_upcoming" class="form-select">
        <option value="1" <?= ($event['is_upcoming']??1)?'selected':'' ?>>Upcoming</option>
        <option value="0" <?= !($event['is_upcoming']??1)?'selected':'' ?>>Past</option>
      </select></div>
    <div class="col-md-6"><label class="form-label fw-semibold">Venue</label><input type="text" name="venue" class="form-control" value="<?= htmlspecialchars($event['venue']??'') ?>"></div>
    <div class="col-md-6"><label class="form-label fw-semibold">Registration Link</label><input type="url" name="registration_link" class="form-control" value="<?= htmlspecialchars($event['registration_link']??'') ?>"></div>
    <div class="col-12"><label class="form-label fw-semibold">Description</label><textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($event['description']??'') ?></textarea></div>
    <div class="col-12"><button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i>Save</button><a href="<?= APP_URL ?>/admin/events" class="btn btn-outline-secondary ms-2">Cancel</a></div>
  </div>
</form>
</div></div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
