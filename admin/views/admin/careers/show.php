<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><?= htmlspecialchars($career['first_name'].' '.$career['last_name']) ?></h5>
  <a href="<?= APP_URL ?>/admin/careers" class="btn btn-sm btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i>Back</a>
</div>
<div class="row g-3">
  <div class="col-md-8">
    <div class="card mb-3"><div class="card-body">
      <dl class="row mb-0">
        <dt class="col-sm-4">Position</dt><dd class="col-sm-8"><?= htmlspecialchars($career['position']) ?></dd>
        <dt class="col-sm-4">Experience</dt><dd class="col-sm-8"><?= htmlspecialchars($career['experience']) ?></dd>
        <dt class="col-sm-4">Email</dt><dd class="col-sm-8"><?= htmlspecialchars($career['email']) ?></dd>
        <dt class="col-sm-4">Phone</dt><dd class="col-sm-8"><?= htmlspecialchars($career['phone']) ?></dd>
        <dt class="col-sm-4">How Heard</dt><dd class="col-sm-8"><?= htmlspecialchars($career['how_heard']) ?></dd>
        <dt class="col-sm-4">Applied</dt><dd class="col-sm-8"><?= date('d M Y',strtotime($career['application_date'])) ?></dd>
        <?php if($career['resume_path']): ?><dt class="col-sm-4">Resume</dt><dd class="col-sm-8"><a href="<?= APP_URL ?>/assets/uploads/<?= htmlspecialchars($career['resume_path']) ?>" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fa fa-download me-1"></i>Download</a></dd><?php endif; ?>
      </dl>
    </div></div>
    <?php if($career['cover_letter']): ?>
    <div class="card"><div class="card-header bg-transparent"><h6 class="mb-0 fw-semibold">Cover Letter</h6></div>
      <div class="card-body"><p class="small mb-0"><?= nl2br(htmlspecialchars($career['cover_letter'])) ?></p></div>
    </div>
    <?php endif; ?>
  </div>
  <div class="col-md-4">
    <div class="card"><div class="card-body">
      <h6 class="fw-semibold mb-3">Update Status</h6>
      <form method="POST" action="<?= APP_URL ?>/admin/careers/<?= $career['id'] ?>/status">
        <div class="mb-3"><select name="status" class="form-select">
          <?php foreach(['new','reviewed','shortlisted','rejected'] as $st): ?>
          <option value="<?= $st ?>" <?= $career['status']===$st?'selected':'' ?>><?= ucfirst($st) ?></option>
          <?php endforeach; ?>
        </select></div>
        <div class="mb-3"><textarea name="notes" class="form-control" rows="3" placeholder="Notes..."><?= htmlspecialchars($career['notes']??'') ?></textarea></div>
        <button type="submit" class="btn btn-primary w-100"><i class="fa fa-save me-1"></i>Update</button>
      </form>
    </div></div>
  </div>
</div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
