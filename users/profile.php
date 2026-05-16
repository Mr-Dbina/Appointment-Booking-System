<?php
require_once __DIR__ . '/../config.php';
?>
<?php include __DIR__ . '/../shared/head.php'; ?>
<?php include __DIR__ . '/../shared/nav.php'; ?>
<link rel="stylesheet" href="<?= BASE_URL ?>/public/css/profile.css">

<div class="profile-page">
  <aside class="sidebar">
    <div class="sidebar-banner">
      <div class="sidebar-avatar">
        <i class="fa-solid fa-user"></i>
      </div>
    </div>
    <div class="sidebar-body">
      <p class="sidebar-name" id="sidebarName">Loading…</p>
      <div class="sidebar-divider"></div>

      <div class="sidebar-contact">
        <div class="contact-row">
          <i class="fa-solid fa-envelope"></i>
          <span id="sidebarEmail">—</span>
        </div>
        <div class="contact-row">
          <i class="fa-solid fa-location-dot"></i>
          <span id="sidebarAddress">—</span>
        </div>
        <div class="contact-row">
          <i class="fa-solid fa-phone"></i>
          <span id="sidebarPhone">—</span>
        </div>
      </div>

      <div class="sidebar-divider"></div>

      <div class="sidebar-actions">
        <button class="btn-primary" id="editProfileBtn">
          <i class="fa-solid fa-pen-to-square"></i> Edit Profile
        </button>
      </div>

      <div class="secure-badge">
        <strong><i class="fa-solid fa-shield-halved"></i> Your information is secure</strong>
        <p>We protect your personal data and keep it private.</p>
      </div>
    </div>
  </aside>
  <main class="profile-main">
    <ul class="tab-nav">
      <li class="tab-link active" data-tab="profile-tab">
        <i class="fa-solid fa-user"></i> Profile
      </li>
      <li class="tab-link" data-tab="appointment-tab">
        <i class="fa-solid fa-calendar-check"></i> Appointments
      </li>
      <li class="tab-link" data-tab="payment-tab">
        <i class="fa-solid fa-credit-card"></i> Payments
      </li>
      <li class="tab-link" data-tab="password-tab">
        <i class="fa-solid fa-lock"></i> Password
      </li>
    </ul>

    <div class="tab-pane active" id="profile-tab">
      <h2 class="pane-heading">Profile Information</h2>
      <p class="pane-sub">Manage your personal information and account details.</p>
      <div class="form-grid">
        <div class="form-field">
          <label>First Name</label>
          <input type="text" id="fieldFirstName" readonly>
        </div>
        <div class="form-field">
          <label>Last Name</label>
          <input type="text" id="fieldLastName" readonly>
        </div>
        <div class="form-field">
          <label>Email Address</label>
          <input type="email" id="fieldEmail" readonly>
        </div>
        <div class="form-field">
          <label>Phone <span class="editable-tag">Editable</span></label>
          <input type="text" id="fieldPhone">
        </div>
        <div class="form-field">
          <label>Date of Birth</label>
          <input type="date" id="fieldDob" readonly>
        </div>
        <div class="form-field">
          <label>Sex</label>
          <input type="text" id="fieldSex" readonly>
        </div>
        <div class="form-field">
          <label>Address <span class="editable-tag">Editable</span></label>
          <input type="text" id="fieldAddress">
        </div>
      </div>
      <button class="save-btn" id="profileSaveBtn">Save Changes</button>
    </div>

    <div class="tab-pane" id="appointment-tab">
      <h2 class="pane-heading">Appointment History</h2>
      <p class="pane-sub">Your past and upcoming bookings.</p>
      <div class="empty-state">
        <div class="empty-icon"><i class="fa-solid fa-calendar-xmark"></i></div>
        <h3>No appointments yet</h3>
        <p>You haven't booked any appointments yet. When you do, they'll appear here.</p>
        <button class="btn-primary" onclick="window.location.href='<?= BASE_URL ?>/users/appointment.php'">
          Book an Appointment
        </button>
      </div>
    </div>
    <div class="tab-pane" id="payment-tab">
      <h2 class="pane-heading">Payment History</h2>
      <p class="pane-sub">Review your past transactions.</p>
      <div class="payment-placeholder">
        <i class="fa-solid fa-receipt"></i>
        <h3>No transactions found</h3>
        <p>Your previous transactions will appear here once you've completed a payment.</p>
      </div>
    </div>
    <div class="tab-pane" id="password-tab">
      <h2 class="pane-heading">Change Password</h2>
      <p class="pane-sub">Update your account password regularly to stay secure.</p>
      <div class="password-card">
        <div class="form-field">
          <label>Current Password</label>
          <div class="input-wrap">
            <input type="password" id="cur-pw" placeholder="Enter current password">
            <i class="fa-solid fa-eye toggle-eye" data-target="cur-pw"></i>
          </div>
        </div>
        <div class="form-field">
          <label>New Password</label>
          <div class="input-wrap">
            <input type="password" id="new-pw" placeholder="Enter new password">
            <i class="fa-solid fa-eye toggle-eye" data-target="new-pw"></i>
          </div>
        </div>
        <div class="form-field">
          <label>Confirm New Password</label>
          <div class="input-wrap">
            <input type="password" id="con-pw" placeholder="Confirm new password">
            <i class="fa-solid fa-eye toggle-eye" data-target="con-pw"></i>
          </div>
        </div>
        <button class="save-btn" id="pwSaveBtn">Update Password</button>
      </div>
    </div>

  </main>
</div>

<div class="toast" id="toast">
  <i class="fa-solid fa-circle-check"></i>
  <span id="toast-msg"></span>
</div>

<script>
  var BASE_URL = "<?= BASE_URL ?>";
</script>
<script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
<script src="<?= BASE_URL ?>/public/js/profile.js"></script>
<?php include __DIR__ . '/../shared/footer.php'; ?>