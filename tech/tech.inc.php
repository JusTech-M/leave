<?php

session_start();
require '../config/db.php';
require '../register/register_model.php';
require '../register/register_contr.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Check file upload
    if (!isset($_FILES['staff_lists']['tmp_name']) || empty($_FILES['staff_lists']['tmp_name'])) {
        $_SESSION['messsage'] = "No file uploaded.";
        header("Location: upload.php");
        die();
    }

    $filename = $_FILES['staff_lists']['name'];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $allowed = ['xls', 'xlsx', 'csv'];

    if (!in_array($ext, $allowed)) {
        $_SESSION['messsage'] = "Invalid file type. Please upload an Excel or CSV file.";
        header("Location: upload.php");
        die();
    }

    // Load spreadsheet
    $filePath = $_FILES['staff_lists']['tmp_name'];
    $spreadsheet = IOFactory::load($filePath);
    $rows = $spreadsheet->getActiveSheet()->toArray();

    // Counters
    $success = 0;
    $failed = 0;
    $skipped = 0;
    $errors = [];

    foreach ($rows as $i => $row) {
        if ($i === 0) continue; // Skip header row

        $surname   = trim($row[0] ?? '');
        $othername = trim($row[1] ?? '');
        $refNo     = trim($row[2] ?? '');
        $email     = trim($row[3] ?? '');
        $role      = strtolower(trim($row[4] ?? 'employee'));
        $unitName  = trim($row[5] ?? '');
        $level     = trim($row[6] ?? '');
        $pass      = $surname; // default password

        // Validate required fields
        if (empty($surname) || empty($email) || empty($role)) {
            $skipped++;
            $errors[] = "Row $i skipped: missing surname/email/role.";
            continue;
        }

        // Get unit_id safely
        $unit_id = get_unitId_by_name($pdo, $unitName);
        if (in_array($role, ['director', 'admin', 'program_coordinator', 'deputy_director'])) {
            $unit_id = null;
        }

        // Validate foreign key
        if ($unit_id === null && !in_array($role, ['director','admin','program_coordinator','deputy_director'])) {
            $failed++;
            $errors[] = "Row $i failed: unit '{$unitName}' not found.";
            continue;
        }

        // Determine leave entitlement
        if ($level === 'snr') {
            $leaveEntitlement = 42;
        } elseif ($level === 'jnr_5&6') {
            $leaveEntitlement = 30;
        } else {
            $leaveEntitlement = 26;
        }

        try {
            set_user($pdo, $surname, $othername, $refNo, $email, $role, $unit_id, $level, $pass, $leaveEntitlement);
            header("Location: upload.php?upload=success");
            $success++;
        } catch (Exception $e) {

            header("Location: upload.php");
            $failed++;
            $errors[] = "Row $i failed: " . $e->getMessage();
        }
    }

    // Upload summary

    $_SESSION['success'] = $success;
    $_SESSION['failed'] = $failed;
    $_SESSION['Skipped'] = $skipped;


    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: upload.php");
    }

} else {
    header("Location: upload.php");
    die();
}

