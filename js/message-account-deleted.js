// Get the URL query parameters
const urlParams = new URLSearchParams(window.location.search);

// Check if the 'message' parameter exists
if (urlParams.has('message')) {
    const message = decodeURIComponent(urlParams.get('message'));
    const messageContainer = document.getElementById('messageContainer');
    messageContainer.innerHTML = message;
    messageContainer.style.display = 'block';

    // Hide the message after 3 seconds
    setTimeout(() => {
        messageContainer.style.display = 'none';
    }, 3000);

    // Hide the message container when the user clicks anywhere on the screen
    document.addEventListener('click', function () {
        messageContainer.style.display = 'none';
    });
}