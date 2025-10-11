<?php
session_start();
require '../config/db.php';
require '../config/send_mail.php';
require 'd_director_model.php';
require '../public/casual_model.php';
require '../public/util.php';

if ($_SESSION['role'] !== 'deputy_director') die("Access denied.");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $appId = $_POST['user_id'];
    $unit_id = $_POST['unit_id'];
    $action = $_POST['action'];
    $note = $_POST['note'];

    try {
// ======= Update leave application status to "pending admin approval"  ==============================
        update_leave_app($pdo, $note, $id, $unit_id, $action);
        if($action === "approve"){
            $fromEmail = "noreply@oaucdl.edu.ng";
            $adminEmail = get_admin_email($pdo);
            $subject = "Pending Leave Request From a Member of Staff";
            $message = "Dear Adminisrative Secretaty,\n\nA new leave request has been submitted.\nPlease review it.\n\nRegards,\nLeave Management System";
            sendNotification($adminEmail['email'], $subject, $message, $fromEmail);
        }else{
            $fromEmail = "noreply@oaucdl.edu.ng";

// ======= Get applicant email from ../public/casual_model.php' =====================================
            $hod_details = get_hod_email($pdo, $_SESSION['unit_id']);
            $appsDetails = get_leave_app_details($pdo, $id);
            $appEmail = get_applicant_email($pdo, $appId);
            $subject = "Leave Request Rejected";
            $message = "Dear".$appEmail['surname']. " " .$appEmail['othername'].",\n\nYour leave request has been rejected by the Head of Unit.\n\nFor the following reason:\n{$appsDetails['hod_recommendation']}\n\nRegards,\nLeave Management System";
            sendNotification($appEmail['email'], $subject, $message, $fromEmail);
        }
        

        header("Location: pending_requests.php");
        exit;
    } catch (PDOException $e) {
        die('Query failed: '. $e->getMessage());
    }
}
