<?php
$base = "http://localhost/appointment_booking_system";
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Happy Care Clinic – Patient Portal</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Ponomar&display=swap" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?= $base ?>/public/css/login.css">
</head>
<body>
<div class="page">
  <div class="left">
    <div class="card">
      <p class="welcome">Welcome Back</p>
      <h1>Sign in to your<br>patient portal</h1>
      <p class="sub">Access records, appointment & more</p>
      <div class="field">
        <input type="email" id="email" placeholder="Email Address" autocomplete="email">
      </div>
      <div class="field">
        <input type="password" id="password" placeholder="Password" autocomplete="current-password">
        <span class="icon" id="togglePwd">
          <i class="fa-solid fa-lock"></i>
        </span>
      </div>
      <div class="row-mid">
        <label><input type="checkbox"> Keep me logged in</label>
        <a href="forgot.php">Forgot Password?</a>
      </div>
      <button class="btn-login"><span>Log in</span></button>
      <div class="divider"></div>
      <p class="register">
        Not Registered Yet?
        <a href="<?php echo $base; ?>/app/views/auth/register.php">
          Create an account
        </a>
      </p>
    </div>
  </div>
  <div class="right">
    <img class="bg"
      src="<?php echo $base; ?>/public/images/background_login.png"
      alt="Medical background">
    <div class="overlay"></div>
    <div class="content">
      <div class="brand">
        <div class="brand-text">
          <h2>Happy Care Clinic</h2>
          <span>TRUSTED MEDICAL CARE</span>
        </div>
        <img src="<?php echo $base; ?>/public/images/logo.png" alt="Logo">
      </div>
      <div class="hero-text">
        <span class="line line-pink">HEALING WITH</span>
        <span class="line line-cyan">PRECISION,</span>
        <span class="line line-pink">CARING</span>
        <span class="line line-white">WITH HEART</span>
        <p class="hero-sub">
          Your health is our highest priority. Expert care delivered with warmth, compassion, and precision.
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