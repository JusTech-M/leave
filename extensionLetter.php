<?php

require_once('tcpdf/tcpdf.php'); // adjust path if needed



$pdf = new TCPDF();
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();

// ---- Add Logo (x=15mm, y=10mm, width=30mm) ----
function displayLogo($pdf, $path){
    $logoPath = __DIR__ . $path;  // make sure this file exists
    $pdf->Image($logoPath, 15, 10, 50, 0, 'PNG');

// ---- Move cursor down so text doesn't overlap logo ----
    $pdf->Ln(0);

}

//$resumptionDate = calculateResumptionDate($endDate, $pdo);
// ---- Now write the HTML letter ----
 $html = "
    <div style='font-family:Arial,sans-serif;'>
      <h2 style='text-align:center;'>OBAFEMI AWOLOWO UNIVERSITY</h2>
      <h3 style='text-align:center;'>CENTRE FOR DISTANCE LEARNING</h3>
      <p style='text-align:center;'>ILE-IFE, OSUN STATE, NIGERIA<br>
      Tel: 08101828793 | director@oaucdl.edu.ng</p>
      <hr>

      <p><b>Date:</b> " . date('l, jS F Y') . "</p>
      <p><b>To:</b> {$leave['name']}<br>{$leave['email']}</p>

      <h3>RE: EXTENSION OF LEAVE RESUMPTION DATE</h3>

      <p>This is to inform you that your original leave resumption date of 
      <b>" . $originalResumption->format('l, jS F Y') . "</b> has been extended.</p>";

    if ($recall_days > 0) {
        $html .= "<p>The extension is due to your recall period of <b>{$recall_days} day(s)</b>.</p>";
    }
    if ($public_days > 0) {
        $html .= "<p>Additionally, <b>{$public_days} emergency public holiday day(s)</b> 
                  fell within your leave period.</p>";
    }

    $html .= "
      <p>Your new resumption date is <b>" . $newResumption->format('l, jS F Y') . "</b>.</p>
      <p>Kindly take note and resume accordingly.</p>

      <br><br>
      <p>(Signed)<br>
      Director,<br>
      Centre for Distance Learning,<br>
      Obafemi Awolowo University, Ile-Ife.</p>
    </div>";

$pdf->writeHTML($html, true, false, true, false, '');

// ---- Save file ----
$filePath = __DIR__ . '/generated_letters/extention_letter_' . time() . '.pdf';
$pdf->Output($filePath, "F");
