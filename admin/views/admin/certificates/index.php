<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0">
    <i class="fa fa-certificate me-2 text-warning"></i>Certificates
    <span class="badge bg-secondary ms-1"><?= $total ?></span>
  </h5>
  <a href="<?= APP_URL ?>/admin/certificates/create" class="btn btn-primary btn-sm">
    <i class="fa fa-plus me-1"></i>Generate Certificate
  </a>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <th>Certificate ID</th>
          <th>Student</th>
          <th>Program</th>
          <th>Type</th>
          <th>Issued</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($certs as $c): ?>
      <tr>
        <td><code class="small"><?= htmlspecialchars($c['certificate_id']) ?></code></td>
        <td>
          <span class="fw-semibold"><?= htmlspecialchars($c['full_name']) ?></span>
          <br><small class="text-muted"><?= htmlspecialchars($c['candidate_id']) ?></small>
        </td>
        <td class="small"><?= htmlspecialchars(substr($c['program_name'], 0, 45)) ?></td>
        <td>
          <?php $tc = ['participation'=>'primary','completion'=>'success','merit'=>'warning']; ?>
          <span class="badge bg-<?= $tc[$c['certificate_type']] ?? 'secondary' ?>-subtle
                             text-<?= $tc[$c['certificate_type']] ?? 'secondary' ?>">
            <?= ucfirst($c['certificate_type']) ?>
          </span>
        </td>
        <td class="small text-muted">
          <?= $c['issued_date'] ? date('d M Y', strtotime($c['issued_date'])) : '—' ?>
        </td>
        <td>
          <span class="badge <?= $c['status']==='issued'?'bg-success':($c['status']==='revoked'?'bg-danger':'bg-secondary') ?>">
            <?= ucfirst($c['status']) ?>
          </span>
        </td>
        <td>
          <a href="<?= APP_URL ?>/admin/certificates/<?= $c['id'] ?>"
             class="btn btn-sm btn-outline-info btn-action" title="View">
            <i class="fa fa-eye"></i>
          </a>
          <a href="<?= APP_URL ?>/admin/certificates/<?= $c['id'] ?>/print"
             target="_blank"
             class="btn btn-sm btn-outline-success btn-action" title="Print / Download">
            <i class="fa fa-print"></i>
          </a>
          <form method="POST"
                action="<?= APP_URL ?>/admin/certificates/<?= $c['id'] ?>/delete"
                class="d-inline"
                onsubmit="return confirm('Delete certificate?')">
            <button class="btn btn-sm btn-outline-danger btn-action" title="Delete">
              <i class="fa fa-trash"></i>
            </button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php if (empty($certs)): ?>
      <tr><td colspan="7" class="text-center text-muted py-4">No certificates generated yet</td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
  <?php if ($pages > 1): ?>
  <div class="card-footer">
    <nav><ul class="pagination pagination-sm mb-0">
      <?php for ($i = 1; $i <= $pages; $i++): ?>
      <li class="page-item <?= $i === $page ? 'active' : '' ?>">
        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
      </li>
      <?php endfor; ?>
    </ul></nav>
  </div>
  <?php endif; ?>
</div>
<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>