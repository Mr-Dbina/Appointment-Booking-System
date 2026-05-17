<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers/supabase.php';


$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['action']) && $_POST['action'] === 'add') {
        $name      = trim($_POST['name']      ?? '');
        $specialty = trim($_POST['specialty'] ?? '');
        $email     = trim($_POST['email']     ?? '');
        $phone     = trim($_POST['phone']     ?? '');
        $schedule  = trim($_POST['schedule']  ?? '');
        if ($name && $specialty) {
            $res = supabase_post('doctors', [
                'name'      => $name,
                'specialty' => $specialty,
                'email'     => $email,
                'phone'     => $phone,
                'schedule'  => $schedule,
                'status'    => 'active',
            ]);
            $message = ($res['status'] === 201) ? 'success:Doctor added successfully.' : 'error:Failed to add doctor.';
        } else {
            $message = 'error:Name and specialty are required.';
        }
    }
    if (!empty($_POST['action']) && $_POST['action'] === 'toggle' && !empty($_POST['doctor_id'])) {
        $id        = $_POST['doctor_id'];
        $newStatus = $_POST['new_status'] ?? 'active';
        if (in_array($newStatus, ['active', 'inactive'])) {
            $res = supabase_patch('doctors', '?id=eq.' . urlencode($id), ['status' => $newStatus]);
            $message = ($res['status'] === 204) ? 'success:Doctor status updated.' : 'error:Failed to update status.';
        }
    }
}

$doctorRes = supabase_get('doctors', '?select=*&order=name.asc');
$doctors   = ($doctorRes['status'] === 200 && is_array($doctorRes['body'])) ? $doctorRes['body'] : [];
$serviceRes = supabase_get('services', '?select=id,name&order=name.asc');
$services   = ($serviceRes['status'] === 200 && is_array($serviceRes['body'])) ? $serviceRes['body'] : ['OB-GYN','General Medicine','Dermatology','Pediatrics'];

$totalActive   = count(array_filter($doctors, fn($d) => ($d['status'] ?? 'active') === 'active'));
$totalInactive = count($doctors) - $totalActive;

[$msgType, $msgText] = $message ? explode(':', $message, 2) : ['', ''];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors — Happy Care Clinic Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Ponomar&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/admin.css">
    <style>
        .alert { padding:10px 16px; border-radius:8px; margin-bottom:16px; font-size:.9rem; }
        .alert-success { background:#d1fae5; color:#065f46; border:1px solid #6ee7b7; }
        .alert-error   { background:#fee2e2; color:#991b1b; border:1px solid #fca5a5; }
    </style>
</head>
<body>
<div class="layout">
    <?php include __DIR__ . '/sidebar.php'; ?>
    <main class="main">
        <div class="topbar">
            <button class="hamburger" id="hamburger"><i class="fa-solid fa-bars"></i></button>
            <div>
                <h1>Doctors</h1>
                <span><?= count($doctors) ?> doctors on record</span>
            </div>
        </div>

        <?php if ($msgText): ?>
            <div class="alert alert-<?= $msgType ?>">
                <i class="fa-solid fa-<?= $msgType === 'success' ? 'circle-check' : 'circle-xmark' ?>"></i>
                <?= htmlspecialchars($msgText) ?>
            </div>
        <?php endif; ?>

        <div class="stats-grid" style="grid-template-columns:repeat(3,1fr);">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fa-solid fa-user-doctor"></i></div>
                <div class="stat-info"><p>Total Doctors</p><h2><?= count($doctors) ?></h2></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon confirmed"><i class="fa-solid fa-circle-check"></i></div>
                <div class="stat-info"><p>Active</p><h2><?= $totalActive ?></h2></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon cancelled"><i class="fa-solid fa-circle-xmark"></i></div>
                <div class="stat-info"><p>Inactive</p><h2><?= $totalInactive ?></h2></div>
            </div>
        </div>

        <!-- Add Doctor Form -->
        <div class="section-card" style="margin-bottom:24px;">
            <div class="section-header"><h2>Add New Doctor</h2></div>
            <div style="padding:22px 20px;">
                <form method="POST">
                    <input type="hidden" name="action" value="add">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Full Name *</label>
                            <input type="text" name="name" placeholder="Dr. First Last" required>
                        </div>
                        <div class="form-group">
                            <label>Specialty *</label>
                            <select name="specialty" required>
                                <?php if (is_array($services) && isset($services[0]['name'])): ?>
                                    <?php foreach ($services as $svc): ?>
                                        <option value="<?= htmlspecialchars($svc['name']) ?>"><?= htmlspecialchars($svc['name']) ?></option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <?php foreach ($services as $svc): ?>
                                        <option><?= htmlspecialchars($svc) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" placeholder="doctor@happycare.com">
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" placeholder="09XXXXXXXXX">
                        </div>
                        <div class="form-group full">
                            <label>Schedule</label>
                            <input type="text" name="schedule" placeholder="e.g. Mon, Wed, Fri">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn-primary"><i class="fa-solid fa-plus"></i> Add Doctor</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Doctors Table -->
        <div class="section-card">
            <div class="section-header">
                <h2>All Doctors</h2>
                <div class="search-bar">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" class="search-input" data-table="doctorTable" placeholder="Search doctor...">
                </div>
            </div>
            <div class="table-wrap">
                <table id="doctorTable">
                    <thead>
                        <tr><th>#</th><th>Name</th><th>Specialty</th><th>Email</th><th>Phone</th><th>Schedule</th><th>Status</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                    <?php if (empty($doctors)): ?>
                        <tr><td colspan="8" style="text-align:center;padding:40px;color:#888;">
                            <i class="fa-solid fa-user-doctor" style="font-size:2rem;margin-bottom:8px;display:block;opacity:.3;"></i>
                            No doctors found in the database.
                        </td></tr>
                    <?php else: ?>
                    <?php foreach ($doctors as $i => $d):
                        $status = $d['status'] ?? 'active';
                        $toggle = $status === 'active' ? 'inactive' : 'active';
                    ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($d['name']) ?></td>
                        <td><?= htmlspecialchars($d['specialty'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($d['email']    ?? '—') ?></td>
                        <td><?= htmlspecialchars($d['phone']    ?? '—') ?></td>
                        <td><?= htmlspecialchars($d['schedule'] ?? '—') ?></td>
                        <td><span class="badge <?= $status ?>"><?= ucfirst($status) ?></span></td>
                        <td>
                            <div class="action-btns">
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="action"    value="toggle">
                                    <input type="hidden" name="doctor_id" value="<?= htmlspecialchars($d['id']) ?>">
                                    <input type="hidden" name="new_status" value="<?= $toggle ?>">
                                    <button type="submit" class="btn-sm <?= $status === 'active' ? 'btn-cancel' : 'btn-confirm' ?>">
                                        <?= $status === 'active' ? 'Deactivate' : 'Activate' ?>
                                    </button>
                                </form>
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
<script src="<?= BASE_URL ?>/public/js/admin.js"></script>
</body>
</html>