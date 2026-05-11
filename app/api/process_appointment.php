<?php
require_once __DIR__ . '/../helpers/supabase.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

$serviceId  = $input['service_id']   ?? '';
$slotId     = $input['time_slot_id'] ?? '';
$authToken  = $input['auth_token']   ?? '';

if (!$serviceId || !$slotId || !$authToken) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

$ch = curl_init(SUPABASE_URL . '/auth/v1/user');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER     => [
        'apikey: '               . SUPABASE_KEY,
        'Authorization: Bearer ' . $authToken,
    ],
]);
$userBody   = json_decode(curl_exec($ch), true);
$userStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($userStatus !== 200 || empty($userBody['id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized. Please log in.']);
    exit;
}

$patientId = $userBody['id'];

$slotResult = supabase_get(
    'time_slots',
    '?id=eq.' . urlencode($slotId) . '&is_available=eq.true'
);

if ($slotResult['status'] !== 200 || empty($slotResult['body'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Time slot is not available']);
    exit;
}

$slot = $slotResult['body'][0];

if ($slot['booked_count'] >= $slot['max_patients']) {
    http_response_code(400);
    echo json_encode(['error' => 'This time slot is fully booked']);
    exit;
}

$doctorId = $slot['doctor_id'];

$dupResult = supabase_get(
    'appointments',
    '?patient_id=eq.' . urlencode($patientId)
    . '&time_slot_id=eq.' . urlencode($slotId)
    . '&status=neq.cancelled'
);

if (!empty($dupResult['body'])) {
    http_response_code(400);
    echo json_encode(['error' => 'You already have an appointment in this time slot']);
    exit;
}

$serviceResult = supabase_get('services', '?id=eq.' . urlencode($serviceId));

if ($serviceResult['status'] !== 200 || empty($serviceResult['body'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Service not found']);
    exit;
}

$price = $serviceResult['body'][0]['price'];

$ch = curl_init(SUPABASE_URL . '/rest/v1/appointments');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => json_encode([
        'patient_id'   => $patientId,
        'doctor_id'    => $doctorId,
        'service_id'   => $serviceId,
        'time_slot_id' => $slotId,
        'status'       => 'pending',
    ]),
    CURLOPT_HTTPHEADER     => [
        'apikey: '               . SUPABASE_KEY,
        'Authorization: Bearer ' . SUPABASE_KEY,
        'Content-Type: application/json',
        'Prefer: return=representation',
    ],
]);
$apptBody   = json_decode(curl_exec($ch), true);
$apptStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($apptStatus !== 201 || empty($apptBody)) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to create appointment']);
    exit;
}

$appointment   = $apptBody[0];
$appointmentId = $appointment['id'];
$appointmentNo = $appointment['appointment_no'];

$ch = curl_init(SUPABASE_URL . '/rest/v1/payments');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => json_encode([
        'appointment_id' => $appointmentId,
        'amount'         => $price,
        'status'         => 'paid',
    ]),
    CURLOPT_HTTPHEADER     => [
        'apikey: '               . SUPABASE_KEY,
        'Authorization: Bearer ' . SUPABASE_KEY,
        'Content-Type: application/json',
        'Prefer: return=representation',
    ],
]);
$payBody   = json_decode(curl_exec($ch), true);
$payStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($payStatus !== 201 || empty($payBody)) {
    // Rollback: cancel the appointment
    supabase_patch(
        'appointments',
        '?id=eq.' . urlencode($appointmentId),
        ['status' => 'cancelled']
    );
    http_response_code(500);
    echo json_encode(['error' => 'Failed to process payment']);
    exit;
}

$paymentRef = $payBody[0]['payment_ref'];

echo json_encode([
    'success'        => true,
    'appointment_no' => $appointmentNo,
    'payment_ref'    => $paymentRef,
    'amount'         => $price,
    'slot_date'      => $slot['slot_date'],
    'start_time'     => $slot['start_time'],
    'end_time'       => $slot['end_time'],
]);