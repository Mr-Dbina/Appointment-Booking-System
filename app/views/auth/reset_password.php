<?php
$base  = "http://localhost/appointment_booking_system";
$email = htmlspecialchars($_GET['email'] ?? '');
if (!$email) {
    header("Location: $base/app/views/auth/forgot.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reset Password — Happy Care Clinic</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Ponomar&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="<?= $base ?>/public/css/login.css">
  <style>
    .steps {
      display: flex; align-items: center; gap: 8px; margin-bottom: 20px;
    }
    .step-dot {
      width: 10px; height: 10px; border-radius: 50%;
      background: #f9a8c4; transition: background .3s;
    }
    .step-dot.active { background: var(--pink); }
    .step-line { flex: 1; height: 2px; background: #f9a8c4; }

    /* strength bar */
    .strength-wrap { margin: -6px 0 14px; padding: 0 4px; }
    .strength-bar {
      height: 4px; border-radius: 4px;
      background: #f0c0cc; overflow: hidden;
    }
    .strength-fill {
      height: 100%; width: 0%;
      border-radius: 4px;
      transition: width .3s, background .3s;
    }
    .strength-label {
      font-size: .75rem; color: var(--sub);
      margin-top: 4px; text-align: right;
    }
  </style>
</head>
<body>
<div class="page">
  <div class="left">
    <div class="card">

      <div class="steps">
        <div class="step-dot active"></div>
        <div class="step-line"></div>
        <div class="step-dot active"></div>
        <div class="step-line"></div>
        <div class="step-dot active"></div>
      </div>

      <p class="welcome">Step 3 of 3</p>
      <h1>Set a new<br>password</h1>
      <p class="sub">Choose a strong password for your account.</p>

      <div id="formMessage" class="form-message"></div>

      <div class="field">
        <input type="password" id="password" placeholder="New Password"/>
        <span class="icon clickable" id="togglePwd">
          <i class="fa-solid fa-lock" id="lockIcon"></i>
        </span>
      </div>

      <div class="strength-wrap">
        <div class="strength-bar">
          <div class="strength-fill" id="strengthFill"></div>
        </div>
        <div class="strength-label" id="strengthLabel"></div>
      </div>

      <div class="field">
        <input type="password" id="confirmPassword" placeholder="Confirm Password"/>
        <span class="icon clickable" id="toggleConfirm">
          <i class="fa-solid fa-lock" id="lockIcon2"></i>
        </span>
      </div>

      <button class="btn-login" id="resetBtn" style="margin-top:6px;">
        <span id="resetBtnText">Reset Password</span>
      </button>

      <div class="divider"></div>

      <p class="register">
        Back to
        <a href="<?= $base ?>/app/views/auth/login.php">Sign in</a>
      </p>

    </div>
  </div>

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
        <span class="line line-pink">ALMOST</span>
        <span class="line line-cyan">THERE,</span>
        <span class="line line-pink">NEW</span>
        <span class="line line-white">PASSWORD</span>
        <p class="hero-sub">
          Create a strong password to keep your patient account secure.
        </p>
      </div>
    </div>
  </div>
</div>

<script>
const base  = "<?= $base ?>";
const email = "<?= addslashes($email) ?>";

// ── Toggle password visibility ────────────────────────────────────────────────
function toggleVisibility(inputId, iconId) {
  const input = document.getElementById(inputId);
  const icon  = document.getElementById(iconId);
  input.type  = input.type === 'password' ? 'text' : 'password';
  icon.className = input.type === 'password'
    ? 'fa-solid fa-lock' : 'fa-solid fa-lock-open';
}
document.getElementById('togglePwd').addEventListener('click', () =>
  toggleVisibility('password', 'lockIcon'));
document.getElementById('toggleConfirm').addEventListener('click', () =>
  toggleVisibility('confirmPassword', 'lockIcon2'));

// ── Password strength ─────────────────────────────────────────────────────────
const pwdInput     = document.getElementById('password');
const strengthFill = document.getElementById('strengthFill');
const strengthLbl  = document.getElementById('strengthLabel');

const levels = [
  { label: '',          color: '#f0c0cc', pct: 0   },
  { label: 'Weak',      color: '#ef4444', pct: 25  },
  { label: 'Fair',      color: '#f97316', pct: 50  },
  { label: 'Good',      color: '#eab308', pct: 75  },
  { label: 'Strong',    color: '#22c55e', pct: 100 },
];

pwdInput.addEventListener('input', () => {
  const v = pwdInput.value;
  let score = 0;
  if (v.length >= 8)             score++;
  if (/[A-Z]/.test(v))          score++;
  if (/[0-9]/.test(v))          score++;
  if (/[^A-Za-z0-9]/.test(v))   score++;
  const lvl = levels[score];
  strengthFill.style.width      = lvl.pct + '%';
  strengthFill.style.background = lvl.color;
  strengthLbl.textContent       = lvl.label;
  strengthLbl.style.color       = lvl.color;
});

// ── Reset ─────────────────────────────────────────────────────────────────────
const resetBtn    = document.getElementById('resetBtn');
const resetBtnTxt = document.getElementById('resetBtnText');
const msgBox      = document.getElementById('formMessage');

function showMsg(msg, type) {
  msgBox.textContent   = msg;
  msgBox.className     = 'form-message ' + type;
  msgBox.style.display = 'block';
}
function setLoading(on) {
  resetBtn.disabled      = on;
  resetBtnTxt.textContent = on ? 'Resetting…' : 'Reset Password';
}

document.addEventListener('keydown', e => { if (e.key === 'Enter') resetBtn.click(); });

resetBtn.addEventListener('click', async () => {
  const pwd     = document.getElementById('password').value;
  const confirm = document.getElementById('confirmPassword').value;

  if (pwd.length < 8)
    return showMsg('Password must be at least 8 characters.', 'error');
  if (pwd !== confirm)
    return showMsg('Passwords do not match.', 'error');

  setLoading(true);

  const res  = await fetch(`${base}/app/api/reset_password_api.php`, {
    method:  'POST',
    headers: { 'Content-Type': 'application/json' },
    body:    JSON.stringify({ password: pwd }),
  });
  const json = await res.json();

  setLoading(false);

  if (!json.ok) return showMsg(json.error || 'Failed to reset password.', 'error');

  showMsg('✅ Password reset! Redirecting to login…', 'success');
  setTimeout(() => {
    window.location.href = `${base}/app/views/auth/login.php`;
  }, 2000);
});
</script>
</body>
</html>