<?php
require_once __DIR__ . '/../config.php';
?>
  <?php include __DIR__ . '/../shared/head.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/index.css" />
  <script>
    (async () => {
      const { createClient } = supabase;
      const db = createClient(
        "https://alvgmydqyffyegcbtsyg.supabase.co",
        "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImFsdmdteWRxeWZmeWVnY2J0c3lnIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzgwNzA0MTcsImV4cCI6MjA5MzY0NjQxN30.7YGzh5EX569NXZhGvrZWh48RUNBYrSagINZQhCePX8k"
      );
      const { data: { session } } = await db.auth.getSession();
      if (!session) {
        window.location.href = "<?= BASE_URL ?>/auth/login.php";
      }
    })();
  </script>
  <?php include __DIR__ . '/../shared/nav.php'; ?>
  <div class="hero">
    <div class="hero-text">
      <h1>Compassionate care, precise medicine — every patient, every time.</h1>
      <p>Your health is not just our priority — it is our purpose. We deliver trusted medical care with warmth, expertise, and a commitment to your well-being at every step</p>
      <div class="hero-btns">
        <a href="<?= BASE_URL ?>/users/service.php" class="btn-outline">
          <i class="fa-solid fa-briefcase-medical"></i>
          Clinic Services
        </a>
        <a href="<?= BASE_URL ?>/users/appointment.php" class="btn-pink">
          <i class="fa-solid fa-calendar-check"></i>
          Book Appointment
        </a>
      </div>
    </div>
    <div class="hero-image-wrap">
      <img src="<?= BASE_URL ?>/public/images/checkk.png" alt="Doctor with patient" class="hero-img" />
      <div class="hero-stats">
        <div class="stat-card">
          <div class="num">400+</div>
          <div class="label">Recover Patient</div>
        </div>
        <div class="stat-card">
          <div class="num">98%</div>
          <div class="label">Satisfied Patient</div>
        </div>
      </div>
    </div>
  </div>
  <section class="doctors" id="doctors">
    <div class="section-header">
      <h2>Meet Our Expert Dogtors</h2>
      <p>Finest Industry Experts</p>
    </div>
    <div class="doctors-grid">
      <div class="doctor-card">
        <img src="<?= BASE_URL ?>/public/images/puma.png" alt="Dr. Puma" />
        <div class="doctor-info">
          <div class="name">Dr. Puma</div>
          <div class="spec">M.D., DPCP (Internal Medicine)</div>
        </div>
      </div>
      <div class="doctor-card">
        <img src="<?= BASE_URL ?>/public/images/luca.png" alt="Dr. Luca" />
        <div class="doctor-info">
          <div class="name">Dr. Luca</div>
          <div class="spec">M.D., DPDS (Dermatology)</div>
        </div>
      </div>
      <div class="doctor-card">
        <img src="<?= BASE_URL ?>/public/images/babu.png" alt="Dra. Babu" />
        <div class="doctor-info">
          <div class="name">Dra. Babu</div>
          <div class="spec">M.D., DPOGS (Obstetrics and Gynecology)</div>
        </div>
      </div>
      <div class="doctor-card">
        <img src="<?= BASE_URL ?>/public/images/coli.png" alt="Dra. Coli" />
        <div class="doctor-info">
          <div class="name">Dra. Coli</div>
          <div class="spec">M.D., DPPS (Pediatrics)</div>
        </div>
      </div>
    </div>
  </section>
<section class="services" id="services">
  <div class="section-header">
    <h2>Our Service</h2>
    <p>Whether it's a routine check-up or an unexpected concern, our general medicine team is here to listen, diagnose, and provide compassionate care—prioritizing your comfort and peace of mind every step of the way.</p>
  </div>
  <a class="back-btn" href="<?= BASE_URL ?>/users/service.php">View Services ⮞</a>
    <div class="services-grid">
        <div class="service-card bg-1">
          <div class="card-img-wrap">
            <img src="<?= BASE_URL ?>/public/images/parental.png" alt="Prenatal Check-up"/>
            <div class="card-overlay">
              <h3>OB-GYN</h3>
                <p>Your body is always changing, and therefore it's important to consider your reproductive well-being. Routine visits to your OB-GYN will allow you to know your body and take action on any health problems that may arise.</p>
                <a href="<?= BASE_URL ?>/users/ob_service.php" class="btn-learn">View Services</a>
            </div>
          </div>
          <div class="card-label">OB-GYN</div>
        </div>
        <div class="service-card bg-2"`>
          <div class="card-img-wrap">
            <img src="<?= BASE_URL ?>/public/images/ultrasound.png" alt="Ultrasound"/>
            <div class="card-overlay">
              <h3>General Medicine</h3>
              <p>Your health can deteriorate overnight, so you need to consider the possibility of surgery when necessary. Surgery is important for treating diseases, preventing problems, and returning you to a healthy state, because acting now may improve your future.</p>
              <a href="<?= BASE_URL ?>/users/gen_service.php" class="btn-learn">View Services</a>
            </div>
          </div>
          <div class="card-label">General Medicine</div>
        </div>
        <div class="service-card bg-3">
          <div class="card-img-wrap">
            <img src="<?= BASE_URL ?>/public/images/fam_plan.png" alt="Family Planning"/>
            <div class="card-overlay">
              <h3>Pediatrics</h3>
              <p>Children's health is constantly evolving, making regular pediatric checkups essential. They help track development, catch issues early, and ensure your child reaches key milestones—because a healthy future starts now.</p>
              <a href="<?= BASE_URL ?>/users/pedia_service.php" class="btn-learn">View Services</a>
            </div>
          </div>
          <div class="card-label">Pediatrics</div>
        </div>
        <div class="service-card bg-4">
          <div class="card-img-wrap">
            <img src="<?= BASE_URL ?>/public/images/menstra.png" alt="Menstrual Problems"/>
            <div class="card-overlay">
              <h3>Dermatology</h3>
              <p>The condition of your skin represents your general health status. Dermatology examinations enable you to identify any problems that may occur, ensure good skin condition, and feel confident, as proper care of your skin today will benefit you in the future.</p>
              <a href="<?= BASE_URL ?>/users/derma_service.php" class="btn-learn">View Services</a>
            </div>
          </div>
          <div class="card-label">Dermatology</div>
        </div>
    </div>
  </section>
  <div class="story" id="about">
    <img src="<?= BASE_URL ?>/public/images/clinic.png" alt="Clinic" class="story-img" />
    <div class="story-content">
      <h2>Our Story</h2>
      <p>Happy Care was established to resolve a persistent imbalance in healthcare, where patients are often forced to choose between advanced medical treatment and affordability; the clinic is founded on the principle that quality care must be accessible, evidence-based, and reliable, integrating modern medical technology with patient-centered practices to deliver consistent and safe outcomes, from general consultations and preventive screenings to skin, body, and non-invasive wellness treatments, all under transparent pricing and standardized clinical protocols, ensuring that every service provides measurable value, maintains professional integrity, and upholds the core commitment of Happy Care—to deliver modern, efficient, and compassionate healthcare without compromise.</p>
      <a href="<?= BASE_URL ?>/users/aboutus.php" class="btn-story">Read More</a>
    </div>
  </div>
  <?php include __DIR__ . '/../shared/footer.php'; ?>
