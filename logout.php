<?php
session_start();

if ($clientKey = $_SESSION['client_key'] ?? null) {
    require_once('db-connection.php');
    require_once('token-management.php');
    deleteTokenByClientId(explode(':', base64_decode($clientKey))[0]);
}
session_unset();
session_destroy();
header("Location: index.php");
exit;
