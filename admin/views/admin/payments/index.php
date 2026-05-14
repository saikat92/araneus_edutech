<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><i class="fa fa-credit-card me-2 text-success"></i>Payments</h5>
  <a href="<?= APP_URL ?>/admin/payments/create" class="btn btn-primary btn-sm"><i class="fa fa-plus me-1"></i>Record Payment</a>
</div>
<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead><tr><th>Date</th><th>Invoice</th><th>Client</th><th>Method</th><th>Txn ID</th><th>Amount</th></tr></thead>
      <tbody>
      <?php foreach($payments as $p): ?>
      <tr>
        <td class="small"><?= $p['payment_date'] ?></td>
        <td><a href="<?= APP_URL ?>/admin/invoices/<?= $p['invoice_id'] ?>" class="text-decoration-none"><?= htmlspecialchars($p['invoice_number']) ?></a></td>
        <td><?= htmlspecialchars($p['client_name']) ?></td>
        <td><span class="badge bg-secondary-subtle text-secondary"><?= ucfirst(str_replace('_',' ',$p['payment_method'])) ?></span></td>
        <td><code class="small"><?= htmlspecialchars($p['transaction_id']) ?></code></td>
        <td class="fw-semibold text-success fs-6">₹<?= number_format($p['amount'],2) ?></td>
      </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
