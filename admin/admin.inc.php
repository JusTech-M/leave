<?php
session_start();
require '../config/db.php';
require '../config/send_mail.php';
require 'admin_model.php';
require '../public/leave_model.php';
require '../public/util.php';
require '../dompdf/autoload.inc.php';
//require '../tcpdf/tcpdf.php';
if ($_SESSION['role'] !== 'admin') die("Access denied.");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $appId = $_POST['user_id'];
    $action = $_POST['action'];
    $note = $_POST['note'];

    try {
// ======= Update leave application status to "pending admin approval"  ==============================
        update_leave_app($pdo, $note, $id, $action);
        if($action === "approve"){
            $fromEmail = "noreply@oaucdl.edu.ng";
            $directorEmail = get_director_email($pdo);
            $subject = "Pending Leave Request From a Member of Staff";
            $message = "Dear Administrative Secretary,\n\nA new leave request has been submitted.\nPlease review it.\n\nRegards,\nLeave Management System";
            sendNotification($directorEmail['email'], $subject, $message, $fromEmail);
        }elseif($action === "reject"){
            $fromEmail = "noreply@oaucdl.edu.ng";

// ======= Get applicant email from ../public/leave_model.php' =====================================
            $appDetails = get_leave_app_details($pdo, $id);
            $appEmail = get_applicant_email($pdo, $appId);
            $subject = "Leave Request Rejected";
            $message = "Dear ".$appEmail['surname']." ".$appEmail['othername'].",\n\nYour leave request has been rejected by {$_SESSION['name']}.\n\nFor the following reason\n{$appDetails['admin_note']}\n\nRegards,\nLeave Management System";
            sendNotification($appEmail['email'], $subject, $message, $fromEmail);
        }elseif($action === "approve_recallRequest"){
            
            $recall = get_recallPublicHoliday($pdo, $id);
            $appDetails = get_leave_app_details($pdo, $recall['leave_app_id']);
            
            $days = $recall['total_working_days'];
// ======================================= Extend the based on the number of days worked =========================================================================
            $originalResumption = new DateTime($appDetails['resumption_date']);
            $newResumption = addWorkingDays($appDetails['resumption_date'] , $days);
            include '../pdf/dompdf.php';
            include_once "../extentionLetter.php";

            $appEmail = get_applicant_email($pdo, $appId);
            $subject = "Leave Extension Approved";
            $message = "Dear ".$appEmail['surname']." ".$appEmail['othername'].",\n\nYour request for your leave extension has been approved {$_SESSION['name']}.\n\nFor the following reason\n{$appDetails['admin_note']}\n\nRegards,\nLeave Management System";
            sendNotification($appEmail['email'], $subject, $message, $fromEmail);


        }else{
            $appDetails = get_leave_app_details($pdo, $id);
            $appEmail = get_applicant_email($pdo, $appId);
            $subject = "Leave Extension Rejected";
            $message = "Dear ".$appEmail['surname']." ".$appEmail['othername'].",\n\nYour request for your leave extension has been rejected {$_SESSION['name']}.\n\nFor the following reason\n{$appDetails['admin_note']}\n\nRegards,\nLeave Management System";
            sendNotification($appEmail['email'], $subject, $message, $fromEmail);
        }
        

        header("Location: pending_requests.php");
        exit;
    } catch (PDOException $e) {
        die('Query failed: '. $e->getMessage());
    }
}
