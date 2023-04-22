<?php
require_once('session.php');
require_once('orders-backend.php');

// foreach (fetchOrders(explode(':', base64_decode($_SESSION['client_key']))) as $order) {
//     print_r($order);
//     echo '<br>';
// }
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
    <link rel="stylesheet" href="styles/orders.css">
</head>

<body>
    <!-- Content section of the document -->
    <?php require_once('sidenav.php'); ?>
    <div id="booking-main" class="booking">
        <!-- Open button -->
        <?php require_once('open-btn.php'); ?>
        <!-- Content of the page -->
        <div id="main" class="orders">
            <h1>See all the orders</h1>
            <?php $index = 1; ?>
                <?php foreach (fetchOrders(getClientId()) as $order) : ?>
                    <!-- caption text -->
                    <div class="order-record">
                        <div class="row">
                            <div >
                                <h2>
                                    #
                                    <?= $index ?>
                                    <?= $order['order_type'] ?>
                                </h2>
                                <!-- Cancel button is available only for some time -->
                                <p><?= $order['status'] . ' order' ?>
                                    <?php if ($order['status'] == 'Ongoing') : ?>
                                        <?= ' by ' . $order['date'] ?>
                                    <?php elseif ($order['status'] == 'Completed') : ?>
                                        <?= ' on ' . $order['date'] ?>
                                    <?php endif; ?>
                                <?php if ($order['status'] == 'Ongoing') : ?>
                                    <button type="submit" onclick="alert('Order #3 cancelled!')" name="submitCancelling" class="cancel-btn">Cancel</button>
                                <?php endif; ?>
                                </p>
                                <p>
                                    Driver:
                                    <?= $order['name'] . ' ' . $order['surname'] ?>
                                </p>
                            </div>
                            <div class="price">
                                <?= $order['price'] ?>
                                EUR
                            </div>
                        </div>
                    </div>
                    <?php $index++; ?>
                <?php endforeach; ?>


            <script src="js/dashboard-navigation.js"></script>
        </div>

    </div>
</body>

</html>