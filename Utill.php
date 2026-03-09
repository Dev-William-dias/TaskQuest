<?php

class Utill {

    public static function logError(string $message): void {
        $logFile = __DIR__ . "/logs/error_log.txt";
        $date = date("Y-m-d H:i:s");

        if (!is_dir(dirname($logFile))) {
            mkdir(dirname($logFile), 0777, true);
        }

        $logEntry = "[{$date}] - {$message}\n";

        file_put_contents($logFile, $logEntry, FILE_APPEND);
    }

    public static function respMessage(int $code, array $data) {
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode($data);
        exit;
    }
}
    
