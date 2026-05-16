<?php
define('SUPABASE_URL', 'https://alvgmydqyffyegcbtsyg.supabase.co');
define('SUPABASE_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImFsdmdteWRxeWZmeWVnY2J0c3lnIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3ODA3MDQxNywiZXhwIjoyMDkzNjQ2NDE3fQ.uYnOkTQccvhwB7IBR8KJP8kXSE8C-BsiRKsr1RWNn44');

function supabase_request(string $url, string $method = 'GET', array $data = [], array $extraHeaders = []): array {
    $headers = array_merge([
        'apikey: ' . SUPABASE_KEY,
        'Authorization: Bearer ' . SUPABASE_KEY,
        'Content-Type: application/json',
    ], $extraHeaders);

    $opts = [
        'http' => [
            'method'  => $method,
            'header'  => implode("\r\n", $headers),
            'content' => $data ? json_encode($data) : null,
            'ignore_errors' => true,
        ]
    ];

    $context  = stream_context_create($opts);
    $body     = file_get_contents($url, false, $context);
    $status   = 0;

    foreach ($http_response_header as $h) {
        if (preg_match('/HTTP\/\d\.\d (\d+)/', $h, $m)) {
            $status = (int) $m[1];
        }
    }

    return ['status' => $status, 'body' => json_decode($body, true)];
}

function supabase_get(string $table, string $filter = ''): array {
    return supabase_request(SUPABASE_URL . '/rest/v1/' . $table . $filter);
}

function supabase_post(string $table, array $data): array {
    return supabase_request(
        SUPABASE_URL . '/rest/v1/' . $table,
        'POST',
        $data,
        ['Prefer: return=representation']
    );
}

function supabase_patch(string $table, string $filter, array $data): array {
    return supabase_request(
        SUPABASE_URL . '/rest/v1/' . $table . $filter,
        'PATCH',
        $data,
        ['Prefer: return=minimal']
    );
}

function supabase_rpc(string $function, array $params): array {
    return supabase_request(
        SUPABASE_URL . '/rest/v1/rpc/' . $function,
        'POST',
        $params
    );
}