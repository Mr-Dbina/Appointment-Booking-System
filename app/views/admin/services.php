<?php
$base = "http://localhost/appointment_booking_system";

$services = [
    ['id'=>1,'name'=>'OB-GYN',         'description'=>'Women\'s health, prenatal care, and reproductive services.','doctors'=>2,'fee'=>'₱500','status'=>'active'],
    ['id'=>2,'name'=>'General Medicine','description'=>'Primary care, check-ups, and common illness consultations.', 'doctors'=>2,'fee'=>'₱300','status'=>'active'],
    ['id'=>3,'name'=>'Dermatology',    'description'=>'Skin, hair, and nail conditions and treatments.',            'doctors'=>1,'fee'=>'₱600','status'=>'active'],
    ['id'=>4,'name'=>'Pediatrics',     'description'=>'Medical care for infants, children, and adolescents.',       'doctors'=>1,'fee'=>'₱400','status'=>'active'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services — Happy Care Clinic Admin</title>
    <?php include __DIR__ . '/admin_styles.php'; ?>
</head>
<body>
<div class="layout">
    <?php include __DIR__ . '/sidebar.php'; ?>

    <main class="main">
        <div class="topbar">
            <button class="hamburger" id="hamburger"><i class="fa-solid fa-bars"></i></button>
            <div>
                <h1>Services</h1>
                <span>Manage clinic services</span>
            </div>
        </div>

        <!-- Add Service -->
        <div class="section-card" style="margin-bottom:24px;">
            <div class="section-header"><h2>Add New Service</h2></div>
            <div style="padding:22px 20px;">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Service Name</label>
                        <input type="text" placeholder="e.g. Cardiology">
                    </div>
                    <div class="form-group">
                        <label>Consultation Fee</label>
                        <input type="text" placeholder="e.g. ₱500">
                    </div>
                    <div class="form-group full">
                        <label>Description</label>
                        <textarea placeholder="Brief description of this service..."></textarea>
                    </div>
                </div>
                <div class="form-actions">
                    <button class="btn-primary"><i class="fa-solid fa-plus"></i> Add Service</button>
                </div>
            </div>
        </div>

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
                    <thead><tr><th>#</th><th>Service</th><th>Description</th><th>Doctors</th><th>Fee</th><th>Status</th><th>Actions</th></tr></thead>
                    <tbody>
                    <?php foreach ($services as $s): ?>
                    <tr>
                        <td><?= $s['id'] ?></td>
                        <td><?= htmlspecialchars($s['name']) ?></td>
                        <td style="white-space:normal;max-width:240px;"><?= htmlspecialchars($s['description']) ?></td>
                        <td><?= $s['doctors'] ?></td>
                        <td><?= $s['fee'] ?></td>
                        <td><span class="badge <?= $s['status'] ?>"><?= ucfirst($s['status']) ?></span></td>
                        <td>
                            <div class="action-btns">
                                <button class="btn-sm btn-edit"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn-sm btn-delete"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
<?php include __DIR__ . '/admin_js.php'; ?>
</body>
</html>