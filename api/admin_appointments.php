<?php
require_once __DIR__ . '/../helpers/supabase.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }


if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id     = $input['id']     ?? '';
    $status = $input['status'] ?? '';

    $allowed = ['pending', 'confirmed', 'cancelled', 'completed'];
    if (!$id || !in_array($status, $allowed)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid id or status']);
        exit;
    }

    $res = supabase_patch('appointments', '?id=eq.' . urlencode($id), ['status' => $status]);
    echo json_encode(['success' => $res['status'] === 204]);
    exit;
}



$filter = '?select=id,appointment_no,status,created_at,'
        . 'patient:patient_id(id,email,raw_user_meta_data),'
        . 'doctor:doctor_id(id,name,specialty),'
        . 'service:service_id(id,name,price),'
        . 'time_slot:time_slot_id(slot_date,start_time,end_time)'
        . '&order=created_at.desc';

$res = supabase_get('appointments', $filter);

if ($res['status'] !== 200) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch appointments', 'detail' => $res]);
    exit;
}

echo json_encode($res['body']);