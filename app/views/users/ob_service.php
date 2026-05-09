<?php
$base = "http://localhost/appointment_booking_system";
?>
<link rel="stylesheet" href="<?= $base ?>/public/css/service_service.css" />
<?php include __DIR__ . '/../shared/head.html'; ?>
<?php include __DIR__ . '/../shared/nav.html'; ?>
<a class="back-btn" href="<?= $base ?>/app/views/users/service.php">⮜ Back</a>
<section class="hero" style="background: url('<?= $base ?>/public/images/obygyn_service.png') center/cover no-repeat;">
  <div class="hero-content">
    <h1>OB-GYN</h1>
    <p>
      Our OB-GYN services focus on your reproductive health and well-being.
      From routine check-ups and preventive care to the diagnosis and treatment
      of common conditions, our experienced doctors provide personalized care
      for you and your family.
    </p>
  </div>
</section>
<section class="services-section">
  <h2>Services</h2>
  <div class="carousel-wrapper">
    <div class="carousel-track-container">
      <div class="carousel-track" id="carouselTrack">
        <div class="service-card">
          <div class="card-img-wrap">
            <img src="<?= $base ?>/public/images/parental.png" alt="Prenatal Check-up"/>
            <div class="card-overlay">
              <h3>Prenatal Check-up</h3>
              <p>Comprehensive prenatal care and regular check-ups to monitor the health of both mother and baby throughout pregnancy.</p>
              <span class="card-price">₱500</span>
              <a href="<?= $base ?>/app/views/users/appointment.php" class="btn-learn">Book Appointment</a>
            </div>
          </div>
          <div class="card-label">Prenatal Check-up</div>
        </div>
        <div class="service-card">
          <div class="card-img-wrap">
            <img src="<?= $base ?>/public/images/ultrasound.png" alt="Ultrasound"/>
            <div class="card-overlay">
              <h3>Ultrasound</h3>
              <p>Accurate ultrasound services for pregnancy monitoring, diagnosis, and overall reproductive health assessment.</p>
              <span class="card-price">₱500</span>
              <a href="<?= $base ?>/app/views/users/appointment.php" class="btn-learn">Book Appointment</a>
            </div>
          </div>
          <div class="card-label">Ultrasound</div>
        </div>
        <div class="service-card">
          <div class="card-img-wrap">
            <img src="<?= $base ?>/public/images/fam_plan.png" alt="Family Planning"/>
            <div class="card-overlay">
              <h3>Family Planning</h3>
              <p>Professional family planning consultations and guidance to help you make informed reproductive health decisions.</p>
              <span class="card-price">₱500</span>
              <a href="<?= $base ?>/app/views/users/appointment.php" class="btn-learn">Book Appointment</a>
            </div>
          </div>
          <div class="card-label">Family Planning</div>
        </div>
        <div class="service-card">
          <div class="card-img-wrap">
            <img src="<?= $base ?>/public/images/menstra.png" alt="Menstrual Problems"/>
            <div class="card-overlay">
              <h3>Menstrual Problems Consultation</h3>
              <p>Expert consultations for irregular periods, menstrual pain, hormonal concerns, and reproductive wellness.</p>
              <span class="card-price">₱500</span>
              <a href="<?= $base ?>/app/views/users/appointment.php" class="btn-learn">Book Appointment</a>
            </div>
          </div>
          <div class="card-label">Menstrual Problems Consultation</div>
        </div>
        <div class="service-card">
          <div class="card-img-wrap">
            <img src="<?= $base ?>/public/images/parents.png" alt="Pregnancy Test"/>
            <div class="card-overlay">
              <h3>Pregnancy Test &amp; Monitoring</h3>
              <p>Reliable pregnancy testing and continuous monitoring to ensure a healthy and safe pregnancy journey.</p>
              <span class="card-price">₱500</span>
              <a href="<?= $base ?>/app/views/users/appointment.php" class="btn-learn">Book Appointment</a>
            </div>
          </div>
          <div class="card-label">Pregnancy Test &amp; Monitoring</div>
        </div>
        <div class="service-card">
          <div class="card-img-wrap">
            <img src="<?= $base ?>/public/images/cervics.png" alt="Pap Smear"/>
            <div class="card-overlay">
              <h3>Pap Smear / Cervical Screening</h3>
              <p>Preventive cervical screening services designed to detect abnormalities early and protect women's health.</p>
              <span class="card-price">₱500</span>
              <a href="<?= $base ?>/app/views/users/appointment.php" class="btn-learn">Book Appointment</a>
            </div>
          </div>
          <div class="card-label">Pap Smear / Cervical Screening</div>
        </div>
      </div>
    </div>
<div class="carousel-controls">
  <div class="carousel-dots" id="dotsContainer"></div>
</div>  
  </div>
</section>
<?php include __DIR__ . '/../shared/footer.html'; ?>
<script>const BASE_URL = "<?= $base ?>";</script>
<script src="<?= $base ?>/public/js/service_service.js"></script>