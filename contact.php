<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = strip_tags(trim($_POST["message"]));
    $date = date("Y-m-d H:i:s");

    $logEntry = "[$date] Imię: $name | E-mail: $email | Wiadomość: $message" . PHP_EOL;

    // Ścieżka do pliku (upewnij się, że ma prawa zapisu)
    $filePath = __DIR__ . '/messages.txt';

    if (!file_put_contents($filePath, $logEntry, FILE_APPEND | LOCK_EX)) {
        error_log("❌ Błąd zapisu do pliku $filePath");
        http_response_code(500);
        echo "Błąd zapisu";
        exit;
    }

    echo "OK";
} else {
    error_log("⚠️ Próba użycia formularza bez POST");
    http_response_code(403);
    echo "Błąd przesyłania formularza.";
}
