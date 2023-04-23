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
    <link rel="stylesheet" href="styles/order-confirmation.css">
    <link rel="stylesheet" href="styles/orders.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>

<body>
    <!-- Content section of the document -->
    <?php require_once('sidenav.php'); ?>
    <div id="booking-main" class="booking">
        <!-- Open button -->
        <?php require_once('open-btn.php'); ?>
        <!-- Content of the page -->
        <div id="main" class="orders">
            <h1>Your orders</h1>
            <div id="order-paginator"></div>
            <?php $index = 1; ?>
            <?php foreach (fetchOrders(getClientId()) as $order) : ?>
                <!-- caption text -->
                <div class="order-record">
                    <div class="row">
                        <div>
                            <h2>
                                #
                                <?= $index ?>
                                <?= $order['order_type'] ?>
                            </h2>
                            <!-- Cancel button is available only for some time -->
                            <p>
                                <?php $dateObj = date_create($order['date']) ?>
                                <?php if ($order['status'] == 'Ongoing') : ?>
                                    <?= 'Ongoing by ' . date_format($dateObj, "d M Y") . ' at ' . $order['time_slot'] ?>
                                    <button type="submit" onclick="cancelOrder(this, <?= $order['order_id'] ?>)" name="submitCancelling" class="cancel-btn">Cancel</button>
                                <?php elseif ($order['status'] == 'Completed') : ?>
                                    <?= 'Completed on ' . date_format($dateObj, "d M Y") . ' at ' . $order['time_slot'] ?>
                                <?php elseif ($order['status'] == 'Cancelled') : ?>
                                    <span class="cancelled">Cancelled</span>
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

            <?php if ($index == 1) : ?>
                <h3 class="order-record">You have no orders at the moment</h3>
                <div class="buttons">
                    <a href="booking.php" class="back-btn">Book!</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div id="client_key" style="display: none"><?= $_SESSION['client_key'] ?? '' ?></div>
    <script src="js/dashboard-navigation.js"></script>
    <script src="js/cancel-order.js"></script>
    <script type="module" src="js/orders-pagination.js"></script>
</body>

</html>