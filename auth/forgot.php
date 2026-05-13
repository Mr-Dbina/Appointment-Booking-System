<?php
// ============================================================
//  app/views/auth/forgot.php
// ============================================================
$base = "http://localhost/appointment_booking_system";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Forgot Password — Happy Care Clinic</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Ponomar&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="<?= $base ?>/public/css/login.css">
  <style>
    /* ── back link ── */
    .back-link {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      color: var(--pink);
      font-size: .84rem;
      font-weight: 700;
      text-decoration: none;
      margin-bottom: 20px;
      transition: opacity .2s;
    }
    .back-link:hover { opacity: .7; }

    /* ── step indicator ── */
    .steps {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 20px;
    }
    .step-dot {
      width: 10px; height: 10px;
      border-radius: 50%;
      background: #f9a8c4;
      transition: background .3s;
    }
    .step-dot.active { background: var(--pink); }
    .step-line {
      flex: 1; height: 2px;
      background: #f9a8c4;
    }
  </style>
</head>
<body>
<div class="page">
  <div class="left">
    <div class="card">

      <a href="<?= $base ?>/auth/login.php" class="back-link">
        <i class="fa-solid fa-arrow-left"></i> Back to Login
      </a>

      <!-- Step dots: 1 active -->
      <div class="steps">
        <div class="step-dot active" id="s1"></div>
        <div class="step-line"></div>
        <div class="step-dot" id="s2"></div>
        <div class="step-line"></div>
        <div class="step-dot" id="s3"></div>
      </div>

      <p class="welcome">Reset Password</p>
      <h1>Forgot your<br>password?</h1>
      <p class="sub">Enter your email and we'll send you a 6-digit OTP.</p>

      <div id="formMessage" class="form-message"></div>

      <div class="field">
        <input type="email" id="email" placeholder="Email Address" autocomplete="email"/>
        <span class="icon"><i class="fa-solid fa-envelope"></i></span>
      </div>

      <button class="btn-login" id="sendBtn" style="margin-top:6px;">
        <span id="sendBtnText">Send OTP</span>
      </button>

      <div class="divider"></div>

      <p class="register">
        Remembered it?
        <a href="<?= $base ?>/auth/login.php">Sign in</a>
      </p>

    </div>
  </div>

  <!-- Right panel (same as login) -->
  <div class="right">
    <img class="bg" src="<?= $base ?>/public/images/background_login.png" alt="Medical background">
    <div class="overlay"></div>
    <div class="content">
      <div class="brand">
        <div class="brand-text">
          <h2>Happy Care Clinic</h2>
          <span>TRUSTED MEDICAL CARE</span>
        </div>
        <img src="<?= $base ?>/public/images/logo.png" alt="Logo">
      </div>
      <div class="hero-text">
        <span class="line line-pink">SECURE</span>
        <span class="line line-cyan">ACCOUNT</span>
        <span class="line line-pink">RECOVERY</span>
        <span class="line line-white">MADE EASY</span>
        <p class="hero-sub">
          We'll send a one-time password to your registered email
          so you can regain access safely.
        </p>
      </div>
    </div>
  </div>
</div>

<script>
const base       = "<?= $base ?>";
const sendBtn    = document.getElementById('sendBtn');
const sendBtnTxt = document.getElementById('sendBtnText');
const msgBox     = document.getElementById('formMessage');

function showMsg(msg, type) {
  msgBox.textContent = msg;
  msgBox.className   = 'form-message ' + type;
  msgBox.style.display = 'block';
}

function setLoading(on) {
  sendBtn.disabled   = on;
  sendBtnTxt.textContent = on ? 'Sending…' : 'Send OTP';
}

document.addEventListener('keydown', e => { if (e.key === 'Enter') sendBtn.click(); });

sendBtn.addEventListener('click', async () => {
  const email = document.getElementById('email').value.trim();
  if (!email) return showMsg('Please enter your email address.', 'error');

  setLoading(true);

  const res  = await fetch(`${base}/api/send_otp_api.php`, {
    method:  'POST',
    headers: { 'Content-Type': 'application/json' },
    body:    JSON.stringify({ email }),
  });
  const json = await res.json();

  setLoading(false);

  if (!json.ok) return showMsg(json.error || 'Failed to send OTP.', 'error');

  // Activate step 2 dot visually
  document.getElementById('s2').classList.add('active');

  showMsg('✅ OTP sent! Check your email.', 'success');

  // Redirect to OTP verification page, passing email as query param
  setTimeout(() => {
    window.location.href =
      `${base}/auth/verify_otp.php?email=${encodeURIComponent(email)}`;
  }, 1600);
});
</script>
</body>
</html>