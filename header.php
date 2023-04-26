<?php 
require_once('db-connection.php');
require_once('token-management.php');
if (
    ($clientKey = $_SESSION['client_key'] ?? null) &&
    validateClientKey($clientKey)
) {
    include 'header-logged-in.php';
} else {
    include 'header-non-logged-in.php';
}
