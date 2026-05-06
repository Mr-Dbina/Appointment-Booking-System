<?php
// Load .env manually (or use vlucas/phpdotenv via composer)
$env = parse_ini_file(__DIR__ . '/../../../.env');

define('SUPABASE_URL',  $env['SUPABASE_URL']);
define('SUPABASE_KEY',  $env['SUPABASE_SERVICE_KEY']);
define('ENCRYPT_KEY',   $env['ENCRYPT_KEY']);

function supabase_rpc(string $function, array $params): array {
    $ch = curl_init(SUPABASE_URL . '/rest/v1/rpc/' . $function);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => json_encode($params),
        CURLOPT_HTTPHEADER     => [
            'apikey: '               . SUPABASE_KEY,
            'Authorization: Bearer ' . SUPABASE_KEY,
            'Content-Type: application/json',
        ],
    ]);
    $body   = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ['status' => $status, 'body' => json_decode($body, true)];
}

function supabase_get(string $table, string $filter = ''): array {
    $ch = curl_init(SUPABASE_URL . '/rest/v1/' . $table . $filter);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => [
            'apikey: '               . SUPABASE_KEY,
            'Authorization: Bearer ' . SUPABASE_KEY,
        ],
    ]);
    $body   = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ['status' => $status, 'body' => json_decode($body, true)];
}

function supabase_patch(string $table, string $filter, array $data): array {
    $ch = curl_init(SUPABASE_URL . '/rest/v1/' . $table . $filter);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST  => 'PATCH',
        CURLOPT_POSTFIELDS     => json_encode($data),
        CURLOPT_HTTPHEADER     => [
            'apikey: '               . SUPABASE_KEY,
            'Authorization: Bearer ' . SUPABASE_KEY,
            'Content-Type: application/json',
            'Prefer: return=minimal',
        ],
    ]);
    $body   = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ['status' => $status, 'body' => json_decode($body, true)];
}