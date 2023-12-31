<?php
require_once('db-connection.php');
require_once('token-management.php');
$clientId = getClientId();

// Connect to the database
$link = connectDatabase();

// Prepare the database query
$query = "SELECT username, name, surname, email, phone_number, street, house, postcode FROM Clients WHERE client_id = ?";
$statement = $link->prepare($query);
$statement->bind_param('i', $clientId);
$statement->execute();

// Get the result from the query
$result = $statement->get_result();

// Retrieve the client data from the result
$data = $result->fetch_assoc();
$username = $data['username'];
$name = $data['name'];
$surname = $data['surname'];
$email = $data['email'];
$phone = $data['phone_number'];
$street = $data['street'];
$house = $data['house'];
$index = $data['postcode'];

// Close the database connection and free the result set
$statement->close();
$link->close();
