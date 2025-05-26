<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"] ?? ''));
    $email = filter_var(trim($_POST["email"] ?? ''), FILTER_SANITIZE_EMAIL);
    $message = strip_tags(trim($_POST["message"] ?? ''));
    $date = date("Y-m-d H:i:s");

    if (empty($name) || empty($email) || empty($message)) {
        http_response_code(400);
        echo "Brak wymaganych pól.";
        exit;
    }

    $logEntry = "[$date]\nImię: $name\nE-mail: $email\nWiadomość: $message\n\n";
    $filePath = __DIR__ . '/messages.txt';

    if (file_put_contents($filePath, $logEntry, FILE_APPEND | LOCK_EX) === false) {
        http_response_code(500);
        echo "Błąd zapisu do pliku.";
        exit;
    }

    echo "OK";
} else {
    http_response_code(403);
    echo "Błąd przesyłania formularza.";
}
