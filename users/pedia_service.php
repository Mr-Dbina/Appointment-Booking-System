<?php
require_once __DIR__ . '/../config.php';
?>
<link rel="stylesheet" href="<?= BASE_URL ?>/public/css/service_service.css"/>
<?php include __DIR__ . '/../shared/head.php'; ?>
<?php include __DIR__ . '/../shared/nav.php'; ?>
<a class="back-btn" href="<?= BASE_URL ?>/users/service.php">⮜ Back</a>
<section class="hero" style="background: url('<?= BASE_URL ?>/public/images/pedia_service.png') center/cover no-repeat;">
  <div class="hero-content">
    <h1>Pediatrics</h1>
    <p>
      Our pediatrics services focus on the health and well-being of children from infancy through adolescence.
      From routine check-ups and preventive care to the diagnosis and treatment
      of common conditions, our experienced doctors provide personalized care
      for you and your family.
    </p>
  </div>
</section>
<section class="services-section">
  <h2>Services</h2>
  <div class="carousel-wrapper">
    <button class="carousel-arrow carousel-prev" id="prevBtn">
      <i class="fa-solid fa-chevron-left"></i>
    </button>
    <button class="carousel-arrow carousel-next" id="nextBtn">
      <i class="fa-solid fa-chevron-right"></i>
    </button>
    <div class="carousel-track-container">
      <div class="carousel-track" id="carouselTrack">
        <div class="service-card">
          <div class="card-img-wrap">
            <img src="<?= BASE_URL ?>/public/images/development.jpg" alt="Growth & Development Monitoring"/>
            <div class="card-overlay">
              <h3>Growth &amp; Development Monitoring</h3>
              <p>Regular check-ups to monitor a child’s growth, development, and overall health at every stage.</p>              <span class="card-price">₱500</span>
              <a href="<?= BASE_URL ?>/users/appointment.php?service=Growth+%26+Development+Monitoring" class="btn-learn">Book Appointment</a>
            </div>
          </div>
          <div class="card-label">Growth & Development Monitoring</div>
        </div>
        <div class="service-card">
          <div class="card-img-wrap">
            <img src="<?= BASE_URL ?>/public/images/nutrition.jpg" alt="Nutrition Consultation"/>
            <div class="card-overlay">
              <h3>Nutrition Consultation</h3>
              <p>Personalized nutrition advice and guidance to support healthy growth and development.</p>
              <span class="card-price">₱500</span>
              <a href="<?= BASE_URL ?>/users/appointment.php?service=Nutrition+Consultation" class="btn-learn">Book Appointment</a>
            </div>
          </div>
          <div class="card-label">Nutrition Consultation</div>
        </div>
        <div class="service-card">
          <div class="card-img-wrap">
            <img src="<?= BASE_URL ?>/public/images/new_born.jpg" alt="Newborn Care"/>
            <div class="card-overlay">
              <h3>Newborn Care</h3>
              <p>Comprehensive care and guidance for new parents to ensure the health and well-being of their newborns.</p>
              <span class="card-price">₱500</span>
              <a href="<?= BASE_URL ?>/users/appointment.php?service=Newborn+Care" class="btn-learn">Book Appointment</a>
            </div>
          </div>
          <div class="card-label">Newborn Care</div>
        </div>
        <div class="service-card">
          <div class="card-img-wrap">
            <img src="<?= BASE_URL ?>/public/images/fever.jpg" alt="Fever / Cough Consultation"/>
            <div class="card-overlay">
              <h3>Fever / Cough Consultation</h3>
              <p>Expert consultations for fever and cough symptoms in children.</p>
              <span class="card-price">₱500</span>
              <a href="<?= BASE_URL ?>/users/appointment.php?service=Fever+%2F+Cough+Consultation" class="btn-learn">Book Appointment</a>
            </div>
          </div>
          <div class="card-label">Fever / Cough Consultation</div>
        </div>
      </div>
    </div>
<div class="carousel-controls">
  <div class="carousel-dots" id="dotsContainer"></div>
</div>  
  </div>
</section>
<?php include __DIR__ . '/../shared/footer.php'; ?>
<script src="<?= BASE_URL ?>/public/js/service_service.js"></script>