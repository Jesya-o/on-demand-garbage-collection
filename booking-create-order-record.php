<?php
require_once('db-connections.php');

function createBooking($data) {
    updateClientData($data);
    createOrder($data);
}

function updateClientData($data) {
    $link = connectDatabase();
    $query = "UPDATE Client 
    SET name = ?, surname = ?, email = ?, phone_number = ? WHERE client_id = ?";
    $statement = $link->prepare($query);
    $statement->bind_param(
        'ssssi',
        $data[0],
        $data[1],
        $data[2],
        $data[10]
    );

    if ($statement->execute()) {
        $statement->close();
        return true;
    }

    return false;
}

function createOrder($data) {
    $link = connectDatabase();
    $query = "UPDATE Client 
    SET name = ?, surname = ?, email = ?, phone_number = ? WHERE client_id = ?";
    $statement = $link->prepare($query);
    $statement->bind_param(
        'ssssi',
        $data[0],
        $data[1],
        $data[2],
        $data[10]
    );

    if ($statement->execute()) {
        $statement->close();
        return true;
    }

    return false;
}
?>