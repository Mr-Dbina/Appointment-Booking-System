<?php
session_start();
$base = 'http://localhost/appointment_booking_system';

$projectRef = 'alvgmydqyffyegcbtsyg';
$token = $_COOKIE["sb-{$projectRef}-auth-token"] ?? null;

if (!$token) {
    header("Location: $base/auth/login.php");
    exit;
}