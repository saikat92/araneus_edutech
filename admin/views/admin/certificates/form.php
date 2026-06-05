<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0">Generate Certificate</h5>
  <a href="<?= APP_URL ?>/admin/certificates" class="btn btn-sm btn-outline-secondary">
    <i class="fa fa-arrow-left me-1"></i>Back
  </a>
</div>

<div class="card">
  <div class="card-body">
    <form method="POST" action="<?= APP_URL ?>/admin/certificates/create" id="certForm" enctype="multipart/form-data">
      <div class="row g-3">

        <!-- Student picker -->
        <div class="col-md-6">
          <label class="form-label fw-semibold">Student <span class="text-danger">*</span></label>
          <select name="student_id" id="studentPicker" class="form-select" required onchange="fillFromStudent(this)">
            <option value="">Select Student...</option>
            <?php
            $seen = [];
            foreach ($students as $s):
              if (in_array($s['id'], $seen)) continue;
              $seen[] = $s['id'];
            ?>
            <option value="<?= $s['id'] ?>"
              data-enrollment="<?= $s['enrollment_id'] ?>"
              data-course="<?= htmlspecialchars($s['course_title'] ?? '') ?>"
              data-start="<?= $s['enrollment_date'] ?? '' ?>"
              data-end="<?= $s['completion_date'] ?? '' ?>"
              data-hours="<?= $s['time_hours'] ?>">
              <?= htmlspecialchars($s['full_name']) ?> — <?= $s['candidate_id'] ?>
            </option>
            <?php endforeach; ?>
          </select>
          <input type="hidden" name="enrollment_id" id="enrollmentId">
        </div>

        <div class="col-md-3">
          <label class="form-label fw-semibold">Certificate Type</label>
          <select name="certificate_type" class="form-select">
            <option value="participation">Participation</option>
            <option value="completion">Completion</option>
            <option value="merit">Merit</option>
          </select>
        </div>

        <div class="col-md-3">
          <label class="form-label fw-semibold">Certificate ID Prefix</label>
          <div class="input-group">
            <input type="text" name="cert_prefix" class="form-control" value="PP" maxlength="5"
                   style="text-transform:uppercase" placeholder="PP">
            <span class="input-group-text text-muted small">/MM/YY/XXXXXX</span>
          </div>
          <div class="form-text">Auto-generated. Prefix e.g. PP, CP, MT</div>
        </div>

        <div class="col-12">
          <label class="form-label fw-semibold">Program Name <span class="text-danger">*</span></label>
          <input type="text" name="program_name" id="programName" class="form-control"
                 placeholder="e.g. Integrated Internship Program on Python Power" required
                 value="<?= htmlspecialchars($cert['program_name'] ?? '') ?>">
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">Project Name</label>
          <input type="text" name="project_name" class="form-control"
                 placeholder='e.g. "BizInsight_Pro"'
                 value="<?= htmlspecialchars($cert['project_name'] ?? '') ?>">
        </div>

        <div class="col-md-3">
          <label class="form-label fw-semibold">Mode</label>
          <select name="mode" class="form-select">
            <option value="Offline">Offline</option>
            <option value="Online">Online</option>
            <option value="Hybrid">Hybrid</option>
          </select>
        </div>

        <div class="col-md-3">
          <label class="form-label fw-semibold">Duration</label>
          <input type="text" name="duration" id="durationField" class="form-control"
                 placeholder="e.g. 120 hours"
                 value="<?= htmlspecialchars($cert['duration'] ?? '') ?>">
        </div>

        <div class="col-md-3">
          <label class="form-label fw-semibold">Start Date</label>
          <input type="date" name="start_date" id="startDate" class="form-control"
                 value="<?= $cert['start_date'] ?? '' ?>">
        </div>

        <div class="col-md-3">
          <label class="form-label fw-semibold">End Date</label>
          <input type="date" name="end_date" id="endDate" class="form-control"
                 value="<?= $cert['end_date'] ?? '' ?>">
        </div>

        <div class="col-md-4">
          <label class="form-label fw-semibold">Director Name</label>
          <input type="text" name="director_name" class="form-control"
                 value="Shubhajit Kantossan">
        </div>

        <div class="col-md-4">
          <label class="form-label fw-semibold">Project Coordinator</label>
          <input type="text" name="coordinator_name" class="form-control"
                 value="Mayukh Maitha">
        </div>
        
        <div class="col-md-6">
          <label class="form-label fw-semibold">QR Code Image</label>
          <input type="file" name="qr_image" id="qrImage" class="form-control"
                accept="image/png,image/jpeg,image/jpg"
                onchange="previewQR(this)">
          <div class="form-text">Upload your pre-generated QR PNG. Leave blank to use API fallback.</div>
          <div id="qrPreview" class="mt-2 d-none">
            <img id="qrPreviewImg" src="" style="width:100px;height:100px;border:2px solid #c9a84c;border-radius:8px;padding:4px;">
          </div>
        </div>


        <div class="col-12 mt-2 d-flex gap-2">
          <button type="submit" class="btn btn-primary px-4">
            <i class="fa fa-certificate me-2"></i>Generate Certificate
          </button>
          <a href="<?= APP_URL ?>/admin/certificates" class="btn btn-outline-secondary">Cancel</a>
        </div>

      </div>
    </form>
  </div>
</div>

<?php
$studentsJson = json_encode($students);
$extraJs = <<<JS
<script>

function previewQR(input) {
  const preview = document.getElementById('qrPreview');
  const img     = document.getElementById('qrPreviewImg');
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => { img.src = e.target.result; preview.classList.remove('d-none'); };
    reader.readAsDataURL(input.files[0]);
  }
}

const studentsData = $studentsJson;

function fillFromStudent(sel) {
  const opt = sel.options[sel.selectedIndex];
  if (!opt.value) return;
  document.getElementById('enrollmentId').value  = opt.dataset.enrollment || '';
  document.getElementById('startDate').value     = opt.dataset.start || '';
  document.getElementById('endDate').value       = opt.dataset.end   || '';
  if (opt.dataset.hours) {
    document.getElementById('durationField').value = opt.dataset.hours + ' hours';
  }
  if (opt.dataset.course) {
    // Suggest program name if empty
    const pn = document.getElementById('programName');
    if (!pn.value) pn.value = opt.dataset.course;
  }
}
</script>
JS;
require APP_ROOT.'/views/partials/layout_bottom.php';
?>