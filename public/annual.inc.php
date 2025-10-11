<?php
session_start();
require '../config/db.php';
require '../config/send_mail.php';
require 'casual_model.php';
require 'leave_contr.php';
require 'util.php';


if($_SERVER["REQUEST_METHOD"]=="POST"){
    $leaveType = $_POST["annual_leave"];
    $applicantName = trim($_POST["employee_name"]);
    $designation = trim($_POST["designation"]);
    $department = trim($_POST["department"]);
    $startDate = $_POST["start_date"];
    $endDate = $_POST["end_date"];
    //$TotalWorkingDays = $_POST["working_days"];
    $isOnLeave = $_POST["onLeave"];
    $isOnLeaveApproved = $_POST["onLeaveApproved"];
    $isOnLeaveStart = $_POST["on_leave_start"] ?? null;
    $isOnLeaveEnd = $_POST["on_leave_end"] ?? null;
    $isOnLeaveStartApproved = $_POST["on_leave_start_approved"] ?? null;
    $isOnLeaveEndApproved = $_POST["on_leave_end_approved"] ?? null;
    $defferedLeave = $_POST["deffered_leave"];
    $relievingName = trim($_POST["relieving_name"]);
    $relievingEmail = trim($_POST["relieving_email"]);
    $role = $_SESSION['role'];

    try {

        if(isset($_POST["onLeave"])){
            $selectedRadio = $_POST["onLeave"];
            //echo $selectedRadio;
            if($selectedRadio === "no"){

                $isOnLeaveStart = null;
                $isOnLeaveEnd = null;
                $isOnLeaveStartApproved = null;
                $isOnLeaveEndApproved = null;
            }
        }

        if(isset($_POST["onLeaveApproved"])){
            $selectedRadio = $_POST["onLeaveApproved"];
            //echo $selectedRadio;
            if($selectedRadio === "no"){
                $isOnLeaveStartApproved = null;
                $isOnLeaveEndApproved = null;
            }
        }

        $holidays = [];

        if(get_public_holidays($pdo)){
            $publicHolidays = get_public_holidays($pdo);
            foreach ($publicHolidays as $holiday) {
                array_push($holidays, $holiday);
            }
        }

        $TotalWorkingDays = getWorkingDays($startDate, $endDate, $holidays);

        $user_id = $_SESSION["user_id"];
        $relievingUnitId = get_relieve_unit_id($pdo, $relievingEmail);
        //$remainingLeave = 5 - $_SESSION['num_casual_used'];
        $errors = [];
// ======================= get_app($pdo, $user_id) is from util.php =========================================================
        $user = get_app($pdo, $user_id);
        $remainingLeave = ($user['leeav_entitlement'] - $user['num_used_leave']) < 0 ? 0: $user['leeav_entitlement'] - $user['num_used_leave'];

        if(officer_not_a_member_of_staff($pdo, $relievingEmail)){
            $errors["not_a_member"] = "The relieving officer is not a member of staff";
        }

        if($_SESSION['email'] === $relievingEmail){
            $errors["same_user"] = "You Cannot Relieve Yourself.";
        }

        if(get_applicant($pdo, $_SESSION['user_id'])){
            $errors["already_applied"] = "You have a pending leave request";
        }

        if($TotalWorkingDays > $user['leeav_entitlement']){
             $errors["max_leave_exceeded"] = "You have exceeded the numbers leave days you have!!!";
       }


        if(($user['leeav_entitlement']-$TotalWorkingDays) < 0){
             $errors["max_leave_exceeded"] = "You have taken {$user['num_used_leave']} day(s) Leave already. you have {$remainingLeave} day(s) remaining";
       }

       if($user['leeav_entitlement'] <= 0){
             $errors["leave_exhausted"] = "You have exhausted your leave days";
       }

       
        // if(($TotalWorkingDays + $_SESSION['num_casual_used']) > 5){
        //     $errors["max_casual_exceeded_"] = "You have used {$_SESSION['num_casual_used']} working days already. you have {$remainingLeave} working days Left";
        // }

        // if($_SESSION['num_casual_used'] === 5){
        //      $errors["max_casual_exceeded__"] = "You have exhausted the numbers of casual leave. Apply for Annual Leave instead";
        // }

        

        if($errors){
            $_SESSION["errors"] = $errors;
            header('Location: apply_leave.php');
            die();
        }else{
            submit_leave_form_annual($pdo, 
         $user_id, 
         $leaveType, 
         $startDate, 
         $endDate, 
         $TotalWorkingDays, 
         $relievingName, 
         $relievingEmail, 
         $applicantName, 
         $designation, 
         $department,
        $isOnLeaveStart, 
        $isOnLeaveEnd, 
        $isOnLeaveStartApproved, 
        $isOnLeaveEndApproved, 
        $defferedLeave,
        $role);

        $relievingOfficer = get_relieving_officer($pdo, $relievingEmail);

        if($relievingOfficer){
            $fromEmail = "noreply@oaucdl.edu.ng";
            $subject = "Request to Relieve a Member of Staff";
            $message = "Dear ".$relievingOfficer['surname']. " ".$relievingOfficer['othername'].",\n\nA new leave request has been submitted.\nPlease review it.\n\nRegards,\nLeave Management System";
            sendNotification($relievingOfficer['email'], $subject, $message, $fromEmail);
        }

        if($_SESSION['role'] === 'program_coordinator'){
            updateStatus_ifProg($pdo);
        }

        

        header('Location: apply_leave.php?form=submitted');
        die();
        }
         
    } catch (PDOException $e) {
        die("query failed: ". $e->getMessage());
    }
}else{
    header('Location: ../login/login.php');
}




