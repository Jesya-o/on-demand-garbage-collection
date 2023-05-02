// Get references to HTML elements
const datepicker = document.getElementById('datepicker');
const calendarContainer = document.querySelector('.calendar-container');
const calendarMonthYear = document.querySelector('.calendar-month-year');
const calendarDays = document.querySelector('.calendar-days');
const calendarPrevMonth = document.querySelector('.calendar-prev-month');
const calendarNextMonth = document.querySelector('.calendar-next-month');
const timeSlots = document.querySelectorAll('.time-selector input[type="radio"]');

// Define arrays for months and days of the week
const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
const daysOfWeek = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];

// Initialize current and selected dates and month/year values
const currentDate = new Date();
let selectedDate = currentDate;
let currentMonth = currentDate.getMonth();
let currentYear = currentDate.getFullYear();

// Function to update the calendar view
function updateCalendar() {
    // Update month and year heading
    calendarMonthYear.innerHTML = months[currentMonth] + ' ' + currentYear;

    // Calculate first day of the month and number of days in the month
    const firstDayOfMonth = new Date(currentYear, currentMonth, 1).getDay() || 7;
    const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

    // Generate HTML for days of the week
    let daysHtml = '';
    for (let i = 1; i <= 7; i++) {
        daysHtml += '<div class="calendar-day">' + daysOfWeek[i % 7] + '</div>';
    }

    // Generate HTML for empty days before the first day of the month
    for (let i = 1; i < firstDayOfMonth; i++) {
        daysHtml += '<div class="calendar-day"></div>';
    }

    // Generate HTML for days in the month
    const currentDate = new Date();
    const today = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()).getTime();
    for (let i = 1; i <= daysInMonth; i++) {
        const date = new Date(currentYear, currentMonth, i);
        let classes = 'calendar-day';

        if (date.getTime() < today) {
            classes += ' past-date';
        } else if (date.getTime() === selectedDate.getTime()) {
            classes += ' selected';
        }

        if (date.toDateString() === currentDate.toDateString()) {
            classes += ' today';
        }

        daysHtml += '<div class="' + classes + '">' + i + '</div>';
    }

    // Update calendar view with generated HTML
    calendarDays.innerHTML = daysHtml;

    // Disable past time slots and set opacity of future time slots
    timeSlots.forEach(function (slot) {
        const slotTime = new Date(selectedDate.getFullYear(), selectedDate.getMonth(), selectedDate.getDate(), slot.value.split(':')[0], slot.value.split(':')[1]).getTime();
        if (slotTime < currentDate.getTime()) {
            slot.disabled = true;
            slot.checked = false;
            slot.nextElementSibling.style.opacity = 0.5;
        } else {
            slot.disabled = false;
            slot.nextElementSibling.style.opacity = 1;
        }
    });
}

// Initial update of calendar view
updateCalendar();

// Event listener for previous month button
calendarPrevMonth.addEventListener('click', function () {
    // Check if previous month is in the past and prevent going back
    const prevMonth = currentMonth - 1;
    const prevYear = currentYear;

    // Check if previous month is in the past
    if (prevMonth < currentDate.getMonth() && prevYear <= currentDate.getFullYear()) {
        return;
    }

    // Update current month and year and update calendar view
    currentMonth--;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    updateCalendar();
});

// Event listener for next month button
calendarNextMonth.addEventListener('click', function () {
    // Update current month and year and update calendar view
    currentMonth++;
    if (currentMonth > 11) {
        currentYear++;
        currentMonth = 0;
    }
    updateCalendar();
});

// Event listener for datepicker input field
datepicker.addEventListener('click', function () {
    calendarContainer.classList.toggle('show');
});

// Event listener for calendar days
calendarDays.addEventListener('click', function (event) {
    // Check if clicked element is a calendar day and prevent selection if not
    const dayElement = event.target;
    if (!dayElement.classList.contains('calendar-day')) {
        return;
    }
    // Update selected date, calendar view, and datepicker input field value
    const day = parseInt(dayElement.innerHTML);
    selectedDate = new Date(currentYear, currentMonth, day);
    updateCalendar();
    datepicker.value = selectedDate.toLocaleDateString();

    // Hide calendar after date selection
    calendarContainer.classList.remove('show');

    // Call a function to update available time slots for the selected date
    updateAvailableTimeSlots();
});
