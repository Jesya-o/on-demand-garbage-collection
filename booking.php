<?php require_once('session.php');

$name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$surname = isset($_SESSION['surname']) ? $_SESSION['surname'] : '';
$phone = isset($_SESSION['phone']) ? $_SESSION['phone'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$street = isset($_SESSION['street']) ? $_SESSION['street'] : '';
$house = isset($_SESSION['house']) ? $_SESSION['house'] : '';
$index = isset($_SESSION['index']) ? $_SESSION['index'] : '';
$datepicker = isset($_SESSION['datepicker']) ? $_SESSION['datepicker'] : '';
$time = isset($_SESSION['time']) ? $_SESSION['time'] : '';
$service = isset($_SESSION['service']) ? $_SESSION['service'] : '';
$comment = isset($_SESSION['comment']) ? $_SESSION['comment'] : '';
$selectedDate = isset($_SESSION['datepicker']) ? $_SESSION['datepicker'] : date('Y-m-d');
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
                            <input type="text" id="name" name="name" class="field" placeholder=" Name" required pattern="^[A-Za-z '\-šžõäöüŠŽÕÄÖÜ]{1,200}$" value="<?= $name; ?>">
                            <label for="surname">Surname</label>
                            <input type="text" id="surname" name="surname" class="field" placeholder=" Surname" required pattern="^[A-Za-z '\-šžõäöüŠŽÕÄÖÜ]{1,200}$" value="<?= $surname; ?>">
                            <label for="phone">Phone (optional) </label>
                            <input type="text" id="phone" name="phone" class="field" placeholder=" +372 58678900" pattern="^[0-9\-\+ ]{7,15}$" value="<?= $phone; ?>">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="field" placeholder=" name@example.com" required pattern="^[\w\-\.]{1,50}@([\w-]{1,50}\.){1,50}[\w-]{2,4}$" value="<?= $email; ?>">

                            <span class="Tallinn">Address: &nbsp;Tallinn, Estonia</span>
                            <div class="line">
                                <div class="address-group street">
                                    <label for="street">Street name</label>
                                    <input type="text" id="street" name="street" class="field" placeholder=" Akadeemia tee" required pattern="[\\w\\s.,'-#;^:=()~&>+=*/<!?{}\\[\\]]+" value="<?php echo $street; ?>">
                                </div>
                                <div class="address-group house">
                                    <label for="house">House</label>
                                    <input type="text" id="house" name="house" class="field" placeholder=" 8" required pattern="[\\w\\s.,'-#;^:=()~&>+=*/<!?{}\\[\\]]{1,5}" value="<?php echo $house; ?>">
                                </div>
                                <div class="address-group index">
                                    <label for="index">Postcode</label>
                                    <input type="text" id="index" name="index" class="field" placeholder=" 21800" required pattern="\d{5}" value="<?= $index; ?>">
                                </div>
                            </div>
                        </div>
                        <!-- Date picker -->
                        <div class="line time">
                            <!-- Calendar -->
                            <div class="date-row">
                                <label for="datepicker" class="calendar-label">Select a date:</label>
                                <div class="calendar-container">
                                    <div class="calendar-header">
                                        <div class="calendar-prev-month">&lt;</div>
                                        <div class="calendar-month-year"></div>
                                        <div class="calendar-next-month">&gt;</div>
                                    </div>
                                    <div class="calendar-days"></div>
                                </div>
                                <input type="hidden" id="datepicker" name="datepicker" required value="<?= isset($_SESSION['datepicker']) ? $_SESSION['datepicker'] : ''; ?>">
                            </div>
                            <!-- Available time slots -->
                            <div class="date-row">
                                <label for="datepicker" class="calendar-label time-slots">Free slots:</label>
                                <div class="calendar-container time-slots time-selector">
                                    <input type="radio" id="time1" name="time" value="10:00" <?= isset($_SESSION['time']) && $_SESSION['time'] === '10:00' ? 'checked' : ''; ?>>
                                    <label for="time1">10:00</label><br>
                                    <input type="radio" id="time2" name="time" value="11:00" <?= isset($_SESSION['time']) && $_SESSION['time'] === '11:00' ? 'checked' : ''; ?>>
                                    <label for="time2" disabled>11:00</label><br>
                                    <input type="radio" id="time3" name="time" value="12:00" <?= isset($_SESSION['time']) && $_SESSION['time'] === '12:00' ? 'checked' : ''; ?>>
                                    <label for="time3">12:00</label><br>
                                    <input type="radio" id="time4" name="time" value="13:00" <?= isset($_SESSION['time']) && $_SESSION['time'] === '13:00' ? 'checked' : ''; ?>>
                                    <label for="time4" disabled>13:00</label><br>
                                    <input type="radio" id="time5" name="time" value="14:00" <?= isset($_SESSION['time']) && $_SESSION['time'] === '14:00' ? 'checked' : ''; ?>>
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
                            <input type="radio" id="regular" name="service" value="Regular Pickup" <?= (isset($_SESSION['service']) && $_SESSION['service'] === 'Regular Pickup') ? 'checked' : ''; ?>>
                            <label for="regular">Regular pickup</label><br>
                            <input type="radio" id="recycling" name="service" value="Recycling" <?= (isset($_SESSION['service']) && $_SESSION['service'] === 'Recycling') ? 'checked' : ''; ?>>
                            <label for="recycling">Recycling</label><br>
                            <input type="radio" id="bulk" name="service" value="Bulk Waste Removal" <?= (isset($_SESSION['service']) && $_SESSION['service'] === 'Bulk Waste Removal') ? 'checked' : ''; ?>>
                            <label for="bulk">Bulk waste removal</label>
                        </div>
                        <!-- Bulk waste removal items item-weight form -->
                        <div class="form-container">
                            <p>Enter the weights of items</p>
                            <div class="form-line">
                                <label for="selector1" class="item">Item 1</label>
                                <select name="selector[]">
                                    <option value="option1">10 - 20 kg</option>
                                    <option value="option2">20 - 50 kg</option>
                                    <option value="option3">50 - 100 kg</option>
                                    <option value="option4">100 - 200 kg</option>
                                    <option value="option5">200 - 500 kg</option>
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

    <script src="js/dashboard-navigation.js"></script>
    <script src="js/bulk-waste-add-item.js"></script>
    <script src="js/dashboard-calendar.js"></script>
    <script src="js/current-date.js"></script>
    <script src="js/booking-totalprice.js"></script>
    <script src="js/booking-validation.js"></script>
    <script>
        <?php if (isset($_SESSION['error_message'])): ?>
            alert("<?= $_SESSION['error_message']; ?>");
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNUUbQx_beVyNpZ1KjcZma3KZHDGbC68U&libraries=places"></script>
    <script src="js/address-suggestions.js"></script>
</body>

</html>