<?php
$base = "http://localhost/appointment_booking_system";

$appointments = [
    ['id'=>1,'patient'=>'Maria Santos',   'service'=>'OB-GYN',         'doctor'=>'Dr. Reyes',  'date'=>'2025-05-06','time'=>'09:00 AM','status'=>'confirmed'],
    ['id'=>2,'patient'=>'Juan dela Cruz', 'service'=>'General Medicine','doctor'=>'Dr. Lim',   'date'=>'2025-05-06','time'=>'10:30 AM','status'=>'pending'],
    ['id'=>3,'patient'=>'Ana Reyes',      'service'=>'Dermatology',     'doctor'=>'Dr. Cruz',  'date'=>'2025-05-07','time'=>'02:00 PM','status'=>'pending'],
    ['id'=>4,'patient'=>'Carlos Bautista','service'=>'Pediatrics',      'doctor'=>'Dr. Garcia','date'=>'2025-05-07','time'=>'11:00 AM','status'=>'confirmed'],
    ['id'=>5,'patient'=>'Rosa Mendoza',   'service'=>'OB-GYN',         'doctor'=>'Dr. Reyes',  'date'=>'2025-05-08','time'=>'03:30 PM','status'=>'cancelled'],
    ['id'=>6,'patient'=>'Pedro Torres',   'service'=>'General Medicine','doctor'=>'Dr. Lim',   'date'=>'2025-05-08','time'=>'08:00 AM','status'=>'confirmed'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments — Happy Care Clinic Admin</title>
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
                <h1>Appointments</h1>
                <span><?= date('l, F j, Y') ?></span>
            </div>
        </div>

        <!-- Add Appointment Form -->
        <div class="section-card" style="margin-bottom:24px;">
            <div class="section-header"><h2>Book New Appointment</h2></div>
            <div style="padding:22px 20px;">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Patient Name</label>
                        <input type="text" placeholder="Enter patient name">
                    </div>
                    <div class="form-group">
                        <label>Service</label>
                        <select>
                            <option>OB-GYN</option>
                            <option>General Medicine</option>
                            <option>Dermatology</option>
                            <option>Pediatrics</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Doctor</label>
                        <select>
                            <option>Dr. Reyes</option>
                            <option>Dr. Lim</option>
                            <option>Dr. Cruz</option>
                            <option>Dr. Garcia</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date">
                    </div>
                    <div class="form-group">
                        <label>Time</label>
                        <input type="time">
                    </div>
                    <div class="form-group" style="display:flex;align-items:flex-end;">
                        <button class="btn-primary"><i class="fa-solid fa-plus"></i> Book Appointment</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Appointments Table -->
        <div class="section-card">
            <div class="section-header">
                <h2>All Appointments</h2>
                <div class="search-bar">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" class="search-input" data-table="apptTable" placeholder="Search...">
                </div>
            </div>
            <div class="table-wrap">
                <table id="apptTable">
                    <thead><tr><th>#</th><th>Patient</th><th>Service</th><th>Doctor</th><th>Date</th><th>Time</th><th>Status</th><th>Actions</th></tr></thead>
                    <tbody>
                    <?php foreach ($appointments as $a): ?>
                    <tr>
                        <td><?= $a['id'] ?></td>
                        <td><?= htmlspecialchars($a['patient']) ?></td>
                        <td><?= htmlspecialchars($a['service']) ?></td>
                        <td><?= htmlspecialchars($a['doctor']) ?></td>
                        <td><?= $a['date'] ?></td>
                        <td><?= $a['time'] ?></td>
                        <td><span class="badge <?= $a['status'] ?>"><?= ucfirst($a['status']) ?></span></td>
                        <td>
                            <div class="action-btns">
                                <button class="btn-sm btn-view"><i class="fa-solid fa-eye"></i></button>
                                <button class="btn-sm btn-edit"><i class="fa-solid fa-pen"></i></button>
                                <?php if ($a['status'] === 'pending'): ?>
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
        </div>
    </main>
</div>
<script src="<?php echo $base; ?>/public/js/admin.js"></script>
</body>
</html>