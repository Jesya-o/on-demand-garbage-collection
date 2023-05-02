<?php

// Include database connection and token management scripts
require_once('db-connection.php');
require_once('token-management.php');

// Generator function that fetches orders for a given client from the database
function fetchOrders($clientId)
{
    // Connect to the database and prepare the SQL query
    $link = connectDatabase();
    $query = "SELECT o.order_id, o.date, o.order_type, o.time_slot, o.status, o.price, d.name, d.surname
    FROM Orders as o
    INNER JOIN Drivers as d ON o.driver_id = d.driver_id
    WHERE o.client_id = ?
    ORDER BY o.date DESC, CAST(o.time_slot AS FLOAT) DESC, o.order_id DESC";
    $statement = $link->prepare($query);

    // Bind the client ID parameter and execute the query
    $statement->bind_param(
        'i',
        $clientId
    );
    $statement->execute();

    // Get the query results, close the statement, and return orders using a generator
    $result = $statement->get_result();
    $statement->close();
    while ($order = $result->fetch_assoc()) {
        yield $order;
    }
}

// Function that returns the total number of orders for a given client
function getOrdersNumber($clientId)
{
    // Connect to the database and prepare the SQL query
    $link = connectDatabase();
    $query = "SELECT COUNT(*) as orders_number FROM Orders WHERE client_id = ?";
    $statement = $link->prepare($query);

    // Bind the client ID parameter, execute the query, and get the result
    $statement->bind_param(
        'i',
        $clientId
    );
    $statement->execute();
    $result = $statement->get_result()->fetch_assoc()['orders_number'] ?? 0;

    // Close the statement and return the result
    $statement->close();
    return $result;
}

// Function that fetches a specified number of orders for a given client, starting at a specified page number
function fetchOrdersByPage($clientId, $desiredPage, $ordersPerPage)
{
    // Connect to the database and prepare the SQL query
    $link = connectDatabase();
    $query = "SELECT o.order_id, o.date, o.order_type, o.time_slot, o.status, o.price, d.name, d.surname
    FROM Orders as o
    INNER JOIN Drivers as d ON o.driver_id = d.driver_id
    WHERE o.client_id = ?
    ORDER BY o.date DESC, CAST(o.time_slot AS FLOAT) DESC, o.order_id DESC
    LIMIT " . (int)$ordersPerPage . "  OFFSET " . (int)(($desiredPage - 1) * $ordersPerPage);
    $statement = $link->prepare($query);

    // Bind the client ID parameter, execute the query, and get the results
    $statement->bind_param(
        'i',
        $clientId
    );
    $statement->execute();
    $result = $statement->get_result();

    // Close the statement and return the results as an array
    $statement->close();
    $orders = [];
    while ($order = $result->fetch_assoc()) {
        $orders[] = $order;
    }
    return $orders;
}

// Update orders statuses to "Completed" for any ongoing orders that have passed their scheduled end time
$link = connectDatabase();
$query = "UPDATE Orders SET status = 'Completed' 
WHERE status = 'Ongoing'
AND client_id = ?
AND STR_TO_DATE(CONCAT(date, ' ', time_slot+1, ':00:00'), '%Y-%m-%d %T') <= NOW() ";
$statement = $link->prepare($query);
$statement->bind_param('i', getClientId());
$statement->execute();
$statement->close();
