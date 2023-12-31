<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the entered username and password
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Check if the entered username and password are valid
  if (
    preg_match("/^[A-Za-z0-9!@#$%^&*()_+\\-=\\[\\]{};':\"\\\\|,.<>\\/\\?]{4,45}$/", $username) &&
    preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,45}$/', $password)
  ) {
    require_once('db-register-user.php');
    if (checkUsernameUnique($username)) {
      registerUser($username, $password);

      // Generate token
      require_once('token-management.php');
      if ($client_key = authenticateUser($username, $password)) {
        $_SESSION['client_key'] = $client_key;
      }

      // Redirect to booking.php if the username and password are valid
      header("Location: booking.php");
      exit;
    } else {
      $errorMessage = "Sorry, seems this username has already been taken.";
    }
  } else {
    // Display error message if the username and/or password are invalid
    $errorMessage = "Invalid username and/or password.";
  }
}
