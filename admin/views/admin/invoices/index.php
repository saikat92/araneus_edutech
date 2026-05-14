<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><i class="fa fa-file-invoice me-2 text-primary"></i>Invoices <span class="badge bg-secondary ms-1"><?= $total ?></span></h5>
  <a href="<?= APP_URL ?>/admin/invoices/create" class="btn btn-primary btn-sm"><i class="fa fa-plus me-1"></i>New Invoice</a>
</div>
<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead><tr><th>Invoice#</th><th>Client</th><th>Date</th><th>Due</th><th>Total</th><th>Paid</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
      <?php
      $statusColors=['draft'=>'secondary','sent'=>'info','paid'=>'success','partial'=>'warning','overdue'=>'danger','cancelled'=>'dark'];
      foreach($invoices as $i): $sc=$statusColors[$i['status']]??'secondary'; ?>
      <tr>
        <td><a href="<?= APP_URL ?>/admin/invoices/<?= $i['id'] ?>" class="fw-semibold text-decoration-none"><?= htmlspecialchars($i['invoice_number']) ?></a></td>
        <td><?= htmlspecialchars($i['client_name']) ?></td>
        <td class="small text-muted"><?= $i['invoice_date'] ?></td>
        <td class="small <?= $i['due_date']<date('Y-m-d')&&!in_array($i['status'],['paid','cancelled'])?'text-danger fw-semibold':'' ?>"><?= $i['due_date'] ?></td>
        <td class="fw-semibold">₹<?= number_format($i['total_amount'],2) ?></td>
        <td class="text-success">₹<?= number_format($i['amount_paid'],2) ?></td>
        <td><span class="badge bg-<?= $sc ?><?= in_array($sc,['warning'])?' text-dark':'' ?>"><?= ucfirst($i['status']) ?></span></td>
        <td>
          <a href="<?= APP_URL ?>/admin/invoices/<?= $i['id'] ?>" class="btn btn-sm btn-outline-info btn-action"><i class="fa fa-eye"></i></a>
          <a href="<?= APP_URL ?>/admin/invoices/<?= $i['id'] ?>/edit" class="btn btn-sm btn-outline-primary btn-action"><i class="fa fa-pen"></i></a>
          <form method="POST" action="<?= APP_URL ?>/admin/invoices/<?= $i['id'] ?>/delete" class="d-inline" onsubmit="return confirm('Delete invoice?')">
            <button class="btn btn-sm btn-outline-danger btn-action"><i class="fa fa-trash"></i></button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
