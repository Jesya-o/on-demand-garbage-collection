
const customModal = document.getElementById("customModal");
const deleteButton = document.getElementById("deleteButton");
const okButton = document.getElementById("okButton");
const cancelButton = document.getElementById("cancelButton");

// Open the modal when the delete button is clicked
deleteButton.addEventListener("click", function () {
    customModal.style.display = "block";
});

// Redirect to delete-account.php when the OK button is clicked
okButton.addEventListener("click", function () {
    location.href = "../delete-backend.php";
});

// Close the modal when the Cancel button is clicked
cancelButton.addEventListener("click", function () {
    customModal.style.display = "none";
});
