<?php
require APP_ROOT.'/views/partials/layout_top.php';
$p       = $project ?? [];
$isEdit  = !empty($p['id']);
$action  = $isEdit
    ? APP_URL.'/admin/projects/'.$p['id'].'/edit'
    : APP_URL.'/admin/projects/create';

// Decode stored media JSON for pre-filling
$mediaRows = [];
if (!empty($p['media'])) {
    $decoded = json_decode($p['media'], true);
    if (is_array($decoded)) $mediaRows = $decoded;
}
if (empty($mediaRows)) {
    $mediaRows = [['type'=>'link','url'=>'','label'=>'']];
}
?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0">
    <i class="fa fa-layer-group me-2 text-primary"></i>
    <?= $isEdit ? 'Edit Project' : 'New Project' ?>
  </h5>
  <a href="<?= APP_URL ?>/admin/projects" class="btn btn-sm btn-outline-secondary">
    <i class="fa fa-arrow-left me-1"></i>Back
  </a>
</div>

<form method="POST" action="<?= $action ?>">

  <div class="row g-3">

    <!-- Left column -->
    <div class="col-lg-8">

      <!-- Basic info -->
      <div class="card mb-3">
        <div class="card-body">
          <h6 class="fw-bold mb-3 text-muted text-uppercase" style="font-size:.72rem;letter-spacing:.06em;">
            <i class="fa fa-info-circle me-1"></i>Basic Information
          </h6>

          <div class="mb-3">
            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control"
                   value="<?= htmlspecialchars($p['title'] ?? '') ?>" required>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
              <input type="text" name="category" class="form-control"
                     list="catSuggestions"
                     value="<?= htmlspecialchars($p['category'] ?? '') ?>" required>
              <datalist id="catSuggestions">
                <option value="Web Development">
                <option value="EdTech Platform">
                <option value="Business Solutions">
                <option value="ERP Solutions">
                <option value="Compliance Tech">
                <option value="Mobile App">
                <option value="Design">
              </datalist>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Accent Colour</label>
              <div class="input-group">
                <input type="color" name="color" class="form-control form-control-color"
                       value="<?= htmlspecialchars($p['color'] ?? '#ff4000') ?>" title="Badge colour">
                <input type="text"  id="colorHex" class="form-control form-control-sm"
                       value="<?= htmlspecialchars($p['color'] ?? '#ff4000') ?>"
                       style="font-family:monospace;max-width:90px;" readonly>
              </div>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Sort Order</label>
              <input type="number" name="sort_order" class="form-control"
                     value="<?= (int)($p['sort_order'] ?? 0) ?>" min="0">
              <div class="form-text">Lower = appears first</div>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Description</label>
            <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($p['description'] ?? '') ?></textarea>
          </div>

          <div class="mb-0">
            <label class="form-label fw-semibold">Tags</label>
            <input type="text" name="tags" class="form-control"
                   value="<?= htmlspecialchars($p['tags'] ?? '') ?>"
                   placeholder="PHP, MySQL, Bootstrap 5">
            <div class="form-text">Comma-separated. Shown as chips on the portfolio page.</div>
          </div>
        </div>
      </div>

      <!-- Media rows -->
      <div class="card mb-3">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0 text-muted text-uppercase" style="font-size:.72rem;letter-spacing:.06em;">
              <i class="fa fa-link me-1"></i>Media / Links
            </h6>
            <button type="button" class="btn btn-sm btn-outline-primary" id="addMediaRow">
              <i class="fa fa-plus me-1"></i>Add Row
            </button>
          </div>
          <div class="form-text mb-3">
            Add links (Live Site, Case Study), YouTube video URLs, or image URLs.
            Set URL to <code>#</code> to show a locked "Private" label.
          </div>

          <div id="mediaRows">
            <?php foreach ($mediaRows as $idx => $m): ?>
            <div class="row g-2 mb-2 media-row">
              <div class="col-md-3">
                <select name="media_type[]" class="form-select form-select-sm">
                  <option value="link"  <?= ($m['type']==='link' ?'selected':'') ?>>Link</option>
                  <option value="video" <?= ($m['type']==='video'?'selected':'') ?>>YouTube Video</option>
                  <option value="image" <?= ($m['type']==='image'?'selected':'') ?>>Image</option>
                </select>
              </div>
              <div class="col-md-5">
                <input type="url" name="media_url[]" class="form-control form-control-sm"
                       placeholder="https://..." value="<?= htmlspecialchars($m['url'] ?? '') ?>">
              </div>
              <div class="col-md-3">
                <input type="text" name="media_label[]" class="form-control form-control-sm"
                       placeholder="Label (e.g. Live Site)"
                       value="<?= htmlspecialchars($m['label'] ?? '') ?>">
              </div>
              <div class="col-md-1 d-flex align-items-center">
                <button type="button" class="btn btn-sm btn-outline-danger remove-media-row"
                        title="Remove">
                  <i class="fa fa-times"></i>
                </button>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

    </div><!-- /col-lg-8 -->

    <!-- Right column -->
    <div class="col-lg-4">

      <!-- Cover image -->
      <div class="card mb-3">
        <div class="card-body">
          <h6 class="fw-bold mb-3 text-muted text-uppercase" style="font-size:.72rem;letter-spacing:.06em;">
            <i class="fa fa-image me-1"></i>Cover Image
          </h6>
          <div class="mb-3">
            <label class="form-label fw-semibold">Image URL</label>
            <input type="url" name="image_url" id="imageUrlInput" class="form-control form-control-sm"
                   placeholder="https://..."
                   value="<?= htmlspecialchars($p['image_url'] ?? '') ?>">
            <div class="form-text">Paste a direct image URL (Unsplash, your CDN, etc.)</div>
          </div>
          <!-- Live preview -->
          <div id="imgPreviewWrap" style="<?= empty($p['image_url']) ? 'display:none;' : '' ?>">
            <img id="imgPreview"
                 src="<?= htmlspecialchars($p['image_url'] ?? '') ?>"
                 alt="Preview"
                 style="width:100%;height:140px;object-fit:cover;border-radius:8px;border:1px solid #e0e0e0;"
                 onerror="this.style.display='none'">
          </div>
        </div>
      </div>

      <!-- Status -->
      <div class="card mb-3">
        <div class="card-body">
          <h6 class="fw-bold mb-3 text-muted text-uppercase" style="font-size:.72rem;letter-spacing:.06em;">
            <i class="fa fa-toggle-on me-1"></i>Status
          </h6>
          <select name="status" class="form-select">
            <option value="published" <?= (($p['status']??'published')==='published'?'selected':'') ?>>
              Published — visible on site
            </option>
            <option value="draft" <?= (($p['status']??'')==='draft'?'selected':'') ?>>
              Draft — hidden from site
            </option>
          </select>
        </div>
      </div>

      <!-- Save button -->
      <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary">
          <i class="fa fa-save me-1"></i><?= $isEdit ? 'Save Changes' : 'Create Project' ?>
        </button>
        <a href="<?= APP_URL ?>/admin/projects" class="btn btn-outline-secondary">Cancel</a>
      </div>

    </div><!-- /col-lg-4 -->
  </div>

</form>

<!-- Media row template (cloned by JS) -->
<template id="mediaRowTemplate">
  <div class="row g-2 mb-2 media-row">
    <div class="col-md-3">
      <select name="media_type[]" class="form-select form-select-sm">
        <option value="link">Link</option>
        <option value="video">YouTube Video</option>
        <option value="image">Image</option>
      </select>
    </div>
    <div class="col-md-5">
      <input type="url" name="media_url[]" class="form-control form-control-sm" placeholder="https://...">
    </div>
    <div class="col-md-3">
      <input type="text" name="media_label[]" class="form-control form-control-sm" placeholder="Label (e.g. Live Site)">
    </div>
    <div class="col-md-1 d-flex align-items-center">
      <button type="button" class="btn btn-sm btn-outline-danger remove-media-row" title="Remove">
        <i class="fa fa-times"></i>
      </button>
    </div>
  </div>
</template>

<script>
// Add media row
document.getElementById('addMediaRow').addEventListener('click', function () {
    var tpl  = document.getElementById('mediaRowTemplate').content.cloneNode(true);
    document.getElementById('mediaRows').appendChild(tpl);
});

// Remove media row (delegated)
document.getElementById('mediaRows').addEventListener('click', function (e) {
    var btn = e.target.closest('.remove-media-row');
    if (!btn) return;
    var rows = document.querySelectorAll('#mediaRows .media-row');
    if (rows.length <= 1) {
        // Clear fields instead of removing the last row
        btn.closest('.media-row').querySelectorAll('input').forEach(function(i){ i.value=''; });
        btn.closest('.media-row').querySelector('select').value = 'link';
    } else {
        btn.closest('.media-row').remove();
    }
});

// Image preview
document.getElementById('imageUrlInput').addEventListener('input', function () {
    var url  = this.value.trim();
    var wrap = document.getElementById('imgPreviewWrap');
    var img  = document.getElementById('imgPreview');
    if (url) {
        img.src = url;
        wrap.style.display = '';
        img.style.display  = '';
    } else {
        wrap.style.display = 'none';
    }
});

// Colour picker → hex text sync
document.querySelector('input[name="color"]').addEventListener('input', function () {
    document.getElementById('colorHex').value = this.value;
});
</script>

<?php require APP_ROOT.'/views/partials/layout_bottom.php'; ?>
