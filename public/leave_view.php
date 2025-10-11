<?php
require '../config/db.php';
require 'casual_model.php';
function display_form_submit(){
    if(isset($_GET['form']) && $_GET['form'] === 'submitted'){
    echo '<br>';
    echo '<div class="alert alert-success" id="error"> Form Submitted Successfully </div>';
}
}


function goto_dashboard(){
    if(isset($_SESSION["role"])){
        if($_SESSION["role"] === "staff") echo '<a href="../employee/dashboard.php" class="btn primary">Dashboard</a><br>';
        elseif($_SESSION["role"] === "head") echo '<a href="../head/dashboard.php" class="btn primary">Dashboard</a><br>';
        elseif($_SESSION["role"] === "admin") echo '<a href="../admin/dashboard.php" class="btn primary">Dashboard</a><br>';
        elseif($_SESSION["role"] === "director") echo '<a href="../director/dashboard.php" class="btn primary">Dashboard</a><br>';
        elseif($_SESSION["role"] === "program_coordinator") echo '<a href="../program/dashboard.php" class="btn primary">Dashboard</a><br>';
        elseif($_SESSION["role"] === "deputy_director") echo '<a href="../deputy_director/dashboard.php" class="btn primary">Dashboard</a><br>';
    }
}

function applicant_details($pdo, $relievingEmail){
    $applicant_details = get_applicant_details($pdo, $relievingEmail);
    $count = 1;

    foreach($applicant_details as $apps){
        echo '<div>'.$count++.'</div>
                <div>'.$apps["surname"].' '.$apps["othername"].'</div>
                <div>'.$apps["leave_type"].'</div>
                <div>'.$apps["start_date"].'</div>
                <div>'.$apps["end_date"].'</div>
                <div>'.$apps["working_days"].'</div>
                <div><form method="post" action="relieve.inc.php" class="note">
                            <input type="hidden" name="id" value="'.$apps['id'].'">
                            <input type="hidden" name="user_id" value="'.$apps['user_id'].'">
                            <textarea name="note" placeholder="Comment" ></textarea><br>
                            <button name="action" value="accept" class="btn yellow">Accept</button>
                            <button name="action" value="reject" class="btn normal">Reject</button>
                        </form></div>';
    }
}


function display_errors(){
    if(isset($_SESSION['errors'])){
        $errors = $_SESSION['errors'];
        foreach($errors as $error){
            echo '<br>';
            echo '<div class="alert alert-error">'.$error.'</div>';
        }

        unset($_SESSION['errors']);
    }
}


// =============== Leave Status =========================

function leave_status($pdo, $user_id){
    $status = get_leave_status($pdo, $user_id);
    if(!$status ){
        echo '<div class="status">
            <p>You currently have no pending leave application</p>
        </div>';
    }else{
         if($status['relieving_officer_status'] === "Pending"){
        echo '<div class="status">
            <p> Relieving Officer is yet to accept to relieve you</p>
            </div>';
        } 

        if($status['relieving_officer_status'] === "Declined"){
            echo '<div class="status">
            <p>Relieving Officer declined to relieve you</p>
            </div>';
        }

        if($status['relieving_officer_status'] === "Accepted" && $status['status'] === "Pending Head Approval"){
            echo '<div class="status">
            <p>Pending HOD Approval</p>
            </div>';
        }

        if($status['relieving_officer_status'] === "Accepted" && $status['status'] === "Pending Admin Approval"){
            echo '<div class="status">
            <p>Pending Admin Approval</p>
            </div>';
        }

        if($status['relieving_officer_status'] === "Accepted" && $status['status'] === "Pending Director Approval"){
            echo '<div class="status">
            <p>Pending Director Approval</p>
            </div>';
        }

        if($status['relieving_officer_status'] === "Accepted" && $status['status'] === "Approved"){
            echo '<div class="status_approved">
            <p>Approved</p>
            </div>
            <div><form method="post" action="status.inc.php"><button name="clear" value="clear" class="btn red">Clear</button></form></div>
            ';
        }

        if($status['relieving_officer_status'] === "Accepted" && $status['status'] === "Rejected"){
            echo '<div class="status">
            <p>Leave Declined</p>
            </div>
            ';
        }
    }

   
}

function leave_status_declined($pdo, $user_id){

    $status = get_leave_status($pdo, $user_id);
    if(!$status){
        echo '';
    }else{
         if($status['relieving_officer_status'] === "Declined"){
            echo '<div class="heading">Status</div>
            <div class="heading">Reason</div>
            <div class="heading">Clear</div>
            <div>Rejected</div>
            <div>'.$status['relieving_officer_note'].'</div>
            <div><form method="post" action="status.inc.php"><button name="clear" value="clear" class="btn red">Clear</button></form></div>';
        }elseif($status['status'] === "Rejected"){
            echo "<div class='heading'>Status</div>
            <div class='heading'>Reason</div>
            <div class='heading'>Clear</div>
            <div>Rejected</div>
            <div>".comment($status)."</div>
            <div><form method='post' action='status.inc.php'><button name='clear' value='clear' class='btn red'>Clear</button></form></div>";
        }
    }
        
    
   
}

function comment($status){
    if($status['admin_note'] === null && $status['director_note'] === null){
        return '<p style="text-align:center"><b>HOD Comment:</b><br> '.$status["hod_recommendation"].'</p>';
    }elseif($status['director_note'] === null){
        return '<p style="text-align:center"><b>Admin Comment:</b><br>'.$status["admin_note"].'</p>';
    }else{
       return '<p style="text-align:center"><b>Director Comment: </b><br>'.$status["director_note"].'</p>';
    }
}


