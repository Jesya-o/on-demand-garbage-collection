// This function takes two parameters: an input field and a button. It toggles the visibility of the input field between password and text and changes the text content of the button accordingly.
function togglePasswordVisibility(inputField, button) {
  // If the input field is of type password, change it to text and change the text content of the button to "Hide".
  if (inputField.type === "password") {
    inputField.type = "text";
    button.textContent = "Hide";
  } else { // Otherwise, change the input field back to password and change the text content of the button to "Show".
    inputField.type = "password";
    button.textContent = "Show";
  }
}

// Add event listeners to the "Show/Hide" buttons for each password input field.
document.getElementById("show-old-password").addEventListener("click", function () {
  // Call the togglePasswordVisibility function and pass the old password input field and the clicked button as arguments.
  togglePasswordVisibility(document.getElementById("old-password"), this);
});

document.getElementById("show-new-password").addEventListener("click", function () {
  // Call the togglePasswordVisibility function and pass the new password input field and the clicked button as arguments.
  togglePasswordVisibility(document.getElementById("new-password"), this);
});

document.getElementById("show-repeat-password").addEventListener("click", function () {
  // Call the togglePasswordVisibility function and pass the repeat password input field and the clicked button as arguments.
  togglePasswordVisibility(document.getElementById("repeat-password"), this);
});
