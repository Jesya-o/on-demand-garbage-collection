<?php 
require_once('db-connection.php');
require_once('token-management.php');
if (
    ($clientKey = $_SESSION['client_key'] ?? null) &&
    validateClientKey($clientKey)
) {
    //header with log out and book
    include 'header-logged-in.php';
} else {
    //header with log in and register
    include 'header-non-logged-in.php';
}
