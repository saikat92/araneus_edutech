<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0">
    <i class="fa fa-briefcase me-2 text-warning"></i>Career Applications
  </h5>
  <a href="<?= APP_URL ?>/admin/careers/jobs" class="btn btn-sm btn-primary">
    <i class="fa fa-bullhorn me-1"></i>Manage Job Postings
  </a>
</div>

<!-- Status filter tabs -->
<div class="mb-3 d-flex gap-2 flex-wrap">
  <?php foreach ([''=>'All', 'new'=>'New', 'reviewed'=>'Reviewed', 'shortlisted'=>'Shortlisted', 'rejected'=>'Rejected'] as $val => $label): ?>
  <a href="?status=<?= $val ?>"
     class="btn btn-sm <?= $status === $val ? 'btn-primary' : 'btn-outline-secondary' ?>">
    <?= $label ?>
    <?php if ($val === 'new'): ?>
      <?php
        $db = \App\Core\Database::getInstance();
        $newCount = $db->count("SELECT COUNT(*) FROM career_applications WHERE status='new'");
        if ($newCount > 0): ?>
        <span class="badge bg-danger ms-1"><?= $newCount ?></span>
      <?php endif; ?>
    <?php endif; ?>
  </a>
  <?php endforeach; ?>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <th>Applicant</th>
          <th>Position</th>
          <th>Experience</th>
          <th>Applied</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php
      $statusColors = [
          'new'         => 'secondary',
          'reviewed'    => 'info',
          'shortlisted' => 'success',
          'rejected'    => 'danger',
      ];
      foreach ($careers as $c): ?>
      <tr>
        <td>
          <span class="fw-semibold"><?= htmlspecialchars($c['first_name'] . ' ' . $c['last_name']) ?></span>
          <br><small class="text-muted"><?= htmlspecialchars($c['email']) ?></small>
        </td>
        <td><?= htmlspecialchars($c['position']) ?></td>
        <td>
          <span class="badge bg-secondary-subtle text-secondary">
            <?= htmlspecialchars($c['experience']) ?>
          </span>
        </td>
        <td class="small text-muted">
          <?= date('d M Y', strtotime($c['application_date'])) ?>
        </td>
        <td>
          <span class="badge bg-<?= $statusColors[$c['status']] ?? 'secondary' ?>">
            <?= ucfirst($c['status']) ?>
          </span>
        </td>
        <td>
          <a href="<?= APP_URL ?>/admin/careers/<?= $c['id'] ?>"
             class="btn btn-sm btn-outline-info btn-action" title="View">
            <i class="fa fa-eye"></i>
          </a>
          <form method="POST"
                action="<?= APP_URL ?>/admin/careers/<?= $c['id'] ?>/delete"
                class="d-inline"
                onsubmit="return confirm('Delete this application?')">
            <button class="btn btn-sm btn-outline-danger btn-action" title="Delete">
              <i class="fa fa-trash"></i>
            </button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php if (empty($careers)): ?>
      <tr>
        <td colspan="6" class="text-center text-muted py-4">
          No applications found<?= $status ? ' with status "'.htmlspecialchars($status).'"' : '' ?>
        </td>
      </tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
