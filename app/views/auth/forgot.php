<?php
$base = "http://localhost/appointment_booking_system";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Happy Care Clinic – Reset Password</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Ponomar&display=swap" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?= $base ?>/public/css/login.css" />
  <style>
    .strength-bar-wrap {
      margin: -8px 0 14px;
      padding: 0 4px;
    }
    .strength-track {
      height: 4px;
      border-radius: 99px;
      background: #f0c0cc;
      overflow: hidden;
    }
    .strength-fill {
      height: 100%;
      border-radius: 99px;
      width: 0%;
      transition: width 0.3s, background 0.3s;
    }
    .strength-label {
      font-size: 0.75rem;
      margin-top: 4px;
      color: var(--sub);
      min-height: 16px;
      transition: color 0.3s;
    }
    .requirements {
      background: rgba(255,255,255,0.7);
      border: 1px solid rgba(255,39,104,0.1);
      border-radius: 14px;
      padding: 12px 16px;
      margin-bottom: 14px;
      display: none;
    }
    .requirements.visible {
      display: block;
    }
    .req-title {
      font-size: 0.75rem;
      font-weight: 700;
      color: var(--sub);
      letter-spacing: 0.05em;
      text-transform: uppercase;
      margin-bottom: 8px;
    }
    .req-item {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 0.8rem;
      color: #aaa;
      margin-bottom: 4px;
      transition: color 0.25s;
    }
    .req-item:last-child { margin-bottom: 0; }
    .req-item i {
      font-size: 0.7rem;
      width: 14px;
      transition: color 0.25s;
    }
    .req-item.met {
      color: #16a34a;
    }
    .req-item.met i {
      color: #16a34a;
    }
    .btn-back {
      width: 100%;
      padding: 13px;
      border-radius: 50px;
      border: 1.5px solid var(--input-border);
      background: transparent;
      font-family: "Ponomar", serif;
      font-size: 0.95rem;
      font-weight: 700;
      color: var(--sub);
      letter-spacing: 0.04em;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      margin-top: 10px;
      transition: border-color 0.25s, color 0.25s, background 0.25s;
      text-decoration: none;
    }
    .btn-back:hover {
      border-color: var(--pink);
      color: var(--pink);
      background: rgba(255,39,104,0.04);
    }
    .match-hint {
      font-size: 0.78rem;
      margin: -10px 0 10px 4px;
      min-height: 16px;
      transition: color 0.25s;
    }
  </style>
</head>
<body>
<div class="page">

  <!-- LEFT: FORM -->
  <div class="left">
    <div class="card">

      <p class="welcome">Account Recovery</p>
      <h1>Reset your<br>password</h1>
      <p class="sub">Choose a strong password to secure your account</p>

      <div id="formMessage" class="form-message"></div>

      <!-- New Password -->
      <div class="field">
        <input type="password" id="password" placeholder="New Password" autocomplete="new-password" />
        <span class="icon clickable" id="togglePwd">
          <i class="fa-solid fa-lock"></i>
        </span>
      </div>

      <!-- Strength bar -->
      <div class="strength-bar-wrap">
        <div class="strength-track">
          <div class="strength-fill" id="strengthFill"></div>
        </div>
        <div class="strength-label" id="strengthLabel"></div>
      </div>

      <!-- Requirements checklist -->
      <div class="requirements" id="requirements">
        <div class="req-title">Password must have</div>
        <div class="req-item" id="req-length">
          <i class="fa-solid fa-circle-xmark"></i> At least 8 characters
        </div>
        <div class="req-item" id="req-upper">
          <i class="fa-solid fa-circle-xmark"></i> One uppercase letter
        </div>
        <div class="req-item" id="req-number">
          <i class="fa-solid fa-circle-xmark"></i> One number
        </div>
        <div class="req-item" id="req-special">
          <i class="fa-solid fa-circle-xmark"></i> One special character
        </div>
      </div>

      <!-- Confirm Password -->
      <div class="field">
        <input type="password" id="confirmPassword" placeholder="Confirm Password" autocomplete="new-password" />
        <span class="icon clickable" id="toggleConfirm">
          <i class="fa-solid fa-lock"></i>
        </span>
      </div>
      <div class="match-hint" id="matchHint"></div>

      <button class="btn-login" id="resetBtn">
        <span id="resetBtnText">Reset Password</span>
      </button>

      <a href="<?= $base ?>/app/views/auth/login.php" class="btn-back">
        <i class="fa-solid fa-arrow-left"></i>
        Back to Login
      </a>

    </div>
  </div>

  <!-- RIGHT: BRANDING -->
  <div class="right">
    <img class="bg" src="<?= $base ?>/public/images/background_login.png" alt="Medical background" />
    <div class="overlay"></div>
    <div class="content">
      <div class="brand">
        <div class="brand-text">
          <h2>Happy Care Clinic</h2>
          <span>TRUSTED MEDICAL CARE</span>
        </div>
        <img src="<?= $base ?>/public/images/logo.png" alt="Happy Care Clinic Logo" />
      </div>
      <div class="hero-text">
        <span class="line line-pink">HEALING WITH</span>
        <span class="line line-cyan">PRECISION,</span>
        <span class="line line-pink">CARING</span>
        <span class="line line-white">WITH HEART</span>
        <p class="hero-sub">
          Your health is our highest priority. Expert care delivered with
          warmth, compassion, and precision.
        </p>
      </div>
    </div>
  </div>

</div>

<script>
  // ── Toggle password visibility ──
  function makeToggle(toggleId, inputId) {
    const toggle = document.getElementById(toggleId);
    const input  = document.getElementById(inputId);
    toggle.addEventListener("click", () => {
      const hidden = input.type === "password";
      input.type = hidden ? "text" : "password";
      toggle.querySelector("i").className = hidden
        ? "fa-solid fa-lock-open"
        : "fa-solid fa-lock";
    });
  }
  makeToggle("togglePwd", "password");
  makeToggle("toggleConfirm", "confirmPassword");

  // ── Password strength ──
  const pwdInput      = document.getElementById("password");
  const strengthFill  = document.getElementById("strengthFill");
  const strengthLabel = document.getElementById("strengthLabel");
  const requirements  = document.getElementById("requirements");

  const reqs = {
    length:  { el: document.getElementById("req-length"),  test: v => v.length >= 8 },
    upper:   { el: document.getElementById("req-upper"),   test: v => /[A-Z]/.test(v) },
    number:  { el: document.getElementById("req-number"),  test: v => /[0-9]/.test(v) },
    special: { el: document.getElementById("req-special"), test: v => /[^A-Za-z0-9]/.test(v) },
  };

  const strengthCfg = [
    { label: "",         color: "",        width: "0%" },
    { label: "Weak",     color: "#ef4444", width: "25%" },
    { label: "Fair",     color: "#f59e0b", width: "50%" },
    { label: "Good",     color: "#3b82f6", width: "75%" },
    { label: "Strong",   color: "#16a34a", width: "100%" },
  ];

  pwdInput.addEventListener("input", () => {
    const val = pwdInput.value;
    requirements.classList.toggle("visible", val.length > 0);

    let score = 0;
    for (const key in reqs) {
      const met = reqs[key].test(val);
      reqs[key].el.classList.toggle("met", met);
      reqs[key].el.querySelector("i").className = met
        ? "fa-solid fa-circle-check"
        : "fa-solid fa-circle-xmark";
      if (met) score++;
    }

    const cfg = strengthCfg[score];
    strengthFill.style.width      = cfg.width;
    strengthFill.style.background = cfg.color;
    strengthLabel.textContent     = cfg.label;
    strengthLabel.style.color     = cfg.color;

    checkMatch();
  });

  // ── Match hint ──
  const confirmInput = document.getElementById("confirmPassword");
  const matchHint    = document.getElementById("matchHint");

  function checkMatch() {
    const p = pwdInput.value;
    const c = confirmInput.value;
    if (!c) { matchHint.textContent = ""; return; }
    if (p === c) {
      matchHint.textContent = "✓ Passwords match";
      matchHint.style.color = "#16a34a";
    } else {
      matchHint.textContent = "✗ Passwords do not match";
      matchHint.style.color = "#ef4444";
    }
  }
  confirmInput.addEventListener("input", checkMatch);

  // ── Submit ──
  const resetBtn     = document.getElementById("resetBtn");
  const resetBtnText = document.getElementById("resetBtnText");
  const formMessage  = document.getElementById("formMessage");

  function showMessage(type, text) {
    formMessage.className = `form-message ${type}`;
    formMessage.textContent = text;
    formMessage.style.display = "block";
  }

  resetBtn.addEventListener("click", () => {
    const p = pwdInput.value;
    const c = confirmInput.value;

    if (!p) { showMessage("error", "Please enter a new password."); return; }

    const allMet = Object.values(reqs).every(r => r.test(p));
    if (!allMet) { showMessage("error", "Password does not meet all requirements."); return; }
    if (p !== c)  { showMessage("error", "Passwords do not match."); return; }

    resetBtnText.textContent = "Resetting...";
    resetBtn.disabled = true;

    // TODO: hook up your Supabase password update here
    setTimeout(() => {
      showMessage("success", "Password reset successfully! Redirecting to login...");
      setTimeout(() => {
        window.location.href = "<?= $base ?>/app/views/auth/login.php";
      }, 2000);
    }, 1500);
  });
</script>
</body>
</html>