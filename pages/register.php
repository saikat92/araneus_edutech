<?php
// ── ALL PHP logic runs FIRST — before header.php outputs any HTML ──
require_once '../controller/Auth.php';
require_once '../includes/config.php';

$auth      = new Auth();
$errorMsg  = '';
$successMsg = '';
$formData  = ['candidate_id'=>'','full_name'=>'','email'=>''];

// Redirect if already logged in
if ($auth->isLoggedIn() && $auth->getUserRole() === 'student') {
    header('Location: ../portal/dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $formData = [
        'candidate_id'     => trim($_POST['candidate_id']     ?? ''),
        'full_name'        => trim($_POST['full_name']        ?? ''),
        'email'            => trim($_POST['email']            ?? ''),
        'password'         => $_POST['password']              ?? '',
        'confirm_password' => $_POST['confirm_password']      ?? '',
    ];

    if ($formData['password'] !== $formData['confirm_password']) {
        $errorMsg = "Passwords do not match.";
    } else {
        $result = $auth->registerStudent($formData);
        if ($result['success']) {
            $successMsg = $result['message'];
            $formData   = ['candidate_id'=>'','full_name'=>'','email'=>''];
        } else {
            $errorMsg = $result['message'];
        }
    }
}

$page_title = "Create Account";
require_once '../includes/header.php';
?>

<style>
/* ══ Register page — mirrors login.php design system exactly ══ */
.reg-page {
    min-height: calc(100vh - var(--nav-height));
    display: flex;
    align-items: stretch;
}

/* ── Left panel (identical dark theme as login) ── */
.reg-left {
    background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 60%, #16213e 100%);
    padding: calc(var(--nav-height) + 60px) 60px 60px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    overflow: hidden;
}
.reg-left::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 20% 80%, rgba(255,64,0,.18) 0%, transparent 55%);
    pointer-events: none;
}
.reg-left::after {
    content: '';
    position: absolute; top: -60px; left: -60px;
    width: 280px; height: 280px;
    border-radius: 50%;
    background: rgba(255,169,0,.05);
    pointer-events: none;
}

/* Brand (same as login) */
.reg-brand { display:flex; align-items:center; gap:12px; margin-bottom:36px; }
.reg-brand img { width:46px; height:46px; object-fit:contain; }
.reg-brand-text {
    font-family:'Montserrat',sans-serif; font-weight:800; font-size:1.5rem;
    background:var(--gradient-color); -webkit-background-clip:text;
    -webkit-text-fill-color:transparent; background-clip:text;
}
.reg-brand-sub { font-size:.65rem; font-weight:500; color:rgba(255,255,255,.5);
    letter-spacing:.08em; text-transform:uppercase; display:block; margin-top:2px; }

.reg-tagline { font-size:clamp(1.7rem,3vw,2.4rem); font-weight:800; color:#fff;
    line-height:1.2; margin-bottom:14px; }
.reg-sub { color:rgba(255,255,255,.65); font-size:.93rem; line-height:1.75;
    margin-bottom:36px; max-width:400px; }

/* Steps panel — unique to register */
.reg-steps { margin-bottom:36px; }
.reg-step {
    display:flex; align-items:flex-start; gap:14px;
    margin-bottom:20px;
}
.step-circle {
    width:36px; height:36px; border-radius:50%;
    background:var(--gradient-color);
    display:flex; align-items:center; justify-content:center;
    font-weight:800; font-size:.82rem; color:#fff;
    flex-shrink:0; box-shadow:0 4px 14px rgba(255,64,0,.35);
}
.step-body .step-title { font-weight:600; font-size:.87rem; color:#fff; margin-bottom:3px; }
.step-body .step-desc  { font-size:.78rem; color:rgba(255,255,255,.5); line-height:1.5; }
/* Connector line between steps */
.reg-step:not(:last-child) .step-circle::after {
    /* done via pseudo below the circle row */
}
.reg-steps-inner { position:relative; }
.reg-steps-inner::before {
    content:'';
    position:absolute; left:17px; top:36px; bottom:20px;
    width:2px; background:rgba(255,255,255,.08); border-radius:2px;
}

/* Info card at bottom */
.reg-info-card {
    background:rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.1);
    border-radius:14px;
    padding:18px 20px;
    backdrop-filter:blur(6px);
    max-width:420px;
}
.reg-info-card p { color:rgba(255,255,255,.75); font-size:.82rem; line-height:1.65; margin:0; }
.reg-info-card .info-title { font-size:.72rem; font-weight:700; letter-spacing:.08em;
    text-transform:uppercase; color:var(--secondary-color); margin-bottom:8px; }

/* ── Right panel — form ── */
.reg-right {
    background:#f8f9fa;
    padding: calc(var(--nav-height) + 30px) 60px 50px;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    overflow-y:auto;
}

.reg-card { width:100%; max-width:480px; }

.reg-card-header { text-align:center; margin-bottom:28px; }
.reg-avatar {
    width:64px; height:64px; border-radius:18px;
    background:var(--gradient-color);
    display:inline-flex; align-items:center; justify-content:center;
    margin-bottom:14px;
    box-shadow:0 8px 24px rgba(255,64,0,.3);
}
.reg-avatar i { font-size:26px; color:#fff; }
.reg-card h2   { font-size:1.45rem; font-weight:800; margin-bottom:5px; color:var(--dark-color); }
.reg-card .reg-subtitle { color:#888; font-size:.85rem; }

/* Field styling — same as login */
.reg-field { margin-bottom:18px; }
.reg-field label { font-size:.8rem; font-weight:600; color:#444; margin-bottom:6px; display:block; }
.reg-field label .req { color:var(--primary-color); }

.input-wrap { position:relative; }
.input-icon {
    position:absolute; left:13px; top:50%; transform:translateY(-50%);
    color:#bbb; font-size:.85rem; pointer-events:none; transition:color .2s;
}
.reg-field input {
    width:100%; padding:11px 14px 11px 38px;
    border:1.5px solid #e0e0e0; border-radius:10px;
    font-size:.88rem; background:#fff; outline:none;
    transition:border-color .2s, box-shadow .2s;
    font-family:'Poppins',sans-serif;
}
.reg-field input:focus { border-color:var(--primary-color); box-shadow:0 0 0 3px rgba(255,64,0,.11); }
.reg-field input:focus ~ .input-icon { color:var(--primary-color); }
.reg-field input.is-error { border-color:#dc3545; }
.reg-field .field-hint { font-size:.73rem; color:#aaa; margin-top:5px; }

/* Password toggle */
.toggle-pw-btn {
    position:absolute; right:12px; top:50%; transform:translateY(-50%);
    background:none; border:none; cursor:pointer; color:#bbb;
    font-size:.88rem; padding:4px; transition:color .2s;
}
.toggle-pw-btn:hover { color:var(--primary-color); }

/* Password strength bar */
.pw-strength-wrap { margin-top:7px; }
.pw-strength-bar {
    height:4px; border-radius:2px; background:#e8e8e8;
    overflow:hidden; margin-bottom:4px;
}
.pw-strength-fill { height:100%; border-radius:2px; width:0%; transition:width .3s, background .3s; }
.pw-strength-label { font-size:.7rem; color:#aaa; }

/* Password match indicator */
.pw-match-icon { position:absolute; right:38px; top:50%; transform:translateY(-50%); font-size:.85rem; }

/* Two column row */
.reg-row { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
@media (max-width:480px) { .reg-row { grid-template-columns:1fr; } }

/* Terms checkbox */
.terms-wrap {
    display:flex; align-items:flex-start; gap:10px;
    padding:12px 14px; border-radius:10px;
    border:1.5px solid #e8e8e8; background:#fff;
    margin-bottom:20px; cursor:pointer; transition:border-color .2s;
}
.terms-wrap:has(input:checked) { border-color:rgba(255,64,0,.3); background:rgba(255,64,0,.02); }
.terms-wrap input[type=checkbox] { accent-color:var(--primary-color); width:15px; height:15px; flex-shrink:0; margin-top:1px; cursor:pointer; }
.terms-wrap label { font-size:.8rem; color:#555; cursor:pointer; line-height:1.55; }
.terms-wrap label a { color:var(--primary-color); font-weight:600; text-decoration:none; }
.terms-wrap label a:hover { text-decoration:underline; }

/* Submit button (same as login) */
.reg-btn {
    width:100%; padding:13px;
    background:var(--gradient-color);
    border:none; border-radius:10px;
    color:#fff; font-size:.93rem; font-weight:700;
    cursor:pointer; transition:var(--transition);
    letter-spacing:.02em; margin-bottom:20px;
    display:flex; align-items:center; justify-content:center; gap:8px;
    font-family:'Poppins',sans-serif;
}
.reg-btn:hover { opacity:.88; transform:translateY(-1px); box-shadow:0 6px 20px rgba(255,64,0,.35); }
.reg-btn .spinner { display:none; width:16px; height:16px; border:2px solid rgba(255,255,255,.4);
    border-top-color:#fff; border-radius:50%; animation:regSpin .6s linear infinite; }
@keyframes regSpin { to { transform:rotate(360deg); } }

/* Alerts (same style as login) */
.reg-alert {
    border-radius:8px; padding:12px 16px;
    font-size:.84rem; display:flex; align-items:flex-start; gap:10px;
    margin-bottom:18px;
}
.reg-alert i { margin-top:1px; flex-shrink:0; }
.reg-alert-error   { background:#fff3f3; border:1px solid #fcc; border-left:4px solid #dc3545; color:#842029; }
.reg-alert-success { background:#f0fff4; border:1px solid #b7efc5; border-left:4px solid #198754; color:#0a4723; }

/* Login link (same as login page's register link) */
.reg-login-link { text-align:center; font-size:.84rem; color:#888; }
.reg-login-link a { color:var(--primary-color); font-weight:700; text-decoration:none; }
.reg-login-link a:hover { text-decoration:underline; }

/* Progress dots */
.form-progress { display:flex; gap:8px; justify-content:center; margin-bottom:24px; }
.fp-dot { width:8px; height:8px; border-radius:50%; background:#e0e0e0; transition:.2s; }
.fp-dot.active { background:var(--primary-color); width:24px; border-radius:4px; }
.fp-dot.done   { background:var(--primary-color); opacity:.4; }

/* Responsive */
@media (max-width:1199px) {
    .reg-left  { padding: calc(var(--nav-height) + 40px) 40px 40px; }
    .reg-right { padding: calc(var(--nav-height) + 30px) 36px 40px; }
}
@media (max-width:991px) {
    .reg-left  { display:none; }
    .reg-right { padding: 36px 20px 40px; min-height:calc(100vh - var(--nav-height)); }
}
</style>

<div class="reg-page">

    <!-- ── LEFT PANEL ─────────────────────────────────── -->
    <div class="col-lg-5 d-none d-lg-flex reg-left">
        <div class="position-relative w-100" style="max-width:460px;">

            <!-- Brand -->
            <div class="reg-brand">
                <img src="<?= SITE_URL ?>assets/images/icon.png" alt="Araneus">
                <div>
                    <div class="reg-brand-text">ARANEUS</div>
                    <span class="reg-brand-sub">Edutech LLP</span>
                </div>
            </div>

            <!-- Tagline -->
            <h1 class="reg-tagline">
                Start Your<br>
                <span style="background:var(--gradient-color);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                    Learning Journey
                </span>
            </h1>
            <p class="reg-sub">
                Create your student account in seconds. Your Candidate ID is provided in your enrollment confirmation email.
            </p>

            <!-- Steps -->
            <div class="reg-steps">
                <div class="reg-steps-inner">
                    <?php foreach ([
                        ['1', 'Enter your Candidate ID',   'Provided in your enrollment confirmation email from Araneus.'],
                        ['2', 'Fill in your details',       'Name, email address, and a strong password.'],
                        ['3', 'Verify your email',          'Click the link we send you to activate your account.'],
                        ['4', 'Access your portal',         'Log in and start exploring your courses, assignments, and grades.'],
                    ] as [$num, $title, $desc]): ?>
                    <div class="reg-step">
                        <div class="step-circle"><?= $num ?></div>
                        <div class="step-body">
                            <div class="step-title"><?= $title ?></div>
                            <div class="step-desc"><?= $desc ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Info card -->
            <div class="reg-info-card">
                <div class="info-title"><i class="fas fa-info-circle me-1"></i> Important</div>
                <p>
                    You must have a valid <strong style="color:#ffa900;">Candidate ID</strong> issued by Araneus Edutech to register.
                    Don't have one? <a href="<?= SITE_URL ?>pages/contact.php" style="color:#ffa900;font-weight:600;">Contact us</a> to enroll in a course first.
                </p>
            </div>

        </div>
    </div>

    <!-- ── RIGHT PANEL — FORM ─────────────────────────── -->
    <div class="col-12 col-lg-7 reg-right">
        <div class="reg-card">

            <!-- Header -->
            <div class="reg-card-header">
                <div class="reg-avatar"><i class="fas fa-user-plus"></i></div>
                <h2>Create Your Account</h2>
                <p class="reg-subtitle">Fill in the details below to register for the student portal</p>
            </div>

            <!-- Progress dots -->
            <div class="form-progress" id="formProgress">
                <div class="fp-dot active" id="dot1"></div>
                <div class="fp-dot"        id="dot2"></div>
                <div class="fp-dot"        id="dot3"></div>
            </div>

            <!-- Alerts -->
            <?php if ($errorMsg): ?>
            <div class="reg-alert reg-alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <span><?= htmlspecialchars($errorMsg) ?></span>
            </div>
            <?php endif; ?>

            <?php if ($successMsg): ?>
            <div class="reg-alert reg-alert-success">
                <i class="fas fa-check-circle"></i>
                <div>
                    <strong>Registration successful!</strong><br>
                    <span><?= htmlspecialchars($successMsg) ?></span>
                </div>
            </div>
            <?php endif; ?>

            <!-- Form -->
            <form method="POST" id="registerForm" novalidate>
                <input type="hidden" name="register" value="1">

                <!-- Step 1: Identity -->
                <div id="step1">
                    <!-- Candidate ID -->
                    <div class="reg-field">
                        <label for="candidate_id">
                            Candidate ID <span class="req">*</span>
                        </label>
                        <div class="input-wrap">
                            <input type="text"
                                   id="candidate_id" name="candidate_id"
                                   placeholder="e.g. ARN/25/001"
                                   value="<?= htmlspecialchars($formData['candidate_id']) ?>"
                                   autocomplete="username"
                                   required>
                            <i class="fas fa-id-badge input-icon"></i>
                        </div>
                        <div class="field-hint">Provided in your enrollment confirmation email</div>
                    </div>

                    <!-- Full Name -->
                    <div class="reg-field">
                        <label for="full_name">Full Name <span class="req">*</span></label>
                        <div class="input-wrap">
                            <input type="text"
                                   id="full_name" name="full_name"
                                   placeholder="Enter your full name"
                                   value="<?= htmlspecialchars($formData['full_name']) ?>"
                                   autocomplete="name"
                                   required>
                            <i class="fas fa-user input-icon"></i>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="reg-field">
                        <label for="email">Email Address <span class="req">*</span></label>
                        <div class="input-wrap">
                            <input type="email"
                                   id="email" name="email"
                                   placeholder="your@email.com"
                                   value="<?= htmlspecialchars($formData['email']) ?>"
                                   autocomplete="email"
                                   required>
                            <i class="fas fa-envelope input-icon"></i>
                        </div>
                        <div class="field-hint">Verification link will be sent here</div>
                    </div>
                </div>

                <!-- Step 2: Password -->
                <div id="step2">
                    <!-- Password row -->
                    <div class="reg-row">
                        <div class="reg-field">
                            <label for="password">Password <span class="req">*</span></label>
                            <div class="input-wrap">
                                <input type="password"
                                       id="password" name="password"
                                       placeholder="Create password"
                                       autocomplete="new-password"
                                       required>
                                <i class="fas fa-lock input-icon"></i>
                                <button type="button" class="toggle-pw-btn" id="togglePw1" title="Show/hide">
                                    <i class="fas fa-eye" id="eyeIcon1"></i>
                                </button>
                            </div>
                            <!-- Strength bar -->
                            <div class="pw-strength-wrap">
                                <div class="pw-strength-bar">
                                    <div class="pw-strength-fill" id="pwStrengthFill"></div>
                                </div>
                                <span class="pw-strength-label" id="pwStrengthLabel"></span>
                            </div>
                        </div>

                        <div class="reg-field">
                            <label for="confirm_password">Confirm Password <span class="req">*</span></label>
                            <div class="input-wrap">
                                <input type="password"
                                       id="confirm_password" name="confirm_password"
                                       placeholder="Re-enter password"
                                       autocomplete="new-password"
                                       required>
                                <i class="fas fa-lock input-icon"></i>
                                <button type="button" class="toggle-pw-btn" id="togglePw2" title="Show/hide">
                                    <i class="fas fa-eye" id="eyeIcon2"></i>
                                </button>
                                <!-- Match indicator -->
                                <span class="pw-match-icon" id="pwMatchIcon"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Password requirements -->
                    <div style="background:#f8f9fa;border-radius:8px;padding:10px 14px;margin-bottom:18px;font-size:.75rem;color:#888;">
                        <div class="fw-semibold mb-1" style="color:#555;">Password must contain:</div>
                        <div class="d-flex flex-wrap gap-2">
                            <?php foreach ([
                                ['pwReq8',    '8+ characters'],
                                ['pwReqUpper','Uppercase letter'],
                                ['pwReqNum',  'Number'],
                                ['pwReqSpec', 'Special character'],
                            ] as [$id,$text]): ?>
                            <span id="<?= $id ?>" style="display:inline-flex;align-items:center;gap:4px;">
                                <i class="fas fa-circle" style="font-size:5px;color:#ccc;"></i> <?= $text ?>
                            </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Terms -->
                <div id="step3">
                    <div class="terms-wrap">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">
                            I have read and agree to the
                            <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms of Service</a>
                            and
                            <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">Privacy Policy</a>
                            of Araneus Edutech LLP.
                        </label>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="reg-btn" id="regBtn">
                    <span class="spinner" id="regSpinner"></span>
                    <i class="fas fa-user-plus" id="regIcon"></i>
                    <span id="regBtnText">Create Account</span>
                </button>

            </form>

            <!-- Login link -->
            <div class="reg-login-link">
                Already have an account? <a href="login.php">Sign in here</a>
            </div>

        </div>
    </div>

</div>

<!-- Terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:16px;overflow:hidden;">
            <div class="modal-header text-white border-0" style="background:var(--gradient-color);">
                <h5 class="modal-title fw-bold"><i class="fas fa-file-contract me-2"></i>Terms of Service</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" style="font-size:.88rem;line-height:1.75;">
                <?php foreach ([
                    ['Acceptance of Terms',      'By registering for the Araneus Edutech Student Portal, you agree to comply with and be bound by these terms of service.'],
                    ['Student Responsibilities', 'You are responsible for maintaining the confidentiality of your account credentials and restricting access to your devices.'],
                    ['Code of Conduct',          'Students must adhere to the code of conduct and academic integrity policies of Araneus Edutech LLP at all times.'],
                    ['Intellectual Property',    'All course materials, content, and resources are the intellectual property of Araneus Edutech and may not be redistributed without written permission.'],
                    ['Termination',              'Araneus Edutech reserves the right to terminate accounts that violate these terms or engage in inappropriate conduct.'],
                ] as [$title,$body]): ?>
                <h6 class="fw-bold mb-1" style="color:#1a1a2e;"><?= $title ?></h6>
                <p class="text-muted mb-3"><?= $body ?></p>
                <?php endforeach; ?>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button class="btn btn-primary btn-sm" data-bs-dismiss="modal">I Understand</button>
            </div>
        </div>
    </div>
</div>

<!-- Privacy Modal -->
<div class="modal fade" id="privacyModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:16px;overflow:hidden;">
            <div class="modal-header text-white border-0" style="background:var(--gradient-color);">
                <h5 class="modal-title fw-bold"><i class="fas fa-shield-alt me-2"></i>Privacy Policy</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" style="font-size:.88rem;line-height:1.75;">
                <?php foreach ([
                    ['Information Collection', 'We collect personal information you provide during registration, including name, email, and academic details.'],
                    ['Use of Information',     'Your information is used to provide educational services, track progress, issue certificates, and send important updates.'],
                    ['Data Protection',        'We implement appropriate security measures to protect your information from unauthorized access or disclosure.'],
                    ['Third-Party Disclosure', 'We do not sell, trade, or transfer your personally identifiable information to outside parties without your consent.'],
                    ['Your Rights',            'You have the right to access, correct, or delete your personal information by contacting our support team at any time.'],
                ] as [$title,$body]): ?>
                <h6 class="fw-bold mb-1" style="color:#1a1a2e;"><?= $title ?></h6>
                <p class="text-muted mb-3"><?= $body ?></p>
                <?php endforeach; ?>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button class="btn btn-primary btn-sm" data-bs-dismiss="modal">I Understand</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Password toggle (×2) ── */
    function bindToggle(btnId, inputId, iconId) {
        document.getElementById(btnId).addEventListener('click', function () {
            var pw   = document.getElementById(inputId);
            var icon = document.getElementById(iconId);
            var show = pw.type === 'password';
            pw.type  = show ? 'text' : 'password';
            icon.classList.toggle('fa-eye',      !show);
            icon.classList.toggle('fa-eye-slash', show);
        });
    }
    bindToggle('togglePw1', 'password',         'eyeIcon1');
    bindToggle('togglePw2', 'confirm_password', 'eyeIcon2');

    /* ── Password strength ── */
    var pwInput  = document.getElementById('password');
    var fillBar  = document.getElementById('pwStrengthFill');
    var fillLbl  = document.getElementById('pwStrengthLabel');
    var reqs = {
        pwReq8:    function(v){ return v.length >= 8; },
        pwReqUpper:function(v){ return /[A-Z]/.test(v); },
        pwReqNum:  function(v){ return /[0-9]/.test(v); },
        pwReqSpec: function(v){ return /[^A-Za-z0-9]/.test(v); },
    };
    var levels = [
        { pct: 0,   color: '#e0e0e0', label: '' },
        { pct: 25,  color: '#dc3545', label: 'Weak' },
        { pct: 50,  color: '#e6ac00', label: 'Fair' },
        { pct: 75,  color: '#378add', label: 'Good' },
        { pct: 100, color: '#1d9e75', label: 'Strong' },
    ];

    pwInput.addEventListener('input', function () {
        var v    = this.value;
        var score = 0;
        for (var key in reqs) {
            var pass = reqs[key](v);
            score += pass ? 1 : 0;
            var el = document.getElementById(key);
            el.querySelector('i').style.color = pass ? '#1d9e75' : '#ccc';
            el.style.color = pass ? '#1d9e75' : '#aaa';
        }
        var lvl = v.length === 0 ? levels[0] : levels[Math.min(score, 4)];
        fillBar.style.width      = lvl.pct + '%';
        fillBar.style.background = lvl.color;
        fillLbl.textContent      = lvl.label;

        // Recheck match
        checkMatch();
    });

    /* ── Password match indicator ── */
    var confirmInput = document.getElementById('confirm_password');
    var matchIcon    = document.getElementById('pwMatchIcon');

    function checkMatch() {
        if (!confirmInput.value) { matchIcon.innerHTML = ''; return; }
        if (pwInput.value === confirmInput.value) {
            matchIcon.innerHTML = '<i class="fas fa-check-circle" style="color:#1d9e75;"></i>';
            confirmInput.style.borderColor = '#1d9e75';
        } else {
            matchIcon.innerHTML = '<i class="fas fa-times-circle" style="color:#dc3545;"></i>';
            confirmInput.style.borderColor = '#dc3545';
        }
    }
    confirmInput.addEventListener('input', checkMatch);

    /* ── Progress dots ── */
    var fields = ['candidate_id','full_name','email','password','confirm_password'];
    function updateProgress() {
        var filled = fields.filter(function(id){
            return document.getElementById(id).value.trim().length > 0;
        }).length;
        var pct = filled / fields.length;
        document.getElementById('dot1').className = 'fp-dot' + (pct < .4  ? ' active' : ' done');
        document.getElementById('dot2').className = 'fp-dot' + (pct >= .4 && pct < .8 ? ' active' : (pct >= .8 ? ' done' : ''));
        document.getElementById('dot3').className = 'fp-dot' + (pct >= .8 ? ' active' : '');
    }
    fields.forEach(function(id) {
        document.getElementById(id).addEventListener('input', updateProgress);
    });

    /* ── Form submit validation ── */
    document.getElementById('registerForm').addEventListener('submit', function (e) {
        // Clear previous errors
        this.querySelectorAll('input').forEach(function(i){ i.style.borderColor = ''; });
        var existingAlert = document.querySelector('.reg-alert.reg-alert-error');
        if (existingAlert) existingAlert.remove();

        var valid = true;
        var firstError = null;

        // Required fields
        ['candidate_id','full_name','email','password','confirm_password'].forEach(function(id) {
            var el = document.getElementById(id);
            if (!el.value.trim()) {
                el.style.borderColor = '#dc3545';
                valid = false;
                if (!firstError) firstError = el;
            }
        });

        // Password match
        var pw1 = document.getElementById('password').value;
        var pw2 = document.getElementById('confirm_password').value;
        if (pw1 && pw2 && pw1 !== pw2) {
            document.getElementById('confirm_password').style.borderColor = '#dc3545';
            valid = false;
        }

        // Terms
        if (!document.getElementById('terms').checked) {
            document.getElementById('terms').parentElement.style.borderColor = '#dc3545';
            valid = false;
        }

        if (!valid) {
            e.preventDefault();
            var msg = document.createElement('div');
            msg.className = 'reg-alert reg-alert-error';
            msg.innerHTML = '<i class="fas fa-exclamation-circle"></i><span>Please fill in all required fields and agree to the terms.</span>';
            document.getElementById('registerForm').insertAdjacentElement('beforebegin', msg);
            if (firstError) firstError.focus();
            return;
        }

        // Show spinner
        document.getElementById('regSpinner').style.display = 'block';
        document.getElementById('regIcon').style.display    = 'none';
        document.getElementById('regBtnText').textContent   = 'Creating account…';
        document.getElementById('regBtn').disabled          = true;
    });

    /* ── Auto-focus first empty field ── */
    var autofocusId = ['candidate_id','full_name','email'].find(function(id){
        return !document.getElementById(id).value;
    });
    if (autofocusId) document.getElementById(autofocusId).focus();

});
</script>

<?php require_once '../includes/footer.php'; ?>
