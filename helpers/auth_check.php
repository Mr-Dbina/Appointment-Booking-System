<?php
require_once __DIR__ . '/../config.php';
session_start();

$projectRef = 'alvgmydqyffyegcbtsyg';
$token = $_COOKIE["sb-{$projectRef}-auth-token"] ?? null;

if (!$token) {
    header("Location: " . BASE_URL . "/auth/login.php");
    exit;
}