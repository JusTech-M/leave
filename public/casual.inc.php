<?php
session_start();
require '../config/db.php';
require '../config/send_mail.php';
require 'casual_model.php';
require 'leave_contr.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $leaveType = $_POST["casual_leave"];
    $applicantName = trim($_POST["employee_name"]);
    $designation = trim($_POST["designation"]);
    $department = trim($_POST["department"]);
    $startDate = $_POST["start_date"];
    $endDate = $_POST["end_date"];
    //$TotalWorkingDays = $_POST["Total_working_days"];
    $leavePurpose = $_POST["leave_purpose"];
    $relievingName = trim($_POST["relieving_name"]);
    $relievingEmail = trim($_POST["relieving_email"]);
    $role = $_SESSION['role'];

    try {
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
        $remainingLeave = 5 - $_SESSION['num_casual_used'];
        $errors = [];

        if(officer_not_a_member_of_staff($pdo, $relievingEmail)){
            $errors["not_a_member"] = "The relieving officer is not a member of staff";
        }

        if($_SESSION['email'] === $relievingEmail){
            $errors["same_user"] = "You Cannot Relieve Yourself.";
        }

        if(get_applicant($pdo, $_SESSION['user_id'])){
            $errors["already_applied"] = "You have a pending leave request";
        }

         if(($TotalWorkingDays + $_SESSION['num_casual_used']) > 5){
            $errors["max_casual_exceeded"] = "You have taken {$_SESSION['num_casual_used']} days Casual Leave already. you have {$remainingLeave} day(s) remaining";
        }

        if($TotalWorkingDays > 5){
            $errors["max_casual_exceeded"] = "You can only be granted maximum of five(5) working days";
        }

        if($_SESSION['num_casual_used'] === 5){
             $errors["max_casual_exceeded__"] = "You have exhausted the numbers of casual leave. Apply for Annual Leave instead";
        }

        if( $TotalWorkingDays > 3){
             $errors["max_casual_exceeded___"] = "You can take maximum of 3 working days at a time";
        }


        

        

        if($errors){
            $_SESSION["errors"] = $errors;
            header('Location: apply_leave.php');
            die();
        }else{
            submit_leave_form_casual($pdo, 
         $user_id, 
         $leaveType, 
         $startDate, 
         $endDate, 
         $TotalWorkingDays, 
         $leavePurpose, 
         $relievingName, 
         $relievingEmail, 
         $applicantName, 
         $designation, 
         $department,
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




