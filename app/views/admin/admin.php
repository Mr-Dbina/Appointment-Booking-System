<?php
$base = "http://localhost/appointment_booking_system";

// --- Mock Data (replace with real DB queries) ---
$stats = [
    'total_appointments' => 128,
    'pending'            => 14,
    'confirmed'          => 89,
    'cancelled'          => 25,
];

$appointments = [
    ['id' => 1,  'patient' => 'Maria Santos',   'service' => 'OB-GYN',          'doctor' => 'Dr. Reyes',    'date' => '2025-05-06', 'time' => '09:00 AM', 'status' => 'confirmed'],
    ['id' => 2,  'patient' => 'Juan dela Cruz', 'service' => 'General Medicine', 'doctor' => 'Dr. Lim',     'date' => '2025-05-06', 'time' => '10:30 AM', 'status' => 'pending'],
    ['id' => 3,  'patient' => 'Ana Reyes',      'service' => 'Dermatology',      'doctor' => 'Dr. Cruz',    'date' => '2025-05-07', 'time' => '02:00 PM', 'status' => 'pending'],
    ['id' => 4,  'patient' => 'Carlos Bautista','service' => 'Pediatrics',       'doctor' => 'Dr. Garcia',  'date' => '2025-05-07', 'time' => '11:00 AM', 'status' => 'confirmed'],
    ['id' => 5,  'patient' => 'Rosa Mendoza',   'service' => 'OB-GYN',          'doctor' => 'Dr. Reyes',    'date' => '2025-05-08', 'time' => '03:30 PM', 'status' => 'cancelled'],
    ['id' => 6,  'patient' => 'Pedro Torres',   'service' => 'General Medicine', 'doctor' => 'Dr. Lim',     'date' => '2025-05-08', 'time' => '08:00 AM', 'status' => 'confirmed'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Happy Care Clinic</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Ponomar&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --pink:   #ff2768;
            --cyan:   #00cfdd;
            --white:  #ffffff;
            --label:  #c0024e;
            --text:   #1a1a2e;
            --sub:    #555;
            --light:  #fff0f5;
            --border: #f9a8c4;
            --shadow: rgba(255, 39, 104, 0.12);
        }

        body {
            font-family: "Ponomar", serif;
            background: #fdf4f7;
            color: var(--text);
            min-height: 100vh;
            display: flex;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 230px;
            flex-shrink: 0;
            background: linear-gradient(160deg, #fff 0%, #ffe0ec 60%, var(--pink) 100%);
            display: flex;
            flex-direction: column;
            padding: 28px 18px;
            border-right: 1px solid var(--border);
            min-height: 100vh;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 36px;
            text-decoration: none;
        }

        .sidebar-brand img {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }

        .sidebar-brand span {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text);
            line-height: 1.2;
        }

        .sidebar nav { flex: 1; }

        .nav-section {
            font-size: 0.7rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--label);
            margin: 18px 0 8px 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 12px;
            color: var(--text);
            text-decoration: none;
            font-size: 0.92rem;
            transition: background 0.2s, color 0.2s;
            margin-bottom: 4px;
        }

        .nav-item i { width: 18px; text-align: center; color: var(--pink); }

        .nav-item:hover, .nav-item.active {
            background: rgba(255,39,104,0.12);
            color: var(--pink);
        }

        .nav-item.active { font-weight: 700; }

        .sidebar-footer {
            border-top: 1px solid var(--border);
            padding-top: 16px;
        }

        .admin-tag {
            font-size: 0.75rem;
            color: var(--sub);
            text-align: center;
        }

        .admin-tag strong { color: var(--pink); display: block; font-size: 0.9rem; }

        /* ── MAIN CONTENT ── */
        .main {
            flex: 1;
            padding: 32px 36px;
            overflow-y: auto;
        }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .page-header h1 { font-size: 1.6rem; color: var(--text); font-weight: 400; }
        .page-header span { font-size: 0.85rem; color: var(--sub); }

        /* ── STAT CARDS ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--white);
            border-radius: 16px;
            padding: 22px 20px;
            box-shadow: 0 4px 20px var(--shadow);
            border: 1px solid #fde8ef;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .stat-icon.total     { background: #ffe0ec; color: var(--pink); }
        .stat-icon.pending   { background: #fff3cd; color: #b88000; }
        .stat-icon.confirmed { background: #d4edda; color: #1a7a34; }
        .stat-icon.cancelled { background: #f8d7da; color: #721c24; }

        .stat-info p { font-size: 0.78rem; color: var(--sub); margin-bottom: 4px; }
        .stat-info h2 { font-size: 1.7rem; font-weight: 700; color: var(--text); }

        /* ── TABLE SECTION ── */
        .section-card {
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 4px 20px var(--shadow);
            border: 1px solid #fde8ef;
            overflow: hidden;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 22px;
            border-bottom: 1px solid #fde8ef;
        }

        .section-header h2 { font-size: 1rem; font-weight: 700; color: var(--text); }

        .search-bar {
            display: flex;
            align-items: center;
            background: var(--light);
            border: 1px solid var(--border);
            border-radius: 50px;
            padding: 6px 14px;
            gap: 8px;
        }

        .search-bar input {
            border: none;
            background: transparent;
            font-family: "Ponomar", serif;
            font-size: 0.85rem;
            color: var(--text);
            outline: none;
            width: 180px;
        }

        .search-bar i { color: var(--pink); font-size: 0.85rem; }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.88rem;
        }

        thead th {
            background: var(--light);
            color: var(--label);
            font-size: 0.75rem;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 12px 16px;
            text-align: left;
        }

        tbody tr {
            border-bottom: 1px solid #fde8ef;
            transition: background 0.15s;
        }

        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #fff8fb; }

        tbody td { padding: 13px 16px; color: var(--text); }

        .badge {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .badge.confirmed { background: #d4edda; color: #1a7a34; }
        .badge.pending   { background: #fff3cd; color: #b88000; }
        .badge.cancelled { background: #f8d7da; color: #721c24; }

        .action-btns { display: flex; gap: 6px; }

        .btn-sm {
            padding: 5px 12px;
            border-radius: 50px;
            border: none;
            font-family: "Ponomar", serif;
            font-size: 0.78rem;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .btn-sm:hover { opacity: 0.75; }
        .btn-confirm  { background: #d4edda; color: #1a7a34; }
        .btn-cancel   { background: #f8d7da; color: #721c24; }
        .btn-view     { background: var(--light); color: var(--pink); border: 1px solid var(--border); }
    </style>
</head>
<body>

<!-- ── SIDEBAR ── -->
<aside class="sidebar">
    <a class="sidebar-brand" href="<?= $base ?>/app/views/users/main.php">
        <img src="<?= $base ?>/public/images/logo.png" alt="Logo">
        <span>Happy Care<br>Clinic</span>
    </a>

    <nav>
        <div class="nav-section">Main</div>
        <a class="nav-item active" href="#"><i class="fa-solid fa-gauge"></i> Dashboard</a>
        <a class="nav-item" href="#"><i class="fa-solid fa-calendar-check"></i> Appointments</a>
        <a class="nav-item" href="#"><i class="fa-solid fa-users"></i> Patients</a>
        <a class="nav-item" href="#"><i class="fa-solid fa-user-doctor"></i> Doctors</a>

        <div class="nav-section">Settings</div>
        <a class="nav-item" href="#"><i class="fa-solid fa-stethoscope"></i> Services</a>
        <a class="nav-item" href="#"><i class="fa-solid fa-gear"></i> Settings</a>
    </nav>

    <div class="sidebar-footer">
        <div class="admin-tag">
            <strong>Admin</strong>
            Logged in as Admin
        </div>
        <a class="nav-item" href="<?= $base ?>/app/views/auth/logout.php" style="margin-top:10px;">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
    </div>
</aside>

<!-- ── MAIN ── -->
<main class="main">
    <div class="page-header">
        <div>
            <h1>Dashboard</h1>
            <span><?= date('l, F j, Y') ?></span>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon total"><i class="fa-solid fa-calendar-days"></i></div>
            <div class="stat-info">
                <p>Total Appointments</p>
                <h2><?= $stats['total_appointments'] ?></h2>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon pending"><i class="fa-solid fa-clock"></i></div>
            <div class="stat-info">
                <p>Pending</p>
                <h2><?= $stats['pending'] ?></h2>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon confirmed"><i class="fa-solid fa-circle-check"></i></div>
            <div class="stat-info">
                <p>Confirmed</p>
                <h2><?= $stats['confirmed'] ?></h2>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon cancelled"><i class="fa-solid fa-circle-xmark"></i></div>
            <div class="stat-info">
                <p>Cancelled</p>
                <h2><?= $stats['cancelled'] ?></h2>
            </div>
        </div>
    </div>

    <!-- Appointments Table -->
    <div class="section-card">
        <div class="section-header">
            <h2>Recent Appointments</h2>
            <div class="search-bar">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Search patient...">
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Patient</th>
                    <th>Service</th>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $appt): ?>
                <tr>
                    <td><?= $appt['id'] ?></td>
                    <td><?= htmlspecialchars($appt['patient']) ?></td>
                    <td><?= htmlspecialchars($appt['service']) ?></td>
                    <td><?= htmlspecialchars($appt['doctor']) ?></td>
                    <td><?= $appt['date'] ?></td>
                    <td><?= $appt['time'] ?></td>
                    <td>
                        <span class="badge <?= $appt['status'] ?>">
                            <?= ucfirst($appt['status']) ?>
                        </span>
                    </td>
                    <td>
                        <div class="action-btns">
                            <button class="btn-sm btn-view"><i class="fa-solid fa-eye"></i></button>
                            <?php if ($appt['status'] === 'pending'): ?>
                                <button class="btn-sm btn-confirm">Confirm</button>
                                <button class="btn-sm btn-cancel">Cancel</button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

</body>
</html>