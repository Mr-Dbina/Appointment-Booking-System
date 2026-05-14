<?php
require_once __DIR__ . '/../helpers/supabase.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Fetch all appointments
$apptRes = supabase_get('appointments', '?select=status,created_at,patient_id,doctor_id,service:service_id(name),time_slot:time_slot_id(slot_date,start_time),doctor:doctor_id(name)&order=created_at.desc&limit=10');

$allRes = supabase_get('appointments', '?select=status');

$stats = ['total' => 0, 'pending' => 0, 'confirmed' => 0, 'cancelled' => 0, 'completed' => 0];

if ($allRes['status'] === 200 && is_array($allRes['body'])) {
    foreach ($allRes['body'] as $a) {
        $stats['total']++;
        $s = $a['status'] ?? 'pending';
        if (isset($stats[$s])) $stats[$s]++;
    }
}

$recent = ($apptRes['status'] === 200 && is_array($apptRes['body'])) ? $apptRes['body'] : [];

// Fetch patient count
$patientRes = supabase_get('profiles', '?select=id');
$patientCount = ($patientRes['status'] === 200 && is_array($patientRes['body']))
    ? count($patientRes['body']) : 0;

// Fetch doctor count
$doctorRes = supabase_get('doctors', '?select=id,status');
$doctorCount = ($doctorRes['status'] === 200 && is_array($doctorRes['body']))
    ? count($doctorRes['body']) : 0;

echo json_encode([
    'stats'         => $stats,
    'patient_count' => $patientCount,
    'doctor_count'  => $doctorCount,
    'recent'        => $recent,
]);