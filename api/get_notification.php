<?php
require_once __DIR__ . '/../helpers/supabase.php';
header('Content-Type: application/json');

$token = $_GET['token'] ?? $_SERVER['HTTP_AUTHORIZATION'] ?? '';
$token = str_replace('Bearer ', '', $token);

if (!$token) {
    echo json_encode(['notifications' => [], 'count' => 0]);
    exit;
}

$opts = [
    'http' => [
        'method' => 'GET',
        'header' => implode("\r\n", [
            'apikey: ' . SUPABASE_KEY,
            'Authorization: Bearer ' . $token,
        ]),
        'ignore_errors' => true,
    ]
];
$context  = stream_context_create($opts);
$userBody = json_decode(file_get_contents(SUPABASE_URL . '/auth/v1/user', false, $context), true);
$userStatus = 0;
foreach ($http_response_header as $h) {
    if (preg_match('/HTTP\/\d\.\d (\d+)/', $h, $m)) $userStatus = (int) $m[1];
}

if ($userStatus !== 200 || empty($userBody['id'])) {
    echo json_encode(['notifications' => [], 'count' => 0]);
    exit;
}

$patient_id = $userBody['id'];

$filter = '?select=' . urlencode(
    'id,appointment_no,status,notes,' .
    'time_slots(slot_date,start_time,end_time),' .
    'services(name)'
) . '&patient_id=eq.' . urlencode($patient_id) .
  '&status=in.(pending,confirmed)' .
  '&order=created_at.desc';

$result = supabase_get('appointments', $filter);

if ($result['status'] !== 200 || !is_array($result['body'])) {
    echo json_encode(['notifications' => [], 'count' => 0]);
    exit;
}

$notifications = [];
foreach ($result['body'] as $appt) {
    $slot    = $appt['time_slots'] ?? null;
    $service = $appt['services']['name'] ?? 'Appointment';
    $status  = ucfirst($appt['status']);
    $appt_no = $appt['appointment_no'] ?? '';

    if (!$slot) continue;
    if (strtotime($slot['slot_date']) < strtotime('today')) continue;

    $date_formatted = date('l, F j, Y', strtotime($slot['slot_date']));
    $time_formatted = date('g:i A', strtotime($slot['start_time']));

    $notifications[] = [
        'id'             => $appt['id'],
        'appointment_no' => $appt_no,
        'service'        => $service,
        'status'         => strtolower($appt['status']),
        'date'           => $date_formatted,
        'time'           => $time_formatted,
        'raw_date'       => $slot['slot_date'],
        'message'        => "Your {$service} appointment is booked on {$date_formatted} at {$time_formatted}.",
        'status_label'   => $status,
    ];
}

echo json_encode([
    'notifications' => $notifications,
    'count'         => count($notifications),
]);