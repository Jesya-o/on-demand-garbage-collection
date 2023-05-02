<?php
require_once('db-connection.php');

// Function to register a new user
function registerUser($username, $password) {
    $link = connectDatabase();
    $query = "INSERT INTO Clients (username, password) VALUES (?, ?)";
    $statement = $link->prepare($query);

    // Bind parameters to the prepared statement
    $statement->bind_param(
        'ss',
        $username, // username
        password_hash($password, PASSWORD_ARGON2I) // password hashed with Argon2i
    );

    // Execute the statement and return true if successful
    if ($statement->execute()) {
        $statement->close();
        return true;
    }
    return false;
}

// Function to check if a username already exists in the database
function checkUsernameUnique($username) {
    $link = connectDatabase();
    $query = "SELECT username FROM Clients WHERE username = ?";
    $statement = $link->prepare($query);

    // Bind parameters to the prepared statement
    $statement->bind_param(
        's',
        $username // username
    );

    // Execute the statement and fetch the data
    $statement->execute();
    $data = $statement->get_result()->fetch_assoc();
    $statement->close();

    // Return true if the data is not set (i.e., username is unique)
    return !isset($data['username']);
}
