<?php
require_once __DIR__ . '/../config.php';
$projectRef = "alvgmydqyffyegcbtsyg";


$cookieName = "sb-{$projectRef}-auth-token";
setcookie($cookieName, "", [
    "expires"  => time() - 3600,
    "path"     => "/",
    "httponly" => true,
    "samesite" => "Lax",
]);


setcookie("sb-{$projectRef}-auth-token-code-verifier", "", [
    "expires"  => time() - 3600,
    "path"     => "/",
    "httponly" => true,
    "samesite" => "Lax",
]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <title>Signing out…</title>
  <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
</head>
<body>
<script>
  const { createClient } = supabase;
  const db = createClient(
    "https://alvgmydqyffyegcbtsyg.supabase.co",
    "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImFsdmdteWRxeWZmeWVnY2J0c3lnIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzgwNzA0MTcsImV4cCI6MjA5MzY0NjQxN30.7YGzh5EX569NXZhGvrZWh48RUNBYrSagINZQhCePX8k"
  );

  db.auth.signOut().finally(() => {
    window.location.replace("<?= BASE_URL ?>/auth/login.php");
  });
</script>
</body>
</html>