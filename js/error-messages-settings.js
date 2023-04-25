const usernameInput = document.querySelector('#username');
const oldPasswordInput = document.querySelector('#old-password');
const newPasswordInput = document.querySelector('#new-password');
const repeatPasswordInput = document.querySelector('#repeat-password');

function validatePasswordInput(passwordInput) {
	const password = passwordInput.value.trim();

	const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,45}$/;

	if (password.length === 0) {
		passwordInput.setCustomValidity('Password is required');
	} else if (password.length < 8) {
		passwordInput.setCustomValidity('Password must be at least 8 characters');
	} else if (!/[a-z]/.test(password)) {
		passwordInput.setCustomValidity('Password must contain at least one lowercase letter');
	} else if (!/[A-Z]/.test(password)) {
		passwordInput.setCustomValidity('Password must contain at least one uppercase letter');
	} else if (!/\d/.test(password)) {
		passwordInput.setCustomValidity('Password must contain at least one number');
	} else if (!/[\W_]/.test(password)) {
		passwordInput.setCustomValidity('Password must contain at least one special character');
	} else if (password.length > 45) {
		passwordInput.setCustomValidity('Password cannot be more than 45 characters');
	} else if (!passwordPattern.test(password)) {
		passwordInput.setCustomValidity('Password does not meet the required pattern');
	} else {
		passwordInput.setCustomValidity('');
	}

}

usernameInput.addEventListener('input', () => {
	const username = usernameInput.value.trim();
	const pattern = /^[A-Za-z][A-Za-z0-9_.]{4,14}$/;

	if (username.length === 0) {
		usernameInput.setCustomValidity('Username is required');
	} else if (username.length < 5) {
		usernameInput.setCustomValidity('Username must be at least 5 characters');
	} else if (username.length > 15) {
		usernameInput.setCustomValidity('Username cannot be more than 15 characters');
	} else if (!pattern.test(username)) {
		usernameInput.setCustomValidity('Username can only contain letters from English alphabet, numbers, dots, and underscores, and must start with a letter');
	} else {
		usernameInput.setCustomValidity('');
	}
});

oldPasswordInput.addEventListener('input', () => {
	validatePasswordInput(oldPasswordInput);
});

newPasswordInput.addEventListener('input', () => {
	validatePasswordInput(newPasswordInput);
});

repeatPasswordInput.addEventListener('input', () => {
	validatePasswordInput(repeatPasswordInput);
});

// add event listener for invalid event on username input
usernameInput.addEventListener('invalid', () => {
	if (usernameInput.validity.valueMissing) {
		usernameInput.setCustomValidity('Username is required');
	} else {
		usernameInput.setCustomValidity('');
	}
});

// add event listener for invalid event on password input
oldPasswordInput.addEventListener('invalid', () => {
	if (oldPasswordInput.validity.valueMissing) {
		oldPasswordInput.setCustomValidity('Password is required');
	} else {
		validatePasswordInput(oldPasswordInput);
	}
});

newPasswordInput.addEventListener('invalid', () => {
	if (newPasswordInput.validity.valueMissing) {
		newPasswordInput.setCustomValidity('Password is required');
	} else {
		validatePasswordInput(newPasswordInput);
	}
});

repeatPasswordInput.addEventListener('invalid', () => {
	if (repeatPasswordInput.validity.valueMissing) {
		repeatPasswordInput.setCustomValidity('Password is required');
	} else {
		validatePasswordInput(repeatPasswordInput);
	}
});
