<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h5 class="fw-bold mb-0">Dashboard</h5>
    <p class="text-muted small mb-0">Welcome back, <?= htmlspecialchars($_SESSION['user_name']) ?></p>
  </div>
  <span class="badge bg-primary-subtle text-primary px-3 py-2"><i class="fa fa-calendar me-1"></i><?= date('d M Y') ?></span>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
  <?php $cards=[
    ['label'=>'Total Students','val'=>$stats['total_students'],'icon'=>'fa-user-graduate','bg'=>'#4f8ef7','sub'=>$stats['active_students'].' active'],
    ['label'=>'Enrollments','val'=>$stats['total_enrollments'],'icon'=>'fa-list-check','bg'=>'#10b981','sub'=>$stats['total_courses'].' courses'],
    ['label'=>'Clients','val'=>$stats['total_clients'],'icon'=>'fa-building','bg'=>'#f59e0b','sub'=>$stats['pending_invoices'].' pending invoices'],
    ['label'=>'Revenue Collected','val'=>'₹'.number_format($stats['total_revenue'],0),'icon'=>'fa-indian-rupee-sign','bg'=>'#6366f1','sub'=>'Paid invoices'],
    ['label'=>'Pending Grading','val'=>$stats['pending_grading'],'icon'=>'fa-file-arrow-up','bg'=>'#ef4444','sub'=>'Submissions'],
    ['label'=>'New Contacts','val'=>$stats['new_contacts'],'icon'=>'fa-envelope','bg'=>'#14b8a6','sub'=>'Unread messages'],
  ]; foreach($cards as $c): ?>
  <div class="col-6 col-md-4 col-xl-2">
    <div class="card stat-card h-100">
      <div class="card-body d-flex align-items-start gap-3">
        <div class="icon-box" style="background:<?= $c['bg'] ?>22;color:<?= $c['bg'] ?>">
          <i class="fa <?= $c['icon'] ?>"></i>
        </div>
        <div>
          <div class="fw-bold fs-5 lh-1"><?= $c['val'] ?></div>
          <div class="text-muted" style="font-size:.72rem"><?= $c['label'] ?></div>
          <div class="text-muted" style="font-size:.68rem"><?= $c['sub'] ?></div>
        </div>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<div class="row g-3 mb-4">
  <div class="col-lg-7">
    <div class="card h-100">
      <div class="card-header bg-transparent border-0 pb-0 d-flex justify-content-between align-items-center">
        <h6 class="fw-semibold mb-0"><i class="fa fa-chart-line me-2 text-primary"></i>Enrollment Trend</h6>
      </div>
      <div class="card-body"><canvas id="enrollChart" height="90"></canvas></div>
    </div>
  </div>
  <div class="col-lg-5">
    <div class="card h-100">
      <div class="card-header bg-transparent border-0 pb-0">
        <h6 class="fw-semibold mb-0"><i class="fa fa-clock-rotate-left me-2 text-warning"></i>Recent Submissions</h6>
      </div>
      <div class="card-body p-0">
        <div class="list-group list-group-flush">
        <?php foreach($recent_submissions as $s): ?>
        <a href="<?= APP_URL ?>/admin/submissions/<?= $s['id'] ?>" class="list-group-item list-group-item-action px-3 py-2">
          <div class="fw-semibold small"><?= htmlspecialchars($s['full_name']) ?></div>
          <div class="text-muted" style="font-size:.75rem"><?= htmlspecialchars(substr($s['assignment_title'],0,40)) ?>...</div>
          <div class="d-flex justify-content-between mt-1">
            <?php if($s['grade']): ?><span class="badge bg-success-subtle text-success">Grade: <?= $s['grade'] ?></span><?php else: ?><span class="badge bg-warning-subtle text-warning">Pending</span><?php endif; ?>
            <span class="text-muted" style="font-size:.7rem"><?= date('d M',strtotime($s['submitted_at'])) ?></span>
          </div>
        </a>
        <?php endforeach; ?>
        <?php if(empty($recent_submissions)): ?><div class="text-center text-muted p-3 small">No submissions yet</div><?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
    <h6 class="fw-semibold mb-0"><i class="fa fa-users me-2 text-success"></i>Recent Students</h6>
    <a href="<?= APP_URL ?>/admin/students" class="btn btn-sm btn-outline-primary">View All</a>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead><tr><th>Candidate ID</th><th>Name</th><th>Email</th><th>Status</th><th>Joined</th></tr></thead>
        <tbody>
        <?php foreach($recent_students as $s): ?>
        <tr>
          <td><code class="small"><?= htmlspecialchars($s['candidate_id']) ?></code></td>
          <td><a href="<?= APP_URL ?>/admin/students/<?= $s['id'] ?>" class="text-decoration-none fw-semibold"><?= htmlspecialchars($s['full_name']) ?></a></td>
          <td class="text-muted small"><?= htmlspecialchars($s['email']) ?></td>
          <td><span class="badge badge-status-<?= $s['status'] ?>"><?= ucfirst($s['status']) ?></span></td>
          <td class="text-muted small"><?= date('d M Y',strtotime($s['created_at'])) ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php
$months=array_column(array_reverse($enrollment_chart),'month');
$counts=array_column(array_reverse($enrollment_chart),'total');
$extraJs = '<script>
new Chart(document.getElementById("enrollChart"),{
  type:"bar",
  data:{
    labels:'.json_encode($months).',
    datasets:[{label:"Enrollments",data:'.json_encode($counts).',backgroundColor:"rgba(79,142,247,.7)",borderRadius:6}]
  },
  options:{plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,ticks:{stepSize:1}}},responsive:true}
});
</script>';
require APP_ROOT.'/views/partials/layout_bottom.php';
