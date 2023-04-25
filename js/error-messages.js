const usernameInput = document.querySelector('#username');
const passwordInput = document.querySelector('#password');

usernameInput.addEventListener('input', (event) => {
	const username = usernameInput.value.trim();
	const pattern = /^[A-Za-z0-9!@#$%^&*()_+\-=[\]{};':"\\|,.<>\/?]{4,45}$/;

    if (!pattern.test(username)) {
        event.target.setCustomValidity('Username must be between 4 and 15 characters, start with a letter, and contain only English letters, numbers, underscores, or periods.');
    } else {
        event.target.setCustomValidity('');
    }
});

passwordInput.addEventListener('input', () => {
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
		passwordInput.setCustomValidity('Password should be 8-45 characters long, and contain lower-, uppercase letters, numbers and speacial characters');
	} else {
		passwordInput.setCustomValidity('');
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