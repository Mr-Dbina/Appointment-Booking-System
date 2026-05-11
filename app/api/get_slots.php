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

// Group by start_time — merge all doctors' slots into one per time
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
        // Accumulate remaining slots across all doctors
        $grouped[$key]['remaining'] += (int) $slot['remaining'];
        $grouped[$key]['slot_ids'][] = $slot['id'];

        // Pick best status: available > limited > booked
        $priority = ['available' => 3, 'limited' => 2, 'booked' => 1];
        $current  = $priority[$grouped[$key]['status']] ?? 0;
        $incoming = $priority[$slot['status']] ?? 0;

        if ($incoming > $current) {
            $grouped[$key]['status'] = $slot['status'];
            $grouped[$key]['id']     = $slot['id'];
        }
    }
}

// Re-index and return
$formatted = array_values($grouped);

echo json_encode(['slots' => $formatted]);