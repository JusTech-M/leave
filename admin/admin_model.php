<?php

function get_leave_request($pdo){
    $stmt = $pdo->prepare("SELECT la.*, u.surname, u.othername, u.role FROM leave_applications la 
    JOIN users u ON la.user_id=u.id 
    WHERE (la.relieving_officer_status='Accepted' AND la.status='Pending Admin Approval') OR (la.relieving_officer_status='Accepted' AND u.role='program_coordinator' AND la.status='Pending Admin Approval')");
    $stmt->execute();
    $apps = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $apps;
}

function update_leave_app($pdo, $note, $id, $action){
    if($action ==="approve"){
        $stmt = $pdo->prepare("UPDATE leave_applications SET status='Pending Director Approval', admin_note=? WHERE id=?");
        $stmt->execute([$note, $id]);
    }else{
        $stmt = $pdo->prepare("UPDATE leave_applications SET status='Rejected', admin_note=? WHERE id=?");
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



