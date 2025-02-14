<?php

// Webhook handler on the Webhook Server

// Get the raw POST data
$input = file_get_contents('php://input');
$payload = json_decode($input, true);

if (!$payload) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON payload']);
    exit;
}

// Extract and map payload data
$mappedData = [
    'id' => $payload['id'] ?? null,
    'pbx' => $payload['pbx'] ?? null,
    'company' => $payload['company'] ?? null,
    'time' => $payload['time'] ?? null,
    'type' => $payload['type'] ?? null,
    'integrationId' => $payload['integrationId'] ?? null,
    'data' => [
        'id' => $payload['data']['id'] ?? null,
        'pbx' => $payload['data']['pbx'] ?? null,
        'time' => $payload['data']['time'] ?? null,
        'company' => $payload['data']['company'] ?? null,
        'licenses' => $payload['data']['licenses'] ?? [],
        'event' => $payload['data']['event'] ?? null,
        'eventTrigger' => $payload['data']['eventTrigger'] ?? null,
        'start' => $payload['data']['start'] ?? null,
        'flows' => array_map(function ($flow) {
            $caller = $flow['caller'] ?? [];
            return array_merge([
                'caller_phone' => $caller['phone'] ?? null,
                'caller_email' => $caller['email'] ?? null,
                'caller_userId' => $caller['userId'] ?? null,
                'caller_extension' => $caller['userExtension'] ?? null,
                'caller_department' => $caller['userDepartment'] ?? null,
                'caller_groupId' => $caller['groupId'] ?? null,
                'caller_groupName' => $caller['groupName'] ?? null,
                'caller_userAgent' => $caller['userAgent'] ?? null,
                'caller_device' => $caller['userDevice'] ?? null,
                'caller_role' => $caller['role'] ?? null,
                'caller_license' => $caller['license'] ?? null
            ], [
                'flowIndex' => $flow['flowIndex'] ?? null,
                'duration' => $flow['duration'] ?? 0,
                'connectTime' => $flow['connectTime'] ?? 0,
                'talkTime' => $flow['talkTime'] ?? 0,
                'waitTime' => $flow['waitTime'] ?? 0,
                'holdTime' => $flow['holdTime'] ?? 0,
                'queueTime' => $flow['queueTime'] ?? 0,
                'destination' => $flow['destination'] ?? null,
                'direction' => $flow['direction'] ?? null,
                'remotePhone' => $flow['remotePhone'] ?? null,
                'status' => $flow['status'] ?? null,
            ]);
        }, $payload['data']['flows'] ?? [])
    ]
];

// Log extracted and mapped data for debugging
file_put_contents('mapped_data.json', date("Y-m-d H:i:s") . " - Received Data: " . json_encode($mappedData, JSON_PRETTY_PRINT));

// Add API token
$apiToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoiIiwibmFtZSI6IiIsIkFQSV9USU1FIjoxNzM0MDYzNjgxfQ.48Z1SGBQVYzYTmozakSv8lpW6mdpNs8b-tyX10Qkak0'; // Replace with your actual API token

// API URL
$apiUrl = 'https://kundenportal.sellx.studio/api/calls';

// Send the mapped JSON data to the API
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'authtoken: ' . $apiToken
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($mappedData));

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

// Log API response for debugging
file_put_contents('api_response.log', "HTTP Code: $httpCode\nResponse: $response\nError: $error\n", FILE_APPEND);

if ($httpCode >= 200 && $httpCode < 300) {
    http_response_code(200);
    echo json_encode(['status' => 'success', 'message' => 'Data forwarded successfully']);
} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to forward data']);
}