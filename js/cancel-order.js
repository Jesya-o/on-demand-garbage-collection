// Function that is triggered when a user clicks on a cancel button to cancel an order
const cancelOrder = (button, orderId) => {
    // retrieves the client key
    const clientKeyElement = $('#client_key');
    const clientKey = clientKeyElement.length > 0 ? clientKeyElement.text() : null;

    if (clientKey) {
        // check if the user confirms the cancellation
        showCustomConfirm("Are you sure you want to cancel this order?").then((confirmed) => {
            if (confirmed) {
                const url = window.location.href;

                // sends an AJAX request to a PHP script on the server to cancel the order
                $.ajax({
                    type: 'POST',
                    url: url.substring(0, url.lastIndexOf('/')) + '/api/cancel-order.php',
                    data: { orderId: orderId },
                    beforeSend: (xhr) => {
                        xhr.setRequestHeader("Authorization", clientKey);
                    },
                    success: (data) => {
                        // update the status of the order to 'Cancelled'
                        const statusElement = button.parentElement;
                        const cancelledLabel = document.createElement('span');
                        cancelledLabel.textContent = 'Cancelled';
                        const spanInfo = $('<span>').addClass('cancelled').text(' The driver would\'ve arrived at ' + formatDate(order.date) + ' at ' + order.time_slot);
                    p1.append(spanInfo);
                        cancelledLabel.className = 'cancelled';
                        // Reload the current page
location.reload();

                        statusElement.innerHTML = '';
                        statusElement.appendChild(cancelledLabel);

                        // display a success message to the user
                        showMessage('Order canceled successfully!');
                    },
                    error: (data) => {
                        // displays an error message to the user
                        showMessage('Could not cancel order!');
                        if (data?.responseJSON?.reloadRequired) {
                            location.reload();
                        }
                    }
                });
            }
        });
    }
}

// Function that displays a message to the user on the web page
// Input: message
function showMessage(message) {
    // create an HTML element to display the message
    const messageContainer = document.getElementById("messageContainer");
    messageContainer.innerHTML = message + '<br><br>Click on me to hide the message now';
    messageContainer.style.display = "block";

    // add an event listener to hide the message when it is clicked
    messageContainer.addEventListener("click", function () {
        messageContainer.style.display = "none";
    });

    // Set a timeout to hide the message after 3 seconds
    setTimeout(() => {
        messageContainer.style.display = "none";
    }, 3000);
}

// function that displays a custom confirmation message to the user
// Input: message
function showCustomConfirm(message) {
    return new Promise((resolve) => {

        // Create an HTML element to display the message along with 'Yes' and 'No' buttons
        const confirmContainer = document.createElement('div');
        confirmContainer.className = 'custom-confirm';

        const confirmButtons = document.createElement('div');
        confirmButtons.className = 'confirm-buttons';

        const messageElement = document.createElement('p');
        messageElement.textContent = message;

        const yesButton = document.createElement('button');
        yesButton.textContent = 'Yes';

        const noButton = document.createElement('button');
        noButton.textContent = 'No';
        noButton.className = 'no-button';


        // Add event listeners to the buttons to resolve a Promise with a boolean value indicating whether the user clicked 'Yes' or 'No'
        yesButton.addEventListener('click', () => {
            document.body.removeChild(confirmContainer);
            resolve(true);
        });

        noButton.addEventListener('click', () => {
            document.body.removeChild(confirmContainer);
            resolve(false);
        });

        confirmContainer.appendChild(messageElement);
        confirmButtons.appendChild(yesButton);
        confirmButtons.appendChild(noButton);
        confirmContainer.appendChild(confirmButtons);
        document.body.appendChild(confirmContainer);
    });
}
