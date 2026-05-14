<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><i class="fa fa-scale-balanced me-2 text-primary"></i>Accounts Ledger</h5>
</div>

<!-- Araneus summary cards -->
<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card border-0 bg-primary text-white p-3">
      <div class="small opacity-75">Total Billed</div>
      <div class="fs-4 fw-bold">₹<?= number_format($summary['total_billed'],2) ?></div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card border-0 bg-success text-white p-3">
      <div class="small opacity-75">Total Received</div>
      <div class="fs-4 fw-bold">₹<?= number_format($summary['total_received'],2) ?></div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card border-0 bg-danger text-white p-3">
      <div class="small opacity-75">Outstanding</div>
      <div class="fs-4 fw-bold">₹<?= number_format($summary['total_outstanding'],2) ?></div>
    </div>
  </div>
</div>

<!-- Client ledger table -->
<div class="card">
  <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
    <h6 class="fw-semibold mb-0">Client Account Balances</h6>
    <span class="badge bg-secondary"><?= count($clients) ?> clients</span>
  </div>
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <th>Client</th>
          <th>Type</th>
          <th class="text-end">Total Invoiced</th>
          <th class="text-end">Total Paid</th>
          <th class="text-end">Balance Due</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($clients as $c): ?>
      <tr>
        <td>
          <a href="<?= APP_URL ?>/admin/accounts/<?= $c['id'] ?>/ledger" class="fw-semibold text-decoration-none">
            <?= htmlspecialchars($c['client_name']) ?>
          </a>
          <?php if($c['contact_person']): ?>
          <br><small class="text-muted"><?= htmlspecialchars($c['contact_person']) ?></small>
          <?php endif; ?>
        </td>
        <td><span class="badge bg-secondary-subtle text-secondary"><?= ucfirst($c['client_type']) ?></span></td>
        <td class="text-end fw-semibold">₹<?= number_format($c['total_invoiced'],2) ?></td>
        <td class="text-end text-success">₹<?= number_format($c['total_paid'],2) ?></td>
        <td class="text-end <?= $c['balance_due']>0?'text-danger fw-bold':'text-muted' ?>">
          ₹<?= number_format($c['balance_due'],2) ?>
        </td>
        <td>
          <?php if($c['balance_due']<=0 && $c['total_invoiced']>0): ?>
            <span class="badge bg-success-subtle text-success">Clear</span>
          <?php elseif($c['balance_due']>0): ?>
            <span class="badge bg-danger-subtle text-danger">Outstanding</span>
          <?php else: ?>
            <span class="badge bg-secondary-subtle text-secondary">No invoices</span>
          <?php endif; ?>
        </td>
        <td>
          <a href="<?= APP_URL ?>/admin/accounts/<?= $c['id'] ?>/ledger"
             class="btn btn-sm btn-outline-primary btn-action">
            <i class="fa fa-book-open me-1"></i>Ledger
          </a>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php if(empty($clients)): ?>
      <tr><td colspan="7" class="text-center text-muted py-4">No clients yet</td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>