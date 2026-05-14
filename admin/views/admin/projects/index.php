<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><i class="fa fa-layer-group me-2 text-primary"></i>Projects</h5>
  <a href="<?= APP_URL ?>/admin/projects/create" class="btn btn-primary btn-sm">
    <i class="fa fa-plus me-1"></i>New Project
  </a>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <th style="width:50px;">#</th>
          <th>Title</th>
          <th>Category</th>
          <th>Tags</th>
          <th>Status</th>
          <th style="width:70px;">Order</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php if (empty($projects)): ?>
        <tr><td colspan="7" class="text-center text-muted py-4">No projects yet. <a href="<?= APP_URL ?>/admin/projects/create">Add one</a>.</td></tr>
      <?php else: ?>
      <?php foreach ($projects as $p): ?>
        <tr>
          <td>
            <?php if ($p['image_url']): ?>
              <img src="<?= htmlspecialchars($p['image_url']) ?>"
                   alt="" width="40" height="40"
                   style="object-fit:cover;border-radius:6px;"
                   onerror="this.style.display='none'">
            <?php else: ?>
              <div style="width:40px;height:40px;border-radius:6px;background:<?= htmlspecialchars($p['color']) ?>;display:flex;align-items:center;justify-content:center;">
                <i class="fa fa-layer-group text-white" style="font-size:.8rem;"></i>
              </div>
            <?php endif; ?>
          </td>
          <td class="fw-semibold"><?= htmlspecialchars($p['title']) ?></td>
          <td>
            <span class="badge bg-secondary-subtle text-secondary">
              <?= htmlspecialchars($p['category']) ?>
            </span>
          </td>
          <td class="small text-muted">
            <?php foreach (array_slice(explode(',', $p['tags'] ?? ''), 0, 3) as $tag): ?>
              <span class="badge bg-light text-secondary border me-1"><?= htmlspecialchars(trim($tag)) ?></span>
            <?php endforeach; ?>
          </td>
          <td>
            <span class="badge <?= $p['status']==='published' ? 'bg-success' : 'bg-warning text-dark' ?>">
              <?= ucfirst($p['status']) ?>
            </span>
          </td>
          <td class="text-muted text-center"><?= (int)$p['sort_order'] ?></td>
          <td>
            <a href="<?= APP_URL ?>/admin/projects/<?= $p['id'] ?>/edit"
               class="btn btn-sm btn-outline-primary btn-action" title="Edit">
              <i class="fa fa-pen"></i>
            </a>
            <form method="POST"
                  action="<?= APP_URL ?>/admin/projects/<?= $p['id'] ?>/delete"
                  class="d-inline"
                  onsubmit="return confirm('Delete \'<?= htmlspecialchars(addslashes($p['title'])) ?>\'? This cannot be undone.')">
              <button class="btn btn-sm btn-outline-danger btn-action" title="Delete">
                <i class="fa fa-trash"></i>
              </button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
