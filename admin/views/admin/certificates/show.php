<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h5 class="fw-bold mb-0">Certificate <code><?= htmlspecialchars($cert['certificate_id']) ?></code></h5>
    <small class="text-muted"><?= htmlspecialchars($cert['full_name']) ?></small>
  </div>
  <div class="d-flex gap-2">
    <a href="<?= APP_URL ?>/admin/certificates/<?= $cert['id'] ?>/print"
       target="_blank" class="btn btn-sm btn-success">
      <i class="fa fa-print me-1"></i>Print / Download
    </a>
    <?php if ($cert['status'] === 'issued'): ?>
    <form method="POST" action="<?= APP_URL ?>/admin/certificates/<?= $cert['id'] ?>/revoke"
          onsubmit="return confirm('Revoke this certificate?')">
      <button class="btn btn-sm btn-warning"><i class="fa fa-ban me-1"></i>Revoke</button>
    </form>
    <?php endif; ?>
    <a href="<?= APP_URL ?>/admin/certificates" class="btn btn-sm btn-outline-secondary">
      <i class="fa fa-arrow-left me-1"></i>Back
    </a>
  </div>
</div>

<div class="row g-3">
  <div class="col-md-5">
    <div class="card">
      <div class="card-header bg-transparent">
        <h6 class="mb-0 fw-semibold"><i class="fa fa-info-circle me-2"></i>Certificate Details</h6>
      </div>
      <ul class="list-group list-group-flush small">
        <li class="list-group-item d-flex justify-content-between">
          <span class="text-muted">Certificate ID</span>
          <code><?= htmlspecialchars($cert['certificate_id']) ?></code>
        </li>
        <li class="list-group-item d-flex justify-content-between">
          <span class="text-muted">Student</span>
          <span class="fw-semibold"><?= htmlspecialchars($cert['full_name']) ?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between">
          <span class="text-muted">Candidate ID</span>
          <span><?= htmlspecialchars($cert['candidate_id']) ?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between">
          <span class="text-muted">Type</span>
          <span><?= ucfirst($cert['certificate_type']) ?></span>
        </li>
        <li class="list-group-item">
          <span class="text-muted d-block mb-1">Program</span>
          <span class="fw-semibold"><?= htmlspecialchars($cert['program_name']) ?></span>
        </li>
        <?php if ($cert['project_name']): ?>
        <li class="list-group-item d-flex justify-content-between">
          <span class="text-muted">Project</span>
          <span><?= htmlspecialchars($cert['project_name']) ?></span>
        </li>
        <?php endif; ?>
        <li class="list-group-item d-flex justify-content-between">
          <span class="text-muted">Duration</span>
          <span><?= htmlspecialchars($cert['duration']) ?> (<?= $cert['mode'] ?>)</span>
        </li>
        <li class="list-group-item d-flex justify-content-between">
          <span class="text-muted">Period</span>
          <span><?= date('d-m-Y', strtotime($cert['start_date'])) ?> to <?= date('d-m-Y', strtotime($cert['end_date'])) ?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between">
          <span class="text-muted">Issued</span>
          <span><?= date('d M Y', strtotime($cert['issued_date'])) ?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between">
          <span class="text-muted">Status</span>
          <span class="badge <?= $cert['status']==='issued'?'bg-success':($cert['status']==='revoked'?'bg-danger':'bg-secondary') ?>">
            <?= ucfirst($cert['status']) ?>
          </span>
        </li>
      </ul>
    </div>
  </div>

  <div class="col-md-7">
    <!-- Certificate preview -->
    <div class="card">
      <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-semibold"><i class="fa fa-eye me-2"></i>Preview</h6>
        <a href="<?= APP_URL ?>/admin/certificates/<?= $cert['id'] ?>/print"
           target="_blank" class="btn btn-sm btn-outline-success">
          <i class="fa fa-external-link me-1"></i>Open Full View
        </a>
      </div>
      <div class="card-body p-2">
        <iframe src="<?= APP_URL ?>/admin/certificates/<?= $cert['id'] ?>/print"
                style="width:100%;height:480px;border:none;border-radius:8px;"></iframe>
      </div>
    </div>
  </div>
</div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>