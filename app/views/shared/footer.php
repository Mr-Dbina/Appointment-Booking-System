<?php
$base = "http://localhost/appointment_booking_system";
?>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Happy Care Clinic</title>
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
          href="<?php echo $base; ?>/public/css/footer.css"
        />
  </head>
    <footer>
      <div class="footer-grid">
        <div class="footer-col">
          <h4>Quick Links</h4>
          <ul>
            <li>
              <a
                href="<?php echo $base; ?>/app/views/users/service.php"
                >Services</a
              >
            </li>
            <li>
              <a
                href="<?php echo $base; ?>/app/views/users/aboutus.php"
                >About Us</a
              >
            </li>
            <li>
              <a
                href="<?php echo $base; ?>/app/views/users/appointment.php"
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
                href="<?php echo $base; ?>/app/views/users/ob_service.php"
                >OB-GYN</a
              >
            </li>
            <li>
              <a
                href="<?php echo $base; ?>/app/views/users/gen_service.php"
                >General Medicine</a
              >
            </li>
            <li>
              <a
                href="<?php echo $base; ?>/app/views/users/ped_service.php"
                >Pediatrics</a
              >
            </li>
            <li>
              <a
                href="<?php echo $base; ?>/app/views/users/derma_service.php"
                >Dermatology</a
              >
            </li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Help</h4>
          <ul>
            <li><a href="<?php echo $base; ?>/app/views/users/help.php#no-show-policy">No Show Policy</a></li>
            <li><a href="<?php echo $base; ?>/app/views/users/help.php#data-privacy">Data Privacy</a></li>
            <li><a href="<?php echo $base; ?>/app/views/users/help.php#faqs">FAQs</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Follow Us</h4>
          <div class="social-links">
            <a href="<?php echo $base; ?>/app/views/users/facebook.php" class="social-icon"
              ><i class="fa-brands fa-facebook-f"></i
            ></a>
            <a href="<?php echo $base; ?>/app/views/users/instagram.php" class="social-icon"
              ><i class="fa-brands fa-instagram"></i
            ></a>
            <a href="<?php echo $base; ?>/app/views/users/twitter.php" class="social-icon"
              ><i class="fa-brands fa-x-twitter"></i
            ></a>
            <a href="<?php echo $base; ?>/app/views/users/linkedin.php" class="social-icon"
              ><i class="fa-brands fa-linkedin-in"></i
            ></a>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <img
          src="<?php echo $base; ?>/public/images/logo.png"
        />
        <span>Happy Care Clinic</span>
      </div>
    </footer>


