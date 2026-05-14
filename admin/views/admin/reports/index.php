<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0"><i class="fa fa-chart-bar me-2 text-primary"></i>Reports & Analytics</h5>
  <div class="d-flex gap-2">
    <a href="<?= APP_URL ?>/admin/reports/export?type=students" class="btn btn-sm btn-outline-success"><i class="fa fa-download me-1"></i>Students CSV</a>
    <a href="<?= APP_URL ?>/admin/reports/export?type=enrollments" class="btn btn-sm btn-outline-info"><i class="fa fa-download me-1"></i>Enrollments CSV</a>
    <a href="<?= APP_URL ?>/admin/reports/export?type=invoices" class="btn btn-sm btn-outline-warning"><i class="fa fa-download me-1"></i>Invoices CSV</a>
  </div>
</div>
<div class="row g-3 mb-4">
  <div class="col-lg-7">
    <div class="card h-100">
      <div class="card-header bg-transparent"><h6 class="mb-0 fw-semibold"><i class="fa fa-chart-line me-2 text-success"></i>Monthly Revenue (Paid Invoices)</h6></div>
      <div class="card-body"><canvas id="revenueChart" height="100"></canvas></div>
    </div>
  </div>
  <div class="col-lg-5">
    <div class="card h-100">
      <div class="card-header bg-transparent"><h6 class="mb-0 fw-semibold"><i class="fa fa-pie-chart me-2 text-warning"></i>Student Status</h6></div>
      <div class="card-body d-flex align-items-center justify-content-center"><canvas id="studentChart" width="200" height="200"></canvas></div>
    </div>
  </div>
</div>
<div class="row g-3">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-transparent"><h6 class="mb-0 fw-semibold"><i class="fa fa-trophy me-2 text-warning"></i>Enrollments by Course</h6></div>
      <div class="card-body"><canvas id="courseChart" height="120"></canvas></div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-transparent"><h6 class="mb-0 fw-semibold"><i class="fa fa-building me-2 text-primary"></i>Top Clients by Revenue</h6></div>
      <div class="table-responsive">
        <table class="table table-sm mb-0">
          <thead><tr><th>Client</th><th>Invoices</th><th>Revenue</th></tr></thead>
          <tbody>
          <?php foreach($top_clients as $c): ?>
          <tr><td><?= htmlspecialchars($c['client_name']) ?></td>
              <td><?= $c['invoice_count'] ?></td>
              <td class="fw-semibold text-success">₹<?= number_format($c['total'],0) ?></td></tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php
$rm=array_reverse($revenue_monthly);
$extraJs='<script>
new Chart(document.getElementById("revenueChart"),{type:"bar",data:{labels:'.json_encode(array_column($rm,"month")).',datasets:[{label:"Revenue ₹",data:'.json_encode(array_column($rm,"total")).',backgroundColor:"rgba(16,185,129,.7)",borderRadius:5}]},options:{plugins:{legend:{display:false}},scales:{y:{beginAtZero:true}}}});
new Chart(document.getElementById("studentChart"),{type:"doughnut",data:{labels:'.json_encode(array_column($students_by_status,"status")).',datasets:[{data:'.json_encode(array_column($students_by_status,"count")).',backgroundColor:["#4f8ef7","#10b981","#f59e0b"]}]},options:{plugins:{legend:{position:"bottom"}}}});
new Chart(document.getElementById("courseChart"),{type:"bar",data:{labels:'.json_encode(array_map(fn($r)=>substr($r["title"],0,20),$enrollments_by_course)).',datasets:[{label:"Enrollments",data:'.json_encode(array_column($enrollments_by_course,"count")).',backgroundColor:"rgba(79,142,247,.7)",borderRadius:5}]},options:{indexAxis:"y",plugins:{legend:{display:false}}}});
</script>';
require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
