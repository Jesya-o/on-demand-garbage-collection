const dateInput = document.getElementById("datepicker");
const submitBtn = document.getElementById("submit-btn");
const messageContainer = document.getElementById("messageContainer");

// Show message for 3 seconds
function showMessage(message) {
  messageContainer.innerHTML = message;
  messageContainer.style.display = 'block';

  // Set a timeout to hide the message after 3 seconds
  setTimeout(() => {
    hideMessage();
  }, 3000);
}

// Hide message
function hideMessage() {
  messageContainer.style.display = 'none';
}

// If form submitted without entered data, place the message about it
submitBtn.addEventListener("click", function (event) {
  if (dateInput.value === "") {
    event.preventDefault(); // prevent form submission
    showMessage("Please choose a date.");
  }
});

// Hide the message when the user interacts with the date input field
dateInput.addEventListener("input", hideMessage);

// Hide the message when the user clicks anywhere on the screen
document.addEventListener("click", function (event) {
  // Check if the click event target is not the messageContainer itself
  // and if the target is not the submit button
  if (event.target !== messageContainer && event.target !== submitBtn) {
    hideMessage();
  }
});
