<?php
// Standalone — no layout. Called directly via require in CertificateController::print()
$certId   = htmlspecialchars($cert['certificate_id']);
$name     = htmlspecialchars($cert['full_name']);
$program  = htmlspecialchars($cert['program_name']);
$project  = htmlspecialchars($cert['project_name'] ?? '');
$start    = $cert['start_date']  ? date('d-m-Y', strtotime($cert['start_date']))  : '';
$end      = $cert['end_date']    ? date('d-m-Y', strtotime($cert['end_date']))    : '';
$duration = htmlspecialchars($cert['duration'] ?? '');
$mode     = htmlspecialchars($cert['mode'] ?? 'Offline');
$director = htmlspecialchars($cert['director_name'] ?? 'Shubhajit Kantossan');
$coord    = htmlspecialchars($cert['coordinator_name'] ?? 'Mayukh Maitha');
$qrPath   = $cert['qr_code_path']
    ? APP_URL . '/assets/uploads/' . $cert['qr_code_path']
    : 'https://api.qrserver.com/v1/create-qr-code/?size=160x160&data=' . urlencode(APP_URL . '/verify/' . $certId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Certificate — <?= $certId ?></title>
<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Cinzel:wght@700;900&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
html, body { width: 100%; height: 100%; background: #0d2137; display: flex; align-items: center; justify-content: center; }

.cert-wrap {
  width: 1050px; height: 740px;
  position: relative;
  background: #0d2137;
  display: flex; align-items: center; justify-content: center;
  overflow: hidden;
}

/* Outer diamond teal corners */
.cert-wrap::before {
  content: '';
  position: absolute; inset: 0;
  background:
    linear-gradient(135deg, #1a4a6b 0%, transparent 45%),
    linear-gradient(315deg, #1a4a6b 0%, transparent 45%);
  z-index: 0;
}

/* Gold border lines */
.gold-border {
  position: absolute; inset: 18px;
  border: 3px solid #c9a84c;
  z-index: 1;
  pointer-events: none;
}
.gold-border-inner {
  position: absolute; inset: 24px;
  border: 1px solid rgba(201,168,76,.4);
  z-index: 1;
  pointer-events: none;
}

/* White inner card */
.cert-inner {
  position: relative; z-index: 2;
  width: 870px; height: 620px;
  background: #fff;
  display: flex; flex-direction: column; align-items: center;
  padding: 28px 60px 20px;
  clip-path: polygon(3% 0%, 97% 0%, 100% 3%, 100% 97%, 97% 100%, 3% 100%, 0% 97%, 0% 3%);
}

.cert-id {
  font-family: 'Open Sans', sans-serif;
  font-size: 10px; font-weight: 700;
  letter-spacing: .12em;
  color: #1a3a5c;
  text-transform: uppercase;
  margin-bottom: 4px;
}

.cert-title-main {
  font-family: 'Cinzel', serif;
  font-size: 52px; font-weight: 900;
  color: #1a3a5c;
  letter-spacing: .04em;
  line-height: 1;
  margin-bottom: 0;
}

.cert-title-sub {
  font-family: 'Cinzel', serif;
  font-size: 22px; font-weight: 700;
  color: #c9a84c;
  letter-spacing: .18em;
  margin-bottom: 10px;
}

.cert-presented {
  font-family: 'Open Sans', sans-serif;
  font-size: 13px;
  color: #333;
  margin-bottom: 4px;
}

.cert-student-name {
  font-family: 'Great Vibes', cursive;
  font-size: 58px;
  color: #c9a84c;
  line-height: 1.15;
  margin-bottom: 2px;
}

.cert-name-line {
  width: 420px;
  border-bottom: 1.5px solid #888;
  margin-bottom: 12px;
}

.cert-body {
  font-family: 'Open Sans', sans-serif;
  font-size: 12.5px;
  color: #222;
  text-align: center;
  line-height: 1.7;
  max-width: 640px;
  margin-bottom: 14px;
}
.cert-body em { font-style: italic; font-weight: 700; }

/* QR + signatures row */
.cert-footer {
  width: 100%;
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  margin-top: auto;
  padding-top: 4px;
}

.sig-block {
  text-align: center;
  width: 180px;
}
.sig-name {
  font-family: 'Great Vibes', cursive;
  font-size: 22px;
  color: #222;
  border-bottom: 1px solid #444;
  padding-bottom: 2px;
  margin-bottom: 3px;
}
.sig-label {
  font-family: 'Open Sans', sans-serif;
  font-size: 10px;
  letter-spacing: .12em;
  color: #555;
  text-transform: uppercase;
}

.qr-center {
  text-align: center;
}
.qr-center img {
  width: 110px; height: 110px;
  border: 3px solid #c9a84c;
  border-radius: 8px;
  padding: 4px;
  background: #fff;
}

.msme-logo {
  text-align: center;
  width: 130px;
}
.msme-logo img { width: 90px; }
.msme-text {
  font-size: 7px;
  font-weight: 700;
  color: #1a4a9b;
  letter-spacing: .06em;
  text-transform: uppercase;
  margin-top: 2px;
}

/* Gold corner ornaments */
.corner {
  position: absolute;
  width: 80px; height: 80px;
  z-index: 3;
  pointer-events: none;
}
.corner svg { width: 100%; height: 100%; }
.corner.tl { top: 28px; left: 28px; }
.corner.tr { top: 28px; right: 28px; transform: scaleX(-1); }
.corner.bl { bottom: 28px; left: 28px; transform: scaleY(-1); }
.corner.br { bottom: 28px; right: 28px; transform: scale(-1); }

/* Star decorations (css only) */
.stars { position: absolute; inset: 0; z-index: 0; pointer-events: none; overflow: hidden; }
.star {
  position: absolute;
  width: 4px; height: 4px;
  background: #c9a84c;
  border-radius: 50%;
  opacity: .6;
}

@media print {
  html, body { background: white; }
  .cert-wrap { break-inside: avoid; }
}
</style>
</head>
<body>

<div class="cert-wrap">
  <!-- Gold borders -->
  <div class="gold-border"></div>
  <div class="gold-border-inner"></div>

  <!-- Corner ornaments (SVG fleur/mandala style) -->
  <?php foreach (['tl','tr','bl','br'] as $c): ?>
  <div class="corner <?= $c ?>">
    <svg viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg">
      <g fill="#c9a84c" opacity=".9">
        <circle cx="8" cy="8" r="4"/>
        <path d="M0 0 Q40 0 40 40 Q20 20 0 0Z" opacity=".4"/>
        <path d="M4 0 Q4 36 40 36 Q22 18 4 0Z" opacity=".5"/>
        <path d="M0 4 Q36 4 36 40 Q18 22 0 4Z" opacity=".5"/>
        <rect x="0" y="0" width="3" height="50" rx="1.5" opacity=".6"/>
        <rect x="0" y="0" width="50" height="3" rx="1.5" opacity=".6"/>
        <circle cx="55" cy="5" r="2" opacity=".4"/>
        <circle cx="5" cy="55" r="2" opacity=".4"/>
        <circle cx="30" cy="10" r="1.5" opacity=".5"/>
        <circle cx="10" cy="30" r="1.5" opacity=".5"/>
      </g>
    </svg>
  </div>
  <?php endforeach; ?>

  <!-- Inner white certificate -->
  <div class="cert-inner">
    <div class="cert-id">CERTIFICATE ID : <?= $certId ?></div>
    <div class="cert-title-main">CERTIFICATE</div>
    <div class="cert-title-sub">OF &nbsp; <?= strtoupper($cert['certificate_type'] ?? 'PARTICIPATION') ?></div>
    <div class="cert-presented">This Certificate Is Proudly Presented To :</div>
    <div class="cert-student-name"><?= $name ?></div>
    <div class="cert-name-line"></div>

    <div class="cert-body">
      For successfully completing the <em><?= $program ?></em>
      <?php if ($project): ?>
        and accomplishing the project "<em><?= $project ?></em>",
      <?php endif; ?>
      <?php if ($start && $end): ?>
        held from <em><?= $start ?> to <?= $end ?></em>,
      <?php endif; ?>
      <?php if ($duration): ?>
        with a total duration of <em><?= $duration ?> (<?= $mode ?>)</em>,
      <?php endif; ?>
      organized by <em>Araneus Edutech LLP</em>.
    </div>

    <!-- Footer: sig | qr | msme | sig -->
    <div class="cert-footer">

      <!-- Director signature -->
      <div class="sig-block">
        <div class="sig-name"><?= $director ?></div>
        <div class="sig-label">(Director)</div>
      </div>

      <!-- QR Code -->
      <div class="qr-center">
        <img src="<?= $qrPath ?>" alt="Verify QR">
      </div>

      <!-- MSME logo placeholder -->
      <div class="msme-logo">
        <div style="background:#1a4a9b;color:#fff;font-weight:900;font-size:18px;padding:6px 10px;border-radius:4px;letter-spacing:.05em;font-family:sans-serif;">
          <img src="<?= APP_URL ?>/assets/img/msme-logo.png" style="width:90px">
        </div>
        <div class="msme-text">Micro, Small &amp; Medium<br>Enterprises</div>
      </div>

      <!-- Coordinator signature -->
      <div class="sig-block">
        <div class="sig-name"><?= $coord ?></div>
        <div class="sig-label">(Project Coordinator)</div>
      </div>

    </div>
  </div>
</div>

<script>window.onload = function() { window.print(); }</script>
</body>
</html>