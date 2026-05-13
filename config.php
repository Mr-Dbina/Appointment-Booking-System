<?php
$docRoot = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] ?? ''), '/');
$dir = str_replace('\\', '/', __DIR__);
$basePath = ($docRoot && strpos($dir, $docRoot) === 0) ? substr($dir, strlen($docRoot)) : '';
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
define('BASE_URL', $protocol . '://' . $host . $basePath);
