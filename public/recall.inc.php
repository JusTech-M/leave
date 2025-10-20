<?php

session_start();
require '../config/db.php';
require '../config/send_mail.php';
require 'leave_model.php';
require 'leave_contr.php';
require 'util_view.php';
require 'util.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $applicantName = trim($_POST["employee_name"]);
    $designation = trim($_POST["designation"]);
    $department = trim($_POST["department"]);
    $startDate = $_POST["start_date"];
    $endDate = $_POST["end_date"];
    //$TotalWorkingDays = $_POST["Total_working_days"];
    $recallPurpose = $_POST["recall_purpose"];
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
        $unit_id = $_SESSION["unit_id"];
        $errors = [];

        // if(officer_not_a_member_of_staff($pdo, $relievingEmail)){
        //     $errors["not_a_member"] = "The relieving officer is not a member of staff";
        // }

        // if($_SESSION['email'] === $relievingEmail){
        //     $errors["same_user"] = "You Cannot Relieve Yourself.";
        // }

        // if(get_applicant($pdo, $_SESSION['user_id'])){
        //     $errors["already_applied"] = "You have a pending leave request";
        // }

        //  if(($TotalWorkingDays + $_SESSION['num_casual_used']) > 5){
        //     $errors["max_casual_exceeded"] = "You have taken {$_SESSION['num_casual_used']} days Casual Leave already. you have {$remainingLeave} day(s) remaining";
        // }

        // if($TotalWorkingDays > 5){
        //     $errors["max_casual_exceeded"] = "You can only be granted maximum of five(5) working days";
        // }

        // if($_SESSION['num_casual_used'] === 5){
        //      $errors["max_casual_exceeded__"] = "You have exhausted the numbers of casual leave. Apply for Annual Leave instead";
        // }

        // if( $TotalWorkingDays > 3){
        //      $errors["max_casual_exceeded___"] = "You can take maximum of 3 working days at a time";
        // }


        

        

        if($errors){
            $_SESSION["errors"] = $errors;
            header('Location: apply_leave.php');
            die();
        }else{

            $is_userLeave_approved = get_users_leave_approved($pdo, $_SESSION['user_id']);

            if($is_userLeave_approved){
                 submit_recall_form($pdo, $unit_id, $applicantName, $designation, $department, $startDate, $endDate, $TotalWorkingDays, $recallPurpose, $user_id, $is_userLeave_approved['id']);
            }else{
                $_SESSION['not_onLeave'] = "You are not on any leave. you cannot apply for recall/public holiday";
                header("Location: recall.php");
                die();
            }
           

        //$relievingOfficer = get_relieving_officer($pdo, $relievingEmail);

        // if($relievingOfficer){
        //     $fromEmail = "noreply@oaucdl.edu.ng";
        //     $subject = "Request to Relieve a Member of Staff";
        //     $message = "Dear ".$relievingOfficer['surname']. " ".$relievingOfficer['othername'].",\n\nA new leave request has been submitted.\nPlease review it.\n\nRegards,\nLeave Management System";
        //     sendNotification($relievingOfficer['email'], $subject, $message, $fromEmail);
        // }

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




