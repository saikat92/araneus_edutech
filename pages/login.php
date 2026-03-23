<?php
// ── ALL PHP logic runs FIRST — before header.php outputs any HTML ──
require_once '../controller/Auth.php';   // Auth.php starts session safely here
require_once '../includes/config.php';   // constants only, no output

$auth     = new Auth();
$errorMsg = '';

$db = new Database();
$conn = $db->getConnection();
// If already logged in, go straight to dashboard
if ($auth->isLoggedIn() && $auth->getUserRole() === 'student') {
    header('Location: ../portal/dashboard.php');
    exit;
}

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $candidateId = trim($_POST['candidate_id'] ?? '');
    $password    = trim($_POST['password']     ?? '');

    if (empty($candidateId) || empty($password)) {
        $errorMsg = "Please enter both Candidate ID and Password.";
    } else {
        $result = $auth->loginStudent($candidateId, $password);
        if ($result['success']) {
            header('Location: ' . $result['redirect']);
            exit;
        } else {
            $errorMsg = $result['message'];
        }
    }
}

// ── NOW include header — HTML output begins here ──
$page_title = "Student Portal Login";
require_once '../includes/header.php';
?>

<style>
/* ── Login page styles ── */
.login-page {
    min-height: calc(100vh - var(--nav-height));
    display: flex;
    align-items: stretch;
}

/* Left panel */
.login-left {
    background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 60%, #16213e 100%);
    padding: calc(var(--nav-height) + 60px) 60px 60px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    overflow: hidden;
}
.login-left::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at 80% 20%, rgba(255,64,0,.2) 0%, transparent 55%);
    pointer-events: none;
}
.login-left::after {
    content: '';
    position: absolute;
    bottom: -80px; right: -80px;
    width: 320px; height: 320px;
    border-radius: 50%;
    background: rgba(255,169,0,.06);
    pointer-events: none;
}

/* Brand strip on left */
.login-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 48px;
}
.login-brand img {
    width: 46px; height: 46px;
    object-fit: contain;
}
.login-brand-text { font-family: 'Montserrat', sans-serif; font-weight: 800; font-size: 1.5rem;
    background: var(--gradient-color); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
.login-brand-sub  { font-size: .65rem; font-weight: 500; color: rgba(255,255,255,.5); letter-spacing: .08em; text-transform: uppercase; }

.login-tagline { font-size: clamp(1.8rem, 3vw, 2.6rem); font-weight: 800; color: #fff; line-height: 1.2; margin-bottom: 16px; }
.login-sub     { color: rgba(255,255,255,.65); font-size: .95rem; line-height: 1.7; margin-bottom: 40px; max-width: 400px; }

/* Feature list */
.feature-list { list-style: none; padding: 0; margin: 0 0 48px; }
.feature-list li {
    display: flex; align-items: center; gap: 14px;
    color: rgba(255,255,255,.8); font-size: .88rem;
    padding: 10px 0;
    border-bottom: 1px solid rgba(255,255,255,.06);
}
.feature-list li:last-child { border: none; }
.fl-icon {
    width: 34px; height: 34px; border-radius: 8px;
    background: rgba(255,255,255,.08);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.fl-icon i { font-size: .85rem; color: var(--secondary-color); }

/* Testimonial snippet */
.login-quote {
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 14px;
    padding: 20px 22px;
    backdrop-filter: blur(6px);
    max-width: 420px;
}
.login-quote p { color: rgba(255,255,255,.8); font-size: .85rem; line-height: 1.7; margin: 0 0 10px; font-style: italic; }
.login-quote .quotee { font-size: .78rem; color: rgba(255,255,255,.5); font-weight: 500; }
.login-quote .quotee strong { color: var(--secondary-color); }

/* Right panel — form */
.login-right {
    background: #f8f9fa;
    padding: calc(var(--nav-height) + 40px) 60px 60px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.login-card {
    width: 100%;
    max-width: 440px;
}

.login-card-header {
    text-align: center;
    margin-bottom: 32px;
}
.login-avatar {
    width: 68px; height: 68px;
    border-radius: 18px;
    background: var(--gradient-color);
    display: inline-flex; align-items: center; justify-content: center;
    margin-bottom: 16px;
    box-shadow: 0 8px 24px rgba(255,64,0,.3);
}
.login-avatar i { font-size: 28px; color: #fff; }

.login-card h2 { font-size: 1.5rem; font-weight: 800; margin-bottom: 6px; color: var(--dark-color); }
.login-card .subtitle { color: #888; font-size: .87rem; }

/* Input styling */
.login-field { margin-bottom: 20px; }
.login-field label { font-size: .82rem; font-weight: 600; color: #444; margin-bottom: 7px; display: block; }
.login-field .input-wrap {
    position: relative;
}
.login-field .input-icon {
    position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
    color: #aaa; font-size: .9rem; pointer-events: none;
    transition: color .2s;
}
.login-field input {
    width: 100%;
    padding: 12px 40px 12px 40px;
    border: 1.5px solid #e0e0e0;
    border-radius: 10px;
    font-size: .9rem;
    background: #fff;
    transition: border-color .2s, box-shadow .2s;
    outline: none;
}
.login-field input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(255,64,0,.12);
}
.login-field input:focus + .input-icon,
.login-field input:focus ~ .input-icon { color: var(--primary-color); }
.login-field input.is-error { border-color: #dc3545; }
.login-field .toggle-pw {
    position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
    background: none; border: none; cursor: pointer; color: #aaa; font-size: .9rem;
    padding: 4px;
}
.login-field .toggle-pw:hover { color: var(--primary-color); }

.login-btn {
    width: 100%;
    padding: 13px;
    background: var(--gradient-color);
    border: none;
    border-radius: 10px;
    color: #fff;
    font-size: .95rem;
    font-weight: 700;
    cursor: pointer;
    transition: var(--transition);
    letter-spacing: .02em;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    margin-bottom: 20px;
}
.login-btn:hover { opacity: .88; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(255,64,0,.35); }
.login-btn:active { transform: translateY(0); }
.login-btn .spinner { display: none; width: 16px; height: 16px; border: 2px solid rgba(255,255,255,.4); border-top-color: #fff; border-radius: 50%; animation: spin .6s linear infinite; }
@keyframes spin { to { transform: rotate(360deg); } }

/* Links row */
.login-links { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; font-size: .83rem; }
.login-links a { color: var(--primary-color); text-decoration: none; font-weight: 600; }
.login-links a:hover { text-decoration: underline; }
.remember-wrap { display: flex; align-items: center; gap: 7px; cursor: pointer; }
.remember-wrap input { accent-color: var(--primary-color); }

/* Divider */
.login-divider { display: flex; align-items: center; gap: 12px; margin: 20px 0; }
.login-divider span { flex: 1; height: 1px; background: #e0e0e0; }
.login-divider small { color: #aaa; font-size: .78rem; white-space: nowrap; }

/* Social buttons */
.social-btns { display: flex; gap: 10px; margin-bottom: 28px; }
.social-btn {
    flex: 1; padding: 10px; border-radius: 8px;
    border: 1.5px solid #e0e0e0; background: #fff;
    font-size: .82rem; font-weight: 600; color: #444;
    cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 7px;
    transition: var(--transition); text-decoration: none;
}
.social-btn:hover { border-color: var(--primary-color); color: var(--primary-color); background: rgba(255,64,0,.03); }

/* Bottom register link */
.login-register { text-align: center; font-size: .84rem; color: #888; }
.login-register a { color: var(--primary-color); font-weight: 700; text-decoration: none; }
.login-register a:hover { text-decoration: underline; }

/* Alert */
.login-alert {
    background: #fff3f3;
    border: 1px solid #fcc;
    border-left: 4px solid #dc3545;
    border-radius: 8px;
    padding: 12px 16px;
    font-size: .85rem;
    color: #842029;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 20px;
}
.login-alert i { margin-top: 1px; flex-shrink: 0; }

/* Legacy portal badge */
.legacy-link {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: .78rem; color: #aaa; text-decoration: none;
    padding: 6px 12px; border-radius: 6px; border: 1px solid #e8e8e8;
    transition: var(--transition);
}
.legacy-link:hover { color: var(--primary-color); border-color: rgba(255,64,0,.2); }

/* Responsive */
@media (max-width: 991px) {
    .login-left  { padding: calc(var(--nav-height) + 40px) 32px 40px; }
    .login-right { padding: 40px 24px; }
}
@media (max-width: 767px) {
    .login-left { display: none; }
    .login-right { min-height: calc(100vh - var(--nav-height)); padding: 40px 20px; }
}
</style>

<div class="login-page">

    <!-- ── LEFT PANEL ───────────────────────────────────── -->
    <div class="col-lg-6 d-none d-lg-flex login-left">
        <div class="position-relative w-100" style="max-width:480px;">

            <!-- Brand -->
            <div class="login-brand">
                <img src="<?= SITE_URL ?>assets/images/icon.png" alt="Araneus Logo">
                <div>
                    <div class="login-brand-text">ARANEUS</div>
                    <div class="login-brand-sub">Edutech LLP</div>
                </div>
            </div>

            <!-- Headline -->
            <h1 class="login-tagline">
                Your Learning<br>
                <span style="background:var(--gradient-color);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                    Journey Awaits
                </span>
            </h1>
            <p class="login-sub">
                Log in to access your personalised dashboard, course materials, assignments, grades, and certificates — all in one place.
            </p>

            <!-- Feature list -->
            <ul class="feature-list">
                <?php foreach ([
                    ['fas fa-book-open',    'Access course materials &amp; resources'],
                    ['fas fa-tasks',        'Submit assignments &amp; track deadlines'],
                    ['fas fa-chart-bar',    'View grades &amp; academic progress'],
                    ['fas fa-certificate',  'Download your earned certificates'],
                    ['fas fa-user-circle',  'Manage your student profile'],
                ] as [$icon, $text]): ?>
                <li>
                    <div class="fl-icon"><i class="<?= $icon ?>"></i></div>
                    <?= $text ?>
                </li>
                <?php endforeach; ?>
            </ul>

            <!-- Quote -->
            <?php
            $quote = $conn->query("SELECT client_name, client_position, testimonial FROM testimonials WHERE status='published' AND is_featured=1 ORDER BY RAND() LIMIT 1")->fetch_assoc();
            if (!$quote) $quote = $conn->query("SELECT client_name, client_position, testimonial FROM testimonials WHERE status='published' ORDER BY RAND() LIMIT 1")->fetch_assoc();
            if ($quote): ?>
            <div class="login-quote">
                <p>"<?= htmlspecialchars(mb_substr($quote['testimonial'], 0, 140)) . (mb_strlen($quote['testimonial']) > 140 ? '…' : '') ?>"</p>
                <div class="quotee">
                    <strong><?= htmlspecialchars($quote['client_name']) ?></strong>
                    <?php if ($quote['client_position']): ?> · <?= htmlspecialchars($quote['client_position']) ?><?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ── RIGHT PANEL — FORM ───────────────────────────── -->
    <div class="col-12 col-lg-6 login-right">
        <div class="login-card">

            <div class="login-card-header">
                <div class="login-avatar"><i class="fas fa-graduation-cap"></i></div>
                <h2>Student Login</h2>
                <p class="subtitle">Enter your credentials to access your portal</p>
            </div>

            <!-- Error alert -->
            <?php if ($errorMsg): ?>
            <div class="login-alert">
                <i class="fas fa-exclamation-circle"></i>
                <span><?= htmlspecialchars($errorMsg) ?></span>
            </div>
            <?php endif; ?>

            <!-- Form -->
            <form method="POST" id="loginForm" novalidate>
                <input type="hidden" name="login" value="1">

                <!-- Candidate ID -->
                <div class="login-field">
                    <label for="candidate_id">Candidate ID</label>
                    <div class="input-wrap">
                        <input type="text"
                               id="candidate_id"
                               name="candidate_id"
                               placeholder="e.g. ARN/25/001"
                               value="<?= htmlspecialchars($_POST['candidate_id'] ?? '') ?>"
                               autocomplete="off"
                               required>
                        <i class="fas fa-id-badge input-icon"></i>
                    </div>
                </div>

                <!-- Password -->
                <div class="login-field">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <input type="password"
                               id="password"
                               name="password"
                               placeholder="Enter your password"
                               autocomplete="current-password"
                               required>
                        <i class="fas fa-lock input-icon"></i>
                        <button type="button" class="toggle-pw" id="togglePw" title="Show/hide password">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember + Forgot -->
                <div class="login-links">
                    <label class="remember-wrap">
                        <input type="checkbox" name="rememberMe" id="rememberMe">
                        <span>Remember me</span>
                    </label>
                    <a href="forgot-password.php">Forgot password?</a>
                </div>

                <!-- Submit -->
                <button type="submit" class="login-btn" id="loginBtn">
                    <span class="spinner" id="btnSpinner"></span>
                    <i class="fas fa-sign-in-alt" id="btnIcon"></i>
                    <span id="btnText">Login to Portal</span>
                </button>

                <!-- Legacy portal -->
                <div class="text-center mb-4">
                    <a href="https://araneus.plastwork.in/studProfile/" target="_blank" rel="noopener" class="legacy-link">
                        <i class="fas fa-external-link-alt"></i>
                        Access Legacy Portal
                    </a>
                </div>
            </form>

            <!-- Social login divider -->
            <div class="login-divider">
                <span></span>
                <small>or continue with</small>
                <span></span>
            </div>

            <div class="social-btns">
                <a href="#" class="social-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24"><path fill="#EA4335" d="M5.266 9.765A7.077 7.077 0 0 1 12 4.909c1.69 0 3.218.6 4.418 1.582L19.91 3C17.782 1.145 15.055 0 12 0 7.27 0 3.198 2.698 1.24 6.65l4.026 3.115Z"/><path fill="#34A853" d="M16.04 18.013c-1.09.703-2.474 1.078-4.04 1.078a7.077 7.077 0 0 1-6.723-4.823l-4.04 3.067A11.965 11.965 0 0 0 12 24c2.933 0 5.735-1.043 7.834-3l-3.793-2.987Z"/><path fill="#4A90E2" d="M19.834 21c2.195-2.048 3.62-5.096 3.62-9 0-.71-.109-1.473-.272-2.182H12v4.637h6.436c-.317 1.559-1.17 2.766-2.395 3.558L19.834 21Z"/><path fill="#FBBC05" d="M5.277 14.268A7.12 7.12 0 0 1 4.909 12c0-.782.125-1.533.357-2.235L1.24 6.65A11.934 11.934 0 0 0 0 12c0 1.92.445 3.73 1.237 5.335l4.04-3.067Z"/></svg>
                    Google
                </a>
                <a href="#" class="social-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24"><path fill="#00A4EF" d="M0 0h11.377v11.372H0z"/><path fill="#FFB900" d="M12.623 0H24v11.372H12.623z"/><path fill="#00B4F0" d="M0 12.623h11.377V24H0z"/><path fill="#7FBA00" d="M12.623 12.623H24V24H12.623z"/></svg>
                    Microsoft
                </a>
            </div>

            <!-- Register link -->
            <div class="login-register">
                Don't have an account?
                <a href="register.php">Create one free</a>
            </div>

        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Toggle password visibility
    document.getElementById('togglePw').addEventListener('click', function () {
        var pw   = document.getElementById('password');
        var icon = document.getElementById('eyeIcon');
        var show = pw.type === 'password';
        pw.type  = show ? 'text' : 'password';
        icon.classList.toggle('fa-eye',      !show);
        icon.classList.toggle('fa-eye-slash', show);
    });

    // ── Form submit: show spinner, basic validation
    document.getElementById('loginForm').addEventListener('submit', function (e) {
        var id = document.getElementById('candidate_id').value.trim();
        var pw = document.getElementById('password').value.trim();

        if (!id || !pw) {
            e.preventDefault();
            // Show inline error if not already present
            if (!document.querySelector('.login-alert')) {
                var alert = document.createElement('div');
                alert.className = 'login-alert';
                alert.innerHTML = '<i class="fas fa-exclamation-circle"></i><span>Please fill in both fields.</span>';
                document.getElementById('loginForm').insertAdjacentElement('beforebegin', alert);
            }
            return;
        }

        // Show spinner
        var btn = document.getElementById('loginBtn');
        document.getElementById('btnSpinner').style.display = 'block';
        document.getElementById('btnIcon').style.display    = 'none';
        document.getElementById('btnText').textContent      = 'Signing in…';
        btn.disabled = true;
    });

    // ── Auto-focus first empty field
    var idField = document.getElementById('candidate_id');
    var pwField = document.getElementById('password');
    if (!idField.value) idField.focus();
    else pwField.focus();

});
</script>

<?php require_once '../includes/footer.php'; ?>
