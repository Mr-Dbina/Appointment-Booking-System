<?php
$base = "http://localhost/appointment_booking_system";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Happy Care Clinic</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Ponomar&display=swap" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?= $base ?>/public/css/index.css" />
</head>
<body>
  <?php include __DIR__ . '/../shared/nav.html'; ?>
<div class="hero">
  <div class="hero-text">
    <h1>Compassionate care, precise medicine — every patient, every time.</h1>
    <p>Your health is not just our priority — it is our purpose. We deliver trusted medical care with warmth, expertise, and a commitment to your well-being at every step</p>
    <div class="hero-btns">
      <a href="/app/views/users/service.php" class="btn-outline">
        <i class="fa-solid fa-briefcase-medical"></i>
        Clinic Services
      </a>
      <a href="/app/views/users/appointment.php" class="btn-pink">
        <i class="fa-solid fa-calendar-check"></i>
        Book Appointment
      </a>
    </div>
  </div>
  <div class="hero-image-wrap">
    <img src="<?= $base ?>/public/images/checkup.png" alt="Doctor with patient" class="hero-img" />
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
      <img src="<?= $base ?>/public/images/puma.png" alt="Dr. Puma" />
      <div class="doctor-info">
        <div class="name">Dr. Puma</div>
        <div class="spec">M.D., DPCP (Internal Medicine)</div>
      </div>
    </div>
    <div class="doctor-card">
      <img src="<?= $base ?>/public/images/luca.png" alt="Dr. Luca" />
      <div class="doctor-info">
        <div class="name">Dr. Luca</div>
        <div class="spec">M.D., DPBS (Surgery)</div>
      </div>
    </div>
    <div class="doctor-card">
      <img src="<?= $base ?>/public/images/babu.png" alt="Dra. Babu" />
      <div class="doctor-info">
        <div class="name">Dra. Babu</div>
        <div class="spec">M.D., DPOGS (Obstetrics and Gynecology)</div>
      </div>
    </div>
    <div class="doctor-card">
      <img src="<?= $base ?>/public/images/coli.png" alt="Dra. Coli" />
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
    <p>Whether it’s a routine check-up to keep your health on track or an unexpected concern that needs immediate attention, our general medicine team is here for you every step of the way. We take the time to listen carefully to your symptoms, concerns, and questions, ensuring that you feel heard and understood. More than that, we provide care with genuine compassion and dedication, prioritizing your comfort and peace of mind, so you can feel confident and supported throughout your healthcare journey.</p>  <div class="services-grid">
    <div class="service-card bg-1">
      <img src="<?= $base ?>/public/images/obgyn.png" alt="OB-GYN" />
      <div class="service-overlay"></div>
      <div class="service-text">
        <h3>OB-GYN</h3>
        <p>Your body is always changing, and therefore it's important to consider your reproductive well-being. Routine visits to your OB-GYN will allow you to know your body and take action on any health problems that may arise.</p>
      </div>
    </div>
    <div class="service-card bg-2">
      <img src="<?= $base ?>/public/images/general_medicine.png" alt="General Medicine" />
      <div class="service-overlay"></div>
      <div class="service-text">
        <h3>General Medicine</h3>
        <p>Your health can deteriorate overnight, so you need to consider the possibility of surgery when necessary. Surgery is important for treating diseases, preventing problems, and returning you to a healthy state, because acting now may improve your future.</p>
      </div>
    </div>
    <div class="service-card bg-3">
      <img src="<?= $base ?>/public/images/pedia.png" alt="Pediatrics" />
      <div class="service-overlay"></div>
      <div class="service-text">
        <h3>Pediatrics</h3>
        <p>Children's health is constantly evolving, making regular pediatric checkups essential. They help track development, catch issues early, and ensure your child reaches key milestones—because a healthy future starts now.</p>
      </div>
    </div>
    <div class="service-card bg-4">
      <img src="<?= $base ?>/public/images/derma.png" alt="Dermatology" />
      <div class="service-overlay"></div>
      <div class="service-text">
        <h3>Dermatology</h3>
        <p>The condition of your skin represents your general health status. Dermatology examinations enable you to identify any problems that may occur, ensure good skin condition, and feel confident, as proper care of your skin today will benefit you in the future.</p>
      </div>
    </div>
  </div>
</section>

<div class="story" id="about">
  <img src="<?= $base ?>/public/images/clinic.png" alt="Clinic" class="story-img" />
  <div class="story-content">
    <h2>Our Story</h2>
    <p>Happy Care was established to resolve a persistent imbalance in healthcare, where patients are often forced to choose between advanced medical treatment and affordability; the clinic is founded on the principle that quality care must be accessible, evidence-based, and reliable, integrating modern medical technology with patient-centered practices to deliver consistent and safe outcomes, from general consultations and preventive screenings to skin, body, and non-invasive wellness treatments, all under transparent pricing and standardized clinical protocols, ensuring that every service provides measurable value, maintains professional integrity, and upholds the core commitment of Happy Care—to deliver modern, efficient, and compassionate healthcare without compromise.</p>
    <a href="#" class="btn-story">Read More</a>
  </div>
</div>

<?php include __DIR__ . '/../shared/footer.html'; ?>

</body>
</html>