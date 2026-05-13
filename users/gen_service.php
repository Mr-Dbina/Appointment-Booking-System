<?php
$base = "http://localhost/appointment_booking_system";
?>
<link rel="stylesheet" href="<?= $base ?>/public/css/service_service.css" />
<?php include __DIR__ . '/../shared/head.php'; ?>
<?php include __DIR__ . '/../shared/nav.php'; ?>
<a class="back-btn" href="<?= $base ?>/users/service.php">⮜ Back</a>
<section class="hero" style="background: url('<?= $base ?>/public/images/gm_service.png') center/cover no-repeat;">
  <div class="hero-content">
    <h1>General Medicine</h1>
    <p>
      Our General Medicine services focus on your overall health and well-being.
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
            <img src="<?= $base ?>/public/images/gen_checkup.jpg" alt="General Check-up"/>
            <div class="card-overlay">
              <h3>General Check-up</h3>
              <p>Routine health assessments and medical consultations to help monitor and maintain your overall well-being.</p>              <span class="card-price">₱500</span>
              <a href="<?= $base ?>/users/appointment.php?service=General+Check-up" class="btn-learn">Book Appointment</a>
            </div>
          </div>
          <div class="card-label">General Check-up</div>
        </div>

        <div class="service-card">
          <div class="card-img-wrap">
            <img src="<?= $base ?>/public/images/vacine.jpg" alt="Vaccination / Immunization"/>
            <div class="card-overlay">
              <h3>Vaccination / Immunization</h3>
              <p>Up-to-date vaccination and immunization services to protect you and your family from preventable diseases.</p>
              <span class="card-price">₱500</span>
              <a href="<?= $base ?>/users/appointment.php?service=Vaccination+%2F+Immunization" class="btn-learn">Book Appointment</a>
            </div>
          </div>
          <div class="card-label">Vaccination / Immunization</div>
        </div>

        <div class="service-card">
          <div class="card-img-wrap">
            <img src="<?= $base ?>/public/images/flu.jpg" alt="Family Planning"/>
            <div class="card-overlay">
              <h3>Fever / Flu Consultation</h3>
              <p>Professional consultation for fever and flu symptoms to ensure proper diagnosis and treatment.</p>
              <span class="card-price">₱500</span>
              <a href="<?= $base ?>/users/appointment.php?service=Fever+%2F+Flu+Consultation" class="btn-learn">Book Appointment</a>
            </div>
          </div>
          <div class="card-label">Fever / Flu Consultation</div>
        </div>

        <div class="service-card">
          <div class="card-img-wrap">
            <img src="<?= $base ?>/public/images/blood.jpg" alt="Blood Pressure Monitoring"/>
            <div class="card-overlay">
              <h3>Blood Pressure Monitoring</h3>
              <p>Regular monitoring of blood pressure to assess cardiovascular health and manage hypertension.</p>
              <span class="card-price">₱500</span>
              <a href="<?= $base ?>/users/appointment.php?service=Blood+Pressure+Monitoring" class="btn-learn">Book Appointment</a>
            </div>
          </div>
          <div class="card-label">Blood Pressure Monitoring</div>
        </div>

        <div class="service-card">
          <div class="card-img-wrap">
            <img src="<?= $base ?>/public/images/diabetes.jpg" alt="Diabetes Screening"/>
            <div class="card-overlay">
              <h3>Diabetes Screening</h3>
              <p>Comprehensive diabetes screening to detect and manage blood sugar levels effectively.</p>
              <span class="card-price">₱500</span>
              <a href="<?= $base ?>/users/appointment.php?service=Diabetes+Screening" class="btn-learn">Book Appointment</a>
            </div>
          </div>
          <div class="card-label">Diabetes Screening</div>
        </div>

        <div class="service-card">
          <div class="card-img-wrap">
            <img src="<?= $base ?>/public/images/med_cert.jpg" alt="Medical Certificate"/>
            <div class="card-overlay">
              <h3>Medical Certificate</h3>
              <p>Issuance of medical certificates for various purposes, including sick leave, academic requirements, and legal documentation.</p>
              <span class="card-price">₱500</span>
              <a href="<?= $base ?>/users/appointment.php?service=Medical+Certificate" class="btn-learn">Book Appointment</a>
            </div>
          </div>
          <div class="card-label">Medical Certificate</div>
        </div>

                <div class="service-card">
          <div class="card-img-wrap">
            <img src="<?= $base ?>/public/images/follow.jpg" alt="Follow-up Consultation"/>
            <div class="card-overlay">
              <h3>Follow-up Consultation</h3>
              <p>Follow-up consultations for ongoing health management and treatment adjustments.</p>
              <span class="card-price">₱500</span>
              <a href="<?= $base ?>/users/appointment.php?service=Follow-up+Consultation" class="btn-learn">Book Appointment</a>
            </div>
          </div>
          <div class="card-label">Follow-up Consultation</div>
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