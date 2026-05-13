<?php
require_once __DIR__ . '/../config.php';

$doctors = [
    ['id'=>1,'name'=>'Dr. Isabel Reyes',  'specialty'=>'OB-GYN',          'email'=>'ireyes@happycare.com',  'phone'=>'09171110001','schedule'=>'Mon, Wed, Fri','status'=>'active'],
    ['id'=>2,'name'=>'Dr. Marco Lim',     'specialty'=>'General Medicine', 'email'=>'mlim@happycare.com',   'phone'=>'09171110002','schedule'=>'Tue, Thu',    'status'=>'active'],
    ['id'=>3,'name'=>'Dr. Carla Cruz',    'specialty'=>'Dermatology',      'email'=>'ccruz@happycare.com',  'phone'=>'09171110003','schedule'=>'Mon, Thu, Sat','status'=>'active'],
    ['id'=>4,'name'=>'Dr. Jose Garcia',   'specialty'=>'Pediatrics',       'email'=>'jgarcia@happycare.com','phone'=>'09171110004','schedule'=>'Wed, Fri',    'status'=>'active'],
    ['id'=>5,'name'=>'Dr. Lea Santos',    'specialty'=>'General Medicine', 'email'=>'lsantos@happycare.com','phone'=>'09171110005','schedule'=>'Mon–Fri',     'status'=>'inactive'],
];
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
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/admin.css"></head>
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

        <div class="stats-grid" style="grid-template-columns:repeat(3,1fr);">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fa-solid fa-user-doctor"></i></div>
                <div class="stat-info"><p>Total Doctors</p><h2><?= count($doctors) ?></h2></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon confirmed"><i class="fa-solid fa-circle-check"></i></div>
                <div class="stat-info"><p>Active</p><h2><?= count(array_filter($doctors, fn($d)=>$d['status']==='active')) ?></h2></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon cancelled"><i class="fa-solid fa-circle-xmark"></i></div>
                <div class="stat-info"><p>Inactive</p><h2><?= count(array_filter($doctors, fn($d)=>$d['status']==='inactive')) ?></h2></div>
            </div>
        </div>

        <!-- Add Doctor -->
        <div class="section-card" style="margin-bottom:24px;">
            <div class="section-header"><h2>Add New Doctor</h2></div>
            <div style="padding:22px 20px;">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" placeholder="Dr. First Last">
                    </div>
                    <div class="form-group">
                        <label>Specialty</label>
                        <select>
                            <option>OB-GYN</option>
                            <option>General Medicine</option>
                            <option>Dermatology</option>
                            <option>Pediatrics</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" placeholder="doctor@happycare.com">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" placeholder="09XXXXXXXXX">
                    </div>
                    <div class="form-group full">
                        <label>Schedule</label>
                        <input type="text" placeholder="e.g. Mon, Wed, Fri">
                    </div>
                </div>
                <div class="form-actions">
                    <button class="btn-primary"><i class="fa-solid fa-plus"></i> Add Doctor</button>
                </div>
            </div>
        </div>

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
                    <thead><tr><th>#</th><th>Name</th><th>Specialty</th><th>Email</th><th>Phone</th><th>Schedule</th><th>Status</th><th>Actions</th></tr></thead>
                    <tbody>
                    <?php foreach ($doctors as $d): ?>
                    <tr>
                        <td><?= $d['id'] ?></td>
                        <td><?= htmlspecialchars($d['name']) ?></td>
                        <td><?= htmlspecialchars($d['specialty']) ?></td>
                        <td><?= htmlspecialchars($d['email']) ?></td>
                        <td><?= $d['phone'] ?></td>
                        <td><?= htmlspecialchars($d['schedule']) ?></td>
                        <td><span class="badge <?= $d['status'] ?>"><?= ucfirst($d['status']) ?></span></td>
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
<script src="<?= BASE_URL ?>/public/js/admin.js"></script>
</body>
</html>