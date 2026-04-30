<?php
$base = "http://localhost/appointment_booking_system";
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Happy Care Clinic – Patient Registration</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link
      href="https://fonts.googleapis.com/css2?family=Ponomar&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
      rel="stylesheet"
    />
  <link rel="stylesheet" href="<?= $base ?>/public/css/register.css">
  </head>
  <body>
    <div class="page">
      <div class="left">
        <div class="card">
          <p class="welcome">Create Account</p>
          <h1>Patient Registration</h1>
          <p class="sub">fill in your details to get started</p>
          <div class="field-row">
            <div class="field">
              <input
                type="text"
                placeholder="First Name"
                autocomplete="given-name"
              />
            </div>
            <div class="field">
              <input
                type="text"
                placeholder="Last Name"
                autocomplete="family-name"
              />
            </div>
          </div>
          <div class="field">
            <input
              type="email"
              id="email"
              placeholder="Email Address"
              autocomplete="email"
            />
          </div>
          <div class="field">
            <input type="tel" placeholder="Phone Number" autocomplete="tel" />
          </div>
          <div class="field-row">
            <div class="field">
              <input type="date" id="dob" />
              <span class="icon"
                ><i class="fa-solid fa-calendar-days"></i
              ></span>
            </div>
            <div class="field">
              <select
                id="sex"
                class="unselected"
                onchange="this.classList.remove('unselected')"
              >
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>
              <span class="icon"><i class="fa-solid fa-chevron-down"></i></span>
            </div>
          </div>
          <div class="field">
            <input
              type="password"
              id="password"
              placeholder="Password"
              autocomplete="new-password"
            />
            <span class="icon clickable" id="togglePwd">
              <i class="fa-solid fa-lock"></i>
            </span>
          </div>
          <div class="terms-row">
            <input type="checkbox" id="terms" />
            <label for="terms">
              I agree to the <a href="#">Terms of Service</a> and
              <a href="#">Privacy Policy</a> of Happy Care Clinic.
            </label>
          </div>
          <div class="divider"></div>
          <button class="btn-register"><span>Register</span></button>
          <p class="signin">
            Already have account?
            <a href="<?= $base ?>/app/views/auth/login.php">Sign in here</a>
          </p>
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
      const dobInput = document.getElementById("dob");
      dobInput.addEventListener("focus", () => {
        if (!dobInput.value) dobInput.type = "date";
      });
    </script>
  </body>
</html>
