<?php
require_once('booking-backend.php');
require_once('token-management.php');

// Function to sanitize user inputs
function sanitize($input)
{
	if (is_array($input)) {
		// if input is an array, recursively call sanitize() on each element
		return array_map('sanitize', $input);
	}
	// else, sanitize the string value
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlspecialchars($input);
	return $input;
}
if (
	$_SERVER['REQUEST_METHOD'] === 'POST' &&
	isset($_POST['submitBooking'], $_POST['name'], $_POST['surname'], $_POST['email'], $_POST['street'], $_POST['house'], $_POST['index'], $_POST['datepicker'], $_POST['time'], $_POST['service'], $_POST['price']) &&
	!empty($_POST['name'] && $_POST['surname'] && $_POST['email'] && $_POST['street'] && $_POST['house'] && $_POST['index'] && $_POST['datepicker'] && $_POST['time'] && $_POST['service'])
) {
	// array for errors
	$error_messages = array();
	// form data written to variables
	$name = sanitize($_POST['name']);
	$surname = sanitize($_POST['surname']);
	$email = sanitize($_POST['email']);
	$street = sanitize($_POST['street']);
	$house = sanitize($_POST['house']);
	$index = sanitize($_POST['index']);
	$date = sanitize($_POST['datepicker']);
	$time = sanitize($_POST['time']);
	$service = sanitize($_POST['service']);
	$_SESSION['name'] = $name;
	$_SESSION['email'] = $email;
	$_SESSION['surname'] = $surname;
	$_SESSION['street'] = $street;
	$_SESSION['house'] = $house;
	$_SESSION['index'] = intval($index);
	$_SESSION['date'] = $date;
	$_SESSION['time'] = $time;
	$_SESSION['service'] = $service;
	$_SESSION['selector'] = isset($_POST['selector']) ? $_POST['selector'] : array();

	// Validation
	// First name check: contains only letters
	if (!preg_match("/^[A-Za-z '\-šžõäöüŠŽÕÄÖÜ]{1,30}$/", $name)) {
		$error_messages[] = "Invalid first name. Name should be 1-30 english/estonian letters.";
	}
	// Last name check: contains only letters
	if (!preg_match("/^[A-Za-z '\-šžõäöüŠŽÕÄÖÜ]{1,30}$/", $surname)) {
		$error_messages[] = "Invalid last name. Surname should be 1-30 english/estonian letters.";
	}

	// Email check: contains @ symbol somewhere in the middle and .smth in the end
	if (!preg_match("/^[\w\-\.]{1,50}@([\w-]{1,50}\.){1,50}[\w-]{2,4}$/", $email)) {
		$error_messages[] = "Sorry, the email validation you provided is incorrect. Please enter a valid email address in the format of 'example@example.com'.";
	}
	// Street check
	if (!preg_match("/^[\p{L}a-zA-Z\s\.,'\-\#\;\^\:\=\(\)\~\&\>\+=\*\/\<\?!{}\[\]]+$/u", $street)) {
		$error_messages[] = "Invalid street name.";
	}
	// House check
	if (!preg_match("/^[\w\s\.,'\-\#\;\^\:\=\(\)\~\&\>\+=\*\/\<\?!{}\[\]]+$/", $house)) {
		$error_messages[] = "Invalid street number.";
	}
	// Index check
	if (!preg_match("/^\d{5}$/", $index)) {
		$error_messages[] = "Invalid index.";
	}
	// Date check:
	$timestamp = strtotime($date);
	$current_date = strtotime(date('Y-m-d'));
	$date = date('Y-m-d', $timestamp);
	$dateComponents = explode('-', $date);
	$year = $dateComponents[0];
	$month = $dateComponents[1];
	$day = $dateComponents[2];

	$_SESSION['date'] = $date;

	// Should not be in the past
	if ($timestamp < $current_date) {
		$error_messages[] = "Invalid date. Date provided is in the past.";
	}
	$_SESSION['selector'] = isset($_POST['selector']) ? $_POST['selector'] : array();

	// Should exist
	if (!checkdate($month, $day, $year)) {
		$error_messages[] = "Invalid date. Not existing date.";
	}

	// Time check
	if (!in_array($time, array('10:00', '11:00', '12:00', '13:00', '14:00'))) {
		$error_messages[] = "Invalid time. Not existing time.";
	}

	if ($timestamp == $current_date) {
		$current_time = date('H:i');
		if ($current_time > $time) {
			$error_messages[] = "Time provided is in the past.";
		}
	}

	// Service check
	if (!in_array($_POST['service'], array('Regular Pickup', 'Recycling', 'Bulk Waste Removal'))) {
		$error_messages[] = "Incorrect service provided.";
	}
	if (!isset($_POST['selector']) || empty($_POST['selector'])) {
		$error_messages[] = "Please select at least one item weight";
	} else {
		foreach ($_POST['selector'] as $selected) {
			if (!in_array($selected, array('option1', 'option2', 'option3', 'option4', 'option5'))) {
				$error_messages[] = "Invalid item weight selected";
				break;
			}
		}
	}

	if (isset($_POST['selector']) && !empty($_POST['comment'])) {
		$comment = sanitize($_POST['comment']);
		if (!preg_match("/^[\w\s\.,'\-\#\@\;\$\%\^\:\=\(\)\~\&\€\>\+=\*\/\<\?!{}\[\]]+$/", $comment)) {
			$error_messages[] = "Something strange in comments.";
		}
	} else {
		$comment = '';
	}

	$driver_id = findDriver($date, $time);

	if ($driver_id === null) {
		$error_messages[] = "No available drivers for the given date and time.";
	}

	if (isset($_POST['selector']) && !empty($_POST['phone'])) {
		$phone = sanitize($_POST['phone']);
		$_SESSION['phone'] = $phone;

		if (!preg_match("/^[0-9\-\+ ]{7,15}$/", $phone)) {
			$error_messages[] = "Invalid phone number. There can only be +, - or numbers.";
		}
	} else {
		$phone = '';
	}
	if (!empty($error_messages)) {
		// Store the error messages in a session variable
		session_start();
		$_SESSION['error_messages'] = $error_messages;

		// Redirect the user back to the booking.php page
		header('Location: booking.php');
		exit();
	}
	// If validation don't fail
	if (empty($error_messages)) {
		$_SESSION['booking_made'] = true;
		// Calculate total price based on service type and selected items
		$price = 0;
		if ($service === 'Regular Pickup') {
			$price = 10;
		} else if ($service === 'Recycling') {
			$price = 15;
		} else if ($service === 'Bulk Waste Removal') {
			if (!empty($_POST['selector'])) {
				foreach ($_POST['selector'] as $selected) {
					switch ($selected) {
						case 'option1':
							$price += 45;
							break;
						case 'option2':
							$price += 90;
							break;
						case 'option3':
							$price += 200;
							break;
						case 'option4':
							$price += 420;
							break;
						case 'option5':
							$price += 750;
							break;
					}
				}
			}
		}
		$_SESSION['price'] = $price;
		$selectedItems = implode('|', $_POST['selector']);
		$_SESSION['selected_items'] = $selectedItems;
		$comment = isset($_POST['comment']) ? $_POST['comment'] : '';
		$saveDataChecked = isset($_POST['saveData']) && $_POST['saveData'] === 'saveData';
		// insert the data into the database
		$clientId = getClientId();

		if ($clientId != null) {
			// Update client data if checkbox is checked
			if ($saveDataChecked) {
				updateClientData($clientId, $name, $surname, $email, $phone, $street, $house, $index);
			}

			$_SESSION['success'] = "Your booking was successfully created.";
			header("Location: order-confirmation.php");
		} else {
			$errors['session'] = "Invalid session.";
		}
	}
}
