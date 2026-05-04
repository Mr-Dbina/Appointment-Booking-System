<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Services — Happy Care Clinic</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Ponomar&display=swap" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --pink: #f0437a;
      --pink-light: #fce8ef;
      --blue-light: #d6eaf8;
      --teal: #5bb8c4;
      --dark: #1a1a2e;
      --gray: #6b7280;
    }

    html { scroll-behavior: smooth; }
    body { font-family: 'Ponomar', serif; color: var(--dark); background: #fff; overflow-x: hidden; }

    /* ── NAV ── */
    nav {
      display: flex; align-items: center; justify-content: space-between;
      padding: 0 48px; height: 70px;
      background: #fff;
      box-shadow: 0 1px 0 rgba(0,0,0,0.08);
      position: sticky; top: 0; z-index: 100;
    }
    .nav-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
    .nav-logo svg { width: 40px; height: 40px; }
    .nav-logo span { font-size: 1.15rem; color: var(--pink); }
    .nav-links { display: flex; gap: 36px; list-style: none; }
    .nav-links a { text-decoration: none; color: var(--dark); font-size: 0.95rem; transition: color .2s; }
    .nav-links a:hover, .nav-links a.active { color: var(--pink); }
    .nav-actions { display: flex; align-items: center; gap: 16px; }
    .nav-actions > a { text-decoration: none; color: var(--dark); font-size: 0.95rem; }
    .nav-icon {
      width: 36px; height: 36px; border-radius: 50%; background: #f4f4f4;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; position: relative; color: var(--dark); font-size: 0.88rem;
    }
    .nav-icon .badge {
      position: absolute; top: 4px; right: 4px;
      width: 8px; height: 8px; background: var(--pink); border-radius: 50%; border: 1.5px solid #fff;
    }

    /* ── HERO BANNER ── */
    .hero-banner {
      background: linear-gradient(135deg, #d6eaf8 0%, #fce8ef 100%);
      padding: 60px 48px 70px;
      text-align: center;
      border-radius: 0 0 24px 24px;
      margin: 16px 16px 0;
    }
    .hero-banner h1 {
      font-size: clamp(1.8rem, 3vw, 2.5rem);
      margin-bottom: 24px;
      color: var(--dark);
    }
    .hero-banner p {
      font-size: clamp(0.9rem, 1.4vw, 1rem);
      line-height: 1.7;
      color: var(--dark);
      max-width: 700px;
      margin: 0 auto;
    }

    /* ── SERVICES LIST ── */
    .services-list {
      padding: 48px 16px 80px;
      background: linear-gradient(180deg, #fce8ef 0%, #d6eaf8 50%, #fce8ef 100%);
      display: flex;
      flex-direction: column;
      gap: 24px;
    }

    /* ── SERVICE CARD ── */
    .service-card {
      border-radius: 20px;
      overflow: hidden;
      position: relative;
      min-height: 260px;
      display: flex;
      align-items: flex-end;
      cursor: pointer;
      box-shadow: 0 4px 24px rgba(0,0,0,0.12);
      transition: transform .3s, box-shadow .3s;
      /* fallback gradient backgrounds */
    }
    .service-card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(0,0,0,0.18); }

    .service-card.bg-obgyn     { background: linear-gradient(135deg, #2c3e50, #5a4a6a); }
    .service-card.bg-general   { background: linear-gradient(135deg, #1a3a5c, #2d6a9f); }
    .service-card.bg-pediatrics { background: linear-gradient(135deg, #2c3a50, #3a5a7a); }
    .service-card.bg-derma     { background: linear-gradient(135deg, #2c3545, #4a5a7a); }

    .service-card img {
      position: absolute; inset: 0;
      width: 100%; height: 100%;
      object-fit: cover; display: block;
    }
    /* dark overlay: left heavy so text stays readable */
    .service-overlay {
      position: absolute; inset: 0;
      background: linear-gradient(to right, rgba(10,10,30,0.82) 0%, rgba(10,10,30,0.55) 45%, rgba(10,10,30,0.15) 100%);
      z-index: 1;
    }

    .service-body {
      position: relative; z-index: 2;
      padding: 36px 40px 40px;
      max-width: 54%;
      color: #fff;
    }
    .service-body h2 {
      font-size: clamp(1.4rem, 2.5vw, 2rem);
      margin-bottom: 14px;
      line-height: 1.2;
    }
    .service-body p {
      font-size: 0.85rem;
      line-height: 1.7;
      opacity: 0.92;
      margin-bottom: 24px;
    }
    .btn-book {
      display: inline-flex; align-items: center; gap: 8px;
      padding: 10px 20px; border-radius: 8px;
      background: var(--pink); color: #fff;
      font-family: 'Ponomar', serif; font-size: 0.85rem;
      text-decoration: none; cursor: pointer;
      border: none;
      transition: background .2s;
    }
    .btn-book:hover { background: #d63368; }

    /* ── FOOTER ── */
    footer { background: #d6eaf8; padding: 60px 48px 30px; }
    .footer-grid {
      display: grid; grid-template-columns: repeat(4, 1fr);
      gap: 40px; margin-bottom: 40px;
    }
    .footer-col h4 { font-size: 0.95rem; margin-bottom: 18px; }
    .footer-col ul { list-style: none; }
    .footer-col ul li { margin-bottom: 10px; }
    .footer-col ul li a { text-decoration: none; color: #444; font-size: 0.88rem; transition: color .2s; }
    .footer-col ul li a:hover { color: var(--pink); }
    .social-links { display: flex; gap: 12px; margin-top: 4px; }
    .social-icon {
      width: 36px; height: 36px; border-radius: 8px; background: #fff;
      display: flex; align-items: center; justify-content: center;
      color: var(--dark); font-size: 0.9rem;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
      transition: all .2s; text-decoration: none;
    }
    .social-icon:hover { background: var(--pink); color: #fff; }
    .footer-bottom {
      border-top: 1px solid rgba(0,0,0,0.08); padding-top: 24px;
      display: flex; align-items: center; gap: 10px;
    }
    .footer-bottom span { font-size: 0.88rem; color: var(--dark); }

    /* ── RESPONSIVE ── */
    @media (max-width: 900px) {
      nav { padding: 0 20px; }
      .hero-banner { margin: 10px 10px 0; padding: 40px 20px 50px; }
      .services-list { padding: 32px 10px 60px; }
      .service-body { max-width: 75%; padding: 28px 24px 32px; }
      .footer-grid { grid-template-columns: repeat(2, 1fr); }
      footer { padding: 50px 20px 24px; }
    }
    @media (max-width: 600px) {
      .service-card { min-height: 320px; align-items: flex-end; }
      .service-body { max-width: 100%; padding: 24px 20px 28px; }
      .service-overlay {
        background: linear-gradient(to top, rgba(10,10,30,0.88) 0%, rgba(10,10,30,0.5) 60%, rgba(10,10,30,0.1) 100%);
      }
    }
  </style>
</head>
<body>

<!-- NAV -->
<nav>
  <a href="index.html" class="nav-logo">
    <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
      <circle cx="20" cy="20" r="18" fill="#fce8ef" stroke="#f0437a" stroke-width="2"/>
      <path d="M20 10 C14 10 10 14 10 18 C10 24 20 30 20 30 C20 30 30 24 30 18 C30 14 26 10 20 10Z" fill="#f0437a" opacity="0.3"/>
      <path d="M17 19 H23 M20 16 V22" stroke="#f0437a" stroke-width="2.5" stroke-linecap="round"/>
      <circle cx="14" cy="14" r="3" fill="#5bb8c4" opacity="0.7"/>
    </svg>
    <span>Happy Care Clinic</span>
  </a>
  <ul class="nav-links">
    <li><a href="services.html" class="active">Services</a></li>
    <li><a href="about.html">About Us</a></li>
    <li><a href="index.html#doctors">Doctors</a></li>
  </ul>
  <div class="nav-actions">
    <a href="#">Log in</a>
    <div class="nav-icon"><i class="fa-solid fa-magnifying-glass"></i></div>
    <div class="nav-icon">
      <i class="fa-solid fa-bell"></i>
      <span class="badge"></span>
    </div>
    <div class="nav-icon"><i class="fa-solid fa-user"></i></div>
  </div>
</nav>

<!-- HERO BANNER -->
<div class="hero-banner">
  <h1>Our Services</h1>
  <p>It doesn't matter if you're getting your usual physical or if you have some issue that you need help with – our general medical doctors are always there, ready to listen, diagnose and help. Our mission is early diagnosis and treatment so we can make sure you remain in peak condition.</p>
</div>

<!-- SERVICES LIST -->
<div class="services-list">

  <!-- OB-GYN -->
  <div class="service-card bg-obgyn">
    <!-- Replace "service-obgyn.jpg" with your actual image filename -->
    <img src="service-obgyn.jpg" alt="OB-GYN" />
    <div class="service-overlay"></div>
    <div class="service-body">
      <h2>OBY-GYN</h2>
      <p>An OB-GYN consultation provides care for women's reproductive health, including check-ups, pregnancy care, family planning, and screenings. It also diagnoses and treats menstrual issues, infections, and hormonal concerns while promoting preventive care and overall well-being.</p>
      <a href="#" class="btn-book">
        <i class="fa-solid fa-calendar-check"></i>
        Book Appointment
      </a>
    </div>
  </div>

  <!-- GENERAL MEDICINE -->
  <div class="service-card bg-general">
    <!-- Replace "service-general.jpg" with your actual image filename -->
    <img src="service-general.jpg" alt="General Medicine" />
    <div class="service-overlay"></div>
    <div class="service-body">
      <h2>General Medicine</h2>
      <p>The general medicine visit is concerned with the wellbeing of the individual as a whole. The general medicine visit involves regular health checks for adults, the diagnosis of common diseases, and treatment. Early detection of illness, symptom management, and proper medication usage and care are ensured by a general medicine visit.</p>
      <a href="#" class="btn-book">
        <i class="fa-solid fa-calendar-check"></i>
        Book Appointment
      </a>
    </div>
  </div>

  <!-- PEDIATRICS -->
  <div class="service-card bg-pediatrics">
    <!-- Replace "service-pediatrics.jpg" with your actual image filename -->
    <img src="service-pediatrics.jpg" alt="Pediatrics" />
    <div class="service-overlay"></div>
    <div class="service-body">
      <h2>Pediatrics</h2>
      <p>A pediatric consultation focuses on a child's overall health and development, including routine check-ups, growth monitoring, vaccinations, and early detection of illnesses. It helps address common childhood conditions, developmental concerns, and provides guidance on nutrition and care. Overall, it ensures children grow healthy, strong, and on track developmentally.</p>
      <a href="#" class="btn-book">
        <i class="fa-solid fa-calendar-check"></i>
        Book Appointment
      </a>
    </div>
  </div>

  <!-- DERMATOLOGY -->
  <div class="service-card bg-derma">
    <!-- Replace "service-dermatology.jpg" with your actual image filename -->
    <img src="service-dermatology.jpg" alt="Dermatology" />
    <div class="service-overlay"></div>
    <div class="service-body">
      <h2>Dermatology</h2>
      <p>A dermatology consultation focuses on skin, hair, and nail health, providing diagnosis and treatment for conditions like acne, rashes, infections, and other skin concerns. It also includes preventive care, skin assessments, and personalized treatment plans. Overall, it helps maintain healthy, clear, and confident skin.</p>
      <a href="#" class="btn-book">
        <i class="fa-solid fa-calendar-check"></i>
        Book Appointment
      </a>
    </div>
  </div>

</div>

<!-- FOOTER -->
<footer>
  <div class="footer-grid">
    <div class="footer-col">
      <h4>Quick Links</h4>
      <ul>
        <li><a href="services.html">Services</a></li>
        <li><a href="about.html">About Us</a></li>
        <li><a href="index.html#doctors">Doctors</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Services</h4>
      <ul>
        <li><a href="#">OB-GYN</a></li>
        <li><a href="#">Pediatrics</a></li>
        <li><a href="#">Surgery</a></li>
        <li><a href="#">Dermatology</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Help</h4>
      <ul>
        <li><a href="#">No Show Policy</a></li>
        <li><a href="#">Data Privacy</a></li>
        <li><a href="#">FAQs</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Follow Us</h4>
      <div class="social-links">
        <a href="#" class="social-icon"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="#" class="social-icon"><i class="fa-brands fa-instagram"></i></a>
        <a href="#" class="social-icon"><i class="fa-brands fa-x-twitter"></i></a>
        <a href="#" class="social-icon"><i class="fa-brands fa-linkedin-in"></i></a>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <svg width="32" height="32" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
      <circle cx="20" cy="20" r="18" fill="#fce8ef" stroke="#f0437a" stroke-width="2"/>
      <path d="M17 19 H23 M20 16 V22" stroke="#f0437a" stroke-width="2.5" stroke-linecap="round"/>
      <circle cx="14" cy="14" r="3" fill="#5bb8c4" opacity="0.7"/>
    </svg>
    <span>Happy Care Clinic</span>
  </div>
</footer>

</body>
</html>