<?php
require_once __DIR__ . '/../helpers/supabase.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$date = $_GET['date'] ?? '';

if (!$date) {
    http_response_code(400);
    echo json_encode(['error' => 'Date is required']);
    exit;
}

$result = supabase_get(
    'time_slots_status',
    '?slot_date=eq.' . urlencode($date) . '&order=start_time.asc'
);

if ($result['status'] !== 200) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch slots']);
    exit;
}

$slots = $result['body'] ?? [];

$formatted = array_map(function ($slot) {
    $start = date('g:i A', strtotime($slot['start_time']));
    $end   = date('g:i A', strtotime($slot['end_time']));
    return [
        'id'          => $slot['id'],
        'doctor_id'   => $slot['doctor_id'],
        'doctor_name' => $slot['doctor_name'],
        'start_time'  => $slot['start_time'],
        'end_time'    => $slot['end_time'],
        'label'       => $start . ' – ' . $end,
        'status'      => $slot['status'],    // available | limited | booked
        'remaining'   => $slot['remaining'],
    ];
}, $slots);

echo json_encode(['slots' => $formatted]);