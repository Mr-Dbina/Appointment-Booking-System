<?php
require_once __DIR__ . '/../helpers/supabase.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

// Fetch all appointments grouped by patient for visit counts
$apptRes = supabase_get(
    'appointments',
    '?select=patient_id,status,created_at&order=created_at.desc'
);

$appointments = ($apptRes['status'] === 200 && is_array($apptRes['body']))
    ? $apptRes['body'] : [];

// Build per-patient stats
$patientStats = [];
foreach ($appointments as $a) {
    $pid = $a['patient_id'];
    if (!isset($patientStats[$pid])) {
        $patientStats[$pid] = ['visits' => 0, 'last_visit' => null];
    }
    $patientStats[$pid]['visits']++;
    if (!$patientStats[$pid]['last_visit']) {
        $patientStats[$pid]['last_visit'] = $a['created_at'];
    }
}

// Fetch profiles (public user metadata stored by your register flow)
// Try profiles table first; fall back gracefully
$profileRes = supabase_get(
    'profiles',
    '?select=id,full_name,email,phone,birthday,status&order=full_name.asc'
);

if ($profileRes['status'] === 200 && is_array($profileRes['body'])) {
    $patients = array_map(function ($p) use ($patientStats) {
        $stats = $patientStats[$p['id']] ?? ['visits' => 0, 'last_visit' => null];
        return [
            'id'         => $p['id'],
            'name'       => $p['full_name']  ?? 'N/A',
            'email'      => $p['email']      ?? '',
            'phone'      => $p['phone']      ?? '',
            'dob'        => $p['birthday']   ?? '',
            'status'     => $p['status']     ?? 'active',
            'visits'     => $stats['visits'],
            'last_visit' => $stats['last_visit']
                ? substr($stats['last_visit'], 0, 10) : '—',
        ];
    }, $profileRes['body']);

    echo json_encode($patients);
} else {
    // profiles table doesn't exist — derive patients from appointments
    $seen = [];
    $patients = [];
    foreach ($appointments as $a) {
        $pid = $a['patient_id'];
        if (!isset($seen[$pid])) {
            $seen[$pid] = true;
            $stats = $patientStats[$pid];
            $patients[] = [
                'id'         => $pid,
                'name'       => 'Patient ' . substr($pid, 0, 8),
                'email'      => '',
                'phone'      => '',
                'dob'        => '',
                'status'     => 'active',
                'visits'     => $stats['visits'],
                'last_visit' => substr($stats['last_visit'], 0, 10),
            ];
        }
    }
    echo json_encode($patients);
}
