<?php
function sendNotification($toEmail, $subject, $message, $fromEmail = "noreply@organisation.com", $attachmentPath = null) {
    // Detect if we are in local development
    $isLocal = in_array($_SERVER['SERVER_NAME'], ['localhost', '127.0.0.1']);

    //  Localhost mode: log email content to file
    if ($isLocal) {
        $logDir = __DIR__ . '/../config';
        if (!file_exists($logDir)) mkdir($logDir, 0777, true);
        $logFile = $logDir . "/email_log.txt";

        $logMessage = "To: $toEmail\nSubject: $subject\nMessage:\n$message\n";
        if ($attachmentPath && file_exists($attachmentPath)) {
            $logMessage .= "Attachment: $attachmentPath\n";
        }
        $logMessage .= "---\n";
        file_put_contents($logFile, $logMessage, FILE_APPEND);
        return true;
    }

    //  Production mode: send via PHP mail() with MIME headers
    $boundary = md5(time());
    $headers  = "From: $fromEmail\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"{$boundary}\"\r\n";

    // Message body
    $body  = "--{$boundary}\r\n";
    $body .= "Content-Type: text/plain; charset=\"utf-8\"\r\n";
    $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $body .= $message . "\r\n";

    // If attachment exists, add it
    if ($attachmentPath && file_exists($attachmentPath)) {
        $fileContent = chunk_split(base64_encode(file_get_contents($attachmentPath)));
        $filename = basename($attachmentPath);
        $body .= "--{$boundary}\r\n";
        $body .= "Content-Type: application/octet-stream; name=\"{$filename}\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n";
        $body .= "Content-Disposition: attachment; filename=\"{$filename}\"\r\n\r\n";
        $body .= $fileContent . "\r\n";
    }

    $body .= "--{$boundary}--";

    // Try sending
    return @mail($toEmail, $subject, $body, $headers);
}


