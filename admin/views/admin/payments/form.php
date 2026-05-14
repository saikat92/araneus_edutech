<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0">Record Payment</h5>
  <a href="<?= APP_URL ?>/admin/payments" class="btn btn-sm btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i>Back</a>
</div>
<div class="card"><div class="card-body" style="max-width:600px">
<form method="POST" action="<?= APP_URL ?>/admin/payments/create">
  <div class="mb-3"><label class="form-label fw-semibold">Invoice *</label>
    <select name="invoice_id" class="form-select" required>
      <option value="">Select Invoice...</option>
      <?php foreach($invoices as $i): ?>
      <option value="<?= $i['id'] ?>"><?= htmlspecialchars($i['invoice_number']) ?> — <?= htmlspecialchars($i['client_name']) ?> (Due: ₹<?= number_format($i['balance_due'],2) ?>)</option>
      <?php endforeach; ?>
    </select></div>
  <div class="mb-3"><label class="form-label fw-semibold">Payment Date</label>
    <input type="date" name="payment_date" class="form-control" value="<?= date('Y-m-d') ?>"></div>
  <div class="mb-3"><label class="form-label fw-semibold">Amount (₹) *</label>
    <input type="number" name="amount" class="form-control" step="0.01" required></div>
  <div class="mb-3"><label class="form-label fw-semibold">Payment Method</label>
    <select name="payment_method" class="form-select">
      <?php foreach(['bank_transfer','cash','cheque','online','card'] as $m): ?>
      <option value="<?= $m ?>"><?= ucfirst(str_replace('_',' ',$m)) ?></option>
      <?php endforeach; ?>
    </select></div>
  <div class="mb-3"><label class="form-label fw-semibold">Transaction ID</label>
    <input type="text" name="transaction_id" class="form-control" placeholder="UTR/Txn reference"></div>
  <div class="mb-3"><label class="form-label fw-semibold">Notes</label>
    <textarea name="notes" class="form-control" rows="2"></textarea></div>
  <button type="submit" class="btn btn-success"><i class="fa fa-check me-1"></i>Record Payment</button>
</form>
</div></div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
