// This function takes a date as a parameter and returns a URL that can be used to get available booking slots for that date.
function getUrl(date) {
    // Get the current URL of the page.
    const currentUrl = window.location.href;
    // Remove the last part of the URL (the page name) and append the booking slots API endpoint and the date parameter.
    return currentUrl.substring(0, currentUrl.lastIndexOf('/')) + '/api/booking-slots-availability.php?date=' + date;
}

// This function updates the available time slots based on the selected date.
function updateAvailableTimeSlots() {
    // Get the selected date from the datepicker input field.
    var date = document.getElementById("datepicker").value;
    // Get the current date and time as a timestamp.
    var today = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()).getTime();

    // Create a new XMLHttpRequest object.
    var xhttp = new XMLHttpRequest();
    // Set a callback function to handle the response from the server.
    xhttp.onreadystatechange = function () {
        // If the selected date is greater than or equal to today's date, and the response status is OK (200).
        if (new Date(date).getTime() >= today && this.readyState === 4 && this.status === 200) {
            // Parse the response text as JSON and update the available time slots.
            var availableSlots = JSON.parse(this.responseText);
            updateSlotStatus(availableSlots);
        }
    };
    // Open a GET request to the booking slots API endpoint with the date parameter.
    xhttp.open("GET", getUrl(date), true);
    // Send the request to the server.
    xhttp.send();
}

// This function updates the status of each time slot based on the available slots returned from the server.
function updateSlotStatus(availableSlots) {
    // Get all the time input fields.
    var timeInputs = document.querySelectorAll('input[name="time"]');
    // Loop through each time input field.
    for (var i = 0; i < timeInputs.length; i++) {
        // If the time value is included in the available slots, enable the input and set the opacity to 1.
        if (availableSlots.includes(timeInputs[i].value)) {
            timeInputs[i].disabled = false;
            timeInputs[i].nextElementSibling.style.opacity = 1;
        } else { // Otherwise, disable the input, uncheck it, and set the opacity to 0.5.
            timeInputs[i].disabled = true;
            timeInputs[i].checked = false;
            timeInputs[i].nextElementSibling.style.opacity = 0.5;
        }
    }
}
