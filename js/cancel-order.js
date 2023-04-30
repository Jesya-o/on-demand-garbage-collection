const cancelOrder = (button, orderId) => {
    const clientKeyElement = $('#client_key');
    const clientKey = clientKeyElement.length > 0 ? clientKeyElement.text() : null;

    if (confirm("Are you sure you want to cancel this order?") && clientKey) {
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
}

function showMessage(message) {
    const messageContainer = document.getElementById("messageContainer");
    messageContainer.innerHTML = message + '<br><br>Click to dismiss';
    messageContainer.style.display = "block";
    messageContainer.addEventListener("click", function () {
      messageContainer.style.display = "none";
    });
  
    // Set a timeout to hide the message after 3 seconds
    setTimeout(() => {
      messageContainer.style.display = "none";
    }, 3000);
  }
  