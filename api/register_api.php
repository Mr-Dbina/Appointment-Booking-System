<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../helpers/mailer.php';
require_once __DIR__ . '/../helpers/supabase.php';

$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);

$email     = trim($data['email']     ?? '');
$firstName = trim($data['firstName'] ?? '');

if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['ok' => false, 'error' => 'Invalid email.']);
    exit;
}


$token   = bin2hex(random_bytes(32));
$expires = date('c', strtotime('+24 hours'));


supabase_patch(
    'patients',
    '?email=eq.' . urlencode($email),
    [
        'verification_token' => $token,
        'token_expires_at'   => $expires,
        'email_verified'     => false,
    ]
);

$basePath  = str_replace('\\', '/', substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT'])));
$protocol  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$baseUrl   = $protocol . '://' . $_SERVER['HTTP_HOST'] . $basePath;
$verifyUrl = "$baseUrl/auth/verify.php?token=$token";
$name      = $firstName ?: 'Patient';


$body = email_template(<<<HTML
  <h2 style="margin:0 0 8px;color:#1a1a2e;font-size:1.3rem;">
    Welcome, {$name}! 👋
  </h2>
  <p style="margin:0 0 20px;color:#555;font-size:.93rem;line-height:1.65;">
    Thank you for registering with <strong>Happy Care Clinic</strong>.
    Please verify your email address to activate your account and start
    booking appointments.
  </p>
  <div style="text-align:center;margin:28px 0;">
    <a href="{$verifyUrl}"
       style="display:inline-block;background:linear-gradient(90deg,#ff2768,#ff6fa3);
              color:#fff;text-decoration:none;padding:14px 36px;border-radius:50px;
              font-weight:700;font-size:.97rem;letter-spacing:.03em;">
      ✅ Verify My Email
    </a>
  </div>
  <p style="margin:0;color:#999;font-size:.8rem;text-align:center;">
    This link expires in <strong>24 hours</strong>.<br>
    If you did not create an account, you can safely ignore this email.
  </p>
HTML);

$result = send_mail(
    $email,
    $name,
    '✅ Verify Your Email — Happy Care Clinic',
    $body
);

echo json_encode($result);