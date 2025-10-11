<?php

function get_leave_request($pdo){
    $stmt = $pdo->prepare("SELECT la.*, u.surname, u.othername FROM leave_applications la 
    JOIN users u ON la.user_id=u.id 
    WHERE la.status='Pending Director Approval'");
    $stmt->execute();
    $apps = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $apps;
}

function update_leave_app($pdo, $note, $id, $action){
    if($action ==="approve"){
        $stmt = $pdo->prepare("UPDATE leave_applications SET status='Approved', director_note=? WHERE id=?");
        $stmt->execute([$note, $id]);
    }else{
        $stmt = $pdo->prepare("UPDATE leave_applications SET status='Rejected', director_note=? WHERE id=?");
        $stmt->execute([$note, $id]);
    }
    
}

function get_director_email($pdo){
    $query = "SELECT email, surname, othername FROM users WHERE role = 'director'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $directorEmail = $stmt->fetch(PDO::FETCH_ASSOC);
    return $directorEmail;
}

function get_admin_email($pdo){
    $query = "SELECT email, surname, othername FROM users WHERE role = 'admin'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $adminEmail = $stmt->fetch(PDO::FETCH_ASSOC);
    return $adminEmail;
}

function get_applicant_leave_details($pdo, $id){
    $stmt = $pdo->prepare("SELECT la.*, u.surname, u.othername FROM leave_applications la 
    JOIN users u ON la.user_id=u.id 
    WHERE id=?");
    $stmt->execute([$id]);
    $apps = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $apps;
}

function update_casual_used($pdo, $leave_entitled, $casual_used, $totalUsedLeave, $id){
    $query = "UPDATE users SET leeav_entitlement=?, num_casual_leave = ?, num_used_leave=? WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$leave_entitled, $casual_used, $totalUsedLeave, $id]);
}


// ============================= Clear Leave =============================


function clear_leave($pdo, $usedCasual, $totalLeaveUsed){
    $query = "UPDATE users SET leeav_entitlement = CASE level 
    WHEN 'snr' THEN 42
    WHEN 'jnr_5&6' THEN 30
    WHEN 'jnr_1-4' THEN 26
    ELSE leeav_entitlement
    END, num_casual_leave = ?, num_used_leave = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$usedCasual, $totalLeaveUsed]);
}








