const cancelOrder = (button, orderId) => {
    const clientKeyElement = $('#client_key');
    const clientKey = clientKeyElement.length > 0 ? clientKeyElement.text() : null;

    if (clientKey) {
        showCustomConfirm("Are you sure you want to cancel this order?").then((confirmed) => {
            if (confirmed) {
                const url = window.location.href;
                $.ajax({
                    type: 'POST',
                    url: url.substring(0, url.lastIndexOf('/')) + '/api/cancel-order.php',
                    data: { orderId: orderId },
                    beforeSend: (xhr) => {
                        xhr.setRequestHeader("Authorization", clientKey);
                    },
                    success: (data) => {
                        const statusElement = button.parentElement;
                        const cancelledLabel = document.createElement('span');
                        cancelledLabel.textContent = 'Cancelled';
                        cancelledLabel.className = 'cancelled';

                        statusElement.innerHTML = '';
                        statusElement.appendChild(cancelledLabel);
                        showMessage('Order canceled successfully!');
                    },
                    error: (data) => {
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

function showMessage(message) {
    const messageContainer = document.getElementById("messageContainer");
    messageContainer.innerHTML = message + '<br><br>Click on me to hide the message now';
    messageContainer.style.display = "block";
    messageContainer.addEventListener("click", function () {
        messageContainer.style.display = "none";
    });

    // Set a timeout to hide the message after 3 seconds
    setTimeout(() => {
        messageContainer.style.display = "none";
    }, 3000);
}

function showCustomConfirm(message) {
    return new Promise((resolve) => {
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
