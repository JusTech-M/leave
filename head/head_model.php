<?php

function get_leave_request($pdo, $unit_id){
    $stmt = $pdo->prepare("SELECT la.*, u.surname, u.othername FROM leave_applications la 
    JOIN users u ON la.user_id=u.id 
    WHERE u.unit_id=? AND la.status='Pending Head Approval' AND la.relieving_officer_status='Accepted'");
    $stmt->execute([$unit_id]);
    $apps = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return  $apps;
}

function update_leave_app($pdo, $note, $id, $unit_id, $action){
    if($action ==="approve"){
        $stmt = $pdo->prepare("UPDATE leave_applications SET status='Pending Admin Approval', hod_recommendation=?, unit_id =? WHERE id=?");
        $stmt->execute([$note, $unit_id, $id]);
    }elseif($action ==="reject"){
        $stmt = $pdo->prepare("UPDATE leave_applications SET status='Rejected', hod_recommendation=? WHERE id=?");
        $stmt->execute([$note, $id]);
    }elseif($action ==="approve_recallRequest"){
        $stmt = $pdo->prepare("UPDATE recall_publicholidays SET status='Pending Admin Approval', hod_recommendation=? WHERE id=?");
        $stmt->execute([$note, $id]);
    }else{
        $stmt = $pdo->prepare("UPDATE recall_publicholidays SET status='Rejected', hod_recommendation=? WHERE id=?");
        $stmt->execute([$note, $id]);
    }
    
    
}

function get_admin_email($pdo){
    $query = "SELECT email, surname, othername FROM users WHERE role = 'admin'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $adminEmail = $stmt->fetch(PDO::FETCH_ASSOC);
    return $adminEmail;
}


// ================= recall/public holidays =============================
function get_recall_request($pdo, $unit_id){
    $stmt = $pdo->prepare("SELECT * FROM recall_publicholidays WHERE unit_id = ? AND status='Pending HOD Approval' ;");
    $stmt->execute([$unit_id]);
    $apps = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return  $apps;
}

// function update_recall_request($pdo, $note, $id, $unit_id, $action, $tabl){
//     if($action ==="approve"){
//         $stmt = $pdo->prepare("UPDATE recall_publicholidays SET status='Pending Admin Approval', hod_recommendation=?, unit_id =? WHERE id=?");
//         $stmt->execute([$note, $unit_id, $id]);
//     }else{
//         $stmt = $pdo->prepare("UPDATE leave_applications SET status='Rejected', hod_recommendation=? WHERE id=?");
//         $stmt->execute([$note, $id]);
//     }
    
// }



