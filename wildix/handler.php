<?php
// Webhook-Handler für Wildix -> Perfex API mit Debugging

// Hole die Rohdaten des Webhooks
$raw_post_data = file_get_contents("php://input");

// Debugging: Speichert den Original-Request in einer Log-Datei
file_put_contents("wildix_raw_log.txt", date("Y-m-d H:i:s") . " - Empfangene Daten: " . $raw_post_data . "\n", FILE_APPEND);

// Falls keine Daten empfangen wurden, abbrechen
if (!$raw_post_data) {
    http_response_code(400);
    echo json_encode(["error" => "Keine Daten empfangen"]);
    exit;
}

// Sicherstellen, dass die Antwort nicht leer ist
if (!$response) {
    http_response_code(500);
    echo json_encode(["error" => "Keine Antwort von Perfex API"]);
    exit;
}

// Antwort von Perfex API loggen
$log_entry = date("Y-m-d H:i:s") . " - HTTP Code: $http_code - Perfex API Antwort: " . print_r($response, true) . "\n";
file_put_contents("webhook_log.txt", $log_entry, FILE_APPEND);

// Antwort an Wildix zurückgeben
http_response_code($http_code);
header("Content-Type: application/json"); // Stellt sicher, dass die Antwort JSON ist
echo json_encode(["success" => "Webhook verarbeitet", "perfex_response" => json_decode($response, true)]);
exit;

// JSON in ein Array dekodieren
$data = json_decode($raw_post_data, true);

// Debugging: Falls das JSON nicht korrekt ist
if (json_last_error() !== JSON_ERROR_NONE) {
    file_put_contents("wildix_raw_log.txt", date("Y-m-d H:i:s") . " - Fehlerhafte JSON-Daten: " . json_last_error_msg() . "\n", FILE_APPEND);
    http_response_code(400);
    echo json_encode(["error" => "Ungültiges JSON"]);
    exit;
}

// Falls Daten vorhanden sind, loggen
file_put_contents("wildix_raw_log.txt", date("Y-m-d H:i:s") . " - JSON-Parsing erfolgreich: " . print_r($data, true) . "\n", FILE_APPEND);
?>
