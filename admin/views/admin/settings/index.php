<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<h5 class="fw-bold mb-3"><i class="fa fa-gear me-2 text-primary"></i>Company Settings</h5>

<ul class="nav nav-tabs mb-3" id="settingsTabs">
  <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab-company"><i class="fa fa-building me-1"></i>Company Info</a></li>
  <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-bank"><i class="fa fa-landmark me-1"></i>Bank Details</a></li>
  <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-employees"><i class="fa fa-users me-1"></i>Employees</a></li>
</ul>

<div class="tab-content">

  <!-- Company Info Tab -->
  <div class="tab-pane fade show active" id="tab-company">
    <div class="card"><div class="card-body">
      <form method="POST" action="<?= APP_URL ?>/admin/settings/company">
        <div class="row g-3">
          <div class="col-md-6"><label class="form-label fw-semibold">Company Name</label>
            <input type="text" name="company_name" class="form-control" value="<?= htmlspecialchars($settings['company_name']??'Araneus Edutech') ?>"></div>
          <div class="col-md-6"><label class="form-label fw-semibold">Tagline</label>
            <input type="text" name="company_tagline" class="form-control" value="<?= htmlspecialchars($settings['company_tagline']??'') ?>"></div>
          <div class="col-md-4"><label class="form-label fw-semibold">Email</label>
            <input type="email" name="company_email" class="form-control" value="<?= htmlspecialchars($settings['company_email']??'') ?>"></div>
          <div class="col-md-4"><label class="form-label fw-semibold">Phone</label>
            <input type="text" name="company_phone" class="form-control" value="<?= htmlspecialchars($settings['company_phone']??'') ?>"></div>
          <div class="col-md-4"><label class="form-label fw-semibold">Website</label>
            <input type="url" name="company_website" class="form-control" value="<?= htmlspecialchars($settings['company_website']??'') ?>"></div>
          <div class="col-md-4"><label class="form-label fw-semibold">GSTIN</label>
            <input type="text" name="company_gstin" class="form-control" value="<?= htmlspecialchars($settings['company_gstin']??'') ?>"></div>
          <div class="col-md-4"><label class="form-label fw-semibold">PAN</label>
            <input type="text" name="company_pan" class="form-control" value="<?= htmlspecialchars($settings['company_pan']??'') ?>"></div>
          <div class="col-md-4"><label class="form-label fw-semibold">City</label>
            <input type="text" name="company_city" class="form-control" value="<?= htmlspecialchars($settings['company_city']??'') ?>"></div>
          <div class="col-md-4"><label class="form-label fw-semibold">State</label>
            <input type="text" name="company_state" class="form-control" value="<?= htmlspecialchars($settings['company_state']??'') ?>"></div>
          <div class="col-md-4"><label class="form-label fw-semibold">Pincode</label>
            <input type="text" name="company_pincode" class="form-control" value="<?= htmlspecialchars($settings['company_pincode']??'') ?>"></div>
          <div class="col-12"><label class="form-label fw-semibold">Address</label>
            <textarea name="company_address" class="form-control" rows="2"><?= htmlspecialchars($settings['company_address']??'') ?></textarea></div>
          <div class="col-12"><button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i>Save Company Info</button></div>
        </div>
      </form>
    </div></div>
  </div>

  <!-- Bank Details Tab -->
  <div class="tab-pane fade" id="tab-bank">
    <div class="card"><div class="card-body">
      <form method="POST" action="<?= APP_URL ?>/admin/settings/company">
        <!-- hidden fields so only bank fields get sent but company fields carry over -->
        <?php foreach(['company_name','company_email','company_phone','company_address','company_city','company_state','company_pincode','company_gstin','company_pan','company_website','company_tagline'] as $k): ?>
        <input type="hidden" name="<?= $k ?>" value="<?= htmlspecialchars($settings[$k]??'') ?>">
        <?php endforeach; ?>
        <div class="row g-3">
          <div class="col-md-6"><label class="form-label fw-semibold">Bank Name</label>
            <input type="text" name="bank_name" class="form-control" value="<?= htmlspecialchars($settings['bank_name']??'') ?>"></div>
          <div class="col-md-6"><label class="form-label fw-semibold">Account Number</label>
            <input type="text" name="bank_account" class="form-control" value="<?= htmlspecialchars($settings['bank_account']??'') ?>"></div>
          <div class="col-md-6"><label class="form-label fw-semibold">IFSC Code</label>
            <input type="text" name="bank_ifsc" class="form-control" value="<?= htmlspecialchars($settings['bank_ifsc']??'') ?>"></div>
          <div class="col-md-6"><label class="form-label fw-semibold">Branch</label>
            <input type="text" name="bank_branch" class="form-control" value="<?= htmlspecialchars($settings['bank_branch']??'') ?>"></div>
          <div class="col-12"><button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i>Save Bank Details</button></div>
        </div>
      </form>
    </div></div>
  </div>

  <!-- Employees Tab -->
  <div class="tab-pane fade" id="tab-employees">
    <!-- Add form -->
    <div class="card mb-3"><div class="card-header bg-transparent"><h6 class="mb-0 fw-semibold"><i class="fa fa-user-plus me-2"></i>Add Employee / Freelancer</h6></div>
    <div class="card-body">
      <form method="POST" action="<?= APP_URL ?>/admin/settings/employees/create">
        <div class="row g-2">
          <div class="col-md-3"><input type="text" name="name" class="form-control form-control-sm" placeholder="Full Name" required></div>
          <div class="col-md-3"><input type="text" name="role" class="form-control form-control-sm" placeholder="Role / Designation" required></div>
          <div class="col-md-2">
            <select name="type" class="form-select form-select-sm">
              <option value="full-time">Full-time</option>
              <option value="part-time">Part-time</option>
              <option value="freelancer">Freelancer</option>
              <option value="intern">Intern</option>
            </select>
          </div>
          <div class="col-md-2"><input type="email" name="email" class="form-control form-control-sm" placeholder="Email"></div>
          <div class="col-md-2"><input type="text" name="phone" class="form-control form-control-sm" placeholder="Phone"></div>
          <div class="col-md-2"><input type="number" name="salary" class="form-control form-control-sm" placeholder="Salary/Rate ₹" step="0.01"></div>
          <div class="col-md-2"><input type="date" name="join_date" class="form-control form-control-sm" value="<?= date('Y-m-d') ?>"></div>
          <div class="col-md-2">
            <select name="status" class="form-select form-select-sm">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
          <div class="col-md-3"><input type="text" name="notes" class="form-control form-control-sm" placeholder="Notes"></div>
          <div class="col-md-1"><button type="submit" class="btn btn-primary btn-sm w-100"><i class="fa fa-plus"></i></button></div>
        </div>
      </form>
    </div></div>

    <!-- Employee list -->
    <div class="card">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead><tr><th>Name</th><th>Role</th><th>Type</th><th>Email</th><th>Phone</th><th>Salary/Rate</th><th>Joined</th><th>Status</th><th>Actions</th></tr></thead>
          <tbody>
          <?php foreach($employees as $e): ?>
          <tr>
            <td class="fw-semibold"><?= htmlspecialchars($e['name']) ?></td>
            <td><?= htmlspecialchars($e['role']) ?></td>
            <td>
              <?php $tc=['full-time'=>'primary','part-time'=>'info','freelancer'=>'warning','intern'=>'secondary']; ?>
              <span class="badge bg-<?= $tc[$e['type']]??'secondary' ?>-subtle text-<?= $tc[$e['type']]??'secondary' ?>"><?= ucfirst($e['type']) ?></span>
            </td>
            <td class="small text-muted"><?= htmlspecialchars($e['email']) ?></td>
            <td class="small"><?= htmlspecialchars($e['phone']) ?></td>
            <td class="fw-semibold">₹<?= number_format($e['salary'],0) ?></td>
            <td class="small text-muted"><?= $e['join_date'] ?></td>
            <td><span class="badge badge-status-<?= $e['status'] ?>"><?= ucfirst($e['status']) ?></span></td>
            <td>
              <button class="btn btn-sm btn-outline-primary btn-action"
                onclick="editEmployee(<?= htmlspecialchars(json_encode($e)) ?>)">
                <i class="fa fa-pen"></i>
              </button>
              <form method="POST" action="<?= APP_URL ?>/admin/settings/employees/<?= $e['id'] ?>/delete" class="d-inline" onsubmit="return confirm('Remove employee?')">
                <button class="btn btn-sm btn-outline-danger btn-action"><i class="fa fa-trash"></i></button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php if(empty($employees)): ?>
          <tr><td colspan="9" class="text-center text-muted py-3">No employees yet</td></tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Edit Employee Modal -->
<div class="modal fade" id="editEmpModal" tabindex="-1">
  <div class="modal-dialog"><div class="modal-content">
    <form method="POST" id="editEmpForm">
      <div class="modal-header"><h6 class="modal-title fw-bold">Edit Employee</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-6"><label class="form-label fw-semibold">Name</label><input type="text" name="name" id="ee_name" class="form-control" required></div>
          <div class="col-md-6"><label class="form-label fw-semibold">Role</label><input type="text" name="role" id="ee_role" class="form-control" required></div>
          <div class="col-md-6"><label class="form-label fw-semibold">Type</label>
            <select name="type" id="ee_type" class="form-select">
              <option value="full-time">Full-time</option><option value="part-time">Part-time</option>
              <option value="freelancer">Freelancer</option><option value="intern">Intern</option>
            </select></div>
          <div class="col-md-6"><label class="form-label fw-semibold">Status</label>
            <select name="status" id="ee_status" class="form-select">
              <option value="active">Active</option><option value="inactive">Inactive</option>
            </select></div>
          <div class="col-md-6"><label class="form-label fw-semibold">Email</label><input type="email" name="email" id="ee_email" class="form-control"></div>
          <div class="col-md-6"><label class="form-label fw-semibold">Phone</label><input type="text" name="phone" id="ee_phone" class="form-control"></div>
          <div class="col-md-6"><label class="form-label fw-semibold">Salary/Rate ₹</label><input type="number" name="salary" id="ee_salary" class="form-control" step="0.01"></div>
          <div class="col-12"><label class="form-label fw-semibold">Notes</label><input type="text" name="notes" id="ee_notes" class="form-control"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i>Update</button>
      </div>
    </form>
  </div></div>
</div>

<?php $extraJs = '<script>
function editEmployee(e) {
  document.getElementById("ee_name").value   = e.name;
  document.getElementById("ee_role").value   = e.role;
  document.getElementById("ee_type").value   = e.type;
  document.getElementById("ee_status").value = e.status;
  document.getElementById("ee_email").value  = e.email;
  document.getElementById("ee_phone").value  = e.phone;
  document.getElementById("ee_salary").value = e.salary;
  document.getElementById("ee_notes").value  = e.notes || "";
  document.getElementById("editEmpForm").action = "'.APP_URL.'/admin/settings/employees/" + e.id + "/edit";
  new bootstrap.Modal(document.getElementById("editEmpModal")).show();
}
</script>'; ?>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>