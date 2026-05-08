<?php
$base = "http://localhost/appointment_booking_system";
?>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Happy Care Clinic – General Medicine</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="<?= $base ?>/public/css/ob_service.css"/>
</head>
<body>
    <?php include __DIR__ . '/../shared/nav.html'; ?>

<section class="hero">
  <div class="hero-content">
    <h1>OBY-GYN</h1>
    <p>
      Our OBY-GYN services focus on your reproductive health and well-being.
      From routine check-ups and preventive care to the diagnosis and treatment
      of common conditions, our experienced doctors provide personalized care
      for you and your family.
    </p>
  </div>
</section>

<!-- ─── SERVICES SECTION ──────────────────────────────────────── -->
<section class="services-section">
  <h2>Services</h2>

  <div class="carousel-wrapper">
    <div class="carousel-track-container">
      <div class="carousel-track" id="carouselTrack">

<!-- Card 1 -->
<div class="service-card">
  <div class="card-img-wrap">
    <img src="<?= $base ?>/public/images/parental.png" alt="Treatment"/>
    <div class="card-overlay">
      <h3>Prenatal Check-up</h3>
      <p>Comprehensive prenatal care and regular check-ups to monitor the health of both mother and baby throughout pregnancy.</p>
      <a href="/app/views/users/appointment.php" class="btn-learn">Book Prenatal Check-up</a>
    </div>
  </div>
  <div class="card-label">Prenatal Check-up</div>
</div>

<!-- Card 2 -->
<div class="service-card">
  <div class="card-img-wrap">
    <img src="<?= $base ?>/public/images/ultra.png" alt="Ultrasound"/>
    <div class="card-overlay">
      <h3>Ultrasound</h3>
      <p>Accurate ultrasound services for pregnancy monitoring, diagnosis, and overall reproductive health assessment.</p>
      <a href="/app/views/users/appointment.php" class="btn-learn">Schedule Ultrasound</a>
    </div>
  </div>
  <div class="card-label">Ultrasound</div>
</div>

<!-- Card 3 -->
<div class="service-card">
  <div class="card-img-wrap">
    <img src="<?= $base ?>/public/images/fp.png" alt="Family Planning"/>
    <div class="card-overlay">
      <h3>Family Planning</h3>
      <p>Professional family planning consultations and guidance to help you make informed reproductive health decisions.</p>
      <a href="/app/views/users/appointment.php" class="btn-learn">Consult About Family Planning</a>
    </div>
  </div>
  <div class="card-label">Family Planning</div>
</div>

<!-- Card 4 -->
<div class="service-card">
  <div class="card-img-wrap">
    <img src="<?= $base ?>/public/images/mens.png" alt="Eczema Care"/>
    <div class="card-overlay">
      <h3>Menstrual Problems Consultation</h3>
      <p>Expert consultations for irregular periods, menstrual pain, hormonal concerns, and reproductive wellness.</p>
      <a href="/app/views/users/appointment.php" class="btn-learn">Get Menstrual Consultation</a>
    </div>
  </div>
  <div class="card-label">Menstrual Problems Consultation</div>
</div>

<!-- Card 5 -->
<div class="service-card">
  <div class="card-img-wrap">
    <img src="<?= $base ?>/public/images/pc.png" alt="Wart Removal"/>
    <div class="card-overlay">
      <h3>Pregnancy Test & Monitoring</h3>
      <p>Reliable pregnancy testing and continuous monitoring to ensure a healthy and safe pregnancy journey.</p>
      <a href="/app/views/users/appointment.php" class="btn-learn">Start Pregnancy Monitoring</a>
    </div>
  </div>
  <div class="card-label">Pregnancy Test & Monitoring</div>
</div>

<!-- Card 6 -->
<div class="service-card">
  <div class="card-img-wrap">
    <img src="<?= $base ?>/public/images/cervic.png" alt="Chemical Peel"/>
    <div class="card-overlay">
      <h3>Pap Smear / Cervical Screening</h3>
      <p>Preventive cervical screening services designed to detect abnormalities early and protect women’s health.</p>
      <a href="/app/views/users/appointment.php" class="btn-learn">Book Cervical Screening</a>
    </div>
  </div>
  <div class="card-label">Pap Smear / Cervical Screening</div>
</div>
      </div><!-- /track -->
    </div><!-- /track-container -->

    <!-- Controls -->
    <div class="carousel-controls">
      <button class="carousel-btn" id="prevBtn" aria-label="Previous"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M9 2L4 7L9 12" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
      <div class="carousel-dots" id="dotsContainer"></div>
      <button class="carousel-btn" id="nextBtn" aria-label="Next"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M5 2L10 7L5 12" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
    </div>
  </div>
</section>
  <?php include __DIR__ . '/../shared/footer.html'; ?>
<script>
(function () {
  const track    = document.getElementById('carouselTrack');
  const prevBtn  = document.getElementById('prevBtn');
  const nextBtn  = document.getElementById('nextBtn');
  const dotsWrap = document.getElementById('dotsContainer');
  const GAP      = 22;
  let current    = 0;
  let isAnimating = false;

  function getVisible() {
    const w = track.parentElement.offsetWidth;
    return w < 580 ? 1 : w < 900 ? 2 : 3;
  }

  function getOriginals() {
    return Array.from(track.querySelectorAll('.service-card:not(.clone)'));
  }

  function setup() {
    // Remove old clones
    track.querySelectorAll('.clone').forEach(c => c.remove());
    const originals = getOriginals();
    const vis = getVisible();

    // Clone enough cards for seamless wrap (vis cards on each side)
    const headClones = originals.slice(-vis).map(c => { const cl = c.cloneNode(true); cl.classList.add('clone'); return cl; });
    const tailClones = originals.slice(0, vis).map(c => { const cl = c.cloneNode(true); cl.classList.add('clone'); return cl; });

    headClones.forEach(c => track.prepend(c));
    tailClones.forEach(c => track.append(c));

    // Build dots
    const totalDots = Math.ceil(originals.length / vis);
    dotsWrap.innerHTML = '';
    for (let i = 0; i < totalDots; i++) {
      const d = document.createElement('div');
      d.className = 'dot' + (i === 0 ? ' active' : '');
      d.addEventListener('click', () => !isAnimating && goTo(i));
      dotsWrap.appendChild(d);
    }

    // Jump to real start (after head clones) without animation
    track.style.transition = 'none';
    current = 0;
    setPosition(current, false);
  }

  function cardWidth() {
    return getOriginals()[0].offsetWidth;
  }

  function setPosition(idx, animate) {
    const vis    = getVisible();
    const cw     = cardWidth();
    const offset = (idx + vis) * (cw + GAP); // +vis to skip head clones
    if (animate) {
      track.style.transition = 'transform .45s cubic-bezier(.4,0,.2,1)';
    } else {
      track.style.transition = 'none';
    }
    track.style.transform = `translateX(-${offset}px)`;
  }

  function updateDots() {
    const vis       = getVisible();
    const originals = getOriginals();
    const totalDots = Math.ceil(originals.length / vis);
    const dotIdx    = ((current % totalDots) + totalDots) % totalDots;
    document.querySelectorAll('.dot').forEach((d, i) => d.classList.toggle('active', i === dotIdx));
  }

  function goTo(idx) {
    current = idx;
    setPosition(current, true);
    updateDots();
  }

  function step(dir) {
    if (isAnimating) return;
    isAnimating = true;
    const vis       = getVisible();
    const originals = getOriginals();
    const totalDots = Math.ceil(originals.length / vis);

    current += dir;
    setPosition(current, true);
    updateDots();

    track.addEventListener('transitionend', function onEnd() {
      track.removeEventListener('transitionend', onEnd);
      // Wrap around
      if (current >= totalDots) {
        current = 0;
        setPosition(current, false);
      } else if (current < 0) {
        current = totalDots - 1;
        setPosition(current, false);
      }
      isAnimating = false;
    }, { once: true });
  }

  prevBtn.addEventListener('click', () => step(-1));
  nextBtn.addEventListener('click', () => step(1));

  let resizeTimer;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => { setup(); }, 120);
  });

  setup();
})();
</script>
</body>
</html>