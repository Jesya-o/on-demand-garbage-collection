<?php

require_once('../orders-backend.php');
header('Content-Type: application/json');

$clientKey = $_SERVER['HTTP_AUTHORIZATION'] ?? null;

$response = [];

if (
    ($desiredPage = $_GET['desiredPage'] ?? null) &&
    ($ordersPerPage = $_GET['ordersPerPage'] ?? null) &&    
    $clientKey &&
    validateClientKey($clientKey)
) {
    $clientId = getClientIdFromClientKey($clientKey);
    // Get orders number
    $response['ordersNumber'] = getOrdersNumber($clientId);
    // Get orders for desired page
    $response['orders'] = fetchOrdersByPage($clientId, $desiredPage, $ordersPerPage);
}

echo json_encode($response);
