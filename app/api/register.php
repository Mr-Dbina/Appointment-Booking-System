<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../helpers/supabase.php';

$data = json_decode(file_get_contents('php://input'), true);

// Insert patient (Supabase Auth handles password hashing — no encrypt key needed)
$result = supabase_rpc('insert_patient', [
    'p_id'               => $data['id'],
    'p_email'            => $data['email'],
    'p_first_name'       => $data['firstName'],
    'p_last_name'        => $data['lastName'],
    'p_phone'            => $data['phone'] ?? null,
    'p_dob'              => $data['dob']   ?: null,
    'p_sex'              => $data['sex'],
    'p_token'            => $data['token'],
    'p_token_expires_at' => $data['expiresAt'],
]);

if ($result['status'] !== 200) {
    echo json_encode(['success' => false, 'message' => 'Failed to save patient profile.']);
    exit;
}

// Send verification email
$base      = 'http://localhost/appointment_booking_system';
$link      = "$base/app/views/auth/verify.php?token={$data['token']}&email=" . urlencode($data['email']);
$firstName = htmlspecialchars($data['firstName']);
$to        = $data['email'];
$subject   = 'Verify your Happy Care Clinic account';
$body      = "
<div style='font-family:sans-serif;max-width:480px;margin:0 auto;padding:32px;background:#fff;border-radius:16px;'>
  <h2 style='color:#1a1a2e;'>Hi, {$firstName}! 👋</h2>
  <p style='color:#6b7280;'>Click the button below to verify your email address.</p>
  <a href='{$link}' style='display:inline-block;background:#5b5bd6;color:#fff;padding:14px 28px;
     border-radius:12px;text-decoration:none;font-weight:700;margin:16px 0;'>
    Verify Email Address
  </a>
  <p style='color:#9ca3af;font-size:12px;'>Link expires in 24 hours.</p>
</div>";

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$headers .= "From: Happy Care Clinic <no-reply@happycareclinic.com>\r\n";

$sent = mail($to, $subject, $body, $hea