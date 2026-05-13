<?php
require_once __DIR__ . '/../helpers/supabase.php';
header('Content-Type: application/json');

$name = $_GET['name'] ?? '';
if (!$name) { echo json_encode(['id' => null]); exit; }

$res = supabase_get('services', '?name=eq.' . urlencode($name) . '&select=id');
echo json_encode(['id' => $res['body'][0]['id'] ?? null]);