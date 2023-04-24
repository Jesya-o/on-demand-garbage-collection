<?php require_once('session.php');?>

<?php require_once('settings-validation.php'); ?>
<?php require_once('settings-backend-username.php'); ?>

<?php require_once('settings-backend-personalinfo.php'); ?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Settings</title>
    <meta name="description" content="Tallinn University of Technology – Web Technologies Project - HTML & CSS">
    <meta name="keywords" content="web_project, Throw It, book a collection">
    <meta name="author" content="Dark Side">
    <meta name="viewport" content="initial-scale=1">
    <link rel="icon" href="img/icon.png" type="image/x-icon">

    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/navigation.css">
    <link rel="stylesheet" href="styles/booking.css">
    <link rel="stylesheet" href="styles/settings.css">

</head>

<body>

    <!-- Navigation -->
    <?php require_once('sidenav.php'); ?>
    <div id="booking-main" class="booking">
        <!-- Open and Close button -->
        <div id="openbutton">
            <button class="openbtn" type="button" onclick="openNav();">
                <img src="img/menu-dash.png" alt="toggle menu">
            </button>
        </div>
        <!-- Content of the page -->
        <div class="main-content">
            <!-- Settings header and current time -->
            <div class="booking-header">
                <p class="booking-header-headline">Settings</p>
                <span id="date-time" class="booking-header-timestamp"></span>
            </div>

            <div class="order-form line time">
                <!-- Booking form -->
                <form action="settings.php" name="booking-personal" method="post" class="form-rows">
                    <!-- First row of settings form -->
                    <div class="user-info-disclaimer settings-form">
                        <!-- User info fields -->
                        <p class="booking-form-title">Personal information</p>
                        <div class="input-lines">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="field" placeholder=" Name" required pattern="^[A-Za-z '\-šžõäöüŠŽÕÄÖÜ]{1,30}$" value="<?php echo empty($name) ? '' : $name; ?>">

                        <label for="surname">Surname</label>
                        <input type="text" id="surname" name="surname" class="field" placeholder=" Surname" required pattern="^[A-Za-z '\-šžõäöüŠŽÕÄÖÜ]{1,30}$" value="<?php echo empty($surname) ? '' : $surname; ?>">

                        <label for="phone">Phone (optional)</label>
                        <input type="text" id="phone" name="phone" class="field" placeholder=" +372 58678900" pattern="^[0-9\-\+ ]{7,15}$" value="<?php echo empty($phone) ? '' : $phone; ?>">

                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="field" placeholder=" name@example.com" pattern="^[\w\-\.]{1,50}@([\w-]{1,50}\.){1,50}[\w-]{2,4}$" value="<?php echo empty($email) ? '' : $email; ?>">

                        <span class="Tallinn">Address: &nbsp;Tallinn, Estonia</span>
                        <div class="line">
                            <div class="address-group street">
                                <label for="street">Street name</label>
                                <input type="text" id="street" name="street" class="field" placeholder=" Akadeemia tee" pattern="^[\w\s\.,'\-\#\;\^\:\=\(\)\~\&\>\+=\*\/\<\?!{}\[\]]+$" value="<?php echo empty($street) ? '' : $street; ?>">
                            </div>
                            <div class="address-group house">
                                <label for="house">House</label>
                                <input type="text" id="house" name="house" class="field" placeholder=" 8" pattern="^[\w\s\.,'\-\#\;\^\:\=\(\)\~\&\>\+=\*\/\<\?!{}\[\]]+$" value="<?php echo empty($house) ? '' : $house; ?>">
                            </div>
                            <div class="address-group index">
                                <label for="index">Postcode</label>
                                <input type="text" id="index" name="index" class="field" placeholder=" 21800" pattern="\d{5}" value="<?php echo empty($index) ? '' : $index; ?>">
                            </div>
                        </div>

                            <button type="submit" name="submitSettings" class="settings-save-btn personal-settings-save-btn">Submit and save</button>
                        </div>
                    </div>
                </form>
                <!-- Booking form -->
                <form action="settings.php" name="booking-account" method="post" class="form-rows">
                    <!-- Second row of settings form -->
                    <div class="order-details settings-form">
                        <div class="input-lines">
                            <!-- Username -->
                            <p class="booking-form-title">Account information</p>
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" class="field" required value="<?php echo $username; ?>" pattern="^[A-Za-z '\-šžõäöüŠŽÕÄÖÜ]{2,200}$">

                            <!-- Change password -->
                            <p class="booking-form-title">Change password</p>
                            <label for="old-password">Old password</label>
                            <div id="old-password-group">
                                <input type="password" id="old-password" class="field" name="old-password" required pattern="[A-Za-z0-9!@#%^&*()_+-=]{8,15}">
                                <button type="button" id="show-old-password">Show</button>
                            </div>
                            <br>
                            <label for="new-password">New password</label>
                            <div id="new-password-group">
                                <input type="password" id="new-password" class="field" name="new-password" required pattern="[A-Za-z0-9!@#%^&*()_+-=]{8,15}">
                                <button type="button" id="show-new-password">Show</button>
                            </div>
                            <br>
                            <label for="repeat-password">Repeat password</label>
                            <div id="repeat-password-group">
                                <input type="password" id="repeat-password" class="field" name="repeat-password" required pattern="[A-Za-z0-9!@#%^&*()_+-=]{8,15}">
                                <button type="button" id="show-repeat-password">Show</button>
                            </div>

                            <!-- Submit form button -->
                            <button type="submit" name="submitUserSettings" class="settings-save-btn user-settings-save-btn" style="position: absolute; bottom: -110px;">Submit and save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="js/dashboard-navigation.js"></script>
    <script src="js/current-date.js"></script>
    <script src="js/show-passwords-settings.js"></script>
    <script src="js/error-messages-settings.js"></script>
</body>

</html>