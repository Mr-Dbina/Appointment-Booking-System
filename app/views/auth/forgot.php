<?php
$base = "http://localhost/appointment_booking_system";
?>

  <link href="<?= $base ?>/public/css/login.css" rel="stylesheet" />
  <include __DIR__ . '/../shared/head.html'; ?>
  <body>
    <div class="page">
      <!-- LEFT: FORM -->
      <div class="left">
        <div class="card">
          <p class="welcome">Account Recovery</p>
          <h1>Don’t worry,<br />we’ve got you covered</h1>
          <p class="sub">We’ll guide you through resetting your password</p>
          <div class="field">
            <input type="password" id="password" placeholder="New Password" autocomplete="new-password"/>
          </div>
          <div class="field">
            <input type="password" id="confirmPassword" placeholder="Confirm Password" autocomplete="confirm-password"/>
          </div>
          <button class="btn-login"><span>Reset Password</span></button>
          <div class="divider"></div>
        </div>
      </div>
      <div class="right">
        <img
          class="bg"
          src="<?= $base ?>/public/images/background_login.png"
          alt="Medical background"
        />
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
      const togglePwd = document.getElementById("togglePwd");
      const pwdInput = document.getElementById("password");
      togglePwd.addEventListener("click", () => {
        const isHidden = pwdInput.type === "password";
        pwdInput.type = isHidden ? "text" : "password";
        togglePwd.innerHTML = isHidden
          ? '<i class="fa-solid fa-lock-open"></i>'
          : '<i class="fa-solid fa-lock"></i>';
      });
    </script>
  </body>
</html>
