<?php







header('Content-Type: application/json');

require_once __DIR__ . '/../helpers/mailer.php';
require_once __DIR__ . '/../helpers/supabase.php';

$raw   = file_get_contents('php://input');
$data  = json_decode($raw, true);
$email = trim($data['email'] ?? '');

if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['ok' => false, 'error' => 'Invalid email address.']);
    exit;
}


$res = supabase_get('patients', '?email=eq.' . urlencode($email) . '&select=id,first_name');

if (empty($res['body'])) {
    
    echo json_encode(['ok' => true]);
    exit;
}

$patient   = $res['body'][0];
$firstName = $patient['first_name'] ?? 'Patient';


$otp     = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
$expires = date('c', strtotime('+10 minutes'));


supabase_patch(
    'patients',
    '?email=eq.' . urlencode($email),
    [
        'otp_code'       => $otp,
        'otp_expires_at' => $expires,
        'otp_verified'   => false,
    ]
);


$body = email_template(<<<HTML
  <h2 style="margin:0 0 8px;color:#1a1a2e;font-size:1.25rem;">
    Password Reset Request 🔐
  </h2>
  <p style="margin:0 0 24px;color:#555;font-size:.93rem;line-height:1.65;">
    Hi <strong>{$firstName}</strong>, we received a request to reset your
    <strong>Happy Care Clinic</strong> account password.
    Use the OTP below — it is valid for <strong>10 minutes</strong>.
  </p>

  <!-- OTP Display -->
  <div style="text-align:center;margin:0 0 28px;">
    <div style="display:inline-block;background:#fff5f8;border:2px dashed #ff2768;
                border-radius:16px;padding:18px 36px;">
      <p style="margin:0 0 4px;font-size:.72rem;color:#c0024e;
                letter-spacing:.15em;text-transform:uppercase;font-weight:700;">
        Your OTP Code
      </p>
      <p style="margin:0;font-size:2.6rem;font-weight:900;
                letter-spacing:.35em;color:#ff2768;font-family:monospace;">
        {$otp}
      </p>
    </div>
  </div>

  <p style="margin:0;color:#999;font-size:.8rem;text-align:center;line-height:1.7;">
    Do not share this code with anyone.<br>
    If you did not request a password reset, please ignore this email.<br>
    Your password will not change unless you complete the process.
  </p>
HTML);

$result = send_mail(
    $email,
    $firstName,
    '🔐 Your OTP Code — Happy Care Clinic',
    $body
);

echo json_encode($result);