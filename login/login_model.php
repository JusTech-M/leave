<?php

function get_user($pdo, $email){
    $stmt =$pdo->prepare("SELECT * FROM users WHERE email=? LIMIT 1;");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;
}


function reset_password($pdo, $pass, $email){
    $query = "UPDATE users SET password = ? WHERE email = ?";
    $stmt = $pdo->prepare($query);

     $options = [
        'cost' => 12
    ];
    $hashedpassword = password_hash($pass, PASSWORD_BCRYPT, $options);
    $stmt->execute([$hashedpassword, $email]);

}