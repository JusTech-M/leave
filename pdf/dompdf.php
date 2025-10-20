<?php
use Dompdf\Dompdf;
$dompdf =new Dompdf();
            // $html = "
            //     <div style='font-family:Arial, sans-serif;'>
            //     <div style = 'display:flex; justify-content:space-between;'>
            //     <div><img src='../img/img.png'></div>
            //     <div style='text-align:right;'>
            //     <h2 style=''>OBAFEMI AWOLOWO UNIVERSITY</h2>
            //     <h3 style=''>CENTRE FOR DISTANCE LEARNING</h3>
            //     <p style=''>ILE-IFE, OSUN STATE, NIGERIA<br>
            //     Tel: 08101828793-Direct <br> director@oaucdl.edu.ng <br> www.oaucdl.edu.ng</p>
            //     </div>
                 
            //     </div>
            //     <hr>

            //     <p><b>Our Ref. No:</b>{$appEmail['ref_no']} &nbsp;&nbsp;&nbsp;&nbsp; 
            //     <b>Date:</b> " . date('jS F, Y') . "</p>

            //     <p><b>{$appEmail['surname']} {$appEmail['othername']}</b><br>
            //     Obafemi Awolowo University,<br>
            //     Ile-Ife.</p>

            //     <p>Dear {$appEmail['surname']} {$appEmail['othername']},</p>

            //     <h3>RE: APPLICATION FOR {$app['leave_type']}</h3>

            //     <p>The above subject matter refers.</p>

            //     <p>I write to convey the Director’s approval for you to proceed on 
            //     <b>{$app['working_days']} working days</b> of leave, 
            //     being part of your Annual Leave for " . date('Y') . ".</p>

            //     <p>The leave period spans between <b>{$startDate}</b> and 
            //     <b>{$endDate} ". date('Y') . "</b>.</p>

            //     <p>You are to resume duty on <b>{$app['resumption_date']}</b>.</p>

            //     <p>It is on record that you have <b>{$remainingLeave}</b> working days 
            //     annual leave remaining for " . date('Y') . ".</p>

            //     <p>It is noted that <b>{$app['relieving_officer']}</b>, will cover your 
            //     schedule while on leave.</p>

            //     <p>Kindly fill and submit the resumption form on your resumption.</p>

            //     <p>Thank you.</p>
            //     <br><br>
            //     <p>(Signed)<br>
            //     Director,<br>
            //     Obafemi Awolowo University.</p>

            //     <p><b>Cc:</b> {$app['relieving_officer']}, for your information please.</p>
            //     </div>
            //     ";

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

                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();

                $file = "../generated_letters/extention_$appId.pdf";
                file_put_contents($file, $dompdf->output());