<?php
// Webhook-Empfänger
header("Content-Type: application/json");

// Webhook-Daten empfangen
$webhookData = file_get_contents('php://input');
$data = json_decode($webhookData, true);

// Debugging: Eingehende Daten speichern (optional)
file_put_contents('webhook_log.txt', print_r($data, true), FILE_APPEND);

// Wildix-Daten extrahieren
$callerId = $data['caller_id'] ?? null;
$customerId = $data['customer_id'] ?? null;
$callDate = $data['call_date'] ?? date('Y-m-d H:i:s');
$callStatus = $data['call_status'] ?? 'completed';
$callType = $data['call_type'] ?? 'incoming';

// Fehlerbehandlung bei fehlenden Daten
if (!$callerId || !$customerId) {
    http_response_code(400); // Bad Request
    echo json_encode(["status" => "error", "message" => "Caller ID or Customer ID is missing"]);
    exit;
}

// Anrufdaten an Perfex senden
$response = sendToPerfex($callerId, $customerId, $callDate, $callStatus, $callType);
echo json_encode($response);

/**
 * Funktion: Senden der Anrufdaten an Perfex CRM
 */
function sendToPerfex($callerId, $customerId, $callDate, $callStatus, $callType) {
    $perfexApiUrl = "https://kundenportal.sellx.studio.de/api/tasks"; // API-Endpunkt
    $apiKey = "dein_api_key"; // Deinen API-Key einfügen

    // Anrufdaten vorbereiten
    $postData = [
        "name" => "Anruf von {$callerId}",
        "description" => "Anruftyp: {$callType}\nStatus: {$callStatus}\nDatum: {$callDate}",
        "startdate" => date('Y-m-d', strtotime($callDate)),
        "duedate" => date('Y-m-d', strtotime($callDate)),
        "status" => 1, // Offener Status
        "priority" => 1,
        "rel_id" => $customerId, // Kunden-ID
        "rel_type" => "customer"
    ];

    // CURL-Anfrage an Perfex senden
    $ch = curl_init($perfexApiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer {$apiKey}",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 200) {
        return ["status" => "success", "message" => "Call logged in Perfex CRM successfully."];
    } else {
        return ["status" => "error", "message" => "Failed to log call in Perfex CRM", "details" => $result];
    }
}