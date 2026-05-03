<?php
$base = "http://localhost/appointment_booking_system";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment — Happy Care Clinic</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Ponomar&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base; ?>/public/css/appointment.css">
</head>
<body>
    <?php include __DIR__ . '/../shared/nav.html'; ?>

    <div class="appt-hero">
        <h1>Healthcare made simple</h1>
        <p>Find the right doctor and book in seconds</p>

        <div class="appointment-bar">
            <div class="appt-field">
                <i class="fa-solid fa-magnifying-glass appt-icon"></i>
                <div class="appt-field-text">
                    <span class="appt-label">Check up</span>
                    <span class="appt-value">What service do you need?</span>
                </div>
            </div>
            <div class="appt-divider"></div>
            <div class="appt-field">
                <i class="fa-solid fa-calendar-days appt-icon"></i>
                <div class="appt-field-text">
                    <span class="appt-label">Appointment</span>
                    <span class="appt-value">Select date & time</span>
                </div>
            </div>
            <div class="appt-divider"></div>
            <button class="appt-btn">Book Appointment</button>
        </div>       
    </div>           

    <?php include __DIR__ . '/../shared/footer.html'; ?>
</body>
</html>