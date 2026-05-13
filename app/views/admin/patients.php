<?php
$base = "http://localhost/appointment_booking_system";
require_once __DIR__ . '/../../helpers/supabase.php';

// Fetch appointments for visit stats
$apptRes = supabase_get('appointments', '?select=patient_id,status,created_at&order=created_at.desc');
$allAppts = ($apptRes['status'] === 200 && is_array($apptRes['body'])) ? $apptRes['body'] : [];

$patientStats = [];
foreach ($allAppts as $a) {
    $pid = $a['patient_id'];
    if (!isset($patientStats[$pid])) $patientStats[$pid] = ['visits' => 0, 'last_visit' => null];
    $patientStats[$pid]['visits']++;
    if (!$patientStats[$pid]['last_visit']) $patientStats[$pid]['last_visit'] = substr($a['created_at'], 0, 10);
}

// Try profiles table first
$profileRes = supabase_get('profiles', '?select=id,full_name,email,phone,birthday,status&order=full_name.asc');

if ($profileRes['status'] === 200 && is_array($profileRes['body']) && !empty($profileRes['body'])) {
    $patients = array_map(function($p) use ($patientStats) {
        $stats = $patientStats[$p['id']] ?? ['visits' => 0, 'last_visit' => null];
        return [
            'id'         => $p['id'],
            'name'       => $p['full_name'] ?? 'N/A',
            'email'      => $p['email']     ?? '',
            'phone'      => $p['phone']     ?? '',
            'dob'        => $p['birthday']  ?? '',
            'status'     => $p['status']    ?? 'active',
            'visits'     => $stats['visits'],
            'last_visit' => $stats['last_visit'] ?? '—',
        ];
    }, $profileRes['body']);
} else {
    // Fallback: derive patients from appointments
    $seen = []; $patients = [];
    foreach ($allAppts as $a) {
        $pid = $a['patient_id'];
        if (!isset($seen[$pid])) {
            $seen[$pid] = true;
            $stats = $patientStats[$pid];
            $patients[] = [
                'id'         => $pid,
                'name'       => 'Patient #' . substr($pid, 0, 8),
                'email'      => '',
                'phone'      => '',
                'dob'        => '',
                'status'     => 'active',
                'visits'     => $stats['visits'],
                'last_visit' => $stats['last_visit'] ?? '—',
            ];
        }
    }
}

$totalActive   = count(array_filter($patients, fn($p) => ($p['status'] ?? 'active') === 'active'));
$totalInactive = count($patients) - $totalActive;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients — Happy Care Clinic Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Ponomar&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base; ?>/public/css/admin.css">
</head>
<body>
<div class="layout">
    <?php include __DIR__ . '/sidebar.php'; ?>
    <main class="main">
        <div class="topbar">
            <button class="hamburger" id="hamburger"><i class="fa-solid fa-bars"></i></button>
            <div>
                <h1>Patients</h1>
                <span><?= count($patients) ?> registered patients</span>
            </div>
        </div>

        <div class="stats-grid" style="grid-template-columns:repeat(3,1fr);">
            <div class="stat-card">
                <div class="stat-icon total"><i class="fa-solid fa-users"></i></div>
                <div class="stat-info"><p>Total Patients</p><h2><?= count($patients) ?></h2></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon confirmed"><i class="fa-solid fa-user-check"></i></div>
                <div class="stat-info"><p>Active</p><h2><?= $totalActive ?></h2></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon cancelled"><i class="fa-solid fa-user-xmark"></i></div>
                <div class="stat-info"><p>Inactive</p><h2><?= $totalInactive ?></h2></div>
            </div>
        </div>

        <div class="section-card">
            <div class="section-header">
                <h2>All Patients</h2>
                <div class="search-bar">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" class="search-input" data-table="patientTable" placeholder="Search patient...">
                </div>
            </div>
            <div class="table-wrap">
                <table id="patientTable">
                    <thead>
                        <tr><th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>Date of Birth</th><th>Visits</th><th>Last Visit</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                    <?php if (empty($patients)): ?>
                        <tr><td colspan="8" style="text-align:center;padding:40px;color:#888;">
                            <i class="fa-solid fa-users-slash" style="font-size:2rem;margin-bottom:8px;display:block;"></i>
                            No patients found in the database.
                        </td></tr>
                    <?php else: ?>
                    <?php foreach ($patients as $i => $p): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($p['name']) ?></td>
                        <td><?= htmlspecialchars($p['email']) ?></td>
                        <td><?= htmlspecialchars($p['phone'] ?: '—') ?></td>
                        <td><?= htmlspecialchars($p['dob'] ?: '—') ?></td>
                        <td><?= (int)$p['visits'] ?></td>
                        <td><?= htmlspecialchars($p['last_visit'] ?: '—') ?></td>
                        <td><span class="badge <?= htmlspecialchars($p['status'] ?? 'active') ?>"><?= ucfirst($p['status'] ?? 'active') ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
<script src="<?php echo $base; ?>/public/js/admin.js"></script>
</body>
</html>
<?php
$base = "http://localhost/appointment_booking_system";
require_once __DIR__ . '/../../helpers/supabase.php';

// Fetch appointments for visit stats
$apptRes = supabase_get('appointments', '?select=patient_id,status,created_at&order=created_at.desc');
$allAppts = ($apptRes['status'] === 200 && is_array($apptRes['body'])) ? $apptRes['body'] : [];

$patientStats = [];
foreach ($allAppts as $a) {
    $pid = $a['patient_id'];
    if (!isset($patientStats[$pid])) $patientStats[$pid] = ['visits' => 0, 'last_visit' => null];
    $patientStats[$pid]['visits']++;
    if (!$patientStats[$pid]['last_visit']) $patientStats[$pid]['last_visit'] = substr($a['created_at'], 0, 10);
}

// Try profiles table first
$profileRes = supabase_get('profiles', '?select=id,full_name,email,phone,birthday,status&order=full_name.asc');

if ($profileRes['status'] === 200 && is_array($profileRes['body']) && !empty($profileRes['body'])) {
    $patients = array_map(function($p) use ($patientStats) {
        $stats = $patientStats[$p['id']] ?? ['visits' => 0, 'last_visit' => null];
        return [
            'id'         => $p['id'],
            'name'       => $p['full_name'] ?? 'N/A',
            'email'      => $p['email']     ?? '',
            'phone'      => $p['phone']     ?? '',
            'dob'        => $p['birthday']  ?? '',
            'status'     => $p['status']    ?? 'active',
            'visits'     => $stats['visits'],
            'last_visit' => $stats['last_visit'] ?? '—',
        ];
    }, $profileRes['body']);
} else {
    // Fallback: derive patients from appointments
    $seen = []; $patients = [];
    foreach ($allAppts as $a) {
        $pid = $a['patient_id'];
        if (!isset($seen[$pid])) {
            $seen[$pid] = true;
            $stats = $patientStats[$pid];
            $patients[] = [
                'id'         => $pid,
                'name'       => 'Patient #' . substr($pid, 0, 8),
                'email'      => '',
                'phone'      => '',
                'dob'        => '',
                'status'     => 'active',
                'visits'     => $stats['visits'],
                'last_visit' => $stats['last_visit'] ?? '—',
            ];
        }
    }
}

$totalActive   = count(array_filter($patients, fn($p) => ($p['status'] ?? 'active') === 'active'));
$totalInactive = count($patients) - $totalActive;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients — Happy Care Clinic Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Ponomar&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base; ?>/public/css/admin.css">
</head>
<body>
<div class="layout">
    <?php include __DIR__ . '/sidebar.php'; ?>
    <main class="main">
        <div class="topbar">
            <button class="hamburger" id="hamburger"><i class="fa-solid fa-bars"></i></button>
            <div>
                <h1>Patients</h1>
                <span><?= count($patients) ?> registered patients</span>
            </div>
        </div>

        <div class="stats-grid" style="grid-template-columns:repeat(3,1fr);">
            <div class="stat-card">
                <div class="stat-icon total"><i class="fa-solid fa-users"></i></div>
                <div class="stat-info"><p>Total Patients</p><h2><?= count($patients) ?></h2></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon confirmed"><i class="fa-solid fa-user-check"></i></div>
                <div class="stat-info"><p>Active</p><h2><?= $totalActive ?></h2></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon cancelled"><i class="fa-solid fa-user-xmark"></i></div>
                <div class="stat-info"><p>Inactive</p><h2><?= $totalInactive ?></h2></div>
            </div>
        </div>

        <div class="section-card">
            <div class="section-header">
                <h2>All Patients</h2>
                <div class="search-bar">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" class="search-input" data-table="patientTable" placeholder="Search patient...">
                </div>
            </div>
            <div class="table-wrap">
                <table id="patientTable">
                    <thead>
                        <tr><th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>Date of Birth</th><th>Visits</th><th>Last Visit</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                    <?php if (empty($patients)): ?>
                        <tr><td colspan="8" style="text-align:center;padding:40px;color:#888;">
                            <i class="fa-solid fa-users-slash" style="font-size:2rem;margin-bottom:8px;display:block;"></i>
                            No patients found in the database.
                        </td></tr>
                    <?php else: ?>
                    <?php foreach ($patients as $i => $p): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($p['name']) ?></td>
                        <td><?= htmlspecialchars($p['email']) ?></td>
                        <td><?= htmlspecialchars($p['phone'] ?: '—') ?></td>
                        <td><?= htmlspecialchars($p['dob'] ?: '—') ?></td>
                        <td><?= (int)$p['visits'] ?></td>
                        <td><?= htmlspecialchars($p['last_visit'] ?: '—') ?></td>
                        <td><span class="badge <?= htmlspecialchars($p['status'] ?? 'active') ?>"><?= ucfirst($p['status'] ?? 'active') ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
<script src="<?php echo $base; ?>/public/js/admin.js"></script>
</body>
</html>
