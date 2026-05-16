<?php
require_once __DIR__ . '/../config.php';
$email = htmlspecialchars($_GET['email'] ?? '');
if (!$email) {
    header("Location: " . BASE_URL . "/auth/forgot.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Verify OTP — Happy Care Clinic</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Ponomar&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/login.css">
  <style>
    .back-link {
      display: inline-flex; align-items: center; gap: 7px;
      color: var(--pink); font-size: .84rem; font-weight: 700;
      text-decoration: none; margin-bottom: 20px; transition: opacity .2s;
    }
    .back-link:hover { opacity: .7; }

    .steps {
      display: flex; align-items: center; gap: 8px; margin-bottom: 20px;
    }
    .step-dot {
      width: 10px; height: 10px; border-radius: 50%;
      background: #f9a8c4; transition: background .3s;
    }
    .step-dot.active { background: var(--pink); }
    .step-line { flex: 1; height: 2px; background: #f9a8c4; }

    
    .otp-row {
      display: flex; gap: 10px; justify-content: center;
      margin: 6px 0 18px;
    }
    .otp-box {
      width: 48px; height: 58px;
      border: 2px solid var(--input-border);
      border-radius: 14px;
      font-family: 'Ponomar', serif;
      font-size: 1.6rem; font-weight: 700;
      color: var(--text); text-align: center;
      background: rgba(255,255,255,.9);
      outline: none;
      transition: border-color .25s, box-shadow .25s;
      caret-color: var(--pink);
    }
    .otp-box:focus {
      border-color: var(--pink);
      box-shadow: 0 0 0 3px rgba(255,39,104,.12);
    }
    .otp-box.filled { border-color: var(--pink); }

    .resend-row {
      text-align: center; font-size: .83rem; color: var(--sub);
      margin-bottom: 16px;
    }
    .resend-row a, .resend-row button {
      color: var(--pink); font-weight: 700;
      text-decoration: none; background: none;
      border: none; cursor: pointer; font-family: inherit;
      font-size: inherit; padding: 0;
    }
    .resend-row a:hover, .resend-row button:hover { opacity: .7; }
    #countdown { color: var(--sub); font-weight: 700; }
  </style>
</head>
<body>
<div class="page">
  <div class="left">
    <div class="card">

      <a href="<?= BASE_URL ?>/auth/forgot.php" class="back-link">
        <i class="fa-solid fa-arrow-left"></i> Back
      </a>

      <div class="steps">
        <div class="step-dot active"></div>
        <div class="step-line"></div>
        <div class="step-dot active"></div>
        <div class="step-line"></div>
        <div class="step-dot" id="s3"></div>
      </div>

      <p class="welcome">Step 2 of 3</p>
      <h1>Enter the<br>OTP code</h1>
      <p class="sub">
        We sent a 6-digit code to<br>
        <strong style="color:var(--pink);"><?= $email ?></strong>
      </p>

      <div id="formMessage" class="form-message"></div>

      <!-- 6 separate digit inputs -->
      <div class="otp-row">
        <input class="otp-box" type="text" inputmode="numeric" maxlength="1" id="d0" autocomplete="one-time-code"/>
        <input class="otp-box" type="text" inputmode="numeric" maxlength="1" id="d1"/>
        <input class="otp-box" type="text" inputmode="numeric" maxlength="1" id="d2"/>
        <input class="otp-box" type="text" inputmode="numeric" maxlength="1" id="d3"/>
        <input class="otp-box" type="text" inputmode="numeric" maxlength="1" id="d4"/>
        <input class="otp-box" type="text" inputmode="numeric" maxlength="1" id="d5"/>
      </div>

      <div class="resend-row">
        Didn't get it?
        <span id="resendWrap">
          Resend in <span id="countdown">2:00</span>
        </span>
      </div>

      <button class="btn-login" id="verifyBtn">
        <span id="verifyBtnText">Verify OTP</span>
      </button>

    </div>
  </div>

  <div class="right">
    <img class="bg" src="<?= BASE_URL ?>/public/images/background_login.png" alt="Medical background">
    <div class="overlay"></div>
    <div class="content">
      <div class="brand">
        <div class="brand-text">
          <h2>Happy Care Clinic</h2>
          <span>TRUSTED MEDICAL CARE</span>
        </div>
        <img src="<?= BASE_URL ?>/public/images/logo.png" alt="Logo">
      </div>
      <div class="hero-text">
        <span class="line line-pink">CHECK</span>
        <span class="line line-cyan">YOUR</span>
        <span class="line line-pink">EMAIL</span>
        <span class="line line-white">INBOX</span>
        <p class="hero-sub">
          Enter the 6-digit code we sent you. It expires in 10 minutes.
        </p>
      </div>
    </div>
  </div>
</div>

<script>
const base  = "<?= BASE_URL ?>";
const email = "<?= addslashes($email) ?>";


const boxes = Array.from(document.querySelectorAll('.otp-box'));

boxes.forEach((box, i) => {
  box.addEventListener('input', () => {
    box.value = box.value.replace(/\D/g, '').slice(-1);
    if (box.value) {
      box.classList.add('filled');
      if (i < 5) boxes[i + 1].focus();
    } else {
      box.classList.remove('filled');
    }
  });
  box.addEventListener('keydown', e => {
    if (e.key === 'Backspace' && !box.value && i > 0) boxes[i - 1].focus();
    if (e.key === 'Enter') verifyBtn.click();
  });
  
  box.addEventListener('paste', e => {
    const pasted = (e.clipboardData || window.clipboardData)
      .getData('text').replace(/\D/g, '').slice(0, 6);
    if (pasted.length === 6) {
      e.preventDefault();
      pasted.split('').forEach((ch, j) => {
        boxes[j].value = ch;
        boxes[j].classList.add('filled');
      });
      boxes[5].focus();
    }
  });
});


let seconds = 120;
const cdEl  = document.getElementById('countdown');
const rsWrap = document.getElementById('resendWrap');

const timer = setInterval(() => {
  seconds--;
  const m = Math.floor(seconds / 60);
  const s = String(seconds % 60).padStart(2, '0');
  cdEl.textContent = `${m}:${s}`;
  if (seconds <= 0) {
    clearInterval(timer);
    rsWrap.innerHTML =
      `<button onclick="resendOtp()">Resend OTP</button>`;
  }
}, 1000);

async function resendOtp() {
  rsWrap.textContent = 'Sending…';
  const res  = await fetch(`${base}/api/send_otp_api.php`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ email }),
  });
  const json = await res.json();
  rsWrap.textContent = json.ok ? '✅ New OTP sent!' : '❌ ' + (json.error || 'Error');
}


const verifyBtn    = document.getElementById('verifyBtn');
const verifyBtnTxt = document.getElementById('verifyBtnText');
const msgBox       = document.getElementById('formMessage');

function showMsg(msg, type) {
  msgBox.textContent   = msg;
  msgBox.className     = 'form-message ' + type;
  msgBox.style.display = 'block';
}

function setLoading(on) {
  verifyBtn.disabled     = on;
  verifyBtnTxt.textContent = on ? 'Verifying…' : 'Verify OTP';
}

verifyBtn.addEventListener('click', async () => {
  const otp = boxes.map(b => b.value).join('');
  if (otp.length < 6) return showMsg('Please enter all 6 digits.', 'error');

  setLoading(true);

  const res  = await fetch(`${base}/api/verify_otp_api.php`, {
    method:  'POST',
    headers: { 'Content-Type': 'application/json' },
    body:    JSON.stringify({ email, otp }),
  });
  const json = await res.json();

  setLoading(false);

  if (!json.ok) return showMsg(json.error || 'Verification failed.', 'error');

  document.getElementById('s3').classList.add('active');
  showMsg('✅ OTP verified! Redirecting…', 'success');

  setTimeout(() => {
    window.location.href =
      `${base}/auth/reset_password.php?email=${encodeURIComponent(email)}`;
  }, 1400);
});
</script>
</body>
</html>

