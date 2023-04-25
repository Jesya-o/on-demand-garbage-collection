<?php 
// Start the session

if (isset($_SESSION['confirmation']) && $_SESSION['confirmation'] == true) {
    // navigate to booking
    include 'sidenav-not-confirmed.php';
} else {
    // navigate to confirmation
    include 'sidenav-confirmed.php';
}
?>
