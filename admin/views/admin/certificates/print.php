<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Certificate of Excellence — Araneus Edutech</title>
<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Montserrat:wght@400;500;600;700;800;900&family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
<style>
  *,
  *::before,
  *::after {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  /* A4 Landscape – zero margins */
  html, body {
    width: 100%;
    height: 100%;
    background: #0a1f2e;   /* deep fallback navy */
    margin: 0;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Lato', sans-serif;
  }

  /* certificate wrapper – exact A4 landscape dimensions */
  .certificate {
    width: 297mm;           /* A4 landscape width */
    height: 210mm;          /* A4 landscape height */
    position: relative;
    background-image: url('<?= APP_URL ?>/assets/img/certificate-bg.png');
    background-size: cover;      /* fill entire canvas without distortion */
    background-position: center center;
    background-repeat: no-repeat;
    background-color: #fef9e6;   /* warm base while bg loads */
    box-shadow: 0 20px 35px rgba(0, 0, 0, 0.2);
    overflow: visible;
    page-break-after: avoid;
    break-inside: avoid;
  }

  /* Main content container – positioned exactly within the decorative border area */
  .certificate-content {
    position: relative;
    width: 100%;
    height: 100%;
    padding: 22mm 18mm 20mm 18mm;   /* generous inner margins matching template background */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    background: transparent;        /* no white overlay – pure background image shows through */
  }

  /* ----- TOP SECTION (ID + titles) ----- */
  .top-meta {
    display: flex;
    justify-content: center;
    margin-bottom: 6px;
  }
  .cert-id {
    font-family: 'Montserrat', sans-serif;
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 1px;
    color: #b88638;        /* gold/brass tone matching border */
    background: rgba(255, 248, 225, 0.6);
    padding: 3px 12px;
    border-radius: 30px;
    backdrop-filter: blur(1px);
    text-transform: uppercase;
  }

  .main-titles {
    text-align: center;
    margin-top: -4px;
  }
  .cert-heading {
    font-family: 'Montserrat', sans-serif;
    font-size: 68px;
    font-weight: 900;
    letter-spacing: 4px;
    color: #1f3b4c;
    text-transform: uppercase;
    line-height: 1.1;
    text-shadow: 1px 1px 0 rgba(255,215,140,0.3);
  }
  .cert-sub {
    font-family: 'Montserrat', sans-serif;
    font-size: 22px;
    font-weight: 800;
    letter-spacing: 6px;
    color: #c29b3b;
    text-transform: uppercase;
    margin-top: 2px;
    margin-bottom: 12px;
  }

  /* ----- PRESENTED TO + NAME (script) ----- */
  .presented-line {
    text-align: center;
    font-family: 'Lato', sans-serif;
    font-size: 14px;
    font-weight: 600;
    color: #2c3e44;
    letter-spacing: 0.5px;
    margin-top: 4px;
    margin-bottom: 8px;
  }
  .recipient-name {
    text-align: center;
    font-family: 'Great Vibes', cursive;
    font-size: 68px;
    color: #c29b3b;
    line-height: 1.1;
    margin: 8px 0 2px 0;
    font-weight: normal;
    word-break: keep-all;
  }
  .name-underline {
    width: 440px;
    max-width: 85%;
    height: 1.2px;
    background: linear-gradient(90deg, transparent, #aa7e3a, #e4c27a, #aa7e3a, transparent);
    margin: 0 auto 12px auto;
  }

  /* ----- DESCRIPTION / BODY TEXT (program details) ----- */
  .cert-details {
    max-width: 610px;
    margin: 0 auto;
    text-align: center;
    font-family: 'Lato', sans-serif;
    font-size: 13.5px;
    line-height: 1.65;
    color: #1f2e38;
    background: rgba(255, 253, 245, 0.55);
    padding: 6px 12px;
    border-radius: 14px;
    backdrop-filter: blur(2px);
  }
  .cert-details strong {
    font-weight: 800;
    color: #a7772a;
    font-style: normal;
  }
  .cert-details em {
    font-style: italic;
    font-weight: 500;
  }

  /* ----- FOOTER (signatures + QR + MSME) ----- */
  .footer-section {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-top: 18px;
    padding: 0 12px;
  }

  /* signature blocks (left / right) */
  .signature {
    text-align: center;
    width: 210px;
  }
  .signature-name {
    font-family: 'Great Vibes', cursive;
    font-size: 28px;
    color: #1a2c3c;
    border-bottom: 1.2px solid #bc8f4b;
    display: inline-block;
    min-width: 160px;
    padding-bottom: 4px;
    margin-bottom: 6px;
    line-height: 1.2;
  }
  .signature-role {
    font-family: 'Montserrat', sans-serif;
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 1.8px;
    color: #7c5e2e;
    text-transform: uppercase;
  }

  /* center badge: QR + MSME logo */
  .center-badge {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
  }
  .qr-code {
    width: 112px;
    height: 112px;
    object-fit: contain;
    filter: drop-shadow(0 2px 6px rgba(0,0,0,0.1));
    background: white;
    padding: 5px;
    border-radius: 12px;
  }
  .msme-wrapper {
    text-align: center;
  }
  .msme-logo-img {
    height: 46px;
    object-fit: contain;
    display: block;
    margin: 0 auto;
  }
  /* fallback msme graphic (elegant and subtle) */
  .msme-fallback {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  .msme-bars {
    display: flex;
    gap: 4px;
    justify-content: center;
    margin-bottom: 4px;
  }
  .msme-bar {
    width: 9px;
    background: #1f4b7c;
    border-radius: 3px 3px 0 0;
  }
  .msme-text-en {
    font-family: 'Montserrat', sans-serif;
    font-size: 7px;
    font-weight: 800;
    color: #1f4b7c;
    letter-spacing: 0.6px;
    text-transform: uppercase;
    text-align: center;
    line-height: 1.3;
  }
  .msme-text-hi {
    font-size: 7px;
    color: #1f4b7c;
    text-align: center;
  }

  /* micro adjustments for perfect alignment */
  @media print {
    html, body {
      background: white;
      margin: 0;
      padding: 0;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }
    .certificate {
      width: 100%;
      height: auto;
      box-shadow: none;
      margin: 0;
      page-break-after: avoid;
      break-inside: avoid;
    }
    @page {
      size: landscape;
      margin: 0;
    }
    .certificate-content {
      padding: 22mm 18mm 20mm 18mm;
    }
    .cert-details {
      background: rgba(255, 253, 245, 0.7);
      backdrop-filter: none;
    }
  }

  /* responsive safeguard for screen preview */
  @media screen and (max-width: 1100px) {
    .certificate {
      transform: scale(0.98);
      margin: 15px auto;
    }
  }
</style>
</head>
<body>
<div class="certificate">
  <div class="certificate-content">
    
    <!-- upper part: certificate ID aligned to the right (elegant) -->
    <div class="top-meta">
      <div class="cert-id">Certificate ID : <?= htmlspecialchars($cert['certificate_id'] ?? $certId ?? 'PP/11/25/252611') ?></div>
    </div>

    <!-- main titles area -->
    <div class="main-titles">
      <div class="cert-heading">CERTIFICATE</div>
      <div class="cert-sub">OF &nbsp; <?= strtoupper(htmlspecialchars($cert['certificate_type'] ?? $certType ?? 'PARTICIPATION')) ?></div>
    </div>

    <!-- presented to line -->
    <div class="presented-line">This Certificate Is Proudly Presented To :</div>

    <!-- recipient name + subtle underline -->
    <div class="recipient-name"><?= htmlspecialchars($cert['full_name'] ?? $name ?? 'Recipient Name') ?></div>
    <div class="name-underline"></div>

    <!-- dynamic body text : program, project, dates, duration -->
    <div class="cert-details">
      <?php
        // Safely gather variables from either $cert array or fallback
        $displayProgram = htmlspecialchars($cert['program_name'] ?? $program ?? 'the training program');
        $displayProject = htmlspecialchars($cert['project_name'] ?? $project ?? '');
        $startDate = !empty($cert['start_date']) ? date('d-m-Y', strtotime($cert['start_date'])) : ($start ?? '');
        $endDate = !empty($cert['end_date']) ? date('d-m-Y', strtotime($cert['end_date'])) : ($end ?? '');
        $durationText = htmlspecialchars($cert['duration'] ?? $duration ?? '');
        $modeText = htmlspecialchars($cert['mode'] ?? $mode ?? 'Offline');
      ?>
      For successfully completing the <strong><?= $displayProgram ?></strong>
      <?php if(!empty($displayProject)): ?>
        and accomplishing the project &#8220;<strong><?= $displayProject ?></strong>&#8221;,
      <?php endif; ?>
      <?php if(!empty($startDate) && !empty($endDate)): ?>
        held from <strong><?= $startDate ?> to <?= $endDate ?></strong>,
      <?php endif; ?>
      <?php if(!empty($durationText)): ?>
        with a total duration of <strong><?= $durationText ?> (<?= $modeText ?>)</strong>,
      <?php endif; ?>
      organized by <strong>Araneus Edutech LLP</strong>.
    </div>

    <!-- footer with signatures, QR, MSME badge -->
    <div class="footer-section">
      <!-- left: Director signature -->
      <div class="signature">
        <div class="signature-name"><?= htmlspecialchars($cert['director_name'] ?? $director ?? 'Shubhajit Kanti Das') ?></div>
        <div class="signature-role">(Director)</div>
      </div>

      <!-- center block: QR code + MSME (official) -->
      <div class="center-badge">
        <?php
          $qrPathDisplay = '';
          if (!empty($cert['qr_code_path'])) {
              $qrPathDisplay = UPLOAD_URL . 'uploads/' . $cert['qr_code_path'];
          } elseif (isset($qrPath)) {
              $qrPathDisplay = $qrPath;
          } else {
              $certIdForQR = htmlspecialchars($cert['certificate_id'] ?? $certId ?? 'CERT-UNIQUE');
              $qrPathDisplay = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&ecc=H&color=8B4513&data=' . urlencode(UPLOAD_URL . '/verify/' . $certIdForQR);
          }
        ?>
        <img class="qr-code" src="<?= $qrPathDisplay ?>" alt="Verification QR Code">
        <div class="msme-wrapper">
          <?php
            $logoPath = APP_URL . '/assets/img/msme-logo.png';
            $localFileCheck = APP_ROOT . '/public/assets/img/msme-logo.png';
            if (file_exists($localFileCheck)): ?>
              <img class="msme-logo-img" src="<?= $logoPath ?>" alt="MSME Government of India">
          <?php else: ?>
            <!-- official-style MSME indicator matching govt branding -->
            <div class="msme-fallback">
              <div class="msme-bars">
                <div class="msme-bar" style="height: 12px;"></div>
                <div class="msme-bar" style="height: 20px;"></div>
                <div class="msme-bar" style="height: 26px;"></div>
                <div class="msme-bar" style="height: 16px;"></div>
                <div class="msme-bar" style="height: 22px;"></div>
              </div>
              <div class="msme-text-en">Micro, Small &amp; Medium<br>Enterprises</div>
              <div class="msme-text-hi">सूक्ष्म, लघु एवं मध्यम उद्यम</div>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- right: Coordinator signature -->
      <div class="signature">
        <div class="signature-name"><?= htmlspecialchars($cert['coordinator_name'] ?? $coord ?? 'Mayukh Maitha') ?></div>
        <div class="signature-role">(Project Coordinator)</div>
      </div>
    </div>
  </div>
</div>

<script>
  // automatic printing unless preview mode is active
  if (window.location.search.indexOf('preview=1') === -1) {
    window.addEventListener('load', function() {
      setTimeout(function() {
        window.print();
      }, 300);
    });
  }
</script>
</body>
</html>