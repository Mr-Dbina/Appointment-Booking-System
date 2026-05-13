<?php
require_once __DIR__ . '/../helpers/supabase.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

$res = supabase_get('services', '?select=*&order=name.asc');

if ($res['status'] !== 200) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch services']);
    exit;
}

// Count doctors per service
$doctorCounts = [];
$dcRes = supabase_get('doctors', '?select=service_id,status');
if ($dcRes['status'] === 200 && is_array($dcRes['body'])) {
    foreach ($dcRes['body'] as $d) {
        $sid = $d['service_id'] ?? null;
        if ($sid) {
            $doctorCounts[$sid] = ($doctorCounts[$sid] ?? 0) + 1;
        }
    }
}

$services = array_map(function ($s) use ($doctorCounts) {
    $s['doctor_count'] = $doctorCounts[$s['id']] ?? 0;
    return $s;
}, $res['body']);

echo json_encode($services);
