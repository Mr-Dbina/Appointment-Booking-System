<?php
$base = "http://localhost/appointment_booking_system";
?>
  <link rel="stylesheet" href="<?= $base ?>/public/css/aboutus.css"/>
  <?php include __DIR__ . '/../shared/head.html'; ?>
  <?php include __DIR__ . '/../shared/nav.html'; ?>
<div class="hero-banner">
  <div class="brand">
    <img src="<?= $base ?>/public/images/logo.png"/>
    <span>Happy Care Clinic</span>
  </div>
  <h1>At Happy Care Clinic, we believe that medical excellence shouldn't feel clinical. We combine cutting-edge "precise medicine" with a "compassionate care" philosophy to ensure every visit is personal, effective, and stress-free.</h1>
</div>
<section class="mission">
  <div class="mission-text">
    <h2>Our Mission</h2>
    <p>At Happy Care Clinic, we believe that healthcare should be as unique as the patients we serve. Our mission is to bridge the gap between advanced medical science and genuine human connection. We are dedicated to providing personalized healthcare solutions that empower you to live your healthiest, most vibrant life.</p>
    <p>Beyond our state-of-the-art diagnostic tools, Happy Care Clinic is built on a foundation of clinical excellence. Our medical protocols are overseen by our lead specialists, ensuring that every treatment plan from routine check-ups to complex chronic care is backed by the latest evidence-based research and a deep commitment to patient safety.</p>
  </div>
  <div class="mission-img">
    <img src="<?= $base ?>/public/images/missions.png" alt="Doctor with patient" />
  </div>
</section>
<section class="why">
  <div class="why-img">
    <img src="<?= $base ?>/public/images/choose.png" alt="Medical professionals" />
  </div>
  <div class="why-text">
    <h2>Why Choose Us</h2>
    <p>At Happy Care Clinic, we prioritize precision, empathy, and transparency above all else. We understand that navigating healthcare can be overwhelming, which is why we've designed our facilities to be a sanctuary of modern medicine.</p>
    <p>Our team of board-certified professionals utilizes cutting-edge technology to ensure your diagnosis is accurate and your treatment is effective. Plus, our commitment to "compassionate care" means we take the time to listen, explain, and support you at every step of your wellness journey. With Happy Care, you aren't just a patient; you're a partner in health.</p>
  </div>
</section>
<div class="services-section">
  <div class="cards-grid">
    <div class="service-card">
      <div class="icon"><i class="fa-solid fa-user-doctor"></i></div>
      <h3>General Consultation</h3>
      <p>Your first step toward wellness. We provide thorough physical examinations and health screenings to monitor your well-being and identify potential concerns early.</p>
    </div>
    <div class="service-card">
      <div class="icon"><i class="fa-solid fa-heart-pulse"></i></div>
      <h3>Chronic Disease Management</h3>
      <p>Specialized care for long-term health. We create personalized management plans for conditions like hypertension, diabetes, and asthma to help you maintain a high quality of life.</p>
    </div>
    <div class="service-card">
      <div class="icon"><i class="fa-solid fa-baby"></i></div>
      <h3>Pediatric Care</h3>
      <p>Compassionate healthcare for your little ones. From newborn check-ups to childhood immunizations, we ensure your children grow up healthy and strong in a friendly environment.</p>
    </div>
  </div>
  <div class="cards-row2">
    <div class="service-card">
      <div class="icon"><i class="fa-solid fa-shield-heart"></i></div>
      <h3>Preventive Medicine</h3>
      <p>Staying healthy is easier than getting healthy. We offer vaccinations, nutritional counseling, and lifestyle screenings designed to prevent illness before it starts.</p>
    </div>
    <div class="service-card">
      <div class="icon"><i class="fa-solid fa-people-roof"></i></div>
      <h3>Family Medicine</h3>
      <p>Comprehensive care for every member of the family. We pride ourselves on being your long-term health partner, understanding your family medical history to provide better care.</p>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../shared/footer.html'; ?>