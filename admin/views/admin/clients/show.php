<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><?= htmlspecialchars($client['client_name']) ?></h5>
  <div class="d-flex gap-2">
    <a href="<?= APP_URL ?>/admin/clients/<?= $client['id'] ?>/edit" class="btn btn-sm btn-primary"><i class="fa fa-pen me-1"></i>Edit</a>
    <a href="<?= APP_URL ?>/admin/clients" class="btn btn-sm btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i>Back</a>
  </div>
</div>
<div class="row g-3">
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h6 class="fw-bold"><?= htmlspecialchars($client['client_name']) ?></h6>
        <span class="badge bg-secondary-subtle text-secondary mb-2"><?= ucfirst($client['client_type']) ?></span>
        <ul class="list-unstyled small text-muted mb-0">
          <li><i class="fa fa-user me-2"></i><?= htmlspecialchars($client['contact_person']) ?></li>
          <li><i class="fa fa-envelope me-2"></i><?= htmlspecialchars($client['email']) ?></li>
          <li><i class="fa fa-phone me-2"></i><?= htmlspecialchars($client['phone']) ?></li>
          <li><i class="fa fa-map-pin me-2"></i><?= htmlspecialchars($client['city'].', '.$client['state']) ?></li>
          <?php if($client['gstin']): ?><li><i class="fa fa-file-invoice me-2"></i>GSTIN: <?= htmlspecialchars($client['gstin']) ?></li><?php endif; ?>
        </ul>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="card">
      <div class="card-header bg-transparent"><h6 class="mb-0 fw-semibold"><i class="fa fa-file-invoice me-2"></i>Invoices</h6></div>
      <div class="table-responsive">
        <table class="table table-sm mb-0">
          <thead><tr><th>Invoice#</th><th>Date</th><th>Total</th><th>Status</th></tr></thead>
          <tbody>
          <?php foreach($invoices as $i): ?>
          <tr><td><a href="<?= APP_URL ?>/admin/invoices/<?= $i['id'] ?>" class="text-decoration-none"><?= htmlspecialchars($i['invoice_number']) ?></a></td>
              <td class="small"><?= $i['invoice_date'] ?></td>
              <td class="fw-semibold">₹<?= number_format($i['total_amount'],2) ?></td>
              <td><span class="badge bg-info-subtle text-info"><?= $i['status'] ?></span></td></tr>
          <?php endforeach; ?>
          <?php if(empty($invoices)): ?><tr><td colspan="4" class="text-center text-muted small py-2">No invoices</td></tr><?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
