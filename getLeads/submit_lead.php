<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiToken = $_ENV['API_TOKEN'];

// Funktion zum Schreiben in die Logdatei
function logToFile($message) {
    $logFile = __DIR__ . "/logs/errors.log";
    $date = date("Y-m-d H:i:s");
    file_put_contents($logFile, "[$date] $message" . PHP_EOL, FILE_APPEND);
}

// JSON-Daten aus dem Request lesen
$rawData = file_get_contents("php://input");
$decodedData = json_decode($rawData, true);

if (!$decodedData) {
    logToFile("Keine gültigen Formulardaten empfangen.");
    http_response_code(400);
    die("Fehler: Ungültige Daten.");
}

// Formulardaten zuweisen
$name = isset($decodedData['name']) ? trim($decodedData['name']) : 'Unbekannter Lead';
$company = isset($decodedData['company']) ? trim($decodedData['company']) : 'Keine Firma';
$email = isset($decodedData['email']) ? trim($decodedData['email']) : 'Keine E-Mail';
$phonenumber = isset($decodedData['phone']) ? trim($decodedData['phone']) : 'Keine Nummer';
$description = isset($decodedData['description']) ? trim($decodedData['description']) : 'Keine Beschreibung';

// Pflichtfelder sicherstellen (alle als Strings übergeben)
$leadData = [
    'name' => $name,
    'company' => $company,
    'email' => $email,
    'phonenumber' => $phonenumber,
    'source' => '5',
    'status' => '2',
    'assigned' => '7',
    'description' => $description
];

// Debugging: Die JSON-Payload zur Kontrolle ausgeben
logToFile("Payload: " . json_encode($leadData, JSON_PRETTY_PRINT));

// Umwandlung in `application/x-www-form-urlencoded`-Format
$postFields = http_build_query($leadData);

// cURL-Request vorbereiten
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://kundenportal.sellx.studio/api/leads");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "authtoken: $apiToken",
    "Content-Type: application/x-www-form-urlencoded"
]);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, authtoken");

$response = curl_exec($ch);
if (curl_errno($ch)) {
    logToFile("Fehler bei der Verbindung: " . curl_error($ch));
    http_response_code(500);
} else {
    $result = json_decode($response, true);
    if (isset($result['status']) && $result['status'] === true) {
        logToFile("Lead erfolgreich erstellt: " . json_encode($result));
        echo "Lead erfolgreich erstellt.";
    } else {
        $errorDetails = isset($result['message']) ? $result['message'] : 'Unbekannter Fehler';
        logToFile("Fehler bei der Lead-Erstellung: $errorDetails");
        echo "Fehler bei der Lead-Erstellung: $errorDetails";
        http_response_code(500);
    }
}
curl_close($ch);
