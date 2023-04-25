<?php
require_once('db-connection.php');
require_once('token-management.php');

if ($orderId = $_GET['orderId'] ?? false) {
    $link = connectDatabase();
    $query = "UPDATE Orders SET status = 'Cancelled' WHERE order_id = ? and status = 'Ongoing'";
    $statement = $link->prepare($query);
    $statement->bind_param('i', $orderId);
    $statement->execute();
}
