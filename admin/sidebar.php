<?php
$base    = "http://localhost/appointment_booking_system";
$current = basename($_SERVER['PHP_SELF'], '.php');

$nav_links = [
    ['page' => 'admin',        'icon' => 'fa-gauge',          'label' => 'Dashboard'],
    ['page' => 'appointments', 'icon' => 'fa-calendar-check', 'label' => 'Appointments'],
    ['page' => 'patients',     'icon' => 'fa-users',          'label' => 'Patients'],
    ['page' => 'doctors',      'icon' => 'fa-user-doctor',    'label' => 'Doctors'],
];

$nav_settings = [
    ['page' => 'services', 'icon' => 'fa-stethoscope', 'label' => 'Services'],
    ['page' => 'settings', 'icon' => 'fa-gear',         'label' => 'Settings'],
];
?>
<div class="overlay" id="overlay"></div>

<aside class="sidebar" id="sidebar">
    <a class="sidebar-brand" href="<?= $base ?>/users/main.php">
        <img src="<?= $base ?>/public/images/logo.png" alt="Logo">
        <span>Happy Care<br>Clinic</span>
    </a>

    <nav>
        <div class="nav-section">Main</div>
        <?php foreach ($nav_links as $link):
            $active = ($current === $link['page']) ? ' active' : '';
            $href   = $base . '/admin/' . $link['page'] . '.php';
        ?>
            <a class="nav-item<?= $active ?>" href="<?= $href ?>">
                <i class="fa-solid <?= $link['icon'] ?>"></i> <?= $link['label'] ?>
            </a>
        <?php endforeach; ?>

        <div class="nav-section">Settings</div>
        <?php foreach ($nav_settings as $link):
            $active = ($current === $link['page']) ? ' active' : '';
            $href   = $base . '/admin/' . $link['page'] . '.php';
        ?>
            <a class="nav-item<?= $active ?>" href="<?= $href ?>">
                <i class="fa-solid <?= $link['icon'] ?>"></i> <?= $link['label'] ?>
            </a>
        <?php endforeach; ?>
    </nav>

    <div class="sidebar-footer">
        <div class="admin-tag">
            <strong>Admin</strong>
            Logged in as Admin
        </div>
        <a class="nav-item" href="<?= $base ?>/auth/logout.php" style="margin-top:10px;">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
    </div>
</aside>