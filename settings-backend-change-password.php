<?php
require_once('db-connection.php');

    // Connect to the database
    $link = connectDatabase();

    // Prepare the database query
    $query = "SELECT password FROM Clients WHERE username = ?";
    $statement = $link->prepare($query);
    $statement->bind_param('s', $username);
    $statement->execute();

    // Get the result from the query
    $result = $statement->get_result();

    // Check if the old password is correct
    if ($result->num_rows == 1) {
        $data = $result->fetch_assoc();
        $hash = $data['password'];
        if (!password_verify($old_password, $hash)) {
            // Display error message if the old password is incorrect
            $Message = "Old password is incorrect.";
        } else {
            // Check if the new password and repeat password coincide
            if ($new_password !== $repeat_password) {
                // Display error message if the new password and repeat password do not coincide
                $Message = "New password and repeated password do not match.";
            } else {
                // Update the password in the database
                $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $query = "UPDATE Clients SET password = ? WHERE username = ?";
                $statement = $link->prepare($query);
                $statement->bind_param('ss', $new_hash, $username);
                $statement->execute();

                // Display success message if the password is updated successfully
                $Message = "Password updated successfully.";
            }
        }
    }

    // Close the database connection
    $statement->close();
    $link->close();
