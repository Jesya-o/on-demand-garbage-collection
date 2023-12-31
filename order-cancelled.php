<?php require_once('session.php'); ?>
<?php require_once('order-cancellation.php'); ?>
<?php 
// Check if the user accessed order-confirmed.php from order-confirmation.php
if (!isset($_SESSION['confirmation']) || $_SESSION['confirmation'] != true) {
    $_SESSION['error_message'] = "See your confirmed orders in Orders section on Dashboard. To make sure your ongoing order is confirmed, make a booking first!";
    unset($_SESSION['error_message']);
    header("Location: booking.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Order cancelled</title>
    <meta name="description" content="Tallinn University of Technology – Web Technologies Project - HTML & CSS">
    <meta name="keywords" content="web_project, Throw It, book a collection">
    <meta name="author" content="Dark Side">
    <meta name="viewport" content="initial-scale=1">
    <link rel="icon" href="img/icon.png" type="image/x-icon">

    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/navigation.css">
    <link rel="stylesheet" href="styles/order-confirmation.css">
</head>

<body>

    <!-- Navigation -->
    <?php require('sidenav.php'); ?>

    <div class="confirmation heart-container">
        <!-- Open button -->
        <?php require_once('open-btn.php'); ?>
        <div class="centered-content">

            <img src="img/broken-heart.png" class="heart" alt="broken heart">
            <div class="confirmation-message">
                <p> Your order has been cancelled. </p>
                <p> We are always glad to see you again at Throw It!</p>
            </div>

            <div class="buttons">
                <a href="booking.php" class="confirm-btn single-btn">Back to booking</a>
            </div>
        </div>

    </div>

    <script src="js/dashboard-navigation.js"></script>
</body>

</html>