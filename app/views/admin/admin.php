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