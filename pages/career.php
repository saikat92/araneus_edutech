<?php
$page_title = "Careers";
require_once '../includes/header.php';

// Flash messages from redirect
$successMsg = isset($_GET['success']) ? "Your application has been submitted! We'll be in touch soon." : '';
$errorMsg   = isset($_GET['error'])   ? "Something went wrong. Please try again." : '';

// Handle application POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply_job'])) {
    $errors = [];
    $firstName   = trim($_POST['firstName']   ?? '');
    $lastName    = trim($_POST['lastName']    ?? '');
    $email       = trim($_POST['email']       ?? '');
    $phone       = trim($_POST['phone']       ?? '');
    $jobId       = intval($_POST['job_id']    ?? 0);
    $position    = trim($_POST['position']    ?? '');
    $experience  = trim($_POST['experience']  ?? '');
    $coverLetter = trim($_POST['coverLetter'] ?? '');
    $howHeard    = trim($_POST['howHeard']    ?? '');

    if (!$firstName || !$lastName) $errors[] = "Full name is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (!$phone) $errors[] = "Phone number is required.";
    if (!$position) $errors[] = "Position is required.";

    // Resume upload
    $resumePath = '';
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/resumes/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $ext  = strtolower(pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['pdf','doc','docx'])) $errors[] = "Resume must be PDF or Word (.doc/.docx).";
        elseif ($_FILES['resume']['size'] > 5 * 1024 * 1024) $errors[] = "Resume must be under 5 MB.";
        else {
            $filename   = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($_FILES['resume']['name']));
            $targetPath = $uploadDir . $filename;
            if (move_uploaded_file($_FILES['resume']['tmp_name'], $targetPath)) {
                $resumePath = 'uploads/resumes/' . $filename;
            } else {
                $errors[] = "Failed to upload resume.";
            }
        }
    } else {
        $errors[] = "Please upload your resume.";
    }

    if (empty($errors)) {
        $ins = $conn->prepare("INSERT INTO career_applications (first_name, last_name, email, phone, position, experience, resume_path, cover_letter, how_heard) VALUES (?,?,?,?,?,?,?,?,?)");
        $ins->bind_param("sssssssss", $firstName, $lastName, $email, $phone, $position, $experience, $resumePath, $coverLetter, $howHeard);
        if ($ins->execute()) {
            // Notify HR
            @mail(SITE_EMAIL, "New Job Application: $position",
                "Name: $firstName $lastName\nEmail: $email\nPhone: $phone\nPosition: $position\nExperience: $experience yrs\nHow heard: $howHeard\n\nCover Letter:\n$coverLetter",
                "From: noreply@araneusedutech.com\r\nReply-To: $email");
            header('Location: career.php?success=1');
            exit;
        } else {
            $errorMsg = "Database error. Please try again.";
        }
        $ins->close();
    } else {
        $errorMsg = implode('<br>', $errors);
    }
}

// Fetch active job openings from DB
$deptFilter = trim($_GET['dept'] ?? '');
$locFilter  = trim($_GET['loc']  ?? '');

$where  = "WHERE is_active = 1";
$params = []; $types = '';
if ($deptFilter) { $where .= " AND department = ?"; $params[] = $deptFilter; $types .= 's'; }
if ($locFilter)  { $where .= " AND location = ?";   $params[] = $locFilter;  $types .= 's'; }

$jStmt = $conn->prepare("SELECT * FROM job_openings $where ORDER BY posted_date DESC");
if ($types) $jStmt->bind_param($types, ...$params);
$jStmt->execute();
$jobs     = $jStmt->get_result()->fetch_all(MYSQLI_ASSOC);
$jStmt->close();

// Get distinct depts and locations for filter
$depts = $conn->query("SELECT DISTINCT department FROM job_openings WHERE is_active=1 ORDER BY department")->fetch_all(MYSQLI_ASSOC);
$locs  = $conn->query("SELECT DISTINCT location  FROM job_openings WHERE is_active=1 ORDER BY location")->fetch_all(MYSQLI_ASSOC);
?>

<!-- Hero -->
<section class="hero-section" style="background:linear-gradient(rgba(0,0,0,.75),rgba(0,0,0,.75)),url('https://images.unsplash.com/photo-1551836026-d5c2c5af78e4?auto=format&fit=crop&w=1400&q=80');background-size:cover;background-position:center;">
    <div class="container">
        <div class="col-lg-8 mx-auto text-center text-white">
            <p class="text-warning fw-semibold mb-2 text-uppercase" style="letter-spacing:.08em;">We're Hiring</p>
            <h1 class="display-4 fw-bold mb-3">Join Our Team</h1>
            <p class="lead mb-4 opacity-75">Be part of a team transforming education and business through technology.</p>
            <a href="#openings" class="btn btn-primary btn-lg me-2 px-4">View Openings</a>
            <a href="#culture" class="btn btn-outline-light btn-lg px-4">Our Culture</a>
        </div>
    </div>
</section>

<!-- Alerts -->
<?php if ($successMsg): ?>
<div class="container mt-4">
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($successMsg); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
<?php endif; ?>
<?php if ($errorMsg): ?>
<div class="container mt-4">
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle me-2"></i><?php echo $errorMsg; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
<?php endif; ?>

<!-- Culture -->
<section class="section-padding" id="culture">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Why Work at Araneus Edutech?</h2>
            <p class="lead text-muted">A workplace where innovation, growth, and collaboration thrive</p>
        </div>
        <div class="row g-4">
            <?php
            $perks = [
                ['fas fa-bullseye','Impactful Work','Contribute to projects that transform education and empower businesses across India.'],
                ['fas fa-graduation-cap','Continuous Learning','Access training programs, certifications, and workshops to sharpen your skills.'],
                ['fas fa-users','Collaborative Culture','Work with talented professionals in a supportive environment.'],
                ['fas fa-chart-line','Career Growth','Clear progression paths with regular performance reviews.'],
                ['fas fa-balance-scale','Work-Life Balance','Flexible work arrangements that respect your time.'],
                ['fas fa-trophy','Recognition & Rewards','Competitive pay, bonuses, and recognition for great work.'],
            ];
            foreach ($perks as [$icon, $title, $desc]):
            ?>
            <div class="col-lg-4 col-md-6">
                <div class="text-center p-4 h-100 rounded-3 border bg-white shadow-sm">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                         style="width:64px;height:64px;background:rgba(255,69,0,.1);">
                        <i class="<?php echo $icon; ?> fa-lg" style="color:var(--primary-color);"></i>
                    </div>
                    <h5 class="fw-semibold mb-2"><?php echo $title; ?></h5>
                    <p class="text-muted small mb-0"><?php echo $desc; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Job Openings -->
<section class="py-5 bg-light" id="openings">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Current Openings</h2>
            <p class="lead text-muted">Explore opportunities to join our growing team</p>
        </div>

        <!-- Filters -->
        <form method="GET" class="row g-3 justify-content-center mb-5">
            <div class="col-md-4">
                <select name="dept" class="form-select" onchange="this.form.submit()">
                    <option value="">All Departments</option>
                    <?php foreach ($depts as $d): ?>
                    <option value="<?php echo htmlspecialchars($d['department']); ?>" <?php echo $deptFilter === $d['department'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($d['department']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <select name="loc" class="form-select" onchange="this.form.submit()">
                    <option value="">All Locations</option>
                    <?php foreach ($locs as $l): ?>
                    <option value="<?php echo htmlspecialchars($l['location']); ?>" <?php echo $locFilter === $l['location'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($l['location']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php if ($deptFilter || $locFilter): ?>
            <div class="col-md-2">
                <a href="career.php#openings" class="btn btn-outline-secondary w-100">Clear</a>
            </div>
            <?php endif; ?>
        </form>

        <?php if (empty($jobs)): ?>
        <div class="text-center py-5">
            <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No open positions right now.</h5>
            <p class="text-muted">Check back soon or send us a general application below.</p>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#applyModal"
                    data-position="General Application" data-job-id="0">
                Submit General Application
            </button>
        </div>
        <?php else: ?>
        <div class="row g-4">
            <?php foreach ($jobs as $job):
                $urgent = ($job['application_deadline'] && strtotime($job['application_deadline']) - time() < 7 * 86400);
            ?>
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm" style="border-radius:12px;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($job['title']); ?></h5>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-primary"><?php echo htmlspecialchars($job['department']); ?></span>
                                    <span class="badge bg-secondary"><?php echo htmlspecialchars($job['location']); ?></span>
                                    <span class="badge bg-light text-dark border"><?php echo ucfirst($job['employment_type']); ?></span>
                                </div>
                            </div>
                            <?php if ($urgent): ?>
                            <span class="badge bg-danger flex-shrink-0">Urgent</span>
                            <?php endif; ?>
                        </div>
                        <p class="text-muted small mb-3" style="display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">
                            <?php echo htmlspecialchars($job['description']); ?>
                        </p>
                        <?php if ($job['application_deadline']): ?>
                        <small class="text-muted d-block mb-3">
                            <i class="fas fa-clock me-1"></i>Apply by <?php echo date('d M Y', strtotime($job['application_deadline'])); ?>
                        </small>
                        <?php endif; ?>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#jobDetailModal"
                                    data-id="<?php echo $job['id']; ?>"
                                    data-title="<?php echo htmlspecialchars($job['title']); ?>"
                                    data-dept="<?php echo htmlspecialchars($job['department']); ?>"
                                    data-loc="<?php echo htmlspecialchars($job['location']); ?>"
                                    data-type="<?php echo htmlspecialchars($job['employment_type']); ?>"
                                    data-desc="<?php echo htmlspecialchars($job['description']); ?>"
                                    data-req="<?php echo htmlspecialchars($job['requirements']); ?>"
                                    data-resp="<?php echo htmlspecialchars($job['responsibilities'] ?? ''); ?>"
                                    data-benefits="<?php echo htmlspecialchars($job['benefits'] ?? ''); ?>"
                                    data-deadline="<?php echo $job['application_deadline'] ? date('d M Y', strtotime($job['application_deadline'])) : ''; ?>">
                                <i class="fas fa-eye me-1"></i> View Details
                            </button>
                            <button class="btn btn-primary btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#applyModal"
                                    data-position="<?php echo htmlspecialchars($job['title']); ?>"
                                    data-job-id="<?php echo $job['id']; ?>">
                                <i class="fas fa-paper-plane me-1"></i> Apply Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Process -->
<section class="section-padding">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Our Hiring Process</h2>
            <p class="lead text-muted">Simple, transparent and fast</p>
        </div>
        <div class="row g-4 text-center">
            <?php
            $steps = [
                ['1','fas fa-file-alt','Apply Online','Submit your resume and cover letter through our simple application form.'],
                ['2','fas fa-search','Application Review','Our HR team reviews your application within 3–5 business days.'],
                ['3','fas fa-comments','Interview','Selected candidates are invited for a telephonic or in-person interview.'],
                ['4','fas fa-handshake','Offer & Onboarding','Successful candidates receive an offer and begin their onboarding journey.'],
            ];
            foreach ($steps as [$num, $icon, $title, $desc]):
            ?>
            <div class="col-md-3 col-6">
                <div class="position-relative">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 text-white fw-bold"
                         style="width:56px;height:56px;background:var(--primary-color);font-size:18px;"><?php echo $num; ?></div>
                    <h6 class="fw-semibold mb-1"><?php echo $title; ?></h6>
                    <p class="text-muted small"><?php echo $desc; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ── Job Detail Modal ───────────────────────────────────────── -->
<div class="modal fade" id="jobDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h4 class="modal-title fw-bold mb-1" id="jdTitle"></h4>
                    <div id="jdBadges" class="d-flex flex-wrap gap-2"></div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-3">
                <div id="jdDeadline" class="alert alert-warning py-2 small d-none">
                    <i class="fas fa-clock me-1"></i> Application deadline: <strong id="jdDeadlineDate"></strong>
                </div>
                <h6 class="fw-semibold text-primary mt-3">About the Role</h6>
                <p id="jdDesc" class="text-muted" style="white-space:pre-line;"></p>
                <div id="jdRespBlock">
                    <h6 class="fw-semibold text-primary mt-3">Responsibilities</h6>
                    <p id="jdResp" class="text-muted" style="white-space:pre-line;"></p>
                </div>
                <h6 class="fw-semibold text-primary mt-3">Requirements</h6>
                <p id="jdReq" class="text-muted" style="white-space:pre-line;"></p>
                <div id="jdBenBlock">
                    <h6 class="fw-semibold text-primary mt-3">Benefits</h6>
                    <p id="jdBen" class="text-muted" style="white-space:pre-line;"></p>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="jdApplyBtn">
                    <i class="fas fa-paper-plane me-1"></i> Apply for this Role
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ── Apply Modal ────────────────────────────────────────────── -->
<div class="modal fade" id="applyModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="apply_job" value="1">
                <input type="hidden" name="job_id"   id="applyJobId">
                <input type="hidden" name="position" id="applyPosition">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Apply — <span id="applyTitle" class="text-primary"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="firstName" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="lastName" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Phone <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Years of Experience</label>
                            <select name="experience" class="form-select">
                                <option value="0-1">0 – 1 year</option>
                                <option value="1-3">1 – 3 years</option>
                                <option value="3-5">3 – 5 years</option>
                                <option value="5-10">5 – 10 years</option>
                                <option value="10+">10+ years</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">How did you hear about us?</label>
                            <select name="howHeard" class="form-select">
                                <option value="">Select…</option>
                                <option value="website">Our Website</option>
                                <option value="linkedin">LinkedIn</option>
                                <option value="referral">Employee Referral</option>
                                <option value="job-portal">Job Portal</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold">Cover Letter</label>
                            <textarea name="coverLetter" class="form-control" rows="4" placeholder="Tell us why you're a great fit…"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold">Resume <span class="text-danger">*</span></label>
                            <input type="file" name="resume" class="form-control" accept=".pdf,.doc,.docx" required>
                            <div class="form-text">PDF or Word, max 5 MB</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-paper-plane me-1"></i> Submit Application
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Job detail modal populate
document.getElementById('jobDetailModal').addEventListener('show.bs.modal', function(e) {
    const b = e.relatedTarget;
    document.getElementById('jdTitle').textContent    = b.dataset.title;
    document.getElementById('jdDesc').textContent     = b.dataset.desc;
    document.getElementById('jdReq').textContent      = b.dataset.req;
    document.getElementById('jdResp').textContent     = b.dataset.resp;
    document.getElementById('jdBen').textContent      = b.dataset.benefits;
    document.getElementById('jdRespBlock').style.display = b.dataset.resp   ? '' : 'none';
    document.getElementById('jdBenBlock').style.display  = b.dataset.benefits ? '' : 'none';

    const dl = b.dataset.deadline;
    if (dl) {
        document.getElementById('jdDeadline').classList.remove('d-none');
        document.getElementById('jdDeadlineDate').textContent = dl;
    } else {
        document.getElementById('jdDeadline').classList.add('d-none');
    }

    const badges = document.getElementById('jdBadges');
    badges.innerHTML = `<span class="badge bg-primary">${b.dataset.dept}</span>
        <span class="badge bg-secondary">${b.dataset.loc}</span>
        <span class="badge bg-light text-dark border">${b.dataset.type}</span>`;

    // Wire the Apply button inside detail modal
    document.getElementById('jdApplyBtn').onclick = function() {
        bootstrap.Modal.getInstance(document.getElementById('jobDetailModal')).hide();
        setTimeout(() => {
            document.getElementById('applyJobId').value  = b.dataset.id;
            document.getElementById('applyPosition').value = b.dataset.title;
            document.getElementById('applyTitle').textContent = b.dataset.title;
            new bootstrap.Modal(document.getElementById('applyModal')).show();
        }, 300);
    };
});

// Apply modal populate
document.getElementById('applyModal').addEventListener('show.bs.modal', function(e) {
    const b = e.relatedTarget;
    if (!b) return;
    document.getElementById('applyJobId').value    = b.dataset.jobId   || '';
    document.getElementById('applyPosition').value = b.dataset.position || '';
    document.getElementById('applyTitle').textContent = b.dataset.position || 'Open Position';
});
</script>

<?php require_once '../includes/footer.php'; ?>
