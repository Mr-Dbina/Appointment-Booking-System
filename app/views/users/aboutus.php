<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About Us — Happy Care Clinic</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Ponomar&display=swap" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="aboutus.css" />
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
    <li><a href="index.html#services">Services</a></li>
    <li><a href="about.html" class="active">About Us</a></li>
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
  <div class="brand">
    <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
      <circle cx="20" cy="20" r="18" fill="#fce8ef" stroke="#f0437a" stroke-width="2"/>
      <path d="M20 10 C14 10 10 14 10 18 C10 24 20 30 20 30 C20 30 30 24 30 18 C30 14 26 10 20 10Z" fill="#f0437a" opacity="0.3"/>
      <path d="M17 19 H23 M20 16 V22" stroke="#f0437a" stroke-width="2.5" stroke-linecap="round"/>
      <circle cx="14" cy="14" r="3" fill="#5bb8c4" opacity="0.7"/>
    </svg>
    <span>Happy Care Clinic</span>
  </div>
  <h1>At Happy Care Clinic, we believe that medical excellence shouldn't feel clinical. We combine cutting-edge "precise medicine" with a "compassionate care" philosophy to ensure every visit is personal, effective, and stress-free.</h1>
</div>

<!-- MISSION -->
<section class="mission">
  <div class="mission-text">
    <h2>Our Mission</h2>
    <p>At Happy Care Clinic, we believe that healthcare should be as unique as the patients we serve. Our mission is to bridge the gap between advanced medical science and genuine human connection. We are dedicated to providing personalized healthcare solutions that empower you to live your healthiest, most vibrant life.</p>
    <p>Beyond our state-of-the-art diagnostic tools, Happy Care Clinic is built on a foundation of clinical excellence. Our medical protocols are overseen by our lead specialists, ensuring that every treatment plan from routine check-ups to complex chronic care is backed by the latest evidence-based research and a deep commitment to patient safety.</p>
  </div>
  <div class="mission-img">
    <!-- Replace "mission.jpg" with your actual image filename -->
    <img src="mission.jpg" alt="Doctor with patient" />
  </div>
</section>

<!-- WHY CHOOSE US -->
<section class="why">
  <div class="why-img">
    <!-- Replace "why-us.jpg" with your actual image filename -->
    <img src="why-us.jpg" alt="Medical professionals" />
  </div>
  <div class="why-text">
    <h2>Why Choose Us</h2>
    <p>At Happy Care Clinic, we prioritize precision, empathy, and transparency above all else. We understand that navigating healthcare can be overwhelming, which is why we've designed our facilities to be a sanctuary of modern medicine.</p>
    <p>Our team of board-certified professionals utilizes cutting-edge technology to ensure your diagnosis is accurate and your treatment is effective. Plus, our commitment to "compassionate care" means we take the time to listen, explain, and support you at every step of your wellness journey. With Happy Care, you aren't just a patient; you're a partner in health.</p>
  </div>
</section>

<!-- SERVICE CARDS -->
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

<!-- FOOTER -->
<footer>
  <div class="footer-grid">
    <div class="footer-col">
      <h4>Quick Links</h4>
      <ul>
        <li><a href="index.html#services">Services</a></li>
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