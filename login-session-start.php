<?php
session_start();
require_once('db-connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the entered username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the entered username and password are valid
    if (
        preg_match("/^[A-Za-z0-9!@#$%^&*()_+\\-=\\[\\]{};':\"\\\\|,.<>\\/\\?]{4,45}$/", $username) &&
        preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,45}$/', $password)
    ) {
        // Connect to the database
        $link = connectDatabase();

        // Prepare the database query
        $query = "SELECT password FROM Clients WHERE username = ?";
        $statement = $link->prepare($query);
        $statement->bind_param('s', $username);
        $statement->execute();

        // Get the result from the query
        $result = $statement->get_result();

        // Check if the username and password are valid
        if ($result->num_rows == 1) {
            $data = $result->fetch_assoc();
            $hash = $data['password'];
            if (password_verify($password, $hash)) {
                // Regenerate the session ID
                session_regenerate_id(true);

                // Generate token
                require_once('token-management.php');
                if ($client_key = authenticateUser($username, $password)) {
                    $_SESSION['client_key'] = $client_key;
                }

                // Redirect to booking.php if the username and password are valid
                header("Location: booking.php");
                exit;
            }
        }

        // Close the database connection and display error message if the username and password are invalid
        $statement->close();
        $link->close();
        $errorMessage = "Seems that either your username or password is wrong.";
    } else {
        // Display error message if the username and password are invalid
        $errorMessage = "Invalid username or password format.";
    }
}
