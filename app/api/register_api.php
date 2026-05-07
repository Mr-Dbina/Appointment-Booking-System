<?php
header('Content-Type: application/json');

$data      = json_decode(file_get_contents('php://input'), true);
$base      = 'http://localhost/appointment_booking_system';
$firstName = htmlspecialchars($data['firstName'] ?? 'Patient');
$to        = $data['email'] ?? '';

if (!$to) {
    echo json_encode(['success' => false, 'message' => 'No email provided.']);
    exit;
}

$subject = 'Welcome to Happy Care Clinic!';
$body    = "
<div style='font-family:sans-serif;max-width:480px;margin:0 auto;padding:32px;background:#fff;border-radius:16px;'>
  <h2 style='color:#1a1a2e;'>Hi, {$firstName}! 👋</h2>
  <p style='color:#6b7280;'>Your account has been created successfully.</p>
  <p style='color:#6b7280;'>Check your inbox for a verification email from Supabase to activate your account.</p>
  <a href='{$base}/app/views/auth/login.php'
     style='display:inline-block;background:#5b5bd6;color:#fff;padding:14px 28px;
            border-radius:12px;text-decoration:none;font-weight:700;margin:16px 0;'>
    Go to Login
  </a>
  <p style='color:#9ca3af;font-size:12px;'>If you didn't create this account, ignore this email.</p>
</div>";

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$headers .= "From: Happy Care Clinic <no-reply@happycareclinic.com>\r\n";

$sent = mail($to, $subject, $body, $headers);
echo json_encode(['success' => $sent]);