<?php
$base = "http://localhost/appointment_booking_system";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings — Happy Care Clinic Admin</title>
    <?php include __DIR__ . '/admin_styles.php'; ?>
</head>
<body>
<div class="layout">
    <?php include __DIR__ . '/sidebar.php'; ?>

    <main class="main">
        <div class="topbar">
            <button class="hamburger" id="hamburger"><i class="fa-solid fa-bars"></i></button>
            <div>
                <h1>Settings</h1>
                <span>Clinic configuration</span>
            </div>
        </div>

        <!-- Clinic Info -->
        <div class="section-card" style="margin-bottom:24px;">
            <div class="section-header"><h2><i class="fa-solid fa-hospital" style="color:var(--pink);margin-right:8px;"></i>Clinic Information</h2></div>
            <div style="padding:22px 20px;">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Clinic Name</label>
                        <input type="text" value="Happy Care Clinic">
                    </div>
                    <div class="form-group">
                        <label>Contact Number</label>
                        <input type="text" value="(054) 123-4567">
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" value="info@happycareclinic.com">
                    </div>
                    <div class="form-group">
                        <label>Website</label>
                        <input type="text" value="www.happycareclinic.com">
                    </div>
                    <div class="form-group full">
                        <label>Address</label>
                        <input type="text" value="123 Health St., Naga City, Camarines Sur">
                    </div>
                </div>
                <div class="form-actions">
                    <button class="btn-primary"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
                </div>
            </div>
        </div>

        <!-- Clinic Hours -->
        <div class="section-card" style="margin-bottom:24px;">
            <div class="section-header"><h2><i class="fa-solid fa-clock" style="color:var(--pink);margin-right:8px;"></i>Clinic Hours</h2></div>
            <div style="padding:22px 20px;">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Opening Time</label>
                        <input type="time" value="08:00">
                    </div>
                    <div class="form-group">
                        <label>Closing Time</label>
                        <input type="time" value="17:00">
                    </div>
                    <div class="form-group full">
                        <label>Open Days</label>
                        <input type="text" value="Monday – Saturday">
                    </div>
                </div>
                <div class="form-actions">
                    <button class="btn-primary"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
                </div>
            </div>
        </div>

        <!-- Admin Account -->
        <div class="section-card">
            <div class="section-header"><h2><i class="fa-solid fa-user-shield" style="color:var(--pink);margin-right:8px;"></i>Admin Account</h2></div>
            <div style="padding:22px 20px;">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Admin Name</label>
                        <input type="text" value="Admin">
                    </div>
                    <div class="form-group">
                        <label>Admin Email</label>
                        <input type="email" value="admin@happycareclinic.com">
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" placeholder="Leave blank to keep current">
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" placeholder="Repeat new password">
                    </div>
                </div>
                <div class="form-actions">
                    <button class="btn-primary"><i class="fa-solid fa-floppy-disk"></i> Update Account</button>
                </div>
            </div>
        </div>
    </main>
</div>
<?php include __DIR__ . '/admin_js.php'; ?>
</body>
</html>