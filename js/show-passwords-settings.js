// Function to toggle the password visibility
function togglePasswordVisibility(inputField, button) {
  if (inputField.type === "password") {
    inputField.type = "text";
    button.textContent = "Hide";
  } else {
    inputField.type = "password";
    button.textContent = "Show";
  }
}

// Add event listeners to the buttons
document.getElementById("show-old-password").addEventListener("click", function () {
  togglePasswordVisibility(document.getElementById("old-password"), this);
});

document.getElementById("show-new-password").addEventListener("click", function () {
  togglePasswordVisibility(document.getElementById("new-password"), this);
});

document.getElementById("show-repeat-password").addEventListener("click", function () {
  togglePasswordVisibility(document.getElementById("repeat-password"), this);
});