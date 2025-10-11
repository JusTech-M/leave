<?php
function sendNotification($toEmail, $subject, $message, $fromEmail="noreply@organisation.com") {
     
    // Detect if we are in local development (XAMPP/WAMP)
    $isLocal = in_array($_SERVER['SERVER_NAME'], ['localhost', '127.0.0.1']);

    if ($isLocal) {
        // Log emails instead of sending
        $logFile = __DIR__ . '/email_log.txt';
        $logMessage = "To: $toEmail\nSubject: $subject\nMessage:\n$message\n---\n";
        file_put_contents($logFile, $logMessage, FILE_APPEND);
    } else {
        // Attempt to send via PHP mail() in production
        $headers = "From: " . $fromEmail;
        @mail($toEmail, $subject, $message, $headers);
    }
}
?>
