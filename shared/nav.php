<?php
require_once __DIR__ . '/../config.php';
session_start();
?>
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/nav.css"/>
<nav>
  <a href="<?= BASE_URL ?>/users/main.php" class="nav-logo">
    <img src="<?= BASE_URL ?>/public/images/logo.png" />
    <span>Happy Care Clinic</span>
  </a>

  <ul class="nav-links">
    <li><a href="<?= BASE_URL ?>/users/service.php">Services</a></li>
    <li><a href="<?= BASE_URL ?>/users/aboutus.php">About Us</a></li>
    <li><a href="<?= BASE_URL ?>/users/appointment.php">Appointment</a></li>
  </ul>

  <div class="nav-actions">
    <div class="nav-search">
      <div class="search-box">
        <i class="fa-solid fa-magnifying-glass search-icon"></i>
        <input type="text" class="search-input" placeholder="Search...." />
        <i class="fa-solid fa-xmark search-clear"></i>
      </div>
    </div>

    <div class="nav-icon bell-menu-toggle">
      <i class="fa-solid fa-bell"></i>
      <span class="badge" id="notif-badge" style="display:none;"></span>
      <div class="bell-dropdown" id="bell-dropdown">
        <div class="bell-header">
          <span class="bell-title">Notifications</span>
          <span class="bell-count" id="bell-count"></span>
        </div>
        <div class="bell-body" id="bell-body">
          <div class="bell-empty">
            <i class="fa-solid fa-bell-slash"></i>
            <p>No notifications</p>
          </div>
        </div>
      </div>
    </div>

    <div class="nav-icon user-menu-toggle">
      <i class="fa-solid fa-user"></i>
      <div class="user-dropdown">
        <a href="<?= BASE_URL ?>/users/profile.php" class="dropdown-item">
          <i class="fa-solid fa-user"></i> Profile
        </a>
        <a href="<?= BASE_URL ?>/auth/logout.php" class="dropdown-item signout">
          <i class="fa-solid fa-right-from-bracket"></i> Sign out
        </a>
      </div>
    </div>
  </div>
</nav>
<script src="<?= BASE_URL ?>/public/js/nav.js"></script>
