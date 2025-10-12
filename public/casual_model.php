<?php
//require '../config/db.php';

// ==================== leave form =========================================
function submit_leave_form_casual($pdo, 
$user_id, 
$leaveType,
$startDate, $endDate, 
$TotalWorkingDays, 
$leavePurpose, 
$relievingName, 
$relievingEmail, 
$applicantName, 
$designation, 
$department,
$role
){
    $query = "INSERT INTO leave_applications (user_id, leave_type, start_date, end_date, working_days, reason, relieving_officer, relieving_officer_email, applicant_name, designation, department, role) VALUES(?,?,?,?,?,?,?,?,?,?,?,?);";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id, 
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
    $role 
   ]);
}

function submit_leave_form_annual($pdo, 
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
$role
){
$query = "INSERT INTO leave_applications (user_id, leave_type, start_date, end_date, working_days, relieving_officer, relieving_officer_email, applicant_name, designation, department, is_onLeaveStart, is_onLeaveEnd, is_onLeaveStartApproved, is_onLeaveEndApproved, defferedLleave, role) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
$stmt = $pdo->prepare($query);
$stmt->execute([
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
$role
]);
}




function get_applicant($pdo, $user_id){
    $stmt = $pdo->prepare("SELECT * FROM leave_applications WHERE user_id=?");
    $stmt->execute([$user_id]);
    $apps = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $apps;
}

function get_public_holidays($pdo){
    $stmt = $pdo->prepare("SELECT holiday_date FROM public_holidays");
    $stmt->execute();
    $holidays = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $holidays;
}




// ====================== relieve section ====================================
function get_applicant_details($pdo, $relievingEmail){
    $stmt = $pdo->prepare("SELECT la.*, u.surname, u.othername FROM leave_applications la 
    JOIN users u ON la.user_id=u.id 
    WHERE la.relieving_officer_email=? AND la.relieving_officer_status='Pending'");
    $stmt->execute([$relievingEmail]);
    $apps = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $apps;
}

function relieve_action($pdo, $note, $id, $action){
    if ($action === 'accept') {
        $stmt = $pdo->prepare("UPDATE leave_applications SET relieving_officer_status='accepted', relieving_officer_note=? WHERE id=?");
        $stmt->execute([$note, $id]);
            
    } else {
        $stmt  = $pdo->prepare("UPDATE leave_applications SET relieving_officer_status='declined', relieving_officer_note=? WHERE id=?");
        $stmt->execute([$note, $id]);
    }
}

function get_relieve_email($pdo, $relievingEmail){
    $relieveEmail = $pdo->prepare("SELECT email FROM users WHERE email=?");
    $relieveEmail->execute([$relievingEmail]);
    $result = $relieveEmail->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_relieve_unit_id($pdo, $relievingEmail){
    $relieveUnitId = $pdo->prepare("SELECT unit_id FROM users WHERE email=?");
    $relieveUnitId ->execute([$relievingEmail]);
    $unitId =$relieveUnitId ->fetch(PDO::FETCH_ASSOC);
    return $unitId;
}

function get_relieving_officer($pdo, $relievingEmail){
    $relievingOfficer = $pdo->prepare("SELECT email, surname, othername FROM users WHERE email=?");
    $relievingOfficer ->execute([$relievingEmail]);
    $officer =$relievingOfficer ->fetch(PDO::FETCH_ASSOC);
    return $officer;
}

function get_hod_email($pdo, $unit_id){
    $query = "SELECT email, surname, othername FROM users WHERE unit_id = ? AND role = 'head'";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$unit_id]);
    $hodEmail = $stmt->fetch(PDO::FETCH_ASSOC);
    return $hodEmail;

}

function get_applicant_email($pdo, $appId){
    $query = "SELECT * FROM users WHERE id = ? ";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$appId]);
    $appEmail = $stmt->fetch(PDO::FETCH_ASSOC);
    return $appEmail;

}


// ====================== Track leave status ====================================

function get_leave_status($pdo, $user_id){
    $query = "SELECT * FROM leave_applications WHERE user_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id]);
    $status = $stmt->fetch(PDO::FETCH_ASSOC);
    return $status;
}

function clearLeave($pdo, $user_id){
    $query = "DELETE FROM leave_applications WHERE user_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id]);
}

function updateStatus_ifProg($pdo){
    $query = "UPDATE leave_applications SET status = 'Pending Admin Approval' WHERE role = 'program_coordinator'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
}
//var_dump(get_applicant_details($pdo, "damilareoni2@gmail.com"));

