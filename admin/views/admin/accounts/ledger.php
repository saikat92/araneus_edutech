<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h5 class="fw-bold mb-0"><?= htmlspecialchars($client['client_name']) ?></h5>
    <small class="text-muted">Account Ledger</small>
  </div>
  <div class="d-flex gap-2">
    <a href="<?= APP_URL ?>/admin/invoices/create?client_id=<?= $client['id'] ?>"
       class="btn btn-sm btn-primary"><i class="fa fa-plus me-1"></i>New Invoice</a>
    <a href="<?= APP_URL ?>/admin/accounts" class="btn btn-sm btn-outline-secondary">
      <i class="fa fa-arrow-left me-1"></i>Back
    </a>
  </div>
</div>

<!-- Client info strip -->
<div class="card mb-3">
  <div class="card-body py-2">
    <div class="row g-2 small">
      <div class="col-auto"><i class="fa fa-envelope me-1 text-muted"></i><?= htmlspecialchars($client['email']) ?></div>
      <div class="col-auto"><i class="fa fa-phone me-1 text-muted"></i><?= htmlspecialchars($client['phone']) ?></div>
      <?php if($client['gstin']): ?>
      <div class="col-auto"><i class="fa fa-file-invoice me-1 text-muted"></i>GSTIN: <?= htmlspecialchars($client['gstin']) ?></div>
      <?php endif; ?>
      <div class="col-auto ms-auto">
        <span class="fw-semibold <?= $balance>0?'text-danger':'text-success' ?>">
          <?= $balance>0 ? 'Outstanding: ₹'.number_format($balance,2) : 'Account Clear' ?>
        </span>
      </div>
    </div>
  </div>
</div>

<!-- Ledger table -->
<div class="card">
  <div class="card-header bg-transparent">
    <h6 class="fw-semibold mb-0"><i class="fa fa-table-list me-2"></i>Transaction Ledger</h6>
  </div>
  <div class="table-responsive">
    <table class="table mb-0" style="font-size:.85rem">
      <thead>
        <tr>
          <th>Date</th>
          <th>Reference</th>
          <th>Type</th>
          <th>Description</th>
          <th class="text-end text-danger">Debit (Dr)</th>
          <th class="text-end text-success">Credit (Cr)</th>
          <th class="text-end">Balance</th>
        </tr>
      </thead>
      <tbody>
      <?php if(empty($ledger)): ?>
      <tr><td colspan="7" class="text-center text-muted py-4">No transactions yet</td></tr>
      <?php endif; ?>
      <?php foreach($ledger as $row): ?>
      <tr class="<?= $row['type']==='payment'?'table-success-subtle':'' ?>">
        <td class="text-muted small"><?= date('d M Y', strtotime($row['txn_date'])) ?></td>
        <td>
          <?php if($row['type']==='invoice'): ?>
            <a href="<?= APP_URL ?>/admin/invoices/<?= $row['id'] ?>" class="text-decoration-none fw-semibold">
              <?= htmlspecialchars($row['ref']) ?>
            </a>
          <?php else: ?>
            <span class="text-success fw-semibold"><?= htmlspecialchars($row['ref']) ?></span>
          <?php endif; ?>
        </td>
        <td>
          <?php if($row['type']==='invoice'): ?>
            <span class="badge bg-primary-subtle text-primary">Invoice</span>
          <?php else: ?>
            <span class="badge bg-success-subtle text-success">Payment</span>
          <?php endif; ?>
        </td>
        <td class="text-muted small">
          <?php if($row['type']==='invoice'): ?>
            Invoice raised
            <span class="badge bg-<?= ['draft'=>'secondary','sent'=>'info','paid'=>'success','partial'=>'warning','overdue'=>'danger','cancelled'=>'dark'][$row['status']]??'secondary' ?> ms-1">
              <?= $row['status'] ?>
            </span>
          <?php else: ?>
            Payment received
          <?php endif; ?>
        </td>
        <td class="text-end text-danger">
          <?= $row['debit']>0 ? '₹'.number_format($row['debit'],2) : '—' ?>
        </td>
        <td class="text-end text-success">
          <?= $row['credit']>0 ? '₹'.number_format($row['credit'],2) : '—' ?>
        </td>
        <td class="text-end fw-semibold <?= $row['running_balance']>0?'text-danger':'text-success' ?>">
          ₹<?= number_format(abs($row['running_balance']),2) ?>
          <small class="fw-normal"><?= $row['running_balance']>0?'Dr':'Cr' ?></small>
        </td>
      </tr>
      <?php endforeach; ?>
      </tbody>
      <?php if(!empty($ledger)): ?>
      <tfoot class="table-light fw-bold">
        <tr>
          <td colspan="4" class="text-end">Closing Balance</td>
          <td colspan="2"></td>
          <td class="text-end <?= $balance>0?'text-danger':'text-success' ?>">
            ₹<?= number_format(abs($balance),2) ?>
            <small class="fw-normal"><?= $balance>0?'Dr':'Cr' ?></small>
          </td>
        </tr>
      </tfoot>
      <?php endif; ?>
    </table>
  </div>
</div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>