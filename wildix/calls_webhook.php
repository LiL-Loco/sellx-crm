<?php

// Verbindung zur Datenbank herstellen
function get_db_connection() {
    $host = "localhost";
    $user = "your_db_user";
    $password = "your_db_password";
    $database = "your_perfex_db";

    $connection = new mysqli($host, $user, $password, $database);

    if ($connection->connect_error) {
        die("Verbindung zur Datenbank fehlgeschlagen: " . $connection->connect_error);
    }

    return $connection;
}

// Verifizieren der Anfrage mit dem Secret
function verify_secret($received_signature, $payload, $secret) {
    $calculated_signature = hash_hmac('sha256', $payload, $secret);
    return hash_equals($calculated_signature, $received_signature);
}

// JSON-Daten empfangen
$payload = file_get_contents('php://input');
$data = json_decode($payload, true);

// Secret aus der Wildix-Konfiguration
$secret = "Ll7I428VJiLQ2CRj9xooOZ0Hl1deyK"; // Secret-Key von Wildix
$received_signature = $_SERVER['HTTP_X_WILDIX_SIGNATURE'] ?? '';

// Anfrage verifizieren
if (!verify_secret($received_signature, $payload, $secret)) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Ungültige Signatur."]);
    exit;
}

// Verarbeiten der Webhook-Daten
if ($data) {
    $connection = get_db_connection();

    // Relevante Felder extrahieren
    $caller_name = $data['data']['flows'][0]['caller']['name'] ?? 'Unbekannt';
    $caller_phone = $data['data']['flows'][0]['caller']['phone'] ?? '';
    $start_time = date('Y-m-d H:i:s', strtotime($data['data']['start'] ?? 'now'));
    $stop_time = date('Y-m-d H:i:s'); // Ende des Anrufs (kann angepasst werden)
    $direction = $data['data']['flows'][0]['direction'] ?? 'unknown';
    $duration = 0; // Berechnung der Dauer optional (falls `stop_time` vorhanden ist)

    $staffid = $data['data']['flows'][0]['destination'] ?? null;
    $clientid = $data['data']['company'] ?? null;
    $contactid = $data['data']['id'] ?? null;

    // Berechnung der Dauer
    if (!empty($start_time) && !empty($stop_time)) {
        $duration = strtotime($stop_time) - strtotime($start_time);
    }

    // Anruf in die Datenbank einfügen
    $query = "INSERT INTO tblcall_logs (
        userphone, call_summary, call_start_time, call_end_time, call_duration, call_direction, staffid, clientid, contactid, customer_type, dateadded, dateaupdated
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'customer', NOW(), NOW())";

    $stmt = $connection->prepare($query);
    $stmt->bind_param(
        'ssssiiiii',
        $caller_phone,
        $caller_name,
        $start_time,
        $stop_time,
        $duration,
        $direction,
        $staffid,
        $clientid,
        $contactid
    );

    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode(["status" => "success", "message" => "Anrufdaten erfolgreich gespeichert."]);
    } else {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Datenbankfehler: " . $stmt->error]);
    }

    $stmt->close();
    $connection->close();
} else {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Ungültige Anfragedaten."]);
}

?>