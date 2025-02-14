<?php
// Debugging Webhook Test
header("Content-Type: application/json");

$raw_post_data = file_get_contents("php://input");
$perfexApiUrl = "http://kundenportal.sellx.studio/api/calls";

if (!$raw_post_data) {
    file_put_contents('webhook_debug_log.txt', date("Y-m-d H:i:s") . " - No data received\n", FILE_APPEND);
    http_response_code(400);
    echo json_encode(["error" => "No data received"]);
    exit;
}

// Log the received raw data
file_put_contents('webhook_debug_log.txt', date("Y-m-d H:i:s") . " - Received Data: " . $raw_post_data . "\n", FILE_APPEND); 

echo json_encode(["success" => "Data received", "raw_data" => json_decode($raw_post_data, true)]);
?>
