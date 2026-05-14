<?php
$base = "http://localhost/appointment_booking_system";
require_once __DIR__ . '/../../helpers/supabase.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['action']) && $_POST['action'] === 'add') {
    $name  = trim($_POST['service_name'] ?? '');
    $fee   = trim($_POST['fee']          ?? '');
    $desc  = trim($_POST['description']  ?? '');
    if ($name) {
        $price = preg_replace('/[^\d.]/', '', $fee);
        $res   = supabase_post('services', [
            'name'        => $name,
            'description' => $desc,
            'price'       => $price ? (float)$price : 0,
            'status'      => 'active',
        ]);
        $message = ($res['status'] === 201) ? 'success:Service added successfully.' : 'error:Failed to add service.';
    } else {
        $message = 'error:Service name is required.';
    }
}

$serviceRes = supabase_get('services', '?select=*&order=name.asc');
$services   = ($serviceRes['status'] === 200 && is_array($serviceRes['body'])) ? $serviceRes['body'] : [];

// Count doctors per service
$doctorCounts = [];
$dcRes = supabase_get('doctors', '?select=id,specialty,status');
if ($dcRes['status'] === 200 && is_array($dcRes['body'])) {
    foreach ($services as $svc) {
        $doctorCounts[$svc['id']] = count(array_filter($dcRes['body'], fn($d) => ($d['specialty'] ?? '') === $svc['name']));
    }
}

[$msgType, $msgText] = $message ? explode(':', $message, 2) : ['', ''];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services — Happy Care Clinic Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Ponomar&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base; ?>/public/css/admin.css">
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
                <h1>Services</h1>
                <span>Manage clinic services &mdash; <?= count($services) ?> total</span>
            </div>
        </div>

        <?php if ($msgText): ?>
            <div class="alert alert-<?= $msgType ?>">
                <i class="fa-solid fa-<?= $msgType === 'success' ? 'circle-check' : 'circle-xmark' ?>"></i>
                <?= htmlspecialchars($msgText) ?>
            </div>
        <?php endif; ?>

        <!-- Add Service Form -->
        <div class="section-card" style="margin-bottom:24px;">
            <div class="section-header"><h2>Add New Service</h2></div>
            <div style="padding:22px 20px;">
                <form method="POST">
                    <input type="hidden" name="action" value="add">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Service Name *</label>
                            <input type="text" name="service_name" placeholder="e.g. Cardiology" required>
                        </div>
                        <div class="form-group">
                            <label>Consultation Fee</label>
                            <input type="text" name="fee" placeholder="e.g. 500">
                        </div>
                        <div class="form-group full">
                            <label>Description</label>
                            <textarea name="description" placeholder="Brief description of this service..."></textarea>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn-primary"><i class="fa-solid fa-plus"></i> Add Service</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Services Table -->
        <div class="section-card">
            <div class="section-header">
                <h2>All Services</h2>
                <div class="search-bar">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" class="search-input" data-table="serviceTable" placeholder="Search service...">
                </div>
            </div>
            <div class="table-wrap">
                <table id="serviceTable">
                    <thead>
                        <tr><th>#</th><th>Service</th><th>Description</th><th>Doctors</th><th>Fee</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                    <?php if (empty($services)): ?>
                        <tr><td colspan="6" style="text-align:center;padding:40px;color:#888;">
                            <i class="fa-solid fa-stethoscope" style="font-size:2rem;margin-bottom:8px;display:block;opacity:.3;"></i>
                            No services found in the database.
                        </td></tr>
                    <?php else: ?>
                    <?php foreach ($services as $i => $s):
                        $status = $s['status'] ?? 'active';
                        $fee    = isset($s['price']) ? '₱' . number_format((float)$s['price'], 2) : '—';
                        $docCnt = $doctorCounts[$s['id']] ?? 0;
                    ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($s['name']) ?></td>
                        <td style="white-space:normal;max-width:240px;"><?= htmlspecialchars($s['description'] ?? '') ?></td>
                        <td><?= $docCnt ?></td>
                        <td><?= $fee ?></td>
                        <td><span class="badge <?= $status ?>"><?= ucfirst($status) ?></span></td>
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