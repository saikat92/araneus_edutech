<?php
$sortIcon = fn(string $col) =>
    ($filters['sort'] === $col)
        ? ($filters['order'] === 'asc' ? ' ▲' : ' ▼')
        : ' ⇅';

$sortUrl = function(string $col) use ($filters, $page, $limit): string {
    $order = ($filters['sort'] === $col && $filters['order'] === 'asc') ? 'desc' : 'asc';
    $q = array_merge($filters, ['sort' => $col, 'order' => $order, 'page' => 1, 'limit' => $limit]);
    return '?' . http_build_query($q);
};

$pageUrl = fn(int $p) => '?' . http_build_query(array_merge($filters, ['page' => $p, 'limit' => $limit]));

$dueBadge = function(?string $date): string {
    if (!$date) return '<span class="badge bg-secondary">No due date</span>';
    $d = new DateTime($date); $now = new DateTime('today');
    $diff = (int)$now->diff($d)->format('%r%a');
    if ($diff < 0)  return '<span class="badge bg-danger">Overdue (' . abs($diff) . 'd)</span>';
    if ($diff === 0) return '<span class="badge bg-warning text-dark">Due Today</span>';
    if ($diff <= 7)  return '<span class="badge bg-primary">In ' . $diff . ' days</span>';
    return '<span class="badge bg-success">' . $d->format('d M Y') . '</span>';
};
?>

<?php /* ── Stats bar ──────────────────────────────────────────── */ ?>
<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>


<div class="row g-3 mb-4">
    <?php
    $statCards = [
        ['label'=>'Total',     'value'=>$stats['total']    ?? 0, 'icon'=>'journal-text',  'color'=>'primary',  'filter'=>''],
        ['label'=>'Overdue',   'value'=>$stats['overdue']  ?? 0, 'icon'=>'exclamation-circle','color'=>'danger', 'filter'=>'overdue'],
        ['label'=>'Due Today', 'value'=>$stats['due_today']?? 0, 'icon'=>'clock',         'color'=>'warning',  'filter'=>'today'],
        ['label'=>'This Week', 'value'=>$stats['due_week'] ?? 0, 'icon'=>'calendar-week', 'color'=>'info',     'filter'=>'week'],
    ];
    foreach ($statCards as $sc):
        $active = ($filters['due_filter'] === $sc['filter']) ? 'border-' . $sc['color'] . ' shadow' : '';
        $fUrl   = '?' . http_build_query(array_merge($filters, ['due_filter' => $sc['filter'], 'page' => 1, 'limit' => $limit]));
    ?>
    <div class="col-6 col-md-3">
        <a href="<?= $fUrl ?>" class="text-decoration-none">
            <div class="card h-100 <?= $active ?>">
                <div class="card-body d-flex align-items-center gap-3 py-3">
                    <i class="bi bi-<?= $sc['icon'] ?> fs-2 text-<?= $sc['color'] ?>"></i>
                    <div>
                        <div class="fw-bold fs-4 lh-1"><?= $sc['value'] ?></div>
                        <div class="text-muted small"><?= $sc['label'] ?></div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div>

<?php /* ── Filters bar ─────────────────────────────────────────── */ ?>
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="<?= APP_URL ?>/admin/assignments" class="row g-2 align-items-end">
            <input type="hidden" name="sort"  value="<?= htmlspecialchars($filters['sort']) ?>">
            <input type="hidden" name="order" value="<?= htmlspecialchars($filters['order']) ?>">

            <div class="col-12 col-md-4">
                <label class="form-label small fw-semibold mb-1">Search</label>
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Title or description…"
                       value="<?= htmlspecialchars($filters['search']) ?>">
            </div>

            <div class="col-6 col-md-3">
                <label class="form-label small fw-semibold mb-1">Course</label>
                <select name="course_id" class="form-select form-select-sm">
                    <option value="">All Courses</option>
                    <?php foreach ($courses as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= $filters['course_id'] == $c['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['title']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-6 col-md-2">
                <label class="form-label small fw-semibold mb-1">Due Date</label>
                <select name="due_filter" class="form-select form-select-sm">
                    <option value="">All</option>
                    <option value="overdue"   <?= $filters['due_filter']==='overdue'   ?'selected':'' ?>>Overdue</option>
                    <option value="today"     <?= $filters['due_filter']==='today'     ?'selected':'' ?>>Due Today</option>
                    <option value="week"      <?= $filters['due_filter']==='week'      ?'selected':'' ?>>This Week</option>
                    <option value="upcoming"  <?= $filters['due_filter']==='upcoming'  ?'selected':'' ?>>Upcoming</option>
                    <option value="noduedate" <?= $filters['due_filter']==='noduedate' ?'selected':'' ?>>No Due Date</option>
                </select>
            </div>

            <div class="col-6 col-md-1">
                <label class="form-label small fw-semibold mb-1">Per page</label>
                <select name="limit" class="form-select form-select-sm">
                    <?php foreach ([10, 25, 50, 100] as $n): ?>
                    <option value="<?= $n ?>" <?= $limit==$n ?'selected':'' ?>><?= $n ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-6 col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-info btn-sm flex-fill">
                    <i class="fa fa-filter"></i> Filter
                </button>
                <a href="<?= APP_URL ?>/admin/assignments" class="btn btn-outline-secondary btn-sm btn-danger flex-fill">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<?php /* ── Table ───────────────────────────────────────────────── */ ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span class="fw-semibold">
            <?= $total ?> assignment<?= $total !== 1 ? 's' : '' ?>
            <?php if ($filters['search'] || $filters['course_id'] || $filters['due_filter']): ?>
            <span class="badge bg-secondary ms-1">filtered</span>
            <?php endif; ?>
        </span>
        <a href="<?= APP_URL ?>/admin/assignments/create" class="btn btn-primary btn-sm">
            <i class="fa fa-plus"></i> New Assignment
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width:32px">#</th>
                    <th>
                        <a href="<?= $sortUrl('a.title') ?>" class="text-decoration-none text-dark">
                            Title<?= $sortIcon('a.title') ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $sortUrl('c.title') ?>" class="text-decoration-none text-dark">
                            Course<?= $sortIcon('c.title') ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $sortUrl('a.due_date') ?>" class="text-decoration-none text-dark">
                            Due Date<?= $sortIcon('a.due_date') ?>
                        </a>
                    </th>
                    <th class="text-center">Submissions</th>
                    <th>
                        <a href="<?= $sortUrl('a.created_at') ?>" class="text-decoration-none text-dark">
                            Created<?= $sortIcon('a.created_at') ?>
                        </a>
                    </th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($assignments)): ?>
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                        No assignments found.
                        <?php if ($filters['search'] || $filters['course_id'] || $filters['due_filter']): ?>
                        <a href="/admin/assignments">Clear filters</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php else: ?>
            <?php foreach ($assignments as $i => $a): ?>
                <tr>
                    <td class="text-muted small"><?= $offset + $i + 1 ?></td>
                    <td>
                        <div class="fw-semibold"><?= htmlspecialchars($a['title']) ?></div>
                        <?php if (!empty($a['description'])): ?>
                        <div class="text-muted small text-truncate" style="max-width:280px">
                            <?= htmlspecialchars($a['description']) ?>
                        </div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= APP_URL ?>?course_id=<?= $a['course_id'] ?>&limit=<?= $limit ?>"
                           class="badge bg-light text-dark border text-decoration-none">
                            <?= htmlspecialchars($a['course_title']) ?>
                        </a>
                    </td>
                    <td><?= $dueBadge($a['due_date'] ?? null) ?></td>
                    <td class="text-center">
                        <?php
                            $sub   = (int)($a['submission_count'] ?? 0);
                            $graded = (int)($a['graded_count'] ?? 0);
                        ?>
                        <?php if ($sub > 0): ?>
                        <span class="fw-semibold"><?= $sub ?></span>
                        <span class="text-muted small">
                            (<?= $graded ?> graded)
                        </span>
                        <?php else: ?>
                        <span class="text-muted small">—</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-muted small">
                        <?= date('d M Y', strtotime($a['created_at'])) ?>
                    </td>
                    <td class="text-end">
                        <a href="<?= APP_URL ?>/admin/assignments/<?= $a['id'] ?>/edit"
                           class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <form method="POST" action="<?= APP_URL ?>/admin/assignments/<?= $a['id'] ?>/delete"
                              class="d-inline"
                              onsubmit="return confirm('Delete «<?= htmlspecialchars(addslashes($a['title'])) ?>»?')">
                            <button class="btn btn-sm btn-outline-danger">
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

    <?php if ($pages > 1): ?>
    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span class="text-muted small">
            Showing <?= $offset + 1 ?>–<?= min($offset + $limit, $total) ?> of <?= $total ?>
        </span>
        <nav>
            <ul class="pagination pagination-sm mb-0">
                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= $pageUrl($page - 1) ?>">‹</a>
                </li>
                <?php
                $start = max(1, $page - 2);
                $end   = min($pages, $page + 2);
                if ($start > 1) echo '<li class="page-item disabled"><span class="page-link">…</span></li>';
                for ($p = $start; $p <= $end; $p++):
                ?>
                <li class="page-item <?= $p === $page ? 'active' : '' ?>">
                    <a class="page-link" href="<?= $pageUrl($p) ?>"><?= $p ?></a>
                </li>
                <?php endfor;
                if ($end < $pages) echo '<li class="page-item disabled"><span class="page-link">…</span></li>';
                ?>
                <li class="page-item <?= $page >= $pages ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= $pageUrl($page + 1) ?>">›</a>
                </li>
            </ul>
        </nav>
    </div>
    <?php endif; ?>
</div>

<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
