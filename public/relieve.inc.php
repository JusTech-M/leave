<?php
session_start();
require '../config/db.php';
require '../config/send_mail.php';
require 'casual_model.php';
if ($_SESSION['role'] !== 'staff') die("Access denied.");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $userId = $_POST['user_id'];
    $action = $_POST['action'];
    $note = $_POST['note'];

    try {
        $hodEmail = get_hod_email($pdo, $_SESSION['unit_id']);
        $appId = get_applicant_email($pdo, $userId);
        $relieveEmail = get_applicant_details($pdo, $_SESSION['email']);


// ============== update Leave application status ===========================

        relieve_action($pdo, $note, $id, $action);
        
// =================== Send email based on the action =======================

        if($action === "accept"){
            $fromEmail = "noreply@oaucdl.edu.ng";
            $subject = "Pending Leave Request from Member of Staff";
            $message = "Dear ".$hodEmail['surname']." ".$hodEmail['othername'].",\n\nA leave request has been submitted.\n\nRegards,\nLeave Management System";
            sendNotification($hodEmail['email'], $subject, $message, $fromEmail);

            
        }else{
            foreach($relieveEmail as $email){
                $fromEmail = "noreply@oaucdl.edu.ng";
                $subject = "Leave Request Rejected";
                $message = "Dear ".$appId['surname']." ".$appId['othername'].",\n\nYour Relief request has been rejected by {$email['relieving_officer']}.\n\nRegards,\nLeave Management System";
                sendNotification($appId['email'], $subject, $message, $fromEmail);
            }
        }
        

        header("Location: relieve.php");
        exit;
    } catch (PDOException $e) {
        die("Query Failed: ". $e->getMessage());
    }

    
}
?>