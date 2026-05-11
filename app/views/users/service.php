<?php
$base = "http://localhost/appointment_booking_system";
?>
  <link rel="stylesheet" href="<?= $base ?>/public/css/services.css" />
  <?php include __DIR__ . '/../shared/head.php'; ?>
  <?php include __DIR__ . '/../shared/nav.php'; ?>
<div class="hero-banner">
  <h1>Our Services</h1>
  <p>It doesn't matter if you're getting your usual physical or if you have some issue that you need help with – our general medical doctors are always there, ready to listen, diagnose and help. Our mission is early diagnosis and treatment so we can make sure you remain in peak condition.</p>
</div>
<div class="services-list">
  <div class="service-card bg-obgyn">
    <img src="<?= $base ?>/public/images/obygyn_service.png" alt="OB-GYN" />
    <div class="service-overlay"></div>
    <div class="service-body">
      <h2>OBY-GYN</h2>
      <p>An OB-GYN consultation provides care for women's reproductive health, including check-ups, pregnancy care, family planning, and screenings. It also diagnoses and treats menstrual issues, infections, and hormonal concerns while promoting preventive care and overall well-being.</p>
         <a href="<?= $base ?>/app/views/users/ob_service.php" class="btn-book">Explore Now </a>
    </div>
  </div>
  <div class="service-card bg-general">
    <img src="<?= $base ?>/public/images/gm_service.png" alt="General Medicine" />
    <div class="service-overlay"></div>
    <div class="service-body">
      <h2>General Medicine</h2>
      <p>The general medicine visit is concerned with the wellbeing of the individual as a whole. The general medicine visit involves regular health checks for adults, the diagnosis of common diseases, and treatment. Early detection of illness, symptom management, and proper medication usage and care are ensured by a general medicine visit.</p>
         <a href="<?= $base ?>/app/views/users/gen_service.php" class="btn-book">Explore Now </a>
    </div>
  </div>
  <div class="service-card bg-pediatrics">
    <img src="<?= $base ?>/public/images/pedia_service.png" alt="Pediatrics" />
    <div class="service-overlay"></div>
    <div class="service-body">
      <h2>Pediatrics</h2>
      <p>A pediatric consultation focuses on a child's overall health and development, including routine check-ups, growth monitoring, vaccinations, and early detection of illnesses. It helps address common childhood conditions, developmental concerns, and provides guidance on nutrition and care. Overall, it ensures children grow healthy, strong, and on track developmentally.</p>
      <a href="<?= $base ?>/app/views/users/pedia_service.php" class="btn-book">Explore Now </a>
    </div>
  </div>
  <div class="service-card bg-derma">
    <img src="<?= $base ?>/public/images/derma_service.png" alt="Dermatology" />
    <div class="service-overlay"></div>
    <div class="service-body">
      <h2>Dermatology</h2>
      <p>A dermatology consultation focuses on skin, hair, and nail health, providing diagnosis and treatment for conditions like acne, rashes, infections, and other skin concerns. It also includes preventive care, skin assessments, and personalized treatment plans. Overall, it helps maintain healthy, clear, and confident skin.</p>
         <a href="<?= $base ?>/app/views/users/derma_service.php" class="btn-book">Explore Now </a>
    </div>
  </div>
</div>
  <?php include __DIR__ . '/../shared/footer.php'; ?>
