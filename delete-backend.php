<?php
require_once('db-connection.php');
require_once('session.php');
require_once('token-management.php');

// Get client ID
$clientId = getClientId();

// Connect to the database
$link = connectDatabase();

// Retrieve all orders associated with the client
$query = "SELECT order_id FROM Orders WHERE client_id = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $clientId);
$stmt->execute();
$result = $stmt->get_result();

// Update driver_schedule table by setting order_id to null for the retrieved orders
while ($row = $result->fetch_assoc()) {
    $orderId = $row['order_id'];
    $updateQuery = "UPDATE driver_schedule SET order_id = NULL WHERE order_id = ?";
    $updateStmt = $link->prepare($updateQuery);
    $updateStmt->bind_param("i", $orderId);
    $updateStmt->execute();
    $updateStmt->close();

    // Delete entries from bulk_items table associated with the order
    $deleteQuery = "DELETE FROM Bulk_items WHERE order_id = ?";
    $deleteStmt = $link->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $orderId);
    $deleteStmt->execute();
    $deleteStmt->close();
}

// Delete entries from Orders and Sessions tables associated with the client
$deleteQuery = "DELETE FROM Orders WHERE client_id = ?";
$deleteStmt = $link->prepare($deleteQuery);
$deleteStmt->bind_param("i", $clientId);
$deleteStmt->execute();
$deleteStmt->close();

$deleteQuery = "DELETE FROM Sessions WHERE client_id = ?";
$deleteStmt = $link->prepare($deleteQuery);
$deleteStmt->bind_param("i", $clientId);
$deleteStmt->execute();
$deleteStmt->close();

// Delete the client entry from the Clients table
$deleteQuery = "DELETE FROM Clients WHERE client_id = ?";
$deleteStmt = $link->prepare($deleteQuery);
$deleteStmt->bind_param("i", $clientId);
$deleteStmt->execute();
$deleteStmt->close();

// Close the database connection
$link->close();

echo "<script>alert('Account deleted. We will miss you!'); window.location.href = 'index.php';</script>";
?>
