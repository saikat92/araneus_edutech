<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<style>
.item-row td { vertical-align: middle; padding: .4rem .5rem; }
.item-row input, .item-row select { font-size: .82rem; }
.total-box { background: #f8fafc; border-radius: 10px; padding: 1rem 1.25rem; }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><?= isset($invoice) ? 'Edit Invoice #'.$invoice['invoice_number'] : 'New Invoice' ?></h5>
  <a href="<?= APP_URL ?>/admin/invoices" class="btn btn-sm btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i>Back</a>
</div>

<form method="POST" action="<?= APP_URL ?>/admin/invoices/<?= isset($invoice) ? $invoice['id'].'/edit' : 'create' ?>" id="invoiceForm">

  <!-- Bill Type Toggle (only on create) -->
  <?php if (!isset($invoice)): ?>
  <div class="card mb-3">
    <div class="card-body py-2">
      <div class="d-flex align-items-center gap-4">
        <strong class="small text-muted">BILL TO:</strong>
        <div class="form-check form-check-inline mb-0">
          <input class="form-check-input" type="radio" name="bill_type" id="billClient" value="client" checked onchange="toggleBillType()">
          <label class="form-check-label" for="billClient"><i class="fa fa-building me-1"></i>Client</label>
        </div>
        <div class="form-check form-check-inline mb-0">
          <input class="form-check-input" type="radio" name="bill_type" id="billStudent" value="student" onchange="toggleBillType()">
          <label class="form-check-label" for="billStudent"><i class="fa fa-user-graduate me-1"></i>Student (Fee Invoice)</label>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <div class="row g-3 mb-3">
    <!-- Client selector -->
    <div class="col-md-5" id="clientSection">
      <label class="form-label fw-semibold">Client <span class="text-danger">*</span></label>
      <select name="client_id" id="clientSelect" class="form-select">
        <option value="">Select Client...</option>
        <?php foreach($clients as $c): ?>
        <option value="<?= $c['id'] ?>"
          <?= ((int)($invoice['client_id']??0)===$c['id'] || (int)($preClientId??0)===$c['id']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($c['client_name']) ?>
        </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Student selector (hidden by default) -->
    <div class="col-md-5 d-none" id="studentSection">
      <label class="form-label fw-semibold">Student <span class="text-danger">*</span></label>
      <select name="student_id" id="studentSelect" class="form-select" onchange="loadStudentCourse(this)">
        <option value="">Select Student...</option>
        <?php
        $seenStudents = [];
        foreach($students as $s):
          if (in_array($s['id'], $seenStudents)) continue;
          $seenStudents[] = $s['id'];
        ?>
        <option value="<?= $s['id'] ?>"
          data-course-id="<?= $s['course_id'] ?>"
          data-course-title="<?= htmlspecialchars($s['course_title']??'') ?>"
          data-course-fee="<?= $s['course_fee']??0 ?>">
          <?= htmlspecialchars($s['full_name']) ?> (<?= $s['candidate_id'] ?>)
        </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-3">
      <label class="form-label fw-semibold">Invoice Date</label>
      <input type="date" name="invoice_date" class="form-control" value="<?= $invoice['invoice_date']??date('Y-m-d') ?>">
    </div>
    <div class="col-md-2">
      <label class="form-label fw-semibold">Due Date</label>
      <input type="date" name="due_date" class="form-control" value="<?= $invoice['due_date']??'' ?>">
    </div>
    <div class="col-md-3">
      <label class="form-label fw-semibold">PO Number</label>
      <input type="text" name="po_number" class="form-control" value="<?= htmlspecialchars($invoice['po_number']??'') ?>">
    </div>
    <div class="col-md-3">
      <label class="form-label fw-semibold">Payment Terms</label>
      <input type="text" name="payment_terms" class="form-control" placeholder="e.g. Net 30" value="<?= htmlspecialchars($invoice['payment_terms']??'') ?>">
    </div>
  </div>

  <!-- Line Items -->
  <div class="card mb-3">
    <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-2">
      <h6 class="mb-0 fw-semibold"><i class="fa fa-list me-2"></i>Line Items</h6>
      <button type="button" class="btn btn-sm btn-primary" onclick="addRow()">
        <i class="fa fa-plus me-1"></i>Add Item
      </button>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table mb-0" id="itemsTable">
          <thead class="table-light">
            <tr>
              <th style="width:35%">Item / Description</th>
              <th style="width:8%">Qty</th>
              <th style="width:13%">Unit Price (₹)</th>
              <th style="width:8%">GST %</th>
              <th style="width:12%">Tax (₹)</th>
              <th style="width:13%">Total (₹)</th>
              <th style="width:5%"></th>
            </tr>
          </thead>
          <tbody id="itemsBody">
            <!-- existing items on edit -->
            <?php if (!empty($items)): foreach($items as $item): ?>
            <tr class="item-row">
              <td>
                <input type="hidden" name="item_ps_id[]" value="<?= $item['product_service_id'] ?>">
                <input type="text" name="item_name[]" class="form-control form-control-sm"
                  value="<?= htmlspecialchars($item['description']??$item['product_name']) ?>" required>
              </td>
              <td><input type="number" name="item_qty[]" class="form-control form-control-sm qty"
                value="<?= $item['quantity'] ?>" step="0.01" min="0" onchange="calcRow(this)"></td>
              <td><input type="number" name="item_price[]" class="form-control form-control-sm price"
                value="<?= $item['unit_price'] ?>" step="0.01" min="0" onchange="calcRow(this)"></td>
              <td><input type="number" name="item_gst[]" class="form-control form-control-sm gst"
                value="<?= $item['gst_rate'] ?>" step="0.01" min="0" max="100" onchange="calcRow(this)"></td>
              <td><input type="number" name="item_tax[]" class="form-control form-control-sm tax-display bg-light"
                value="<?= $item['tax_amount'] ?>" readonly></td>
              <td><input type="number" name="item_total[]" class="form-control form-control-sm row-total bg-light"
                value="<?= $item['total_amount'] ?>" readonly></td>
              <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)"><i class="fa fa-times"></i></button></td>
            </tr>
            <?php endforeach; else: ?>
            <!-- default empty row -->
            <tr class="item-row">
              <td>
                <input type="hidden" name="item_ps_id[]" value="0">
                <input type="text" name="item_name[]" class="form-control form-control-sm" placeholder="Item or service description" required>
              </td>
              <td><input type="number" name="item_qty[]" class="form-control form-control-sm qty" value="1" step="0.01" min="0" onchange="calcRow(this)"></td>
              <td><input type="number" name="item_price[]" class="form-control form-control-sm price" value="0" step="0.01" min="0" onchange="calcRow(this)"></td>
              <td><input type="number" name="item_gst[]" class="form-control form-control-sm gst" value="18" step="0.01" min="0" max="100" onchange="calcRow(this)"></td>
              <td><input type="number" name="item_tax[]" class="form-control form-control-sm tax-display bg-light" value="0" readonly></td>
              <td><input type="number" name="item_total[]" class="form-control form-control-sm row-total bg-light" value="0" readonly></td>
              <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)"><i class="fa fa-times"></i></button></td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Quick add from product catalog -->
  <?php if (!empty($products)): ?>
  <div class="mb-3">
    <label class="form-label small text-muted fw-semibold">Quick add from catalog:</label>
    <div class="d-flex flex-wrap gap-2">
      <?php foreach($products as $p): ?>
      <button type="button" class="btn btn-sm btn-outline-secondary"
        onclick="addProductRow(<?= $p['id'] ?>, '<?= addslashes(htmlspecialchars($p['name'])) ?>', <?= $p['unit_price'] ?>, <?= $p['gst_rate'] ?>)">
        <i class="fa fa-plus me-1"></i><?= htmlspecialchars(substr($p['name'],0,25)) ?>
        <span class="text-muted ms-1">₹<?= number_format($p['unit_price'],0) ?></span>
      </button>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>

  <!-- Totals + Notes -->
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label fw-semibold">Notes / Terms</label>
      <textarea name="notes" class="form-control" rows="3"><?= htmlspecialchars($invoice['notes']??'') ?></textarea>
    </div>
    <div class="col-md-6">
      <div class="total-box">
        <div class="d-flex justify-content-between mb-2">
          <span class="text-muted">Subtotal</span>
          <span id="dispSubtotal" class="fw-semibold">₹0.00</span>
          <input type="hidden" name="sub_total" id="sub_total" value="<?= $invoice['sub_total']??0 ?>">
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span class="text-muted">GST / Tax</span>
          <span id="dispTax" class="text-warning">₹0.00</span>
          <input type="hidden" name="tax_amount" id="tax_amount" value="<?= $invoice['tax_amount']??0 ?>">
        </div>
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="text-muted">Discount (₹)</span>
          <input type="number" name="discount_amount" id="discount_amount" class="form-control form-control-sm"
            style="width:110px" value="<?= $invoice['discount_amount']??0 ?>" step="0.01" min="0" onchange="updateTotals()">
        </div>
        <hr class="my-2">
        <div class="d-flex justify-content-between">
          <span class="fw-bold fs-6">Grand Total</span>
          <span id="dispGrand" class="fw-bold fs-5 text-primary">₹0.00</span>
          <input type="hidden" name="grand_total" id="grand_total" value="<?= $invoice['total_amount']??0 ?>">
        </div>
      </div>
    </div>
  </div>

  <div class="mt-3 d-flex gap-2">
    <button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i>Save Invoice</button>
    <a href="<?= APP_URL ?>/admin/invoices" class="btn btn-outline-secondary">Cancel</a>
  </div>
</form>

<?php
$studentsJson = json_encode($students ?? []);
$extraJs = <<<JS
<script>
const studentsData = $studentsJson;

function toggleBillType() {
  const isStudent = document.getElementById('billStudent').checked;
  document.getElementById('clientSection').classList.toggle('d-none', isStudent);
  document.getElementById('studentSection').classList.toggle('d-none', !isStudent);
  document.getElementById('clientSelect').required = !isStudent;
  document.getElementById('studentSelect').required = isStudent;
}

function loadStudentCourse(sel) {
  const opt = sel.options[sel.selectedIndex];
  const fee   = parseFloat(opt.dataset.courseFee || 0);
  const title = opt.dataset.courseTitle || '';
  if (title) {
    // Clear existing rows and add course fee row
    document.getElementById('itemsBody').innerHTML = '';
    addProductRow(0, 'Course Fee: ' + title, fee, 18);
  }
}

function rowTemplate(psId, name, qty, price, gst) {
  const tr = document.createElement('tr');
  tr.className = 'item-row';
  tr.innerHTML = `
    <td>
      <input type="hidden" name="item_ps_id[]" value="\${psId}">
      <input type="text" name="item_name[]" class="form-control form-control-sm" value="\${name}" placeholder="Description" required>
    </td>
    <td><input type="number" name="item_qty[]" class="form-control form-control-sm qty" value="\${qty}" step="0.01" min="0" onchange="calcRow(this)"></td>
    <td><input type="number" name="item_price[]" class="form-control form-control-sm price" value="\${price}" step="0.01" min="0" onchange="calcRow(this)"></td>
    <td><input type="number" name="item_gst[]" class="form-control form-control-sm gst" value="\${gst}" step="0.01" min="0" max="100" onchange="calcRow(this)"></td>
    <td><input type="number" name="item_tax[]" class="form-control form-control-sm tax-display bg-light" value="0" readonly></td>
    <td><input type="number" name="item_total[]" class="form-control form-control-sm row-total bg-light" value="0" readonly></td>
    <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)"><i class="fa fa-times"></i></button></td>
  `;
  return tr;
}

function addRow() {
  const tr = rowTemplate(0, '', 1, 0, 18);
  document.getElementById('itemsBody').appendChild(tr);
  calcRow(tr.querySelector('.qty'));
}

function addProductRow(psId, name, price, gst) {
  const tr = rowTemplate(psId, name, 1, price, gst);
  document.getElementById('itemsBody').appendChild(tr);
  calcRow(tr.querySelector('.qty'));
}

function removeRow(btn) {
  const rows = document.querySelectorAll('.item-row');
  if (rows.length > 1) { btn.closest('tr').remove(); updateTotals(); }
}

function calcRow(el) {
  const row   = el.closest('tr');
  const qty   = parseFloat(row.querySelector('.qty').value)   || 0;
  const price = parseFloat(row.querySelector('.price').value) || 0;
  const gst   = parseFloat(row.querySelector('.gst').value)   || 0;
  const base  = qty * price;
  const tax   = parseFloat((base * gst / 100).toFixed(2));
  const total = parseFloat((base + tax).toFixed(2));
  row.querySelector('.tax-display').value = tax;
  row.querySelector('.row-total').value   = total;
  updateTotals();
}

function updateTotals() {
  let sub = 0, tax = 0;
  document.querySelectorAll('.item-row').forEach(row => {
    sub += parseFloat(row.querySelector('.price').value || 0) * parseFloat(row.querySelector('.qty').value || 0);
    tax += parseFloat(row.querySelector('.tax-display').value || 0);
  });
  const disc  = parseFloat(document.getElementById('discount_amount').value) || 0;
  const grand = sub + tax - disc;
  document.getElementById('dispSubtotal').textContent = '₹' + sub.toFixed(2);
  document.getElementById('dispTax').textContent      = '₹' + tax.toFixed(2);
  document.getElementById('dispGrand').textContent    = '₹' + grand.toFixed(2);
  document.getElementById('sub_total').value          = sub.toFixed(2);
  document.getElementById('tax_amount').value         = tax.toFixed(2);
  document.getElementById('grand_total').value        = grand.toFixed(2);
}

// Init totals on page load
document.querySelectorAll('.item-row').forEach(row => {
  const qtyEl = row.querySelector('.qty');
  if (qtyEl) calcRow(qtyEl);
});
updateTotals();
</script>
JS;
require APP_ROOT.'/views/partials/layout_bottom.php';
?>