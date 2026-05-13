<?php
$base = "http://localhost/appointment_booking_system";
?>
<link rel="stylesheet" href="<?= $base ?>/public/css/service_service.css" />
<?php include __DIR__ . '/../shared/head.php'; ?>
<?php include __DIR__ . '/../shared/nav.php'; ?>
<a class="back-btn" href="<?= $base ?>/users/service.php">⮜ Back</a>
<section class="hero" style="background: url('<?= $base ?>/public/images/derma_service.png') center/cover no-repeat;">
  <div class="hero-content">
    <h1>Dermatology</h1>
    <p>
      Our Derma services focus on your skin health and well-being.
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
            <img src="<?= $base ?>/public/images/pimple.jpg" alt="Acne Treatment"/>
            <div class="card-overlay">
              <h3>Acne Treatment</h3>
              <p>Effective treatment for various types of acne, including mild, moderate, and severe cases.</p>
              <span class="card-price">₱500</span>
              <a href="<?= $base ?>/users/appointment.php?service=Acne+Treatment" class="btn-learn">Book Appointment</a>
            </div>
          </div>
          <div class="card-label">Acne Treatment</div>
        </div>
        <div class="service-card">
          <div class="card-img-wrap">
            <img src="<?= $base ?>/public/images/skin_consult.jpg" alt="Skin Consultation"/>
            <div class="card-overlay">
              <h3>Skin Consultation</h3>
              <p>Professional skin assessments and consultations to help diagnose and treat common skin concerns.</p>              <span class="card-price">₱500</span>
              <a href="<?= $base ?>/users/appointment.php?service=Skin+Consultation" class="btn-learn">Book Appointment</a>
            </div>
          </div>
          <div class="card-label">Skin Consultation</div>
        </div>
        <div class="service-card">
          <div class="card-img-wrap">
            <img src="<?= $base ?>/public/images/rash.jpg" alt="Allergy / Rash Treatment"/>
            <div class="card-overlay">
              <h3>Allergy / Rash Treatment</h3>
              <p>Professional treatment for various skin allergies and rashes to provide relief and promote healing.</p>
              <span class="card-price">₱500</span>
              <a href="<?= $base ?>/users/appointment.php?service=Allergy+%2F+Rash+Treatment" class="btn-learn">Book Appointment</a>
            </div>
          </div>
          <div class="card-label">Allergy / Rash Treatment</div>
        </div>
        <div class="service-card">
          <div class="card-img-wrap">
            <img src="<?= $base ?>/public/images/psoriasis.jpg" alt="Eczema & Psoriasis Care"/>
            <div class="card-overlay">
              <h3>Eczema &amp; Psoriasis Care</h3>
              <p>Specialized care and treatment to help manage eczema, psoriasis, and other chronic skin conditions.</p>              <span class="card-price">₱500</span>
              <a href="<?= $base ?>/users/appointment.php?service=Eczema+%26+Psoriasis+Care" class="btn-learn">Book Appointment</a>
            </div>
          </div>
          <div class="card-label">Eczema & Psoriasis Care</div>
        </div>
        <div class="service-card">
          <div class="card-img-wrap">
            <img src="<?= $base ?>/public/images/wart.jpg" alt="Wart / Mole Removal"/>
            <div class="card-overlay">
              <h3>Wart / Mole Removal</h3>
              <p>Effective removal of warts and moles for cosmetic and health reasons.</p>
              <span class="card-price">₱500</span>
              <a href="<?= $base ?>/users/appointment.php?service=Wart+%2F+Mole+Removal" class="btn-learn">Book Appointment</a>
            </div>
          </div>
          <div class="card-label">Wart / Mole Removal</div>
        </div>
        <div class="service-card">
          <div class="card-img-wrap">
            <img src="<?= $base ?>/public/images/cehemical_peel.jpg" alt="Chemical Peel / Facial Treatments"/>
            <div class="card-overlay">
              <h3>Chemical Peel / Facial Treatments</h3>
              <p>Enhance your skin's appearance with our professional chemical peel and facial treatment options.</p>
              <span class="card-price">₱500</span>
              <a href="<?= $base ?>/users/appointment.php?service=Chemical+Peel+%2F+Facial+Treatments" class="btn-learn">Book Appointment</a>
            </div>
          </div>
          <div class="card-label">Chemical Peel / Facial Treatments</div>
        </div>
                <div class="service-card">
          <div class="card-img-wrap">
            <img src="<?= $base ?>/public/images/hair.jpg" alt="Hair Loss Treatment"/>
            <div class="card-overlay">
              <h3>Hair Loss Treatment</h3>
              <p>Specialized treatment for hair loss to help restore and maintain healthy hair.</p>
              <span class="card-price">₱500</span>
              <a href="<?= $base ?>/users/appointment.php?service=Hair+Loss+Treatment" class="btn-learn">Book Appointment</a>
            </div>
          </div>
          <div class="card-label">Hair Loss Treatment</div>
        </div>
      </div>
    </div>
<div class="carousel-controls">
  <div class="carousel-dots" id="dotsContainer"></div>
</div>  
  </div>
</section>
<?php include __DIR__ . '/../shared/footer.php'; ?>
<script>const BASE_URL = "<?= $base ?>";</script>
<script src="<?= $base ?>/public/js/service_service.js"></script>