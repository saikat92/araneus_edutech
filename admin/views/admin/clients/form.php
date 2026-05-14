<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><?= isset($client)?'Edit Client':'Add Client' ?></h5>
  <a href="<?= APP_URL ?>/admin/clients" class="btn btn-sm btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i>Back</a>
</div>
<div class="card"><div class="card-body">
<form method="POST" action="<?= APP_URL ?>/admin/clients/<?= isset($client)?$client['id'].'/edit':'create' ?>">
  <div class="row g-3">
    <div class="col-md-6"><label class="form-label fw-semibold">Client Name *</label>
      <input type="text" name="client_name" class="form-control" value="<?= htmlspecialchars($client['client_name']??'') ?>" required></div>
    <div class="col-md-3"><label class="form-label fw-semibold">Type</label>
      <select name="client_type" class="form-select">
        <option value="company" <?= ($client['client_type']??'')==='company'?'selected':'' ?>>Company</option>
        <option value="individual" <?= ($client['client_type']??'')==='individual'?'selected':'' ?>>Individual</option>
      </select></div>
    <div class="col-md-3"><label class="form-label fw-semibold">Status</label>
      <select name="status" class="form-select">
        <?php foreach(['active','inactive','lead'] as $st): ?>
        <option value="<?= $st ?>" <?= ($client['status']??'')===$st?'selected':'' ?>><?= ucfirst($st) ?></option>
        <?php endforeach; ?>
      </select></div>
    <div class="col-md-4"><label class="form-label fw-semibold">Contact Person</label>
      <input type="text" name="contact_person" class="form-control" value="<?= htmlspecialchars($client['contact_person']??'') ?>"></div>
    <div class="col-md-4"><label class="form-label fw-semibold">Email *</label>
      <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($client['email']??'') ?>" required></div>
    <div class="col-md-4"><label class="form-label fw-semibold">Phone</label>
      <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($client['phone']??'') ?>"></div>
    <div class="col-md-4"><label class="form-label fw-semibold">City</label>
      <input type="text" name="city" class="form-control" value="<?= htmlspecialchars($client['city']??'') ?>"></div>
    <div class="col-md-4"><label class="form-label fw-semibold">State</label>
      <input type="text" name="state" class="form-control" value="<?= htmlspecialchars($client['state']??'') ?>"></div>
    <div class="col-md-4"><label class="form-label fw-semibold">Country</label>
      <input type="text" name="country" class="form-control" value="<?= htmlspecialchars($client['country']??'India') ?>"></div>
    <div class="col-md-4"><label class="form-label fw-semibold">GSTIN</label>
      <input type="text" name="gstin" class="form-control" value="<?= htmlspecialchars($client['gstin']??'') ?>"></div>
    <div class="col-md-4"><label class="form-label fw-semibold">PAN</label>
      <input type="text" name="pan" class="form-control" value="<?= htmlspecialchars($client['pan']??'') ?>"></div>
    <div class="col-12"><label class="form-label fw-semibold">Address</label>
      <textarea name="address" class="form-control" rows="2"><?= htmlspecialchars($client['address']??'') ?></textarea></div>
    <div class="col-12"><label class="form-label fw-semibold">Notes</label>
      <textarea name="notes" class="form-control" rows="2"><?= htmlspecialchars($client['notes']??'') ?></textarea></div>
    <div class="col-12"><button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i>Save</button>
      <a href="<?= APP_URL ?>/admin/clients" class="btn btn-outline-secondary ms-2">Cancel</a></div>
  </div>
</form>
</div></div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
