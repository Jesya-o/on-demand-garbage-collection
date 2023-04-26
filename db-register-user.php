<?php
require_once('db-connection.php');

function registerUser($username, $password) {
    $link = connectDatabase();
    $query = "INSERT INTO Clients (username, password) VALUES (?, ?)";
    $statement = $link->prepare($query);
    $statement->bind_param(
        'ss',
        $username,
        password_hash($password, PASSWORD_ARGON2I)
    );

    if ($statement->execute()) {
        $statement->close();
        return true;
    }
    return false;
}

function checkUsernameUnique($username) {
    $link = connectDatabase();
    $query = "SELECT username FROM Clients WHERE username = ?";
    $statement = $link->prepare($query);
    $statement->bind_param(
        's',
        $username
    );
    $statement->execute();
    $data = $statement->get_result()->fetch_assoc();
    $statement->close();
    return !isset($data['username']);
}
