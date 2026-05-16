<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice <?= htmlspecialchars($invoice['invoice_number']) ?></title>
    <style>
        /* ── Reset & Base ────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 13px;
            color: #111;
            background: #e8e8e8;
            background-image: radial-gradient(circle at 1px 1px, #c8c8c8 1px, transparent 1px);
            background-size: 20px 20px;
        }

        /* ── Print controls (hidden on print) ───────────────────── */
        .print-controls {
            position: fixed;
            top: 0; left: 0; right: 0;
            background: #1a1a2e;
            color: #fff;
            padding: 10px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 999;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }
        .print-controls h4 { font-size: 14px; font-weight: 600; }
        .print-controls .btn-group { display: flex; gap: 10px; }
        .btn-print {
            background: #4f8ef7;
            color: #fff;
            border: none;
            padding: 7px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            display: flex; align-items: center; gap: 6px;
        }
        .btn-print:hover { background: #2563eb; }
        .btn-back {
            background: transparent;
            color: #ccc;
            border: 1px solid #555;
            padding: 7px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
            text-decoration: none;
            display: flex; align-items: center; gap: 6px;
        }
        .btn-back:hover { background: rgba(255,255,255,0.08); color: #fff; }

        /* ── Page wrapper ────────────────────────────────────────── */
        .page-wrap {
            margin: 64px auto 32px;
            max-width: 820px;
            padding: 0 16px;
        }

        /* ── Invoice Card ────────────────────────────────────────── */
        .invoice-card {
            background: #fff;
            border: 1px solid #c8c8c8;
            padding: 36px 40px 32px;
            position: relative;
        }

        .invoice-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url('<?= APP_URL ?>/assets/img/icon.png');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: 480px auto;
            opacity: 0.09;          /* adjust 0.05–0.12 to taste */
            pointer-events: none;
            z-index: 0;
        }

        /* Ensure all direct children sit above the watermark */
        .invoice-card > * {
            position: relative;
            z-index: 1;
        }

        /* ── Watermark label ─────────────────────────────────────── */
        .copy-label {
            position: absolute;
            top: 12px; right: 16px;
            font-size: 11px;
            font-style: italic;
            color: #888;
            letter-spacing: 0.5px;
        }

        /* ── Header ──────────────────────────────────────────────── */
        .inv-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #111;
            padding-bottom: 16px;
            margin-bottom: 20px;
        }
        .seller-block .company-name {
            font-size: 19px;
            font-weight: 700;
            letter-spacing: 0.3px;
            margin-bottom: 4px;
        }
        .seller-block p { font-size: 12px; color: #333; line-height: 1.55; }

        .inv-meta { text-align: right; }
        .inv-meta h2 {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #1a1a2e;
            margin-bottom: 8px;
        }
        .inv-meta table { margin-left: auto; border-collapse: collapse; }
        .inv-meta table td {
            font-size: 12px;
            padding: 2px 6px 2px 0;
        }
        .inv-meta table td:first-child { color: #555; white-space: nowrap; }
        .inv-meta table td:last-child { font-weight: 600; text-align: right; }

        /* ── Parties ─────────────────────────────────────────────── */
        .parties {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }
        .party-block {
            border: 1px solid #ddd;
            padding: 12px 14px;
            border-radius: 2px;
        }
        .party-block h4 {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #888;
            margin-bottom: 6px;
            font-weight: 700;
        }
        .party-block p { font-size: 12px; line-height: 1.6; }
        .party-block .party-name { font-weight: 700; font-size: 13px; margin-bottom: 2px; }

        /* ── Items Table ─────────────────────────────────────────── */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
            font-size: 12px;
        }
        .items-table thead tr {
            background: #1a1a2e;
            color: #fff;
        }
        .items-table thead th {
            padding: 8px 10px;
            font-weight: 600;
            text-align: left;
            font-size: 11px;
            letter-spacing: 0.3px;
            white-space: nowrap;
        }
        .items-table thead th.right { text-align: right; }
        .items-table tbody tr { border-bottom: 1px solid #eee; }
        .items-table tbody tr:last-child { border-bottom: 2px solid #ccc; }
        .items-table tbody td {
            padding: 9px 10px;
            vertical-align: top;
            line-height: 1.5;
        }
        .items-table tbody td.right { text-align: right; }
        .items-table tbody td.center { text-align: center; }
        .items-table tfoot tr td {
            padding: 6px 10px;
            font-size: 12px;
        }
        .items-table tfoot .label { text-align: right; color: #555; }
        .items-table tfoot .value { text-align: right; font-weight: 600; }
        .items-table tfoot tr.grand-total td {
            font-size: 14px;
            font-weight: 800;
            border-top: 2px solid #111;
            padding-top: 10px;
        }

        /* ── Summary row ─────────────────────────────────────────── */
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            gap: 24px;
        }
        .bank-details {
            flex: 1;
            border: 1px solid #ddd;
            padding: 12px 14px;
            border-radius: 2px;
        }
        .bank-details h4 {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #888;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .bank-details table { border-collapse: collapse; width: 100%; }
        .bank-details table td { font-size: 12px; padding: 2px 0; }
        .bank-details table td:first-child { color: #555; width: 120px; }
        .bank-details table td:last-child { font-weight: 600; }

        .totals-box { min-width: 240px; }
        .totals-box table { width: 100%; border-collapse: collapse; }
        .totals-box table td { padding: 5px 8px; font-size: 12px; }
        .totals-box table td:first-child { color: #555; }
        .totals-box table td:last-child { text-align: right; font-weight: 600; }
        .totals-box table tr.net-payable td {
            background: #1a1a2e;
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            padding: 8px 8px;
        }

        /* ── Words & Footer ──────────────────────────────────────── */
        .amount-words {
            margin-top: 16px;
            font-size: 12px;
            font-style: italic;
            color: #444;
            border-top: 1px dashed #ccc;
            padding-top: 10px;
        }
        .amount-words strong { font-style: normal; }

        .inv-footer {
            margin-top: 24px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            border-top: 1px solid #ddd;
            padding-top: 16px;
        }
        .notes-block { flex: 1; }
        .notes-block h4 {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #888;
            font-weight: 700;
            margin-bottom: 4px;
        }
        .notes-block p { font-size: 11.5px; color: #444; line-height: 1.55; }
        .signature-block { text-align: center; min-width: 180px; }
        .sig-line {
            width: 160px;
            border-top: 1px solid #333;
            margin: 0 auto 4px;
        }
        .signature-block p { font-size: 11px; color: #555; }

        a { color: #666666; text-decoration: none; }
        a:hover { text-decoration: underline; }

        /* ── @print overrides ────────────────────────────────────── */
        @page { size: A4; margin: 12mm 14mm; }
        @media print {
            body { background: #fff; }
            .print-controls { display: none !important; }
            .page-wrap { margin: 0 auto; max-width: 100%; padding: 0; }
            .invoice-card { border: none; padding: 20px 24px 16px; }
        }
    </style>
</head>
<body>

<!-- Print controls bar -->
<div class="print-controls">
    <h4>&#128438; Invoice <?= htmlspecialchars($invoice['invoice_number']) ?></h4>
    <div class="btn-group">
        <a href="/admin/invoices/<?= $invoice['id'] ?>" class="btn-back">&#8592; Back</a>
        <button class="btn-print" onclick="window.print()">&#128438; Print / Save PDF</button>
    </div>
</div>

<div class="page-wrap">
<div class="invoice-card">

    <div class="copy-label">Original Buyer's Copy</div>

    <!-- ── Header ──────────────────────────────────────────────── -->
    <div class="inv-header">
        <div class="seller-block">
            <div class="row">
                <div class="col">
                    <img src="<?= APP_URL ?>/assets/img/logo.png" alt="Araneus Edutech LLP" style="height:50px;">
                </div>
                <div class="col">
                    <div class="company-name">Araneus Edutech LLP</div>
                    <address>
                        116/2, East Chandmari 3rd Lane, N.C.Pukur<br>
                        Kolkata – 700 122<br>
                    </address>
                    <a href="tel:+91-9874291460">+91-9874291460</a><br>
                    <a href="mailto:araneusedutech@gmail.com">araneusedutech@gmail.com</a>
                    <?php if (!empty($invoice['pan'])): ?>
                    <p style="margin-top:4px;">PAN: <?= htmlspecialchars($invoice['pan']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="inv-meta">
            <h2>Tax Invoice</h2>
            <table>
                <tr>
                    <td>Invoice No :</td>
                    <td><?= htmlspecialchars($invoice['invoice_number']) ?></td>
                </tr>
                <tr>
                    <td>Date :</td>
                    <td><?= date('d-m-Y', strtotime($invoice['invoice_date'])) ?></td>
                </tr>
                <?php if (!empty($invoice['due_date'])): ?>
                <tr>
                    <td>Due Date :</td>
                    <td><?= date('d-m-Y', strtotime($invoice['due_date'])) ?></td>
                </tr>
                <?php endif; ?>
                <?php if (!empty($invoice['po_number'])): ?>
                <tr>
                    <td>PO No :</td>
                    <td><?= htmlspecialchars($invoice['po_number']) ?></td>
                </tr>
                <?php endif; ?>
                <tr>
                    <td>LLPIN :</td>
                    <td>AAP-3776</td>
                </tr>
                <tr>
                    <td>PAN :</td>
                    <td>AAXFB1706D</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- ── Buyer / Seller parties ──────────────────────────────── -->
    <div class="parties">
        <div class="party-block">
            <h4>Bill To (Customer)</h4>
            <p class="party-name"><?= htmlspecialchars($invoice['client_name']) ?></p>
            <?php if (!empty($invoice['address'])): ?>
            <p><?= nl2br(htmlspecialchars($invoice['address'])) ?></p>
            <?php endif; ?>
            <?php if (!empty($invoice['city']) || !empty($invoice['state'])): ?>
            <p>
                <?= htmlspecialchars(implode(', ', array_filter([$invoice['city'], $invoice['state'], $invoice['country']]))) ?>
            </p>
            <?php endif; ?>
            <?php if (!empty($invoice['client_phone'])): ?>
            <p>Phone: <?= htmlspecialchars($invoice['client_phone']) ?></p>
            <?php endif; ?>
            <?php if (!empty($invoice['gstin'])): ?>
            <p>GSTIN: <?= htmlspecialchars($invoice['gstin']) ?></p>
            <?php endif; ?>
        </div>

        <div class="party-block">
            <h4>Billed By (Seller)</h4>
            <p class="party-name">Araneus Edutech LLP</p>
            <p>116/2, East Chandmari 3rd Lane, N.C.Pukur<br>
               Kolkata – 700 122, West Bengal</p>
            <p>Phone: +91-70444058292</p>
            <p>PAN: AAXFB1706D &nbsp;|&nbsp; LLPIN: AAP-3776</p>
        </div>
    </div>

    <!-- ── Line items ──────────────────────────────────────────── -->
    <table class="items-table">
        <thead>
            <tr>
                <th style="width:30px">#</th>
                <th>Description</th>
                <th class="right" style="width:60px">Qty</th>
                <th class="right" style="width:90px">Unit Price</th>
                <th class="right" style="width:60px">GST %</th>
                <th class="right" style="width:80px">Tax Amt</th>
                <th class="right" style="width:100px">Amount</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $i => $item): ?>
            <tr>
                <td class="center"><?= $i + 1 ?></td>
                <td><?= htmlspecialchars($item['description']) ?></td>
                <td class="right"><?= htmlspecialchars($item['quantity']) ?></td>
                <td class="right">&#8377; <?= number_format((float)$item['unit_price'], 2) ?></td>
                <td class="center"><?= htmlspecialchars($item['gst_rate']) ?>%</td>
                <td class="right">&#8377; <?= number_format((float)$item['tax_amount'], 2) ?></td>
                <td class="right">&#8377; <?= number_format((float)$item['total_amount'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5"></td>
                <td class="label">Sub Total:</td>
                <td class="value">&#8377; <?= number_format((float)$invoice['sub_total'], 2) ?></td>
            </tr>
            <?php if ((float)$invoice['tax_amount'] > 0): ?>
            <tr>
                <td colspan="5"></td>
                <td class="label">Tax Total:</td>
                <td class="value">&#8377; <?= number_format((float)$invoice['tax_amount'], 2) ?></td>
            </tr>
            <?php endif; ?>
            <?php if ((float)$invoice['discount_amount'] > 0): ?>
            <tr>
                <td colspan="5"></td>
                <td class="label">Discount:</td>
                <td class="value" style="color:#c0392b">– &#8377; <?= number_format((float)$invoice['discount_amount'], 2) ?></td>
            </tr>
            <?php endif; ?>
            <tr class="grand-total">
                <td colspan="5"></td>
                <td class="label" style="font-weight:800;color:#111">Net Payable:</td>
                <td class="value" style="font-size:15px">&#8377; <?= number_format((float)$invoice['total_amount'], 2) ?></td>
            </tr>
        </tfoot>
    </table>

    <!-- ── Amount in words ─────────────────────────────────────── -->
    <div class="amount-words">
        <strong>Amount in Words:</strong> <?= htmlspecialchars(numberToWords((float)$invoice['total_amount'])) ?> only.
    </div>

    <!-- ── Bank details + totals ───────────────────────────────── -->
    <div class="summary-row">
        <div class="bank-details">
            <h4>Wire Transfer / Payment Details</h4>
            <table>
                <tr><td>Bank Name</td><td>State Bank of India (SBI)</td></tr>
                <tr><td>Account No</td><td>38904707477</td></tr>
                <tr><td>IFSC Code</td><td>SBIN0001770</td></tr>
                <tr><td>Remarks</td><td>Software Consulting</td></tr>
            </table>
            <?php if (!empty($invoice['payment_terms'])): ?>
            <p style="margin-top:8px;font-size:11.5px;color:#444;">
                <strong>Payment Terms:</strong> <?= htmlspecialchars($invoice['payment_terms']) ?>
            </p>
            <?php endif; ?>
        </div>

        <div class="totals-box">
            <table>
                <tr>
                    <td>Gross Amount:</td>
                    <td>&#8377; <?= number_format((float)$invoice['sub_total'], 2) ?></td>
                </tr>
                <tr>
                    <td>Add CGST:</td>
                    <td>&#8377; <?= number_format((float)$invoice['tax_amount'] / 2, 2) ?></td>
                </tr>
                <tr>
                    <td>Add SGST:</td>
                    <td>&#8377; <?= number_format((float)$invoice['tax_amount'] / 2, 2) ?></td>
                </tr>
                <?php if ((float)$invoice['discount_amount'] > 0): ?>
                <tr>
                    <td>Less Discount:</td>
                    <td style="color:#c0392b">– &#8377; <?= number_format((float)$invoice['discount_amount'], 2) ?></td>
                </tr>
                <?php endif; ?>
                <tr class="net-payable">
                    <td>NET PAYABLE:</td>
                    <td>&#8377; <?= number_format((float)$invoice['total_amount'], 2) ?></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- ── Footer: notes + signature ──────────────────────────── -->
    <div class="inv-footer">
        <div class="notes-block">
            <h4>Terms & Notes</h4>
            <p>Payment shall be made in two instalments (50% upfront, 50% on delivery).</p>
            <p>Payment once done cannot be refunded under any circumstances.</p>
            <p>Any changes beyond the defined scope will require additional charges.</p>
            <?php if (!empty($invoice['notes'])): ?>
            <p style="margin-top:6px;"><?= nl2br(htmlspecialchars($invoice['notes'])) ?></p>
            <?php endif; ?>
        </div>
        <div class="signature-block">
            <div style="height:48px;"></div>
            <div class="sig-line"></div>
            <p>(Authorised Signature)</p>
            <p style="margin-top:3px;font-weight:600;font-size:11px;">Araneus Edutech LLP</p>
        </div>
    </div>

</div><!-- .invoice-card -->
</div><!-- .page-wrap -->

<script>
<?php
// Simple number-to-words helper (PHP) – defined as a function used above
function numberToWords(float $amount): string {
    $amount = (int)round($amount);
    $ones = ['','One','Two','Three','Four','Five','Six','Seven','Eight','Nine',
             'Ten','Eleven','Twelve','Thirteen','Fourteen','Fifteen','Sixteen',
             'Seventeen','Eighteen','Nineteen'];
    $tens = ['','','Twenty','Thirty','Forty','Fifty','Sixty','Seventy','Eighty','Ninety'];
    if ($amount === 0) return 'Zero';
    $words = '';
    if ($amount >= 10000000) {
        $words .= numberToWords((int)($amount / 10000000)) . ' Crore ';
        $amount %= 10000000;
    }
    if ($amount >= 100000) {
        $words .= numberToWords((int)($amount / 100000)) . ' Lakh ';
        $amount %= 100000;
    }
    if ($amount >= 1000) {
        $words .= numberToWords((int)($amount / 1000)) . ' Thousand ';
        $amount %= 1000;
    }
    if ($amount >= 100) {
        $words .= $ones[(int)($amount / 100)] . ' Hundred ';
        $amount %= 100;
    }
    if ($amount >= 20) {
        $words .= $tens[(int)($amount / 10)] . ' ';
        $amount %= 10;
    }
    if ($amount > 0) {
        $words .= $ones[$amount] . ' ';
    }
    return trim($words);
}
?>
// Auto-prompt print dialog if ?print=1 is in URL
if (new URLSearchParams(window.location.search).get('print') === '1') {
    window.addEventListener('load', () => window.print());
}
</script>
</body>
</html>
