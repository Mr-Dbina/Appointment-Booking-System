<?php
$base = "http://localhost/appointment_booking_system";
require_once __DIR__ . '/../../helpers/supabase.php';

// ── Live stats ────────────────────────────────────────────────────────────
$allRes = supabase_get('appointments', '?select=status');
$stats  = ['total_appointments' => 0, 'pending' => 0, 'confirmed' => 0, 'cancelled' => 0, 'completed' => 0];
if ($allRes['status'] === 200 && is_array($allRes['body'])) {
    foreach ($allRes['body'] as $a) {
        $stats['total_appointments']++;
        $s = $a['status'] ?? 'pending';
        if (isset($stats[$s])) $stats[$s]++;
    }
}

// ── Recent appointments (last 10) ─────────────────────────────────────────
$filter = '?select=id,appointment_no,status,created_at,'
        . 'patient:patient_id(id,email,raw_user_meta_data),'
        . 'doctor:doctor_id(id,name),'
        . 'service:service_id(id,name),'
        . 'time_slot:time_slot_id(slot_date,start_time,end_time)'
        . '&order=created_at.desc&limit=10';
$apptRes      = supabase_get('appointments', $filter);
$appointments = ($apptRes['status'] === 200 && is_array($apptRes['body'])) ? $apptRes['body'] : [];

// ── Patient & Doctor counts ───────────────────────────────────────────────
$pRes   = supabase_get('profiles', '?select=id');
$dRes   = supabase_get('doctors',  '?select=id');
$pCount = ($pRes['status'] === 200 && is_array($pRes['body'])) ? count($pRes['body']) : '—';
$dCount = ($dRes['status'] === 200 && is_array($dRes['body'])) ? count($dRes['body']) : '—';

function patientName(array $appt): string {
    $meta = $appt['patient']['raw_user_meta_data'] ?? [];
    if (!empty($meta['full_name']))  return $meta['full_name'];
    if (!empty($meta['first_name'])) return trim(($meta['first_name'] ?? '') . ' ' . ($meta['last_name'] ?? ''));
    return $appt['patient']['email'] ?? 'Unknown';
}
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
    <link rel="stylesheet" href="<?php echo $base; ?>/public/css/admin.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --pink:   #ff2768;
            --white:  #ffffff;
            --label:  #c0024e;
            --text:   #1a1a2e;
            --sub:    #555;
            --light:  #fff0f5;
            --border: #f9a8c4;
            --shadow: rgba(255, 39, 104, 0.12);
            --sidebar-w: 230px;
        }

        html, body { height: 100%; font-family: "Ponomar", serif; background: #fdf4f7; color: var(--text); }

        .layout { display: flex; min-height: 100vh; }

        /* Overlay for mobile drawer */
        .overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 99; }
        .overlay.open { display: block; }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-w);
            flex-shrink: 0;
            background: linear-gradient(160deg, #fff 0%, #ffe0ec 60%, var(--pink) 100%);
            display: flex;
            flex-direction: column;
            padding: 28px 18px;
            border-right: 1px solid var(--border);
            min-height: 100vh;
            position: relative;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        .sidebar-brand { display: flex; align-items: center; gap: 10px; margin-bottom: 36px; text-decoration: none; }
        .sidebar-brand img { width: 40px; height: 40px; object-fit: contain; }
        .sidebar-brand span { font-size: 1rem; font-weight: 700; color: var(--text); line-height: 1.2; }

        .sidebar nav { flex: 1; }

        .nav-section {
            font-size: 0.7rem; letter-spacing: 0.1em; text-transform: uppercase;
            color: var(--label); margin: 18px 0 8px 8px;
        }

        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 14px; border-radius: 12px;
            color: var(--text); text-decoration: none;
            font-size: 0.92rem; transition: background 0.2s, color 0.2s; margin-bottom: 4px;
        }
        .nav-item i { width: 18px; text-align: center; color: var(--pink); }
        .nav-item:hover, .nav-item.active { background: rgba(255,39,104,0.12); color: var(--pink); }
        .nav-item.active { font-weight: 700; }

        .sidebar-footer { border-top: 1px solid var(--border); padding-top: 16px; }
        .admin-tag { font-size: 0.75rem; color: var(--sub); text-align: center; }
        .admin-tag strong { color: var(--pink); display: block; font-size: 0.9rem; }

        /* ── MAIN ── */
        .main { flex: 1; padding: 28px 32px; overflow-y: auto; min-width: 0; }

        /* ── TOP BAR ── */
        .topbar { display: flex; align-items: center; gap: 14px; margin-bottom: 28px; }
        .topbar h1 { font-size: 1.6rem; color: var(--text); font-weight: 400; }
        .topbar span { font-size: 0.85rem; color: var(--sub); display: block; }

        /* Hamburger */
        .hamburger {
            display: none;
            background: var(--white); border: 1px solid var(--border);
            border-radius: 10px; width: 40px; height: 40px;
            align-items: center; justify-content: center;
            cursor: pointer; color: var(--pink); font-size: 1.1rem; flex-shrink: 0;
        }

        /* ── STAT CARDS ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px; margin-bottom: 28px;
        }

        .stat-card {
            background: var(--white); border-radius: 16px;
            padding: 20px 18px; box-shadow: 0 4px 20px var(--shadow);
            border: 1px solid #fde8ef; display: flex; align-items: center; gap: 14px;
        }

        .stat-icon {
            width: 46px; height: 46px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; flex-shrink: 0;
        }
        .stat-icon.total     { background: #ffe0ec; color: var(--pink); }
        .stat-icon.pending   { background: #fff3cd; color: #b88000; }
        .stat-icon.confirmed { background: #d4edda; color: #1a7a34; }
        .stat-icon.cancelled { background: #f8d7da; color: #721c24; }

        .stat-info p  { font-size: 0.75rem; color: var(--sub); margin-bottom: 3px; }
        .stat-info h2 { font-size: 1.6rem; font-weight: 700; color: var(--text); }

        /* ── TABLE CARD ── */
        .section-card {
            background: var(--white); border-radius: 16px;
            box-shadow: 0 4px 20px var(--shadow);
            border: 1px solid #fde8ef; overflow: hidden;
        }

        .section-header {
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 10px; padding: 16px 20px; border-bottom: 1px solid #fde8ef;
        }
        .section-header h2 { font-size: 1rem; font-weight: 700; color: var(--text); }

        .search-bar {
            display: flex; align-items: center;
            background: var(--light); border: 1px solid var(--border);
            border-radius: 50px; padding: 6px 14px; gap: 8px;
        }
        .search-bar input {
            border: none; background: transparent; font-family: "Ponomar", serif;
            font-size: 0.85rem; color: var(--text); outline: none; width: 160px;
        }
        .search-bar i { color: var(--pink); font-size: 0.85rem; }

        /* Scrollable table on small screens */
        .table-wrap { overflow-x: auto; }

        table { width: 100%; border-collapse: collapse; font-size: 0.87rem; min-width: 560px; }
        thead th {
            background: var(--light); color: var(--label);
            font-size: 0.72rem; letter-spacing: 0.06em;
            text-transform: uppercase; padding: 11px 14px;
            text-align: left; white-space: nowrap;
        }
        tbody tr { border-bottom: 1px solid #fde8ef; transition: background 0.15s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #fff8fb; }
        tbody td { padding: 12px 14px; color: var(--text); white-space: nowrap; }

        .badge { display: inline-block; padding: 3px 11px; border-radius: 50px; font-size: 0.73rem; font-weight: 700; }
        .badge.confirmed { background: #d4edda; color: #1a7a34; }
        .badge.pending   { background: #fff3cd; color: #b88000; }
        .badge.cancelled { background: #f8d7da; color: #721c24; }

        .action-btns { display: flex; gap: 5px; flex-wrap: wrap; }
        .btn-sm {
            padding: 5px 11px; border-radius: 50px; border: none;
            font-family: "Ponomar", serif; font-size: 0.75rem;
            cursor: pointer; transition: opacity 0.2s; white-space: nowrap;
        }
        .btn-sm:hover  { opacity: 0.75; }
        .btn-confirm   { background: #d4edda; color: #1a7a34; }
        .btn-cancel    { background: #f8d7da; color: #721c24; }
        .btn-view      { background: var(--light); color: var(--pink); border: 1px solid var(--border); }

        /* ── RESPONSIVE ── */
        @media (max-width: 1024px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            /* Sidebar becomes a fixed drawer */
            .sidebar {
                position: fixed; top: 0; left: 0;
                height: 100%; transform: translateX(-100%);
            }
            .sidebar.open { transform: translateX(0); }

            .hamburger { display: flex; }
            .main { padding: 20px 16px; }
            .topbar h1 { font-size: 1.3rem; }
        }

        @media (max-width: 480px) {
            .stats-grid { grid-template-columns: 1fr 1fr; gap: 10px; }
            .stat-card  { padding: 14px 12px; gap: 10px; }
            .stat-icon  { width: 38px; height: 38px; font-size: 1rem; }
            .stat-info h2 { font-size: 1.2rem; }
            .search-bar input { width: 110px; }
        }
    </style>
</head>
<body>

<div class="overlay" id="overlay"></div>

<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <a class="sidebar-brand" href="<?php echo $base; ?>/app/views/users/main.php">
            <img src="<?php echo $base; ?>/public/images/logo.png" alt="Logo">
            <span>Happy Care<br>Clinic</span>
        </a>

        <nav>
            <div class="nav-section">Main</div>
            <a class="nav-item active" href="admin.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
            <a class="nav-item" href="appointments.php"><i class="fa-solid fa-calendar-check"></i> Appointments</a>
            <a class="nav-item" href="patients.php"><i class="fa-solid fa-users"></i> Patients</a>
            <a class="nav-item" href="doctors.php"><i class="fa-solid fa-user-doctor"></i> Doctors</a>

            <div class="nav-section">Settings</div>
            <a class="nav-item" href="services.php"><i class="fa-solid fa-stethoscope"></i> Services</a>
            <a class="nav-item" href="settings.php"><i class="fa-solid fa-gear"></i> Settings</a>
        </nav>

        <div class="sidebar-footer">
            <div class="admin-tag">
                <strong>Admin</strong>
                Logged in as Admin
            </div>
            <a class="nav-item" href="<?php echo $base; ?>/app/views/auth/logout.php" style="margin-top:10px;">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </div>
    </aside>

    <!-- MAIN -->
    <main class="main">

        <div class="topbar">
            <button class="hamburger" id="hamburger" aria-label="Open menu">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div>
                <h1>Dashboard</h1>
                <span><?php echo date('l, F j, Y'); ?></span>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon total"><i class="fa-solid fa-calendar-days"></i></div>
                <div class="stat-info"><p>Total Appointments</p><h2><?= $stats['total_appointments'] ?></h2></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon pending"><i class="fa-solid fa-clock"></i></div>
                <div class="stat-info"><p>Pending</p><h2><?= $stats['pending'] ?></h2></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon confirmed"><i class="fa-solid fa-circle-check"></i></div>
                <div class="stat-info"><p>Confirmed</p><h2><?= $stats['confirmed'] ?></h2></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon cancelled"><i class="fa-solid fa-circle-xmark"></i></div>
                <div class="stat-info"><p>Cancelled</p><h2><?= $stats['cancelled'] ?></h2></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue" style="background:#dbeafe;color:#1e40af;"><i class="fa-solid fa-users"></i></div>
                <div class="stat-info"><p>Patients</p><h2><?= $pCount ?></h2></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#ede9fe;color:#6d28d9;"><i class="fa-solid fa-user-doctor"></i></div>
                <div class="stat-info"><p>Doctors</p><h2><?= $dCount ?></h2></div>
            </div>
        </div>

        <!-- Appointments Table -->
        <div class="section-card">
            <div class="section-header">
                <h2>Recent Appointments</h2>
                <a href="appointments.php" style="font-size:.85rem;color:var(--pink);text-decoration:none;">View all &rarr;</a>
                <div class="search-bar">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="searchInput" placeholder="Search patient...">
                </div>
            </div>

            <div class="table-wrap">
                <table id="apptTable">
                    <thead>
                        <tr>
                            <th>Appt #</th><th>Patient</th><th>Service</th><th>Doctor</th>
                            <th>Date</th><th>Time</th><th>Status</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($appointments)): ?>
                        <tr><td colspan="8" style="text-align:center;padding:30px;color:#888;">No appointments yet.</td></tr>
                    <?php else: ?>
                    <?php foreach ($appointments as $appt):
                        $slot   = $appt['time_slot'] ?? [];
                        $doctor = $appt['doctor']    ?? [];
                        $svc    = $appt['service']   ?? [];
                        $status = $appt['status']    ?? 'pending';
                        $date   = $slot['slot_date']  ?? '—';
                        $start  = isset($slot['start_time']) ? substr($slot['start_time'], 0, 5) : '—';
                        $end    = isset($slot['end_time'])   ? substr($slot['end_time'],   0, 5) : '';
                        $time   = $end ? "$start – $end" : $start;
                    ?>
                                                <tr>
                            <td><?= htmlspecialchars($appt['appointment_no'] ?? strtoupper(substr($appt['id'],0,8))) ?></td>
                            <td><?= htmlspecialchars(patientName($appt)) ?></td>
                            <td><?= htmlspecialchars($svc['name']    ?? '—') ?></td>
                            <td><?= htmlspecialchars($doctor['name'] ?? '—') ?></td>
                            <td><?= htmlspecialchars($date) ?></td>
                            <td><?= htmlspecialchars($time) ?></td>
                            <td><span class="badge <?= $status ?>"><?= ucfirst($status) ?></span></td>
                            <td>
                                <div class="action-btns">
                                    <?php if ($status === 'pending'): ?>
                                        <a href="appointments.php" class="btn-sm btn-confirm">Confirm</a>
                                        <a href="appointments.php" class="btn-sm btn-cancel">Cancel</a>
                                    <?php else: ?>
                                        <a href="appointments.php" class="btn-sm btn-view"><i class="fa-solid fa-eye"></i></a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>

<script>
    const hamburger = document.getElementById('hamburger');
    const sidebar   = document.getElementById('sidebar');
    const overlay   = document.getElementById('overlay');

    function openSidebar()  { sidebar.classList.add('open');    overlay.classList.add('open'); }
    function closeSidebar() { sidebar.classList.remove('open'); overlay.classList.remove('open'); }

    hamburger.addEventListener('click', openSidebar);
    overlay.addEventListener('click', closeSidebar);

    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', () => { if (window.innerWidth <= 768) closeSidebar(); });
    });

    document.getElementById('searchInput').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#apptTable tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });
</script>

</body>
</html>