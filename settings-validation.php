<?php
require_once('settings-backend-username.php');

// Function to sanitize user inputs
function sanitize($input)
{
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlspecialchars($input);
	return $input;
}

// For submitted personal settings form: if all mandatory inputs are filled - validate them and write to csv
if (
	$_SERVER['REQUEST_METHOD'] === 'POST' &&
	isset(
		$_POST['submitSettings'],
		$_POST['name'],
		$_POST['surname'],
		$_POST['email'],
		$_POST['street'],
		$_POST['house'],
		$_POST['index']
	) &&
	!empty($_POST['name'] && $_POST['surname'] && $_POST['email'] && $_POST['street'] &&
		$_POST['house'] && $_POST['index'])
) {
	// array for errors
	$error_messages = array();

	// form data writed to variables
	$name = sanitize($_POST['name']);
	$surname = sanitize($_POST['surname']);
	$email = sanitize($_POST['email']);
	$street = sanitize($_POST['street']);
	$house = sanitize($_POST['house']);
	$index = sanitize($_POST['index']);
	// Validation
	// First name check: contains only letters
	if (!preg_match("/^[A-Za-z '\-šžõäöüŠŽÕÄÖÜ]{1,30}$/", $name)) {
		$error_messages[] = "Invalid first name. Please enter only letters.";
	}
	// Last name check: contains only letters
	if (!preg_match("/^[A-Za-z '\-šžõäöüŠŽÕÄÖÜ]{1,30}$/", $surname)) {
		$error_messages[] = "Invalid last name. Please enter only letters.";
	}

	// Email check: contains @ symbol somewhere in the middle and .smth in the end
	if (!preg_match("/^[\w\-\.]{1,50}@([\w-]{1,50}\.){1,50}[\w-]{2,4}$/", $email)) {
		$error_messages[] = "Sorry, the email validation you provided is incorrect. Please enter a valid email address in the format of 'example@example.com'.";
	}
	// Street check
	if (!preg_match("/^[\w\s\.,'\-\#\;\^\:\=\(\)\~\&\>\+=\*\/\<\?!{}\[\]]+$/", $street)) {
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

	if (isset($_POST['selector']) && !empty($_POST['phone'])) {
		$phone = sanitize($_POST['phone']);
		if (!preg_match("/^[0-9\-\+ ]{7,15}$/", $phone)) {
			$error_messages[] = "Invalid phone number. There can only be +, - or numbers.";
		}
	}

	// // If validation don't fail
	// if (empty($error_messages)) {
    //}
}

// For submitted user settings form: if all mandatory inputs are filled - validate them and write to csv
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitUserSettings'])) {
	// array for errors
	$error_messages = array();

	// Validation
	// First name check: contains only letters
	if (!empty($_POST['username'])) {
		$username = sanitize($_POST['username']);
		if (!preg_match("/^[A-Za-z][A-Za-z0-9_.]{4,14}$/", $username)) {
			$error_messages[] = "Invalid first name. Please enter only letters.";
		}
	}

	if (
		!empty($_POST['old-password']) || !empty($_POST['new-password']) ||
		!empty($_POST['repeat-password'])
	) {
		if (
			empty($_POST['old-password']) || empty($_POST['new-password']) ||
			empty($_POST['repeat-password'])
		) {
			$error_messages[] = "Should be provided all the three, old, new and new repeated, passwords.";
		} else {
			$old_password = sanitize($_POST['old-password']);
			$new_password = sanitize($_POST['new-password']);
			$repeat_password = sanitize($_POST['repeat-password']);

			$password_regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@_!%*?&])[A-Za-z\d@_!%*?&]{8,15}$/";

			// Old password check
			if (!preg_match($password_regex, $old_password)) {
				// Here should be check with database username - password matching
				// Gives message invalid password

				$error_messages[] = "Password is incorrect.";
			}

			//  New password validation
			if (!preg_match($password_regex, $new_password)) {
				$error_messages[] = "Invalid password. Please try again.";
			}
			// New password should not be same as old password
			if ($new_password == $old_password) {
				$error_messages[] = "You seem to have provided the same old password. New password should not be same as old password.";
			}
			// Repeated new password validation
			if (!preg_match($password_regex, $repeat_password)) {
				$error_messages[] = "Invalid password. Try again.";
			}
			if ($new_password != $repeat_password) {
				$error_messages[] = "New password and repeated password are not the same.";
			}
		}
	}
	if (!empty($error_messages)) {
		echo "<script>alert('" . implode("\\n", $error_messages) . "');</script>";
	}
	// If validation don't fail
	if (empty($error_messages)) {
		require_once('settings-backend-change-password.php');
		echo "<script>alert('" . $Message . "');</script>";
	}
}
