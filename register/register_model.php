<?php

function set_user($pdo, $surname, $othername, $refNo, $email, $role, $unit_id, $level, $pass, $leaveEntitlement){
    $stmt = $pdo->prepare("INSERT INTO users (surname, othername, ref_no, email, role, unit_id, level, password, leeav_entitlement) VALUES (?,?,?,?,?,?,?,?,?);");
    $options = [
        'cost' => 12
    ];
    $hashedpassword = password_hash($pass, PASSWORD_BCRYPT, $options);
    $stmt->execute([$surname, $othername, $refNo, $email, $role, $unit_id, $level, $hashedpassword, $leaveEntitlement]);

}

function get_units($pdo){
    $units = $pdo->query("SELECT * FROM units")->fetchAll(PDO::FETCH_ASSOC);
    return $units;

}

function get_unitId_by_name($pdo, $unit_name) {
    if (empty($unit_name)) return null;
    $stmt = $pdo->prepare("SELECT id FROM units WHERE unit_name = ?");
    $stmt->execute([$unit_name]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? $row['id'] : null;
}


function get_email(object $pdo, string $email){
    $query = 'SELECT email FROM users WHERE email = ?;';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}