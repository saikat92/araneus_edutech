<?php require APP_ROOT.'/views/partials/layout_top.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0">
    <?= isset($job) ? 'Edit Job Posting' : 'Post New Job' ?>
  </h5>
  <a href="<?= APP_URL ?>/admin/careers/jobs" class="btn btn-sm btn-outline-secondary">
    <i class="fa fa-arrow-left me-1"></i>Back to Jobs
  </a>
</div>

<div class="card">
  <div class="card-body">
    <form method="POST"
          action="<?= APP_URL ?>/admin/careers/jobs/<?= isset($job) ? $job['id'].'/edit' : 'create' ?>">
      <div class="row g-3">

        <div class="col-md-6">
          <label class="form-label fw-semibold">Job Title <span class="text-danger">*</span></label>
          <input type="text" name="title" class="form-control"
                 value="<?= htmlspecialchars($job['title'] ?? '') ?>" required>
        </div>

        <div class="col-md-3">
          <label class="form-label fw-semibold">Department</label>
          <input type="text" name="department" class="form-control"
                 value="<?= htmlspecialchars($job['department'] ?? '') ?>">
        </div>

        <div class="col-md-3">
          <label class="form-label fw-semibold">Location</label>
          <input type="text" name="location" class="form-control"
                 value="<?= htmlspecialchars($job['location'] ?? '') ?>">
        </div>

        <div class="col-md-3">
          <label class="form-label fw-semibold">Employment Type</label>
          <select name="employment_type" class="form-select">
            <?php foreach (['full-time'=>'Full-time','part-time'=>'Part-time','contract'=>'Contract','internship'=>'Internship'] as $val => $label): ?>
            <option value="<?= $val ?>" <?= ($job['employment_type'] ?? '') === $val ? 'selected' : '' ?>>
              <?= $label ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-3">
          <label class="form-label fw-semibold">Posted Date</label>
          <input type="date" name="posted_date" class="form-control"
                 value="<?= $job['posted_date'] ?? date('Y-m-d') ?>">
        </div>

        <div class="col-md-3">
          <label class="form-label fw-semibold">Application Deadline</label>
          <input type="date" name="application_deadline" class="form-control"
                 value="<?= $job['application_deadline'] ?? '' ?>">
        </div>

        <div class="col-md-3">
          <label class="form-label fw-semibold">Status</label>
          <select name="is_active" class="form-select">
            <option value="1" <?= ($job['is_active'] ?? 1) ? 'selected' : '' ?>>Active</option>
            <option value="0" <?= !($job['is_active'] ?? 1) ? 'selected' : '' ?>>Closed</option>
          </select>
        </div>

        <div class="col-12">
          <label class="form-label fw-semibold">Job Description <span class="text-danger">*</span></label>
          <textarea name="description" class="form-control" rows="5" required><?= htmlspecialchars($job['description'] ?? '') ?></textarea>
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">Requirements</label>
          <textarea name="requirements" class="form-control" rows="6"
                    placeholder="List qualifications, skills, education..."><?= htmlspecialchars($job['requirements'] ?? '') ?></textarea>
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">Responsibilities</label>
          <textarea name="responsibilities" class="form-control" rows="6"
                    placeholder="List key responsibilities..."><?= htmlspecialchars($job['responsibilities'] ?? '') ?></textarea>
        </div>

        <div class="col-12">
          <label class="form-label fw-semibold">Benefits</label>
          <textarea name="benefits" class="form-control" rows="3"
                    placeholder="Salary, perks, work culture..."><?= htmlspecialchars($job['benefits'] ?? '') ?></textarea>
        </div>

        <div class="col-12 d-flex gap-2">
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-save me-1"></i><?= isset($job) ? 'Update Job' : 'Post Job' ?>
          </button>
          <a href="<?= APP_URL ?>/admin/careers/jobs" class="btn btn-outline-secondary">Cancel</a>
        </div>

      </div>
    </form>
  </div>
</div>

<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
