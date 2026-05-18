<?php
require_once __DIR__ . '/../helpers/supabase.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$date      = $_GET['date']       ?? '';
$serviceId = $_GET['service_id'] ?? '';

if (!$date) {
    http_response_code(400);
    echo json_encode(['error' => 'Date is required']);
    exit;
}

if ($serviceId) {
    $svcRes = supabase_get('services', '?id=eq.' . urlencode($serviceId) . '&select=department_id');
    $departmentId = $svcRes['body'][0]['department_id'] ?? null;

    if ($departmentId) {
        $docRes = supabase_get('doctors', '?department_id=eq.' . urlencode($departmentId) . '&select=id');
        $doctorIds = array_column($docRes['body'] ?? [], 'id');
    }
}

if (!empty($doctorIds)) {
    $inFilter = implode(',', array_map(fn($id) => urlencode($id), $doctorIds));
    $filter = '?slot_date=eq.' . urlencode($date)
            . '&doctor_id=in.(' . implode(',', $doctorIds) . ')'
            . '&order=start_time.asc';
} else {
    $filter = '?slot_date=eq.' . urlencode($date) . '&order=start_time.asc';
}

$result = supabase_get('time_slots_status', $filter);

if ($result['status'] !== 200) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch slots']);
    exit;
}

$slots = $result['body'] ?? [];
$grouped = [];

foreach ($slots as $slot) {
    $key = $slot['start_time'];
    if (!isset($grouped[$key])) {
        $start = date('g:i A', strtotime($slot['start_time']));
        $end   = date('g:i A', strtotime($slot['end_time']));
        $grouped[$key] = [
            'id'         => $slot['id'],
            'start_time' => $slot['start_time'],
            'end_time'   => $slot['end_time'],
            'label'      => $start . ' – ' . $end,
            'status'     => $slot['status'],
            'remaining'  => (int) $slot['remaining'],
            'slot_ids'   => [$slot['id']],
        ];
    } else {
        $grouped[$key]['remaining'] += (int) $slot['remaining'];
        $grouped[$key]['slot_ids'][] = $slot['id'];
        $priority = ['available' => 3, 'limited' => 2, 'booked' => 1];
        $current  = $priority[$grouped[$key]['status']] ?? 0;
        $incoming = $priority[$slot['status']] ?? 0;
        if ($incoming > $current) {
            $grouped[$key]['status'] = $slot['status'];
            $grouped[$key]['id']     = $slot['id'];
        }
    }
}

echo json_encode(['slots' => array_values($grouped)]);
