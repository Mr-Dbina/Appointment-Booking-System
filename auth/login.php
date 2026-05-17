<?php
require_once __DIR__ . '/../config.php';
?>
  <?php include __DIR__ . '/../shared/head.php'; ?>
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/login.css">
<body>
<div class="page">
  <div class="left">
    <div class="card">
      <p class="welcome">Welcome Back</p>
      <h1>Sign in to your<br>patient portal</h1>
      <p class="sub">Access records, appointment &amp; more</p>

      <div id="formMessage" class="form-message"></div>
      
      <div class="field">
        <input type="email" id="email" placeholder="Email Address" autocomplete="email">
      </div>
      <div class="field">
        <input type="password" id="password" placeholder="Password" autocomplete="current-password">
        <span class="icon clickable" id="togglePwd">
          <i class="fa-solid fa-eye" id="eyeIcon"></i>
        </span>
      </div>
      <div class="row-mid">
        <label><input type="checkbox" id="keepLoggedIn"> Keep me logged in</label>
        <a href="forgot.php">Forgot Password?</a>
      </div>

<button class="btn-login" id="loginBtn">
  <span id="loginBtnText">Log in</span>
</button>

      <div class="divider"></div>

      <p class="register">
        Not Registered Yet?
        <a href="<?= BASE_URL ?>/auth/register.php">Create an account</a>
      </p>
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

<script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
<script>var BASE_URL = "<?= BASE_URL ?>";</script>
<script src="<?= BASE_URL ?>/public/js/lock.js"></script>
<script src="<?= BASE_URL ?>/public/js/login.js"></script>

