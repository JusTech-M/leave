<?php

function get_user($pdo, $username){
    $stmt =$pdo->prepare("SELECT * FROM tech_users WHERE username=? LIMIT 1;");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;
}


function deleteUser($pdo, $appID){
    $query = "DELETE FROM users WHERE ref_no=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$appID]);
}

function userRefNum($pdo, $appID, $email, $unitId){
    $query = "SELECT * FROM users WHERE ref_no=? OR email=? OR unit_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$appID, $email, $unitId]);
    $stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $stmt;
}

function add_user($pdo, $username, $email, $password){
    $query = "INSERT INTO tech_users (username, email, password) VALUES (?,?,?)";
    $stmt = $pdo->prepare($query);
     $options = [
        'cost' => 12
    ];
    $hashedpassword = password_hash($password, PASSWORD_BCRYPT, $options);
    $stmt->execute([$username, $email, $hashedpassword]);
}