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

// ── Step 1: Verify auth token and get user ─────────────────────────────────
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

$patientId    = $userBody['id'];
$patientEmail = $userBody['email'] ?? '—';

// ── Step 2: Get patient name from patients table ───────────────────────────
$patientResult = supabase_get('patients', '?id=eq.' . urlencode($patientId));

if ($patientResult['status'] === 200 && !empty($patientResult['body'])) {
    $p           = $patientResult['body'][0];
    $patientName = trim(($p['first_name'] ?? '') . ' ' . ($p['last_name'] ?? ''));
    if ($patientName === '') $patientName = '—';
} else {
    $patientName = '—';
}

// ── Step 3: Verify time slot is available ──────────────────────────────────
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

// ── Step 4: Check for duplicate booking ────────────────────────────────────
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

// ── Step 5: Get service details (name + price) ─────────────────────────────
$serviceResult = supabase_get('services', '?id=eq.' . urlencode($serviceId));

if ($serviceResult['status'] !== 200 || empty($serviceResult['body'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Service not found']);
    exit;
}

$service      = $serviceResult['body'][0];
$price        = $service['price'];
$serviceName  = $service['name'];

// ── Step 6: Get doctor details (name) ──────────────────────────────────────
$doctorResult = supabase_get('doctors', '?id=eq.' . urlencode($doctorId));

if ($doctorResult['status'] !== 200 || empty($doctorResult['body'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Doctor not found']);
    exit;
}

$doctorName = $doctorResult['body'][0]['name'];

// ── Step 7: Insert appointment ─────────────────────────────────────────────
$apptResult = supabase_post('appointments', [
    'patient_id'   => $patientId,
    'doctor_id'    => $doctorId,
    'service_id'   => $serviceId,
    'time_slot_id' => $slotId,
    'status'       => 'pending',
]);

if ($apptResult['status'] !== 201 || empty($apptResult['body'])) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to create appointment', 'debug' => $apptResult]);
    exit;
}

$appointment   = $apptResult['body'][0];
$appointmentId = $appointment['id'];
$appointmentNo = $appointment['appointment_no'];

// ── Step 8: Insert payment record ──────────────────────────────────────────
$payResult = supabase_post('payments', [
    'appointment_id' => $appointmentId,
    'amount'         => $price,
    'status'         => 'paid',
]);

if ($payResult['status'] !== 201 || empty($payResult['body'])) {
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

$paymentRef = $payResult['body'][0]['payment_ref'];

// ── Step 9: Return full success response ───────────────────────────────────
echo json_encode([
    'success'        => true,
    'appointment_no' => $appointmentNo,
    'payment_ref'    => $paymentRef,
    'amount'         => $price,
    'doctor_name'    => $doctorName,
    'service_name'   => $serviceName,
    'slot_date'      => $slot['slot_date'],
    'start_time'     => $slot['start_time'],
    'end_time'       => $slot['end_time'],
    'patient_name'   => $patientName,
    'patient_email'  => $patientEmail,
]);