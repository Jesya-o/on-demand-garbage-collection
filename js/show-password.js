// Get the password input field and the "Show/Hide" button by their IDs.
const passwordInp = document.querySelector('#password');
const showPasswordButton = document.querySelector('#show-password');

// Add an event listener to the "Show/Hide" button that toggles the password visibility.
showPasswordButton.addEventListener('click', () => {
  // Check the current type of the password input field.
  const type = passwordInp.getAttribute('type') === 'password' ? 'text' : 'password';
  // Set the type of the password input field to either "text" or "password", depending on its current type.
  passwordInp.setAttribute('type', type);
  // Change the text content of the "Show/Hide" button to "Show" if the password is currently visible, or "Hide" if it is hidden.
  showPasswordButton.textContent = type === 'password' ? 'Show' : 'Hide';
});
