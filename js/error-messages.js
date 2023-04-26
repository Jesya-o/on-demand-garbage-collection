const usernameInput = document.getElementById('username');
const passwordInput = document.getElementById('password');
const usernameError = document.getElementById('usernameError');
const passwordError = document.getElementById('passwordError');

const usernamePattern = /^[A-Za-z0-9!@#$%^&*()_+\-=[\]{};':"\\|,.<>\/?]{4,45}$/;
const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,45}$/;

usernameInput.addEventListener('input', () => {
	const username = usernameInput.value.trim();

	if (!usernamePattern.test(username)) {
		usernameError.textContent = 'Username must be between 4 and 45 characters and contain only English letters, numbers, and special characters.';
	} else {
		usernameError.textContent = '';
	}
});

passwordInput.addEventListener('input', () => {
	const password = passwordInput.value;

	if (!passwordPattern.test(password)) {
		passwordError.textContent = 'Password must be between 8 and 45 characters, have at least one lowercase letter, one uppercase letter, one number, and one special character.';
	} else {
		passwordError.textContent = '';
	}
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
passwordInput.addEventListener('invalid', () => {
	if (passwordInput.validity.valueMissing) {
		passwordInput.setCustomValidity('Password is required');
	} else {
		passwordInput.setCustomValidity('');
	}
});

// document.getElementById('signup').addEventListener('submit', (event) => {
// 	event.preventDefault();
// });