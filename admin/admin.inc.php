<?php
session_start();
require '../config/db.php';
require '../config/send_mail.php';
require 'admin_model.php';
require '../public/casual_model.php';
require '../public/util.php';
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
        }else{
            $fromEmail = "noreply@oaucdl.edu.ng";

// ======= Get applicant email from ../public/casual_model.php' =====================================
            $appDetails = get_leave_app_details($pdo, $id);
            $appEmail = get_applicant_email($pdo, $appId);
            $subject = "Leave Request Rejected";
            $message = "Dear ".$appEmail['surname']." ".$appEmail['othername'].",\n\nYour leave request has been rejected by {$_SESSION['name']}.\n\nFor the following reason\n{$appDetails['admin_note']}\n\nRegards,\nLeave Management System";
            sendNotification($appEmail['email'], $subject, $message, $fromEmail);
        }
        

        header("Location: pending_requests.php");
        exit;
    } catch (PDOException $e) {
        die('Query failed: '. $e->getMessage());
    }
}
