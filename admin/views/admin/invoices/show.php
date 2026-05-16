<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0">Invoice <?= htmlspecialchars($invoice['invoice_number']) ?></h5>
  <div class="d-flex gap-2">
    <form method="POST" action="<?= APP_URL ?>/admin/invoices/<?= $invoice['id'] ?>/status" class="d-flex gap-2">
      <select name="status" class="form-select form-select-sm">
        <?php foreach(['draft','sent','paid','partial','overdue','cancelled'] as $st): ?>
        <option value="<?= $st ?>" <?= $invoice['status']===$st?'selected':'' ?>><?= ucfirst($st) ?></option>
        <?php endforeach; ?>
      </select>
      <button class="btn btn-sm btn-success">Update</button>
      <a href="<?= APP_URL ?>/admin/invoices/<?= $invoice['id'] ?>/print" target="_blank" class="btn btn-secondary">
          <i class="bi bi-print"></i>Print
      </a>
    </form>
    <a href="<?= APP_URL ?>/admin/invoices" class="btn btn-sm btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i>Back</a>
  </div>
</div>
<div class="card mb-3">
  <div class="card-body">
    <div class="row mb-3">
      <div class="col-md-6">
        <h6 class="text-muted fw-semibold">Billed To</h6>
        <p class="mb-0 fw-bold"><?= htmlspecialchars($invoice['client_name']) ?></p>
        <small class="text-muted"><?= htmlspecialchars($invoice['client_email']) ?></small><br>
        <?php if($invoice['gstin']): ?><small class="text-muted">GSTIN: <?= htmlspecialchars($invoice['gstin']) ?></small><?php endif; ?>
      </div>
      <div class="col-md-6 text-md-end">
        <h6 class="text-muted fw-semibold">Invoice Details</h6>
        <p class="mb-0">Date: <strong><?= $invoice['invoice_date'] ?></strong></p>
        <p class="mb-0">Due: <strong><?= $invoice['due_date'] ?></strong></p>
        <?php if($invoice['po_number']): ?><p class="mb-0">PO#: <?= htmlspecialchars($invoice['po_number']) ?></p><?php endif; ?>
      </div>
    </div>
    <?php if($items): ?>
    <div class="table-responsive mb-3">
      <table class="table table-sm border rounded">
        <thead class="table-light"><tr><th>Item</th><th class="text-end">Qty</th><th class="text-end">Price</th><th class="text-end">GST</th><th class="text-end">Total</th></tr></thead>
        <tbody>
        <?php foreach($items as $it): ?>
        <tr><td><?= htmlspecialchars($it['product_name']) ?></td>
            <td class="text-end"><?= $it['quantity'] ?></td>
            <td class="text-end">₹<?= number_format($it['unit_price'],2) ?></td>
            <td class="text-end"><?= $it['gst_rate'] ?>%</td>
            <td class="text-end fw-semibold">₹<?= number_format($it['total_amount'],2) ?></td></tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
    <div class="row justify-content-end">
      <div class="col-md-4">
        <table class="table table-sm mb-0">
          <tr><td class="text-muted">Subtotal</td><td class="text-end">₹<?= number_format($invoice['sub_total'],2) ?></td></tr>
          <tr><td class="text-muted">Tax</td><td class="text-end">₹<?= number_format($invoice['tax_amount'],2) ?></td></tr>
          <?php if($invoice['discount_amount']>0): ?><tr><td class="text-muted text-success">Discount</td><td class="text-end text-success">-₹<?= number_format($invoice['discount_amount'],2) ?></td></tr><?php endif; ?>
          <tr class="table-primary fw-bold"><td>Total</td><td class="text-end">₹<?= number_format($invoice['total_amount'],2) ?></td></tr>
          <tr><td class="text-success">Paid</td><td class="text-end text-success">₹<?= number_format($invoice['amount_paid'],2) ?></td></tr>
          <tr class="fw-bold"><td>Balance Due</td><td class="text-end text-danger">₹<?= number_format($invoice['balance_due'],2) ?></td></tr>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- Payments received -->
<?php if($payments): ?>
<div class="card">
  <div class="card-header bg-transparent"><h6 class="mb-0 fw-semibold"><i class="fa fa-credit-card me-2"></i>Payments Received</h6></div>
  <div class="table-responsive">
    <table class="table table-sm mb-0">
      <thead><tr><th>Date</th><th>Method</th><th>Txn ID</th><th>Amount</th></tr></thead>
      <tbody>
      <?php foreach($payments as $p): ?>
      <tr><td><?= $p['payment_date'] ?></td><td><?= ucfirst(str_replace('_',' ',$p['payment_method'])) ?></td>
          <td><code class="small"><?= htmlspecialchars($p['transaction_id']) ?></code></td>
          <td class="fw-semibold text-success">₹<?= number_format($p['amount'],2) ?></td></tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php endif; ?>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
