<?php

function get_leave_app_details($pdo, $id){
    $stmt = $pdo->prepare("SELECT * FROM leave_applications
    WHERE id=? ");
    $stmt->execute([$id]);
    $apps = $stmt->fetch(PDO::FETCH_ASSOC);
    return $apps;
}

function get_recallPublicHoliday($pdo, $id){
    $stmt = $pdo->prepare("SELECT * FROM recall_publicholidays
    WHERE id=? ");
    $stmt->execute([$id]);
    $apps = $stmt->fetch(PDO::FETCH_ASSOC);
    return $apps;
}

function get_app($pdo, $user_id){
    $query = "SELECT leeav_entitlement, num_casual_leave, num_used_leave FROM users WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id]);
    $app = $stmt->fetch(PDO::FETCH_ASSOC);
    return $app;
}


function get_allUser_level($pdo){
    $query = "SELECT level FROM users";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $users;
}

function get_users_leave_approved($pdo, $user_id){
    $stmt = $pdo->prepare("SELECT id, user_id FROM leave_applications
    WHERE status = 'Approved' AND user_id=?");
    $stmt->execute([$user_id]);
    $users_id = $stmt->fetch(PDO::FETCH_ASSOC);
    return $users_id;
}

// ======================================= Extend the based on the number of days worked =========================================================================
            function addWorkingDays($date, $days) {
                $current = new DateTime($date);
                while ($days > 0) {
                    $current->modify('+1 day');
                    $dow = $current->format('N');
                    if ($dow < 6) $days--;
                }
                return $current;
            }


