<?php
$base = "http://localhost/appointment_booking_system";
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Happy Care Clinic System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $base; ?>/public/css/profile.css">
</head>
<body>

<div id="toast-container"></div>
<button id="backToTop" title="Back to top"><i class="fa-solid fa-arrow-up"></i></button>

<div class="search-overlay" id="searchOverlay">
  <div class="search-box">
    <div class="search-input-row">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="text" id="overlaySearchInput" placeholder="Search services (e.g. Acne, Prenatal, Check-up)…" autocomplete="off">
      <button onclick="closeSearch()"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="search-results" id="overlayResults"></div>
  </div>
</div>

<nav>
  <div class="logo" onclick="window.scrollTo({top:0,behavior:'smooth'})">
    <div class="logo-icon"><i class="fa-solid fa-plus"></i></div>
    Happy Care Clinic
  </div>
  <ul class="nav-links">
    <li><a href="#" id="nav-services-link" class="active">Service</a></li>
    <li><a href="#">About Us</a></li>
    <li><a href="#">Doctors</a></li>
  </ul>
  <div class="nav-right">
    <button class="nav-icon-btn" id="searchBtn" title="Search services"><i class="fa-solid fa-magnifying-glass"></i></button>
    <button class="nav-icon-btn" title="Notifications">
      <i class="fa-regular fa-bell"></i>
      <span class="notif-badge">1</span>
    </button>
    <div class="nav-avatar" id="nav-profile-btn" title="My Profile">CD</div>
  </div>
</nav>

<div id="services-view">
  <div class="hero">
    <h1>Our <span>Services</span></h1>
    <p>Whether it's a routine check-up or an unexpected concern, our expert team is always here — listening carefully, diagnosing accurately, and caring genuinely for your health.</p>
    <div class="stats-row">
      <div class="stat-item"><div class="stat-num" data-count="4">0</div><div class="stat-label">Specialties</div></div>
      <div class="stat-item"><div class="stat-num" data-count="24">0</div><div class="stat-label">Services Offered</div></div>
      <div class="stat-item"><div class="stat-num" data-count="400">0</div><div class="stat-label">Patients Served</div></div>
      <div class="stat-item"><div class="stat-num" data-count="98">0</div><div class="stat-label">% Satisfaction Rate</div></div>
    </div>
  </div>

  <div class="filter-bar">
    <button class="filter-btn active" data-filter="all">
      <i class="fa-solid fa-th-large"></i> All Services
    </button>
    <button class="filter-btn" data-filter="obgyn">
      <i class="fa-solid fa-venus"></i> OB-GYN
    </button>
    <button class="filter-btn" data-filter="genmed">
      <i class="fa-solid fa-stethoscope"></i> General Medicine
    </button>
    <button class="filter-btn" data-filter="peds">
      <i class="fa-solid fa-baby"></i> Pediatrics
    </button>
    <button class="filter-btn" data-filter="derm">
      <i class="fa-solid fa-spa"></i> Dermatology
    </button>
    <div class="search-inline">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="text" id="inlineSearch" placeholder="Search services…">
    </div>
  </div>

  <div class="services-wrapper" id="servicesWrapper">
    </div>
</div>

<div id="profile-view" style="display: none;">
  <div class="profile-dashboard">
    <aside class="profile-sidebar">
      <div class="profile-avatar">
        <div class="avatar-circle"></div>
      </div>
      <div class="user-details">
        <h2>Christian Nickhos A. Divina</h2>
        <span class="user-role">Patient</span>
      </div>
      <div class="user-contact">
        <p><i class="fa-solid fa-envelope"></i> christiandivina2316@gmail.com</p>
        <p><i class="fa-solid fa-location-dot"></i> Legazpi City, Albay</p>
      </div>
      <div class="sidebar-actions">
        <button class="btn-profile-primary edit-profile">Edit Profile</button>
        <button class="btn-profile-secondary logout">Logout</button>
      </div>
      <div class="security-badge">
        <i class="fa-solid fa-shield-halved"></i>
        <div>
          <strong>Your information is secure</strong>
          <p>We protect your personal data and keep it private.</p>
        </div>
      </div>
    </aside>

    <main class="profile-content">
      <div class="tabs-container">
        <ul class="profile-tabs">
          <li class="tab-link active" data-tab="appointment-history">Appointment History</li>
          <li class="tab-link" data-tab="payment-history">Payment History</li>
          <li class="tab-link" data-tab="change-password">Change Password</li>
        </ul>
      </div>

      <div id="appointment-history" class="tab-pane active">
        <div class="empty-state">
          <div class="calendar-illustration">📅 ❌</div>
          <h3>No appointment history</h3>
          <p>You haven't booked any appointments yet.<br>When you do, they will appear here.</p>
          <button class="btn-profile-primary jump-to-services">Book an Appointment</button>
        </div>
      </div>

      <div id="payment-history" class="tab-pane">
        <h3>Payment History</h3>
        <p>Your previous transactions will appear here.</p>
      </div>

      <div id="change-password" class="tab-pane">
        <h3>Change Password</h3>
        <p>Password update form goes here.</p>
      </div>
    </main>
  </div>
</div>

<div class="modal-overlay" id="bookingModal">
  <div class="modal-box">
    <div id="bookingForm">
      <div class="modal-header">
        <div>
          <div class="modal-tag pink" id="modal-dept-tag">OB-GYN</div>
          <h3 id="modal-service-title">Prenatal Check-up</h3>
        </div>
        <button class="modal-close" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button>
      </div>

      <div class="form-group">
        <label class="form-label">Full Name *</label>
        <input class="form-input" id="bk-name" placeholder="e.g. Juan dela Cruz" value="Christian Nickhos A. Divina">
        <div class="form-error" id="err-name">Full name is required.</div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Date *</label>
          <input type="date" class="form-input" id="bk-date">
          <div class="form-error" id="err-date">Please select a date.</div>
        </div>
        <div class="form-group">
          <label class="form-label">Time Slot *</label>
          <select class="form-select" id="bk-time">
            <option value="">-- Select --</option>
            <option>8:00 AM</option>
            <option>9:00 AM</option>
            <option>10:00 AM</option>
            <option>11:00 AM</option>
            <option>1:00 PM</option>
            <option>2:00 PM</option>
            <option>3:00 PM</option>
            <option>4:00 PM</option>
          </select>
          <div class="form-error" id="err-time">Please select a time slot.</div>
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Contact Number *</label>
        <input class="form-input" id="bk-phone" placeholder="+63 9XX XXX XXXX">
        <div class="form-error" id="err-phone">Enter a valid phone number.</div>
      </div>
      <div class="form-group">
        <label class="form-label">Notes / Concerns (optional)</label>
        <input class="form-input" id="bk-notes" placeholder="Briefly describe your concern…">
      </div>

      <button class="btn-submit" id="submitBookingBtn">
        <i class="fa-regular fa-calendar-plus"></i> Confirm Appointment
      </button>
    </div>

    <div class="booking-success" id="bookingSuccess">
      <div class="success-circle"><i class="fa-solid fa-check"></i></div>
      <h3>Appointment Requested!</h3>
      <p>Your appointment for <strong id="success-service"></strong> has been submitted. Our staff will confirm your schedule shortly.</p>
      <div class="ref" id="success-ref">REF-XXXXXXX</div>
      <button class="btn-submit" onclick="closeModal()">
        <i class="fa-solid fa-arrow-left"></i> Back to Services
      </button>
    </div>
  </div>
</div>

<footer>
  <div class="footer-grid">
    <div class="footer-col">
      <h4>Quick Links</h4>
      <a href="#" class="jump-to-services">Services</a>
      <a href="#">About Us</a>
      <a href="#">Doctors</a>
    </div>
    <div class="footer-col">
      <h4>Services</h4>
      <a href="#" data-filter-link="obgyn">OB-GYN</a>
      <a href="#" data-filter-link="peds">Pediatrics</a>
      <a href="#" data-filter-link="genmed">General Medicine</a>
      <a href="#" data-filter-link="derm">Dermatology</a>
    </div>
    <div class="footer-col">
      <h4>Help</h4>
      <a href="#">No Show Policy</a>
      <a href="#">Data Privacy</a>
      <a href="#">FAQs</a>
    </div>
    <div class="footer-col">
      <h4>Follow Us</h4>
      <div class="social-row">
        <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="#"><i class="fa-brands fa-instagram"></i></a>
        <a href="#"><i class="fa-brands fa-twitter"></i></a>
        <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="footer-logo">
      <div class="logo-icon"><i class="fa-solid fa-plus"></i></div>
      Happy Care Clinic
    </div>
    <div class="footer-copy">© 2025 Happy Care Clinic. All rights reserved.</div>
  </div>
</footer>

<script src="script.js"></script>
</body>
</html>