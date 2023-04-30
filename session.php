<?php
// Set session expiration time to 30 minutes
ini_set('session.gc_maxlifetime', 1800);
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);

ob_start();

// Start the session
session_start();

require_once('db-connection.php');
require_once('token-management.php');
// If the session variable is not set, redirect to the login page
if (
    !($clientKey = $_SESSION['client_key'] ?? null) ||
    !validateClientKey($clientKey)
) {
    echo "<script>
    const message = encodeURIComponent('Please log in again!');
    window.location.href = 'index.php?message=' + message;
    </script>
    ";
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");
    exit;
}

ob_end_flush();
