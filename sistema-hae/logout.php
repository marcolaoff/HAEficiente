<?php
session_start();
require_once "config.php"; // Inclui a variável $base_url
session_unset();
session_destroy();
header("Location: {$base_url}/login.html");
exit();
?>
