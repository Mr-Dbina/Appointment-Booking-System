<?php







header('Content-Type: application/json');

require_once __DIR__ . '/../helpers/supabase.php';

session_start();

$email     = $_SESSION['otp_reset_email'] ?? null;
$patientId = $_SESSION['otp_reset_id']    ?? null;

if (!$email || !$patientId) {
    echo json_encode(['ok' => false, 'error' => 'Session expired. Please restart the reset process.']);
    exit;
}

$raw      = file_get_contents('php://input');
$data     = json_decode($raw, true);
$password = $data['password'] ?? '';

if (strlen($password) < 8) {
    echo json_encode(['ok' => false, 'error' => 'Password must be at least 8 characters.']);
    exit;
}



$ch = curl_init(SUPABASE_URL . '/auth/v1/admin/users/' . urlencode($patientId));
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST  => 'PUT',
    CURLOPT_POSTFIELDS     => json_encode(['password' => $password]),
    CURLOPT_HTTPHEADER     => [
        'apikey: '               . SUPABASE_KEY,
        'Authorization: Bearer ' . SUPABASE_KEY,
        'Content-Type: application/json',
    ],
]);
$body   = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($status !== 200) {
    $err = json_decode($body, true)['message'] ?? 'Failed to update password.';
    echo json_encode(['ok' => false, 'error' => $err]);
    exit;
}


supabase_patch(
    'patients',
    '?id=eq.' . urlencode($patientId),
    [
        'otp_code'       => null,
        'otp_expires_at' => null,
        'otp_verified'   => false,
    ]
);


unset($_SESSION['otp_reset_email'], $_SESSION['otp_reset_id']);

echo json_encode(['ok' => true]);