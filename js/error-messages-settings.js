const usernameInput = document.getElementById('username');
const oldPasswordInput = document.getElementById('old-password');
const newPasswordInput = document.getElementById('new-password');
const repeatPasswordInput = document.getElementById('repeat-password');
const usernameError = document.getElementById('usernameError');
const oldPasswordError = document.getElementById('OldPasswordError');
const newPasswordError = document.getElementById('NewPasswordError');
const repeatPasswordError = document.getElementById('RepeatPasswordError');

const usernamePattern = /^[A-Za-z0-9!@#$%^&*()_+\-=[\]{};':"\\|,.<>\/?]{4,45}$/;
const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,45}$/;

function validatePasswordInput(passwordInput) {
	const password = passwordInput.value.trim();

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

	if (!usernamePattern.test(username)) {
		usernameError.textContent = 'Username must be between 4 and 45 characters and contain only English letters, numbers, and special characters.';
	} else {
		usernameError.textContent = '';
	}
});
oldPasswordInput.addEventListener('input', () => {
	const password = oldPasswordInput.value;

	if (!passwordPattern.test(password)) {
		oldPasswordError.textContent = 'Password must be between 8 and 45 characters, have at least one lowercase letter, one uppercase letter, one number, and one special character.';
	} else {
		oldPasswordError.textContent = '';
	}
});
newPasswordInput.addEventListener('input', () => {
	const password = newPasswordInput.value;

	if (!passwordPattern.test(password)) {
		newPasswordError.textContent = 'Password must be between 8 and 45 characters, have at least one lowercase letter, one uppercase letter, one number, and one special character.';
	} else {
		newPasswordError.textContent = '';
	}
});
repeatPasswordInput.addEventListener('input', () => {
	const password = repeatPasswordInput.value;

	if (!passwordPattern.test(password)) {
		repeatPasswordError.textContent = 'Password must be between 8 and 45 characters, have at least one lowercase letter, one uppercase letter, one number, and one special character.';
	} else {
		repeatPasswordError.textContent = '';
	}
});

usernameInput.addEventListener('input', () => {
	const username = usernameInput.value.trim();

	if (!usernamePattern.test(username)) {
		usernameError.textContent = 'Username must be between 4 and 45 characters and contain only English letters, numbers, and special characters.';
	} else {
		usernameError.textContent = '';
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
