<?php

function get_leave_app_details($pdo, $id){
    $stmt = $pdo->prepare("SELECT * FROM leave_applications
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


