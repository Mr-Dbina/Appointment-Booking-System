<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../helpers/supabase.php';

$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);

$email = trim($data['email'] ?? '');
$otp   = trim($data['otp']   ?? '');

if (!$email || !$otp) {
    echo json_encode(['ok' => false, 'error' => 'Missing fields.']);
    exit;
}


$res = supabase_get(
    'patients',
    '?email=eq.' . urlencode($email) . '&select=id,otp_code,otp_expires_at,otp_verified'
);

if (empty($res['body'])) {
    echo json_encode(['ok' => false, 'error' => 'Account not found.']);
    exit;
}

$p = $res['body'][0];

if ($p['otp_verified']) {
    echo json_encode(['ok' => false, 'error' => 'OTP already used. Please request a new one.']);
    exit;
}

if (!$p['otp_code'] || $p['otp_code'] !== $otp) {
    echo json_encode(['ok' => false, 'error' => 'Invalid OTP. Please try again.']);
    exit;
}

if (strtotime($p['otp_expires_at']) < time()) {
    echo json_encode(['ok' => false, 'error' => 'OTP has expired. Please request a new one.']);
    exit;
}


supabase_patch(
    'patients',
    '?id=eq.' . $p['id'],
    ['otp_verified' => true]
);



session_start();
$_SESSION['otp_reset_email'] = $email;
$_SESSION['otp_reset_id']    = $p['id'];

echo json_encode(['ok' => true]);