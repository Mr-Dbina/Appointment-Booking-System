<?php
define('SUPABASE_URL', 'https://alvgmydqyffyegcbtsyg.supabase.co');
define('SUPABASE_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImFsdmdteWRxeWZmeWVnY2J0c3lnIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3ODA3MDQxNywiZXhwIjoyMDkzNjQ2NDE3fQ.uYnOkTQccvhwB7IBR8KJP8kXSE8C-BsiRKsr1RWNn44');

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


function supabase_post(string $table, array $data): array {
    $ch = curl_init(SUPABASE_URL . '/rest/v1/' . $table);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => json_encode($data),
        CURLOPT_HTTPHEADER     => [
            'apikey: '               . SUPABASE_KEY,
            'Authorization: Bearer ' . SUPABASE_KEY,
            'Content-Type: application/json',
            'Prefer: return=representation',
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