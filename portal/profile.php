<?php
$page_title = "My Profile";
require_once 'includes/header.php';

// Enrollments with cert info
$enrollments = [];
$stmt = $conn->prepare("
    SELECT e.*, c.title AS course_name, c.syllabus_file,
           cert.id AS cert_db_id, cert.issue_date, cert.expiry_date, cert.file_path AS cert_file
    FROM enrollments e
    LEFT JOIN courses c ON e.course_id = c.id
    LEFT JOIN certificates cert ON e.certificate_id = cert.certificate_id
    WHERE e.student_id = ?
    ORDER BY e.enrollment_date DESC
");
$stmt->bind_param("i", $studentId);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) { $enrollments[] = $row; }
$stmt->close();
?>

<!-- Breadcrumb -->
<div class="portal-breadcrumb">
    <a href="dashboard.php">Dashboard</a>
    <span class="sep">/</span>
    <span class="current">My Profile</span>
</div>

<div class="row g-3">

    <!-- Left: avatar + quick info -->
    <div class="col-lg-4">

        <!-- Avatar card -->
        <div class="p-card mb-3">
            <div class="p-card-body text-center">
                <!-- Clickable avatar -->
                <div style="position:relative;display:inline-block;margin-bottom:14px;cursor:pointer;" onclick="document.getElementById('avatarUpload').click();" title="Click to change photo">
                    <div style="width:90px;height:90px;border-radius:50%;overflow:hidden;background:var(--portal-gradient);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:1.6rem;margin:0 auto;border:3px solid rgba(255,64,0,.2);">
                        <?php $av = avatarUrl($studentData); ?>
                        <?php if ($av): ?>
                            <img src="<?= $av ?>" style="width:100%;height:100%;object-fit:cover;">
                        <?php else: echo studentInitials($studentData['full_name']); endif; ?>
                    </div>
                    <div style="position:absolute;bottom:0;right:0;width:26px;height:26px;background:var(--portal-primary);border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid #fff;">
                        <i class="fas fa-camera" style="font-size:.6rem;color:#fff;"></i>
                    </div>
                </div>
                <form id="avatarForm" enctype="multipart/form-data" style="display:none;">
                    <input type="file" id="avatarUpload" name="profile_picture" accept="image/*">
                </form>

                <h5 class="fw-bold mb-1"><?= htmlspecialchars($studentData['full_name']) ?></h5>
                <div class="badge rounded-pill px-3 py-2 mb-3" style="background:var(--portal-gradient);font-size:.75rem;">
                    <?= htmlspecialchars($studentData['candidate_id']) ?>
                </div>

                <div style="font-size:.8rem;text-align:left;">
                    <?php foreach ([
                        ['fas fa-envelope', $studentData['email']],
                        ['fas fa-phone',    $studentData['phone'] ?? 'Not provided'],
                        ['fas fa-calendar', 'Joined '.date('d M Y', strtotime($studentData['created_at']))],
                    ] as [$icon, $val]): ?>
                    <div class="d-flex gap-2 mb-2" style="color:#555;">
                        <i class="<?= $icon ?> mt-1" style="color:var(--portal-primary);width:14px;font-size:.8rem;flex-shrink:0;"></i>
                        <span class="text-truncate"><?= htmlspecialchars($val) ?></span>
                    </div>
                    <?php endforeach; ?>
                    <?php if (!empty($studentData['github_link'])): ?>
                    <div class="d-flex gap-2 mb-2">
                        <i class="fab fa-github mt-1" style="color:var(--portal-primary);width:14px;font-size:.8rem;flex-shrink:0;"></i>
                        <a href="<?= htmlspecialchars($studentData['github_link']) ?>" target="_blank" style="font-size:.8rem;color:var(--portal-primary);text-decoration:none;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">GitHub</a>
                    </div>
                    <?php endif; ?>
                </div>

                <button class="btn btn-primary w-100 mt-3 btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    <i class="fas fa-edit me-2"></i>Edit Profile
                </button>
            </div>
        </div>

        <!-- Stats mini -->
        <div class="p-card">
            <div class="p-card-body">
                <div class="row g-2 text-center">
                    <?php foreach ([
                        [count($enrollments),   'Courses',      '#378add'],
                        [$certCount,            'Certs',        '#e6ac00'],
                        [$pendingAssignments,   'Pending',      '#ff8c00'],
                        [$studentData['time_hours'].'h','Hours','#1d9e75'],
                    ] as [$num,$label,$color]): ?>
                    <div class="col-6">
                        <div style="background:#f8f9fa;border-radius:10px;padding:12px 8px;">
                            <div style="font-size:1.4rem;font-weight:800;color:<?= $color ?>;"><?= $num ?></div>
                            <div style="font-size:.7rem;color:#888;"><?= $label ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

    </div>

    <!-- Right: profile details + courses table -->
    <div class="col-lg-8 d-flex flex-column gap-3">

        <!-- Profile details -->
        <div class="p-card">
            <div class="p-card-header">
                <h5><i class="fas fa-id-card me-2" style="color:var(--portal-primary);"></i>Profile Details</h5>
                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal" style="font-size:.78rem;">
                    <i class="fas fa-edit me-1"></i>Edit
                </button>
            </div>
            <div class="p-card-body">
                <div class="row g-3" style="font-size:.85rem;">
                    <?php foreach ([
                        ['Candidate ID',           $studentData['candidate_id']],
                        ['Highest Qualification',  $studentData['highest_qualification'] ?? '—'],
                        ['Current Organisation',   $studentData['current_organization'] ?? '—'],
                        ['Organisation ID Card',   $studentData['org_i_card'] ?? '—'],
                        ['Father\'s Name',          $studentData['father_name'] ?? '—'],
                        ['Address',                $studentData['address'] ?? '—'],
                    ] as [$label,$val]): ?>
                    <div class="col-sm-6">
                        <div style="background:#f8f9fa;border-radius:8px;padding:10px 14px;">
                            <div style="font-size:.7rem;color:#888;font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:3px;"><?= $label ?></div>
                            <div style="color:#333;font-weight:500;"><?= htmlspecialchars($val) ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Courses & Progress table -->
        <div class="p-card">
            <div class="p-card-header">
                <h5><i class="fas fa-graduation-cap me-2" style="color:#378add;"></i>Courses & Progress</h5>
            </div>
            <?php if (empty($enrollments)): ?>
            <div class="p-card-body text-center py-4">
                <p class="text-muted small mb-0">Not enrolled in any courses yet.</p>
            </div>
            <?php else: ?>
            <div style="overflow-x:auto;">
                <table class="table table-hover mb-0" style="font-size:.8rem;">
                    <thead style="background:#f8f9fa;">
                        <tr>
                            <?php foreach (['Course','Enrolled','Status','Grade','Certificate','Downloads'] as $h): ?>
                            <th style="font-size:.72rem;font-weight:600;color:#888;text-transform:uppercase;letter-spacing:.04em;padding:10px 12px;"><?= $h ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($enrollments as $e):
                        $badge = match($e['status']){'completed'=>'success','in_progress'=>'warning','dropped'=>'danger',default=>'secondary'};
                    ?>
                        <tr>
                            <td style="padding:10px 12px;vertical-align:middle;font-weight:500;"><?= htmlspecialchars($e['course_name']) ?></td>
                            <td style="padding:10px 12px;vertical-align:middle;color:#888;"><?= date('d M Y', strtotime($e['enrollment_date'])) ?></td>
                            <td style="padding:10px 12px;vertical-align:middle;">
                                <span class="badge bg-<?= $badge ?> rounded-pill" style="font-size:.7rem;">
                                    <?= ucfirst(str_replace('_',' ',$e['status'])) ?>
                                </span>
                            </td>
                            <td style="padding:10px 12px;vertical-align:middle;font-weight:600;">
                                <?= !empty($e['grade']) ? htmlspecialchars($e['grade']) : '<span class="text-muted">—</span>' ?>
                            </td>
                            <td style="padding:10px 12px;vertical-align:middle;">
                                <?php if (!empty($e['cert_file'])): ?>
                                <button class="btn btn-sm btn-outline-warning" style="font-size:.72rem;padding:3px 8px;"
                                        onclick="viewCertificate(<?= $e['cert_db_id'] ?>)">
                                    <i class="fas fa-certificate me-1"></i>View
                                </button>
                                <?php else: ?><span class="text-muted">—</span><?php endif; ?>
                            </td>
                            <td style="padding:10px 12px;vertical-align:middle;">
                                <div class="d-flex gap-1 flex-wrap">
                                    <?php if (!empty($e['syllabus_file'])): ?>
                                    <a href="<?= SITE_URL . $e['syllabus_file'] ?>" download class="btn btn-sm btn-outline-secondary" style="font-size:.7rem;padding:2px 7px;" title="Syllabus"><i class="fas fa-file-pdf"></i></a>
                                    <?php endif; ?>
                                    <?php if (!empty($e['attendance_sheet'])): ?>
                                    <a href="<?= SITE_URL.'uploads/'.$e['attendance_sheet'] ?>" download class="btn btn-sm btn-outline-secondary" style="font-size:.7rem;padding:2px 7px;" title="Attendance"><i class="fas fa-calendar-check"></i></a>
                                    <?php endif; ?>
                                    <?php if (!empty($e['payment_receipt'])): ?>
                                    <a href="<?= SITE_URL.'uploads/'.$e['payment_receipt'] ?>" download class="btn btn-sm btn-outline-secondary" style="font-size:.7rem;padding:2px 7px;" title="Receipt"><i class="fas fa-receipt"></i></a>
                                    <?php endif; ?>
                                    <?php if (!empty($e['project_report'])): ?>
                                    <a href="<?= SITE_URL.'uploads/'.$e['project_report'] ?>" download class="btn btn-sm btn-outline-secondary" style="font-size:.7rem;padding:2px 7px;" title="Project"><i class="fas fa-file-code"></i></a>
                                    <?php endif; ?>
                                    <?php if (empty($e['syllabus_file']) && empty($e['attendance_sheet']) && empty($e['payment_receipt']) && empty($e['project_report'])): ?>
                                    <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:16px;overflow:hidden;">
            <form id="editProfileForm">
                <div class="modal-header" style="background:var(--portal-gradient);color:#fff;border:none;">
                    <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2"></i>Edit Profile</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <?php foreach ([
                            ['full_name',           'Full Name',           'text',  $studentData['full_name'],           true],
                            ['phone',               'Phone',               'text',  $studentData['phone'] ?? '',          true],
                            ['email',               'Email',               'email', $studentData['email'],                true],
                            ['father_name',         'Father\'s Name',      'text',  $studentData['father_name'] ?? '',    false],
                            ['highest_qualification','Highest Qualification','text', $studentData['highest_qualification']??'', false],
                            ['current_organization','Current Organisation','text',  $studentData['current_organization']??'', false],
                            ['org_i_card',          'Org. ID Card',        'text',  $studentData['org_i_card']??'',       false],
                            ['github_link',         'GitHub Link',         'url',   $studentData['github_link']??'',      false],
                        ] as [$name,$label,$type,$val,$req]): ?>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold"><?= $label ?><?= $req?' <span class="text-danger">*</span>':'' ?></label>
                            <input type="<?= $type ?>" class="form-control form-control-sm" name="<?= $name ?>"
                                   value="<?= htmlspecialchars($val) ?>" <?= $req?'required':'' ?>>
                        </div>
                        <?php endforeach; ?>
                        <div class="col-12">
                            <label class="form-label small fw-semibold">Address</label>
                            <textarea class="form-control form-control-sm" name="address" rows="2"><?= htmlspecialchars($studentData['address'] ?? '') ?></textarea>
                        </div>
                    </div>
                    <div id="profileMsg" class="mt-3" style="display:none;"></div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="saveProfileBtn">
                        <i class="fas fa-save me-1"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Certificate View Modal -->
<div class="modal fade" id="certificateModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:16px;overflow:hidden;">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Certificate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="certificateContent"></div>
        </div>
    </div>
</div>

<script>
// Avatar upload
document.getElementById('avatarUpload').addEventListener('change', function() {
    if (!this.files[0]) return;
    var fd = new FormData();
    fd.append('profile_picture', this.files[0]);
    fetch('upload_avatar.php', { method:'POST', body:fd })
        .then(r=>r.json())
        .then(d => { if(d.success) location.reload(); else alert('Upload failed: '+d.error); });
});

// Edit profile
document.getElementById('editProfileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var btn = document.getElementById('saveProfileBtn');
    btn.disabled = true; btn.textContent = 'Saving…';
    fetch('update_profile.php', { method:'POST', body: new FormData(this) })
        .then(r=>r.json())
        .then(d => {
            var msg = document.getElementById('profileMsg');
            msg.style.display='block';
            if(d.success) {
                msg.innerHTML='<div class="alert alert-success py-2 small mb-0"><i class="fas fa-check-circle me-1"></i>Profile updated successfully!</div>';
                setTimeout(()=>location.reload(), 1200);
            } else {
                msg.innerHTML='<div class="alert alert-danger py-2 small mb-0"><i class="fas fa-times-circle me-1"></i>'+d.error+'</div>';
                btn.disabled=false; btn.innerHTML='<i class="fas fa-save me-1"></i>Save Changes';
            }
        });
});

// View certificate
function viewCertificate(certId) {
    document.getElementById('certificateContent').innerHTML = '<div class="text-center py-3"><div class="spinner-border text-primary spinner-border-sm"></div></div>';
    new bootstrap.Modal(document.getElementById('certificateModal')).show();
    fetch('get_certificate.php?id='+certId)
        .then(r=>r.text())
        .then(html=>{ document.getElementById('certificateContent').innerHTML=html; });
}
</script>

<?php $conn->close(); require_once 'includes/footer.php'; ?>
