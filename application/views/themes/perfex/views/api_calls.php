<?php

// API handler on the API Server

defined('BASEPATH') OR exit('No direct script access allowed');

// Ensure the client is not logged in
if (function_exists('is_client_logged_in') && is_client_logged_in()) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Access denied: client is logged in.']);
    exit;
}

// Get the raw POST data
$input = file_get_contents('php://input');
$payload = json_decode($input, true);

if (!$payload) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON payload']);
    exit;
}

// Validate required fields
if (!isset($payload['start'], $payload['userExtension'], $payload['destination'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
    exit;
}

// Process the data (replace this with your actual database or API logic)
$start = $payload['start'];
$userExtension = $payload['userExtension'];
$destination = $payload['destination'];

// Example: Log the data (replace with actual processing)
file_put_contents('api_calls_log.txt', "Start: $start, User Extension: $userExtension, Destination: $destination\n", FILE_APPEND);

// Send response
http_response_code(200);
echo json_encode(['status' => 'success', 'message' => 'Data processed successfully']);