<?php
// app/api/get_notifications.php
session_start();
require_once __DIR__ . '/../../helpers/supabase.php';

header('Content-Type: application/json');

// Check if patient is logged in
if (!isset($_SESSION['patient_id'])) {
    echo json_encode(['notifications' => [], 'count' => 0]);
    exit;
}

$patient_id = $_SESSION['patient_id'];

// Fetch upcoming/pending/confirmed appointments with time slot info
// Using select with join via Supabase PostgREST syntax
$filter = '?select=' . urlencode(
    'id,appointment_no,status,notes,' .
    'time_slots(slot_date,start_time,end_time),' .
    'services(name)'
) . '&patient_id=eq.' . urlencode($patient_id) .
  '&status=in.(pending,confirmed)' .
  '&order=time_slots(slot_date).asc';

$result = supabase_get('appointments', $filter);

if ($result['status'] !== 200 || !is_array($result['body'])) {
    echo json_encode(['notifications' => [], 'count' => 0]);
    exit;
}

$notifications = [];

foreach ($result['body'] as $appt) {
    $slot      = $appt['time_slots'] ?? null;
    $service   = $appt['services']['name'] ?? 'Appointment';
    $status    = ucfirst($appt['status']);
    $appt_no   = $appt['appointment_no'] ?? '';

    if (!$slot) continue;

    // Format: "Monday, June 15, 2025"
    $date_formatted = date('l, F j, Y', strtotime($slot['slot_date']));
    // Format: "9:00 AM"
    $time_formatted = date('g:i A', strtotime($slot['start_time']));

    // Only show upcoming appointments (today or future)
    if (strtotime($slot['slot_date']) < strtotime('today')) continue;

    $notifications[] = [
        'id'          => $appt['id'],
        'appointment_no' => $appt_no,
        'service'     => $service,
        'status'      => $status,
        'date'        => $date_formatted,
        'time'        => $time_formatted,
        'raw_date'    => $slot['slot_date'],
        'message'     => "Your {$service} appointment is booked on {$date_formatted} at {$time_formatted}.",
        'status_label'=> $status,
    ];
}

echo json_encode([
    'notifications' => $notifications,
    'count'         => count($notifications),
]);