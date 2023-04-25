function updateAvailableTimeSlots() {
    var date = document.getElementById("datepicker").value;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            var availableSlots = JSON.parse(this.responseText);
            updateSlotStatus(availableSlots);
        }
    };
    xhttp.open("GET", "booking-slots-availability.php?date=" + date, true);
    xhttp.send();
}

function updateSlotStatus(availableSlots) {
    var timeInputs = document.querySelectorAll('input[name="time"]');
    for (var i = 0; i < timeInputs.length; i++) {
        if (availableSlots.includes(timeInputs[i].value)) {
            timeInputs[i].disabled = false;
            timeInputs[i].nextElementSibling.style.opacity = 1;
        } else {
            timeInputs[i].disabled = true;
            timeInputs[i].nextElementSibling.style.opacity = 0.5;
        }
    }
}
