<?php
require_once('session.php');
require_once('orders-backend.php');
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="description" content="Tallinn University of Technology – Web Technologies Project - HTML & CSS">
    <meta name="keywords" content="web_project, Throw It, book a collection">
    <meta name="author" content="Dark Side">
    <meta name="viewport" content="initial-scale=1">
    <title>History of orders</title>
    <meta name="description" content="Booking form">
    <meta name="author" content="Dark side">
    <link rel="icon" href="img/icon.png" type="image/x-icon">

    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/navigation.css">
    <link rel="stylesheet" href="styles/booking.css">
    <link rel="stylesheet" href="styles/order-confirmation.css">
    <link rel="stylesheet" href="styles/orders.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>

<body>
    <!-- Content section of the document -->
    <?php require_once('sidenav.php'); ?>
    <div class="message-container" id="messageContainer"></div>
    <div id="booking-main" class="booking">
        <!-- Open button -->
        <?php require_once('open-btn.php'); ?>
        <!-- Content of the page -->
        <div id="main" class="orders">
            <h1>Your orders</h1>
            <div id="no-orders" class="no-orders">
                <h3 class="order-record">You have no orders at the moment</h3>
                <div class="buttons">
                    <a href="booking.php" class="back-btn">Book!</a>
                </div>
            </div>
            <div id="order-pagination">
                <div id="container"></div>
                <div id="order-pager" class="pager"></div>
            </div>
        </div>
    </div>

    <div id="client_key" style="display: none"><?= $_SESSION['client_key'] ?? '' ?></div>
    <script src="js/dashboard-navigation.js"></script>
    <script src="js/cancel-order.js"></script>
    <script type="module" src="js/orders-pagination.js"></script>
</body>

</html>