<?php
require_once __DIR__ . '/../config.php';
?>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link
      href="https://fonts.googleapis.com/css2?family=Ponomar&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
          href="<?= BASE_URL ?>/public/css/footer.css"
        />
    <footer>
      <div class="footer-grid">
        <div class="footer-col">
          <h4>Quick Links</h4>
          <ul>
            <li>
              <a
                href="<?= BASE_URL ?>/users/service.php"
                >Services</a
              >
            </li>
            <li>
              <a
                href="<?= BASE_URL ?>/users/aboutus.php"
                >About Us</a
              >
            </li>
            <li>
              <a
                href="<?= BASE_URL ?>/users/appointment.php"
                >Appointment</a
              >
            </li>
            <li></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Services</h4>
          <ul>
            <li>
              <a
                href="<?= BASE_URL ?>/users/ob_service.php"
                >OB-GYN</a
              >
            </li>
            <li>
              <a
                href="<?= BASE_URL ?>/users/gen_service.php"
                >General Medicine</a
              >
            </li>
            <li>
              <a
                href="<?= BASE_URL ?>/users/pedia_service.php"
                >Pediatrics</a
              >
            </li>
            <li>
              <a
                href="<?= BASE_URL ?>/users/derma_service.php"
                >Dermatology</a
              >
            </li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Help</h4>
          <ul>
            <li><a href="<?= BASE_URL ?>/users/help.php#no-show-policy">No Show Policy</a></li>
            <li><a href="<?= BASE_URL ?>/users/help.php#data-privacy">Data Privacy</a></li>
            <li><a href="<?= BASE_URL ?>/users/help.php#faqs">FAQs</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Follow Us</h4>
          <div class="social-links">
            <a href="#" class="social-icon"
              ><i class="fa-brands fa-facebook-f"></i
            ></a>
            <a href="#" class="social-icon"
              ><i class="fa-brands fa-instagram"></i
            ></a>
            <a href="#" class="social-icon"
              ><i class="fa-brands fa-x-twitter"></i
            ></a>
            <a href="#" class="social-icon"
              ><i class="fa-brands fa-linkedin-in"></i
            ></a>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <img
          src="<?= BASE_URL ?>/public/images/logo.png"
        />
        <span>Happy Care Clinic</span>
      </div>
    </footer>


