<?php
$page_title = "Certificate Verification";
require_once '../includes/header.php';

// Handle verification
$certResult  = null;
$notFound    = false;
$searchedId  = '';

if (!empty($_GET['certificate_id'])) {
    $searchedId = trim($_GET['certificate_id']);
    $stmt = $conn->prepare("
        SELECT c.*, s.full_name, s.candidate_id, co.title AS course_title, co.instructor
        FROM certificates c
        LEFT JOIN students s  ON c.student_id = s.id
        LEFT JOIN courses  co ON c.course_name = co.title
        WHERE c.certificate_id = ? AND c.status = 'active'
        LIMIT 1
    ");
    $stmt->bind_param("s", $searchedId);
    $stmt->execute();
    $certResult = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (!$certResult) $notFound = true;
}
?>

<style>
.cert-hero { background:linear-gradient(135deg,#1a1a2e 0%,#0f3460 100%); padding:calc(var(--nav-height) + 60px) 0 70px; color:#fff; }
.verify-card { border-radius:20px; border:none; box-shadow:0 20px 60px rgba(0,0,0,.12); overflow:hidden; }
.verify-card .card-header { background:var(--gradient-color); padding:24px 32px; }
.search-input { border-radius:10px 0 0 10px!important; border:2px solid #e9ecef!important; font-size:1rem!important; padding:14px 18px!important; }
.search-input:focus { border-color:var(--primary-color)!important; box-shadow:none!important; }
.search-btn { border-radius:0 10px 10px 0!important; padding:14px 24px!important; background:var(--gradient-color)!important; border:none!important; }
.cert-result { border-radius:16px; border:2px solid #e9ecef; padding:32px; position:relative; overflow:hidden; }
.cert-result::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background:var(--gradient-color); }
.cert-badge-icon { width:80px; height:80px; border-radius:50%; background:var(--gradient-color); display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
.detail-row { display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #f0f0f0; font-size:.9rem; }
.detail-row:last-child { border:none; }
.feature-box { background:#fff; border-radius:14px; padding:28px 20px; text-align:center; box-shadow:var(--shadow-sm); transition:var(--transition); border-bottom:3px solid transparent; }
.feature-box:hover { transform:translateY(-5px); box-shadow:var(--shadow-md); border-bottom-color:var(--primary-color); }
.feature-icon-wrap { width:64px; height:64px; border-radius:16px; background:rgba(255,64,0,.08); display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
.feature-icon-wrap i { font-size:26px; color:var(--primary-color); }
.step-num { width:44px; height:44px; border-radius:50%; background:var(--gradient-color); color:#fff; font-weight:800; font-size:1.1rem; display:flex; align-items:center; justify-content:center; margin:0 auto 14px; }
</style>

<!-- Hero -->
<section class="cert-hero text-center">
    <div class="container">
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill mb-3">Secure Verification</span>
        <h1 class="display-4 fw-bold mb-3">Certificate Verification</h1>
        <p class="lead opacity-75 mb-0">Instantly verify the authenticity of any Araneus Edutech certificate</p>
    </div>
</section>

<!-- Verify box -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="verify-card card">
                    <div class="card-header text-white">
                        <h4 class="mb-1 fw-bold"><i class="fas fa-shield-check me-2"></i>Verify Certificate</h4>
                        <p class="mb-0 opacity-80 small">Enter the Certificate ID exactly as shown on the certificate</p>
                    </div>
                    <div class="card-body p-4">
                        <form method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text"
                                       name="certificate_id"
                                       class="form-control search-input"
                                       placeholder="e.g. PP/11/25/252608"
                                       value="<?=htmlspecialchars($searchedId)?>"
                                       required>
                                <button class="btn search-btn text-white fw-semibold" type="submit">
                                    <i class="fas fa-search me-2"></i>Verify
                                </button>
                            </div>
                        </form>

                        <?php if ($certResult): ?>
                        <!-- SUCCESS -->
                        <div class="cert-result">
                            <div class="text-center mb-4">
                                <div class="cert-badge-icon">
                                    <i class="fas fa-certificate fa-2x text-white"></i>
                                </div>
                                <div class="badge bg-success px-3 py-2 rounded-pill mb-2">
                                    <i class="fas fa-check-circle me-1"></i>Certificate Verified
                                </div>
                                <h4 class="fw-bold mb-0"><?=htmlspecialchars($certResult['certificate_id'])?></h4>
                            </div>
                            <div class="detail-row"><span class="text-muted">Student Name</span><strong><?=htmlspecialchars($certResult['full_name'] ?? $certResult['student_name'])?></strong></div>
                            <div class="detail-row"><span class="text-muted">Course</span><strong><?=htmlspecialchars($certResult['course_name'])?></strong></div>
                            <div class="detail-row"><span class="text-muted">Instructor</span><span><?=htmlspecialchars($certResult['instructor'] ?? '—')?></span></div>
                            <div class="detail-row"><span class="text-muted">Issue Date</span><strong><?=date('d F Y', strtotime($certResult['issue_date']))?></strong></div>
                            <?php if ($certResult['expiry_date']): ?>
                            <div class="detail-row"><span class="text-muted">Valid Until</span><strong><?=date('d F Y', strtotime($certResult['expiry_date']))?></strong></div>
                            <?php endif; ?>
                            <div class="detail-row"><span class="text-muted">Status</span>
                                <span class="badge bg-success">Active &amp; Valid</span>
                            </div>
                            <?php if (!empty($certResult['file_path'])): ?>
                            <div class="text-center mt-4">
                                <a href="<?=SITE_URL . $certResult['file_path']?>" class="btn btn-primary px-5" download>
                                    <i class="fas fa-download me-2"></i>Download Certificate PDF
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>

                        <?php elseif ($notFound): ?>
                        <!-- NOT FOUND -->
                        <div class="text-center py-4">
                            <div style="width:70px;height:70px;border-radius:50%;background:#fff3f3;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                                <i class="fas fa-times-circle fa-2x text-danger"></i>
                            </div>
                            <h5 class="text-danger fw-bold mb-2">Certificate Not Found</h5>
                            <p class="text-muted mb-3">No certificate matching "<strong><?=htmlspecialchars($searchedId)?></strong>" was found.</p>
                            <p class="small text-muted">Please check the ID and try again, or contact us at <a href="mailto:<?=SITE_EMAIL?>"><?=SITE_EMAIL?></a>.</p>
                        </div>

                        <?php else: ?>
                        <!-- Default prompt -->
                        <div class="text-center py-3 text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Example Certificate ID: <code>PP/11/25/252608</code>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features -->
<section class="section-padding">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Certificate Features</h2>
            <p class="text-muted">Every Araneus certificate comes with multiple layers of authenticity</p>
        </div>
        <div class="row g-4">
            <?php foreach ([
                ['fas fa-qrcode',     'QR Code Verification', 'Scan the QR code on any certificate to instantly verify authenticity on your phone.'],
                ['fas fa-shield-alt', 'Tamper-Proof Design',  'Digital signatures and secure IDs prevent forgery or unauthorised modification.'],
                ['fas fa-download',   'Easy Download',         'Download high-quality PDF certificates suitable for printing and sharing.'],
                ['fas fa-globe',      'Globally Shareable',   'Share verifiable digital badges directly to LinkedIn and professional portfolios.'],
            ] as [$icon,$title,$desc]): ?>
            <div class="col-md-6 col-lg-3">
                <div class="feature-box">
                    <div class="feature-icon-wrap"><i class="<?=$icon?>"></i></div>
                    <h5 class="fw-bold mb-2"><?=$title?></h5>
                    <p class="text-muted small mb-0"><?=$desc?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- How to verify -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">How to Verify</h2>
        </div>
        <div class="row g-4 justify-content-center">
            <?php foreach ([
                ['1','Enter Certificate ID',   'Type the unique Certificate ID exactly as printed on your certificate.'],
                ['2','System Verification',    'Our system cross-checks the ID against our secure certificate database.'],
                ['3','View &amp; Download',    'View full certificate details and download the PDF in one click.'],
            ] as [$n,$title,$desc]): ?>
            <div class="col-md-4">
                <div class="text-center p-4">
                    <div class="step-num"><?=$n?></div>
                    <h5 class="fw-bold mb-2"><?=$title?></h5>
                    <p class="text-muted small mb-0"><?=$desc?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-5 text-white text-center" style="background:var(--gradient-color);">
    <div class="container">
        <h3 class="fw-bold mb-2">Earn Your Own Certificate</h3>
        <p class="mb-4 opacity-80">Enroll in one of our industry-recognised programs and get certified.</p>
        <a href="courses.php" class="btn btn-light btn-lg px-5 fw-bold" style="color:var(--primary-color);">Browse Courses</a>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>
