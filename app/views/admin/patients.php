<?php
$base = "http://localhost/appointment_booking_system";

$patients = [
    ['id'=>1,'name'=>'Maria Santos',   'email'=>'maria@email.com', 'phone'=>'09171234567','dob'=>'1990-03-12','visits'=>5,'last_visit'=>'2025-05-06','status'=>'active'],
    ['id'=>2,'name'=>'Juan dela Cruz', 'email'=>'juan@email.com',  'phone'=>'09181234567','dob'=>'1985-07-22','visits'=>2,'last_visit'=>'2025-05-06','status'=>'active'],
    ['id'=>3,'name'=>'Ana Reyes',      'email'=>'ana@email.com',   'phone'=>'09191234567','dob'=>'1998-11-05','visits'=>1,'last_visit'=>'2025-05-07','status'=>'active'],
    ['id'=>4,'name'=>'Carlos Bautista','email'=>'carlos@email.com','phone'=>'09161234567','dob'=>'2010-01-30','visits'=>8,'last_visit'=>'2025-05-07','status'=>'active'],
    ['id'=>5,'name'=>'Rosa Mendoza',   'email'=>'rosa@email.com',  'phone'=>'09151234567','dob'=>'1975-06-18','visits'=>3,'last_visit'=>'2025-05-08','status'=>'inactive'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients — Happy Care Clinic Admin</title>
    <?php include __DIR__ . '/admin_styles.php'; ?>
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
                <div class="stat-info"><p>Active</p><h2><?= count(array_filter($patients, fn($p)=>$p['status']==='active')) ?></h2></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon cancelled"><i class="fa-solid fa-user-xmark"></i></div>
                <div class="stat-info"><p>Inactive</p><h2><?= count(array_filter($patients, fn($p)=>$p['status']==='inactive')) ?></h2></div>
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
                    <thead><tr><th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>Date of Birth</th><th>Visits</th><th>Last Visit</th><th>Status</th><th>Actions</th></tr></thead>
                    <tbody>
                    <?php foreach ($patients as $p): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><?= htmlspecialchars($p['name']) ?></td>
                        <td><?= htmlspecialchars($p['email']) ?></td>
                        <td><?= $p['phone'] ?></td>
                        <td><?= $p['dob'] ?></td>
                        <td><?= $p['visits'] ?></td>
                        <td><?= $p['last_visit'] ?></td>
                        <td><span class="badge <?= $p['status'] ?>"><?= ucfirst($p['status']) ?></span></td>
                        <td>
                            <div class="action-btns">
                                <button class="btn-sm btn-view"><i class="fa-solid fa-eye"></i></button>
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