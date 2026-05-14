<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0">
    <i class="fa fa-bullhorn me-2 text-primary"></i>Job Openings
  </h5>
  <div class="d-flex gap-2">
    <a href="<?= APP_URL ?>/admin/careers" class="btn btn-sm btn-outline-secondary">
      <i class="fa fa-inbox me-1"></i>Applications
    </a>
    <a href="<?= APP_URL ?>/admin/careers/jobs/create" class="btn btn-sm btn-primary">
      <i class="fa fa-plus me-1"></i>Post New Job
    </a>
  </div>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <th>Title</th>
          <th>Department</th>
          <th>Location</th>
          <th>Type</th>
          <th>Posted</th>
          <th>Deadline</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($jobs as $j): ?>
      <tr>
        <td class="fw-semibold"><?= htmlspecialchars($j['title']) ?></td>
        <td>
          <span class="badge bg-primary-subtle text-primary">
            <?= htmlspecialchars($j['department']) ?>
          </span>
        </td>
        <td class="small text-muted"><?= htmlspecialchars($j['location']) ?></td>
        <td>
          <span class="badge bg-secondary-subtle text-secondary">
            <?= ucfirst($j['employment_type']) ?>
          </span>
        </td>
        <td class="small text-muted">
          <?= $j['posted_date'] ? date('d M Y', strtotime($j['posted_date'])) : '—' ?>
        </td>
        <td class="small <?= ($j['application_deadline'] && $j['application_deadline'] < date('Y-m-d')) ? 'text-danger fw-semibold' : 'text-muted' ?>">
          <?= $j['application_deadline'] ? date('d M Y', strtotime($j['application_deadline'])) : '—' ?>
        </td>
        <td>
          <span class="badge <?= $j['is_active'] ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' ?>">
            <?= $j['is_active'] ? 'Active' : 'Closed' ?>
          </span>
        </td>
        <td>
          <a href="<?= APP_URL ?>/admin/careers/jobs/<?= $j['id'] ?>/edit"
             class="btn btn-sm btn-outline-primary btn-action" title="Edit">
            <i class="fa fa-pen"></i>
          </a>
          <form method="POST"
                action="<?= APP_URL ?>/admin/careers/jobs/<?= $j['id'] ?>/delete"
                class="d-inline"
                onsubmit="return confirm('Delete this job posting?')">
            <button class="btn btn-sm btn-outline-danger btn-action" title="Delete">
              <i class="fa fa-trash"></i>
            </button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php if (empty($jobs)): ?>
      <tr>
        <td colspan="8" class="text-center text-muted py-4">
          No job postings yet.
          <a href="<?= APP_URL ?>/admin/careers/jobs/create">Post your first job</a>
        </td>
      </tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
