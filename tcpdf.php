<?php

//require_once('tcpdf/tcpdf.php'); // adjust path if needed



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
<table width='100%' cellspacing='0' cellpadding='4' border='0'>
  <tr>
  <td width='40%'>".displayLogo($pdf, '/img/img.png')."</td>
    <td align='right'>
      <h2>OBAFEMI AWOLOWO UNIVERSITY</h2>
      <h3>CENTRE FOR DISTANCE LEARNING</h3>
      <p>
        ILE-IFE, OSUN STATE, NIGERIA<br>
        Tel: 08101828793-Direct <br>
        director@oaucdl.edu.ng <br>
        www.oaucdl.edu.ng
      </p>
    </td>
  </tr>
</table>


<p><b>Our Ref. No:</b> {$appEmail['ref_no']} &nbsp;&nbsp;&nbsp;&nbsp; 
<b>Date:</b> " . date('jS F, Y') . "</p>

<p><b>{$appEmail['surname']} {$appEmail['othername']}</b><br>
Centre for Distance Learning<br>
Obafemi Awolowo University,<br>
Ile-Ife.</p>

<p>Dear {$appEmail['surname']} {$appEmail['othername']},</p>

<h3>RE: APPLICATION FOR {$app['leave_type']}</h3>

<p>The above subject matter refers.</p>

<p>I write to convey the Director’s approval for you to proceed on 
<b>{$app['working_days']} working days</b> of leave, 
being part of your Annual Leave for " . date('Y') . ".</p>

<p>The leave period spans between <b>{$startDate}</b> and 
<b>{$endDate} " . date('Y') . "</b>.</p>

<p>You are to resume duty on <b>{$resumptionDate}, " . date('Y') . "</b>.</p>

<p>It is on record that you have <b>{$remainingLeave}</b> working days 
annual leave remaining for " . date('Y') . ".</p>

<p>It is noted that <b>{$app['relieving_officer']}</b>, will cover your 
schedule while on leave.</p>

<p>Kindly fill and submit the resumption form on your resumption.</p>

<p>Thank you.</p>
<br><br>
<p>(Signed)<br>
Director,<br>
Obafemi Awolowo University.</p>

<p><b>Cc:</b> {$app['relieving_officer']}, for your information please.</p>
";

$pdf->writeHTML($html, true, false, true, false, '');

// ---- Save file ----
$filePath = __DIR__ . '/generated_letters/approval_letter_' . $appEmail['ref_no'] . '.pdf';
$pdf->Output($filePath, "F");
