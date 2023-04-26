<?php

require_once('../db-connection.php');
require_once('../token-management.php');

$clientKey = $_SERVER['HTTP_AUTHORIZATION'] ?? null;
$header = 'HTTP/1.1 500 Internal Server Error';
$response = [];

if (
    ($orderId = $_POST['orderId'] ?? null) &&
    $clientKey &&
    validateClientKey($clientKey)
) {
    $link = connectDatabase();
    $query = "UPDATE Orders SET status = 'Cancelled' WHERE order_id = ? and status = 'Ongoing'";
    $statement = $link->prepare($query);
    $statement->bind_param('i', $orderId);
    $statement->execute();

    if ($statement->affected_rows > 0) {
        $header = "HTTP/1.1 200 OK";
    } else {
        $response['reloadRequired'] = true;
    }

    $statement->close();
} else {
    $header = "HTTP/1.1 401 Unauthorized";
}
header('Content-Type: application/json');
header($header);
echo json_encode($response);
