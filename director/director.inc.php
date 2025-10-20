<?php
session_start();
require '../config/db.php';
require '../config/send_mail.php';
require 'director_model.php';
require '../public/leave_model.php';
require '../public/util.php';
require '../dompdf/autoload.inc.php';
require '../tcpdf/tcpdf.php';

if ($_SESSION['role'] !== 'director') die("Access denied.");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $appId = $_POST['user_id'];
    $unit_id = $_POST['unit_id'];
    $action = $_POST['action'];
    $note = $_POST['note'];

    try {
// ======= Update leave application status to "pending admin approval"  ==============================

        
        update_leave_app($pdo, $note, $id, $action);
        if($action === "approve"){
            $app = get_leave_app_details($pdo, $id);
            $appDetails = get_app($pdo, $appId);


            $usedCasualLeave;
            $remainingLeave;
            $totalUsedLeave;


            if($app['leave_type'] === 'Annual Leave'){
                $usedCasualLeave = $appDetails['num_casual_leave'];
                $totalUsedLeave = $appDetails['num_used_leave'] + $app["working_days"];
                $remainingLeave = $appDetails['leeav_entitlement'] - $app["working_days"];
            }
            
            if($app['leave_type'] === 'Casual Leave'){
                $usedCasualLeave = ($appDetails['num_casual_leave'] + $app["working_days"]) <=5 ? ($appDetails['num_casual_leave'] + $app["working_days"]) : 5;
                $totalUsedLeave = $appDetails['num_used_leave'] + $app["working_days"];
                $remainingLeave = $appDetails['leeav_entitlement'] - $app["working_days"];
            }

            
            

            update_casual_used($pdo, $remainingLeave, $usedCasualLeave, $totalUsedLeave, $appId);
            
            $appEmail = get_applicant_email($pdo, $appId);
            $fromEmail = "noreply@oaucdl.edu.ng";
            $subject1 = "Leave Approved";
            $message1 = "Dear {$appEmail['surname']} {$appEmail['othername']},\n\nYour leave application has been approved. Please find your approval letter attached.\n\nRegards,\nLeave Management System";
            $attachment = "../generated_letters/approval_letter_" . $appEmail['ref_no'] . ".pdf";
            sendNotification($appEmail['email'], $subject1, $message1, $fromEmail, $attachment);

            $adminEmail = get_admin_email($pdo);
            //$fromEmail = "noreply@oaucdl.edu.ng";
            $subject2 = $appEmail['surname']." ".$appEmail['othername']." Leave Approved";
            $message2 = "Dear {$adminEmail['surname']} {$adminEmail['othername']},\n\n{$appEmail['surname']} {$appEmail['othername']} leave request has been Approved.\n\nRegards,\nLeave Management System";
            sendNotification($adminEmail['email'], $subject2, $message2, $fromEmail);


            $app = get_leave_app_details($pdo, $id);

            $hodEmail = get_hod_email($pdo, $app['unit_id']);
            //$fromEmail = "noreply@oaucdl.edu.ng";
            $subject3 = $appEmail['surname']." ".$appEmail['othername']." Leave Approved";
            $message3 = "Dear ". $hodEmail['surname']. " ".$hodEmail['othername'].",\n\n{$appEmail['surname']} {$appEmail['othername']} leave request has been Approved.\n\nRegards,\nLeave Management System";
            sendNotification($hodEmail['email'], $subject3, $message3, $fromEmail);

           

            $relievingOfficer = get_relieving_officer($pdo, $app['relieving_officer_email']);
            //$fromEmail = "noreply@oaucdl.edu.ng";
            $subject4 = $appEmail['surname']." ".$appEmail['othername']." Leave Approved";
            $message4 = "Dear {$relievingOfficer['surname']} {$relievingOfficer['othername']},\n\n{$appEmail['surname']} {$appEmail['othername']} leave request has been Approved.\n\nRegards,\nLeave Management System";
            sendNotification($relievingOfficer['email'], $subject4, $message4, $fromEmail);

            //$app = get_applicant_leave_details($pdo, $id);
            // Convert MySQL dates into human-readable strings
            function formatDateReadable($mysqlDate) {
                if (!$mysqlDate) return ""; // handle NULL
                return date("l, jS F", strtotime($mysqlDate));
            }

            function calculateResumptionDate($endDate, $pdo) {
                $date = new DateTime($endDate);

                // fetch all public holidays from DB

                $holidays = get_public_holidays($pdo);

                // move forward until we find a valid working day
                do {
                    $date->modify('+1 day');
                    $isWeekend = in_array($date->format('N'), [6, 7]); // 6=Sat, 7=Sun
                    $isHoliday = in_array($date->format('Y-m-d'), $holidays);
                } while ($isWeekend || $isHoliday);

                return $date->format('Y-m-d');
        }

            $startDate     = formatDateReadable($app['start_date']);
            $endDate       = formatDateReadable($app['end_date']);
            $resumptionDate = formatDateReadable(calculateResumptionDate($endDate, $pdo));
            $resume = calculateResumptionDate($app['end_date'], $pdo);
            update_resumption_date($pdo, $id, $action, $resume);


            // =================== Generate Approval Letter ==========================================
            //include '../pdf/dompdf.php';
            include '../tcpdf.php';


        }else{
           

// ======= Get applicant email from ../public/leave_model.php' =====================================

            $appEmail = get_applicant_email($pdo, $appId);
            $subject = "Leave Request Rejected";
            $message = "Dear {$appEmail['surname']} {$appEmail['othername']},\n\nYour leave request has been rejected by The Director.\n\nFor the following reason:\n{$app['director_note']}\n\nRegards,\nLeave Management System";
            sendNotification($appEmail['email'], $subject, $message, $fromEmail);

        }
        

        header("Location: pending_requests.php");
        exit;
    } catch (PDOException $e) {
        die('Query failed: '. $e->getMessage());
    }
}else{
    header("Location: ../login/login.php");
}
