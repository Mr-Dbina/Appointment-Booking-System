
require_once __DIR__ . '/../helpers/supabase.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

// ── GET ───────────────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $res = supabase_get('doctors', '?select=*&order=name.asc');
    if ($res['status'] !== 200) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch doctors']);
        exit;
    }
    echo json_encode($res['body']);
    exit;
}

// ── POST: add doctor ──────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $required = ['name', 'specialty'];
    foreach ($required as $f) {
        if (empty($input[$f])) {
            http_response_code(400);
            echo json_encode(['error' => "Missing field: $f"]);
            exit;
        }
    }
    $data = [
        'name'      => trim($input['name']),
        'specialty' => trim($input['specialty']),
        'email'     => trim($input['email']    ?? ''),
        'phone'     => trim($input['phone']    ?? ''),
        'schedule'  => trim($input['schedule'] ?? ''),
        'status'    => 'active',
    ];
    $res = supabase_post('doctors', $data);
    echo json_encode(['success' => $res['status'] === 201, 'data' => $res['body']]);
    exit;
}

// ── PATCH: update status ──────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id     = $input['id']     ?? '';
    $status = $input['status'] ?? '';
    if (!$id || !in_array($status, ['active', 'inactive'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid id or status']);
        exit;
    }
    $res = supabase_patch('doctors', '?id=eq.' . urlencode($id), ['status' => $status]);
    echo json_encode(['success' => $res['status'] === 204]);
    exit;
}