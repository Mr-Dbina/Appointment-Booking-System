<?php
$base = "http://localhost/appointment_booking_system";
require_once __DIR__ . '/../../helpers/supabase.php';

$filter = '?select=id,appointment_no,status,created_at,'
        . 'patient:patient_id(id,email,raw_user_meta_data),'
        . 'doctor:doctor_id(id,name,specialty),'
        . 'service:service_id(id,name,price),'
        . 'time_slot:time_slot_id(slot_date,start_time,end_time)'
        . '&order=created_at.desc';

$apptRes      = supabase_get('appointments', $filter);
$appointments = ($apptRes['status'] === 200 && is_array($apptRes['body'])) ? $apptRes['body'] : [];

$counts = ['pending'=>0,'confirmed'=>0,'cancelled'=>0,'completed'=>0];
foreach ($appointments as $a) { $s = $a['status'] ?? 'pending'; if (isset($counts[$s])) $counts[$s]++; }

function patientName(array $appt): string {
    $meta = $appt['patient']['raw_user_meta_data'] ?? [];
    if (!empty($meta['full_name']))  return $meta['full_name'];
    if (!empty($meta['first_name'])) return trim(($meta['first_name'] ?? '') . ' ' . ($meta['last_name'] ?? ''));
    return $appt['patient']['email'] ?? 'Unknown';
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['appt_id']) && !empty($_POST['new_status'])) {
    $allowed = ['pending','confirmed','cancelled','completed'];
    $id = $_POST['appt_id']; $status = $_POST['new_status'];
    if (in_array($status, $allowed)) {
        $r = supabase_patch('appointments', '?id=eq.' . urlencode($id), ['status' => $status]);
        $message = ($r['status'] === 204) ? 'success' : 'error';
        $apptRes = supabase_get('appointments', $filter);
        $appointments = ($apptRes['status'] === 200 && is_array($apptRes['body'])) ? $apptRes['body'] : [];
        $counts = ['pending'=>0,'confirmed'=>0,'cancelled'=>0,'completed'=>0];
        foreach ($appointments as $a) { $s = $a['status'] ?? 'pending'; if (isset($counts[$s])) $counts[$s]++; }
    }
}
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
    <style>
        .alert { padding:10px 16px; border-radius:8px; margin-bottom:16px; font-size:.9rem; }
        .alert-success { background:#d1fae5; color:#065f46; border:1px solid #6ee7b7; }
        .alert-error   { background:#fee2e2; color:#991b1b; border:1px solid #fca5a5; }
        .badge.completed { background:#dbeafe; color:#1e40af; }
        .appt-no { font-size:.75rem; color:#888; font-family:monospace; }
        .filter-bar { display:flex; gap:10px; align-items:center; flex-wrap:wrap; }
        .filter-bar select { border:1px solid #f9a8c4; border-radius:8px; padding:6px 10px; font-size:.85rem; }
    </style>
</head>
<body>
<div class="layout">
    <?php include __DIR__ . '/sidebar.php'; ?>
    <main class="main">
        <div class="topbar">
            <button class="hamburger" id="hamburger"><i class="fa-solid fa-bars"></i></button>
            <div>
                <h1>Appointments</h1>
                <span><?= date('l, F j, Y') ?> &mdash; <?= count($appointments) ?> total records</span>
            </div>
        </div>

        <?php if ($message === 'success'): ?>
            <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> Appointment status updated successfully.</div>
        <?php elseif ($message === 'error'): ?>
            <div class="alert alert-error"><i class="fa-solid fa-circle-xmark"></i> Failed to update appointment.</div>
        <?php endif; ?>

        <div class="stats-grid" style="grid-template-columns:repeat(4,1fr);margin-bottom:20px;">
            <div class="stat-card">
                <div class="stat-icon pending"><i class="fa-solid fa-clock"></i></div>
                <div class="stat-info"><p>Pending</p><h2 id="cnt-pending"><?= $counts['pending'] ?></h2></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon confirmed"><i class="fa-solid fa-circle-check"></i></div>
                <div class="stat-info"><p>Confirmed</p><h2 id="cnt-confirmed"><?= $counts['confirmed'] ?></h2></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon cancelled"><i class="fa-solid fa-circle-xmark"></i></div>
                <div class="stat-info"><p>Cancelled</p><h2 id="cnt-cancelled"><?= $counts['cancelled'] ?></h2></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon total"><i class="fa-solid fa-calendar-check"></i></div>
                <div class="stat-info"><p>Completed</p><h2 id="cnt-completed"><?= $counts['completed'] ?></h2></div>
            </div>
        </div>

        <div class="section-card">
            <div class="section-header">
                <h2>All Appointments</h2>
                <div class="filter-bar">
                    <select id="statusFilter" onchange="filterTable()">
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="completed">Completed</option>
                    </select>
                    <div class="search-bar">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search patient, doctor, service...">
                    </div>
                </div>
            </div>
            <div class="table-wrap">
                <table id="apptTable">
                    <thead>
                        <tr>
                            <th>Appt #</th><th>Patient</th><th>Service</th><th>Doctor</th>
                            <th>Date</th><th>Time</th><th>Fee</th><th>Status</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($appointments)): ?>
                        <tr><td colspan="9" style="text-align:center;padding:40px;color:#888;">
                            <i class="fa-solid fa-calendar-xmark" style="font-size:2rem;margin-bottom:8px;display:block;"></i>
                            No appointments found in the database.
                        </td></tr>
                    <?php else: ?>
                    <?php foreach ($appointments as $a):
                        $slot    = $a['time_slot'] ?? [];
                        $doctor  = $a['doctor']    ?? [];
                        $service = $a['service']   ?? [];
                        $status  = $a['status']    ?? 'pending';
                        $date    = $slot['slot_date']  ?? '—';
                        $start   = isset($slot['start_time']) ? substr($slot['start_time'], 0, 5) : '—';
                        $end     = isset($slot['end_time'])   ? substr($slot['end_time'],   0, 5) : '';
                        $time    = $end ? "$start – $end" : $start;
                        $fee     = isset($service['price']) ? '₱' . number_format($service['price'], 2) : '—';
                        $apptNo  = $a['appointment_no'] ?? strtoupper(substr($a['id'], 0, 8));
                    ?>
                    <tr data-status="<?= htmlspecialchars($status) ?>">
                        <td><span class="appt-no"><?= htmlspecialchars($apptNo) ?></span></td>
                        <td><?= htmlspecialchars(patientName($a)) ?></td>
                        <td><?= htmlspecialchars($service['name'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($doctor['name']  ?? '—') ?></td>
                        <td><?= htmlspecialchars($date) ?></td>
                        <td><?= htmlspecialchars($time) ?></td>
                        <td><?= $fee ?></td>
                        <td><span class="badge <?= $status ?>"><?= ucfirst($status) ?></span></td>
                        <td>
                            <div class="action-btns">
                            <?php if ($status === 'pending'): ?>
                                <button class="btn-sm btn-confirm" onclick="updateStatus('<?= $a['id'] ?>','confirmed',this)">Confirm</button>
                                <button class="btn-sm btn-cancel"  onclick="updateStatus('<?= $a['id'] ?>','cancelled',this)">Cancel</button>
                            <?php elseif ($status === 'confirmed'): ?>
                                <button class="btn-sm btn-confirm" onclick="updateStatus('<?= $a['id'] ?>','completed',this)">Complete</button>
                                <button class="btn-sm btn-cancel"  onclick="updateStatus('<?= $a['id'] ?>','cancelled',this)">Cancel</button>
                            <?php else: ?>
                                <span style="color:#aaa;font-size:.8rem;"><?= ucfirst($status) ?></span>
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
<script src="<?php echo $base; ?>/public/js/admin.js"></script>
<script>
const BASE = '<?= $base ?>';

async function updateStatus(id, newStatus, btn) {
    btn.disabled = true;
    const origText = btn.textContent;
    btn.textContent = '…';
    try {
        const res  = await fetch(`${BASE}/app/api/admin_appointments.php`, {
            method: 'PATCH',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id, status: newStatus }),
        });
        const data = await res.json();
        if (data.success) {
            const row = btn.closest('tr');
            row.dataset.status = newStatus;
            const badge = row.querySelector('.badge');
            if (badge) { badge.className = `badge ${newStatus}`; badge.textContent = newStatus[0].toUpperCase()+newStatus.slice(1); }
            const actionDiv = row.querySelector('.action-btns');
            if (actionDiv) {
                if (newStatus === 'confirmed') {
                    actionDiv.innerHTML = `<button class="btn-sm btn-confirm" onclick="updateStatus('${id}','completed',this)">Complete</button>
                                           <button class="btn-sm btn-cancel"  onclick="updateStatus('${id}','cancelled',this)">Cancel</button>`;
                } else {
                    actionDiv.innerHTML = `<span style="color:#aaa;font-size:.8rem;">${newStatus[0].toUpperCase()+newStatus.slice(1)}</span>`;
                }
            }
            refreshCounters();
        } else {
            alert('Update failed. Please try again.');
            btn.disabled = false; btn.textContent = origText;
        }
    } catch(e) {
        alert('Network error. Please try again.');
        btn.disabled = false; btn.textContent = origText;
    }
}

function refreshCounters() {
    const c = { pending:0, confirmed:0, cancelled:0, completed:0 };
    document.querySelectorAll('#apptTable tbody tr[data-status]').forEach(r => { const s = r.dataset.status; if (c[s]!==undefined) c[s]++; });
    ['pending','confirmed','cancelled','completed'].forEach(k => {
        const el = document.getElementById('cnt-'+k);
        if (el) el.textContent = c[k];
    });
}

function filterTable() {
    const sv = document.getElementById('statusFilter').value.toLowerCase();
    const qv = document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('#apptTable tbody tr[data-status]').forEach(row => {
        const ms = !sv || row.dataset.status === sv;
        const mq = !qv || row.textContent.toLowerCase().includes(qv);
        row.style.display = (ms && mq) ? '' : 'none';
    });
}
</script>
</body>
</html>
