<?php
require_once __DIR__ . '/../../helpers/supabase.php';
$base  = 'http://localhost/appointment_booking_system';
$token = $_GET['token'] ?? '';

$status  = 'error';
$message = 'Invalid or expired verification link.';

if ($token) {
    $res = supabase_get('patients', '?verification_token=eq.' . urlencode($token) . '&select=id,token_expires_at,email_verified');

    if (!empty($res['body'])) {
        $p = $res['body'][0];

        if ($p['email_verified']) {
            $status  = 'done';
            $message = 'Already verified — you can log in.';
        } elseif (strtotime($p['token_expires_at']) < time()) {
            $status  = 'expired';
            $message = 'This link has expired. Please register again.';
        } else {
            supabase_patch('patients', '?id=eq.' . $p['id'], [
                'email_verified'     => true,
                'verification_token' => null,
                'token_expires_at'   => null,
            ]);
            $status  = 'success';
            $message = 'Email verified! You can now log in.';
        }
    }
}
$icon = match($status) { 'success' => '✅', 'done' => '👍', default => '❌' };
?>
<!DOCTYPE html><html lang="en"><head>
<meta charset="UTF-8"><title>Verify — Happy Care Clinic</title>
<link href="https://fonts.googleapis.com/css2?family=Ponomar&display=swap" rel="stylesheet">
<style>
  body{font-family:'Ponomar',serif;background:linear-gradient(135deg,#fce8ef,#fff,#d6eaf8);
       min-height:100vh;display:flex;align-items:center;justify-content:center;}
  .card{background:#fff;border-radius:20px;padding:48px 40px;text-align:center;max-width:400px;box-shadow:0 8px 32px rgba(0,0,0,.1);}
  h2{color:#1a1a2e;margin:12px 0 8px;}
  p{color:#6b7280;margin-bottom:24px;}
  a{display:inline-block;background:#5b5bd6;color:#fff;text-decoration:none;padding:12px 28px;border-radius:12px;font-weight:700;}
</style>
</head><body>
<div class="card">
  <div style="font-size:2.5rem;"><?= $icon ?></div>
  <h2><?= $status === 'success' ? 'Email Verified!' : ($status === 'done' ? 'Already Verified' : 'Verification Failed') ?></h2>
  <p><?= htmlspecialchars($message) ?></p>
  <a href="<?= $base ?>/auth/login.php">Go to Login</a>
</div>
</body></html>