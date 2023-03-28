<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the entered username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the entered username and password are valid
    if (preg_match('/^[A-Za-z][A-Za-z0-9_.]{4,14}$/', $username) && 
        preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@_!%*?&])[A-Za-z\d@_!%*?&]{8,15}$/', $password)) {

        if (($handle = fopen("user_data.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($data[0] === $username && $data[1] === $password) {
                    // Regenerate the session ID
                    session_regenerate_id(true);

                    // Set the session variable
                    $_SESSION['loggedIn'] = true;

                    // Redirect to booking.php if the username and password are valid
                    header("Location: booking.php");
                    exit;
                }
            }
            fclose($handle);
        }

        // Display error message if the username and password are invalid
        $errorMessage = "Seems that either your username or password is wrong.";
    } else {
        // Display error message if the username and password are invalid
        $errorMessage = "Invalid username or password format.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="Tallinn University of Technology – Web Technologies Project - HTML & CSS">
    <meta name="keywords" content="web_project, Throw It, book a collection">
    <meta name="author" content="Dark Side">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Throw It - Log In</title>
    <link rel="stylesheet" href="styles/registration.css">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="icon" href="img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/footer.css">
  </head>
  <body>
    <!-- Header section of the document -->
    <?php require_once('header.php'); ?>

    <!-- Content section of the document -->
    <div id="main" class="centered">
	<div class="welcome-header">
		<h1>Welcome to <br> Throw It</h1>
	</div>
      <div class="form-wrapper">
        <form id="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="input-lines">
            <div class="username-container">
              <input type="text" id="username" class="username" name="username" placeholder="Username" required pattern="^[A-Za-z][A-Za-z0-9_.]{4,14}$">
              <div class="error-msg" id="username-error"></div>
            </div>
            <div class="password-container">
              <input type="password" id="password" class="password" name="password" placeholder="Password" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@_!%*?&])[A-Za-z\d@_!%*?&]{8,15}$">
              <button type="button" id="show-password" class="show-password">Show</button>
              <div class="error-msg" id="password-error"></div>
            </div>
          </div>
		  <?php if(isset($errorMessage)): ?>
            <script>
			  alert('<?php echo $errorMessage; ?>');
			</script>
          <?php endif; ?>
          <div class="forgot-password">
			<a href="#">Forgot password?</a>
		  </div>
          <br>
          <button type="submit" class="login">Log in</button>
          <div class="or">
            <a>or</a>
          </div>
        </form>
        <button type="button" class="signup" onclick="window.location.href='registration.php';">New to Throw It?
				Join now</button>
      </div>
    </div>
    <script src="js/show-password.js"></script>
    <script src="js/error-messages.js"></script>
  </body>
</html>