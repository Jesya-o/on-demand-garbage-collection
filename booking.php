<?php require_once('session.php');
require_once('backend-personalinfo.php');

$selectedItems = isset($_SESSION['selected_items']) ? $_SESSION['selected_items'] : '';

session_start();
if (isset($_SESSION['error_messages'])) {
    echo "<div class='message-container' id='messageContainer' style='display:block;'>";
    foreach ($_SESSION['error_messages'] as $error_message) {
        echo "$error_message<br>";
    }
    echo "<br>Message will be closed in 5s. <br> Click on the screen to close now.";
    echo "</div>";
    // Unset the session variable after displaying the messages
    unset($_SESSION['error_messages']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Booking Form</title>
    <meta name="description" content="Tallinn University of Technology – Web Technologies Project - HTML & CSS">
    <meta name="keywords" content="web_project, Throw It, book a collection">
    <meta name="author" content="Dark Side">
    <meta name="viewport" content="initial-scale=1">
    <link rel="icon" href="img/icon.png" type="image/x-icon">

    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/navigation.css">
    <link rel="stylesheet" href="styles/booking.css">

</head>

<body>
    <!-- Content section of the document -->
    <?php require_once('sidenav.php'); ?>

    <div class="message-container" id="messageContainer"></div>

    <div id="booking-main" class="booking">
        <!-- Open button -->
        <?php require_once('open-btn.php'); ?>
        <!-- Content of the page -->
        <div class="main-content">
            <!-- Booking header and current time -->
            <div class="booking-header">
                <p class="booking-header-headline">Book a collection</p>
                <span id="date-time" class="booking-header-timestamp"></span>
            </div>
            <!-- Booking form -->
            <form action="book-validation.php" name="booking" method="post" class="form-rows">
                <div class="order-form line time">
                    <!-- First row of booking form -->
                    <div class="user-info-disclaimer">
                        <!-- User info fields -->
                        <p class="booking-form-title">Enter your information</p>
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
                                    <input type="text" id="street" name="street" class="field" placeholder=" Akadeemia tee" pattern="^[\w\s\.,'\-#;^:=()~&amp;&gt;+=*\/&lt;?!{}[\]]+$" value="<?php echo empty($street) ? '' : $street; ?>">
                                </div>
                                <div class="address-group house">
                                    <label for="house">House</label>
                                    <input type="text" id="house" name="house" class="field" placeholder=" 8" pattern="^[\w\s\.,'\-#;^:=()~&amp;&gt;+=*\/&lt;?!{}[\]]+$" value="<?php echo empty($house) ? '' : $house; ?>">
                                </div>
                                <div class="address-group index">
                                    <label for="index">Postcode</label>
                                    <input type="text" id="index" name="index" class="field" placeholder=" 21800" pattern="\d{5}" value="<?php echo empty($index) ? '' : $index; ?>">
                                </div>
                            </div>

                        </div>
                        <!-- Date picker -->
                        <div class="line time">
                            <!-- Calendar -->
                            <div class="date-row">
                                <label class="calendar-label">Select a date:</label>
                                <div class="calendar-container">
                                    <div class="calendar-header">
                                        <div class="calendar-prev-month">&lt;</div>
                                        <div class="calendar-month-year"></div>
                                        <div class="calendar-next-month">&gt;</div>
                                    </div>
                                    <div class="calendar-days"></div>
                                </div>
                                <input type="hidden" id="datepicker" name="datepicker" value="<?= isset($_SESSION['datepicker']) ? $_SESSION['datepicker'] : ''; ?>">
                            </div>
                            <!-- Available time slots -->
                            <div class="date-row">
                                <label class="calendar-label time-slots">Free slots:</label>
                                <div class="calendar-container time-slots time-selector">
                                    <input type="radio" id="time1" name="time" value="10:00" <?= isset($_SESSION['time']) && $_SESSION['time'] === '10:00' ? 'checked' : ''; ?> required>
                                    <label for="time1">10:00</label><br>
                                    <input type="radio" id="time2" name="time" value="11:00" <?= isset($_SESSION['time']) && $_SESSION['time'] === '11:00' ? 'checked' : ''; ?> required>
                                    <label for="time2">11:00</label><br>
                                    <input type="radio" id="time3" name="time" value="12:00" <?= isset($_SESSION['time']) && $_SESSION['time'] === '12:00' ? 'checked' : ''; ?> required>
                                    <label for="time3">12:00</label><br>
                                    <input type="radio" id="time4" name="time" value="13:00" <?= isset($_SESSION['time']) && $_SESSION['time'] === '13:00' ? 'checked' : ''; ?> required>
                                    <label for="time4">13:00</label><br>
                                    <input type="radio" id="time5" name="time" value="14:00" <?= isset($_SESSION['time']) && $_SESSION['time'] === '14:00' ? 'checked' : ''; ?> required>
                                    <label for="time5">14:00</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Second row of booking form -->
                    <div class="order-details">
                        <!-- Selecting service to order -->
                        <p class="booking-form-title">Select the service you want</p>
                        <div class="service-selector">
                            <input type="radio" id="regular" name="service" value="Regular Pickup" <?= (isset($_SESSION['service']) && $_SESSION['service'] === 'Regular Pickup') ? 'checked' : ''; ?> required>
                            <label for="regular">Regular pickup</label><br>
                            <input type="radio" id="recycling" name="service" value="Recycling" <?= (isset($_SESSION['service']) && $_SESSION['service'] === 'Recycling') ? 'checked' : ''; ?> required>
                            <label for="recycling">Recycling</label><br>
                            <input type="radio" id="bulk" name="service" value="Bulk Waste Removal" <?= (isset($_SESSION['service']) && $_SESSION['service'] === 'Bulk Waste Removal') ? 'checked' : ''; ?> required>
                            <label for="bulk">Bulk waste removal</label>
                        </div>
                        <!-- Bulk waste removal items item-weight form -->
                        <div class="form-container">
                            <p>Enter the weights of items</p>
                            <div class="form-line">
                                <label class="item">Item 1</label>
                                <select name="selector[]">
                                    <option value="option1">1 - 20 kg</option>
                                    <option value="option2">21 - 50 kg</option>
                                    <option value="option3">51 - 100 kg</option>
                                    <option value="option4">101 - 200 kg</option>
                                    <option value="option5">201 - 500 kg</option>
                                </select>
                                <button type="button" class="remove-btn">&minus;</button>
                            </div>
                            <!-- Button for adding new lines -->
                            <div class="form-line add-elem">
                                <button type="button" class="add-btn">&plus;</button>
                            </div>
                        </div>
                        <!-- Calculated total price -->
                        <div class="total-price">
                            <p>Total:</p>
                            <p></p>
                            <input type="hidden" name="price" id="price" value="">
                        </div>
                        <!-- Comments field -->
                        <p>Anything else you want to add? (optional)</p>
                        <input maxlength="200" class="comment" type="text" name="comment" id="comment" pattern="^[\w\s\.,'\-\#\@\;\:\$\%\^\=\(\)\~\&\€\>\+=\*\/\<\?!{}\[\]]{1,200}$" placeholder="Leave a comment"><br>
                        <!-- Checkbox for saving user data -->
                        <div class="save-data-checkbox">
                            <input type="checkbox" id="saveData" name="saveData" value="saveData">
                            <label for="saveData">Save my information for futher orders</label><br>
                        </div>
                        <!-- Submit form button -->
                        <button type="submit" id="submit-btn" name="submitBooking" class="book-btn">Book!</button>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <script src="js/timeslots-availability.js"></script>
    <script src="js/dashboard-navigation.js"></script>
    <script src="js/bulk-waste-add-item.js"></script>
    <script src="js/dashboard-calendar.js"></script>
    <script src="js/current-date.js"></script>
    <script src="js/booking-totalprice.js"></script>
    <script src="js/booking-validation.js"></script>
    <script>
        const errorMessagesContainer = document.getElementById('messageContainer');
        if (errorMessagesContainer) {
            setTimeout(() => {
                errorMessagesContainer.style.display = 'none';
            }, 5000); // Hide the error messages after 5 seconds
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNUUbQx_beVyNpZ1KjcZma3KZHDGbC68U&libraries=places"></script>
    <script src="js/address-suggestions.js"></script>
</body>

</html>