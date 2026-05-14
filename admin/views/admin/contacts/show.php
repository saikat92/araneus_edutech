<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0">Message from <?= htmlspecialchars($contact['name']) ?></h5>
  <a href="<?= APP_URL ?>/admin/contacts" class="btn btn-sm btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i>Back</a>
</div>
<div class="row g-3">
  <div class="col-md-8">
    <div class="card"><div class="card-body">
      <h6 class="fw-bold"><?= htmlspecialchars($contact['subject']) ?></h6>
      <p class="text-body mb-0"><?= nl2br(htmlspecialchars($contact['message'])) ?></p>
    </div></div>
  </div>
  <div class="col-md-4">
    <div class="card"><div class="card-body">
      <ul class="list-unstyled small mb-3">
        <li><i class="fa fa-user me-2 text-muted"></i><?= htmlspecialchars($contact['name']) ?></li>
        <li><i class="fa fa-envelope me-2 text-muted"></i><a href="mailto:<?= htmlspecialchars($contact['email']) ?>"><?= htmlspecialchars($contact['email']) ?></a></li>
        <?php if($contact['phone']): ?><li><i class="fa fa-phone me-2 text-muted"></i><?= htmlspecialchars($contact['phone']) ?></li><?php endif; ?>
        <li><i class="fa fa-calendar me-2 text-muted"></i><?= date('d M Y H:i',strtotime($contact['submission_date'])) ?></li>
      </ul>
      <form method="POST" action="<?= APP_URL ?>/admin/contacts/<?= $contact['id'] ?>/status">
        <select name="status" class="form-select form-select-sm mb-2">
          <?php foreach(['new','read','replied'] as $st): ?><option value="<?= $st ?>" <?= $contact['status']===$st?'selected':'' ?>><?= ucfirst($st) ?></option><?php endforeach; ?>
        </select>
        <button class="btn btn-sm btn-primary w-100">Update Status</button>
      </form>
    </div></div>
  </div>
</div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
