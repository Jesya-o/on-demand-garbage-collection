<?php

require_once('db-connection.php');
require_once('token-management.php');

function fetchOrders($clientId)
{
    $link = connectDatabase();
    $query = "SELECT o.order_id, o.date, o.order_type, o.time_slot, o.status, o.price, d.name, d.surname
    FROM Orders as o
    INNER JOIN Drivers as d ON o.driver_id = d.driver_id
    WHERE o.client_id = ?
    ORDER BY o.date DESC, CAST(o.time_slot AS FLOAT) DESC, o.order_id DESC";
    $statement = $link->prepare($query);

    $statement->bind_param(
        'i',
        $clientId
    );

    $statement->execute();
    $result = $statement->get_result();
    $statement->close();

    while($order = $result->fetch_assoc()) {
        yield $order;
    }
}

function getOrdersNumber($clientId) {
    $link = connectDatabase();
    $query = "SELECT COUNT(*) as orders_number FROM Orders WHERE client_id = ?";
    $statement = $link->prepare($query);

    $statement->bind_param(
        'i',
        $clientId
    );

    $statement->execute();
    $result = $statement->get_result()->fetch_assoc()['orders_number'] ?? 0;
    $statement->close();
    return $result;
}

function fetchOrdersByPage($clientId, $desiredPage, $ordersPerPage) {
    $link = connectDatabase();
    $query = "SELECT o.order_id, o.date, o.order_type, o.time_slot, o.status, o.price, d.name, d.surname
    FROM Orders as o
    INNER JOIN Drivers as d ON o.driver_id = d.driver_id
    WHERE o.client_id = ?
    ORDER BY o.date DESC, CAST(o.time_slot AS FLOAT) DESC, o.order_id DESC
    LIMIT " . (int)$ordersPerPage . "  OFFSET " . (int)(($desiredPage - 1) * $ordersPerPage);
    $statement = $link->prepare($query);

    $statement->bind_param(
        'i',
        $clientId
    );

    $statement->execute();
    $result = $statement->get_result();
    $statement->close();

    $orders = [];
    while($order = $result->fetch_assoc()) {
        $orders[] = $order;
    }
    return $orders;
}

// Update orders statuses
$link = connectDatabase();
$query = "UPDATE Orders SET status = 'Completed' 
WHERE status = 'Ongoing'
AND client_id = ?
AND STR_TO_DATE(CONCAT(date, ' ', time_slot+1, ':00:00'), '%Y-%m-%d %T') <= NOW() ";
$statement = $link->prepare($query);
$statement->bind_param('i', getClientId());
$statement->execute();
$statement->close();
