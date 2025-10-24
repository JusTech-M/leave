<?php

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