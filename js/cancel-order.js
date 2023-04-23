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
                xhr.setRequestHeader ("Authorization", clientKey);
            },
            success: (data) => {
                const statusElement = button.parentElement;
                const cancelledLabel = document.createElement('span');
                cancelledLabel.textContent = 'Cancelled';
                cancelledLabel.className = 'cancelled';

                statusElement.innerHTML = '';
                statusElement.appendChild(cancelledLabel);
                alert('Order canceled successfully!');
            },
            error: (data) => {
                alert('Could not cancel order!');
                if (data?.responseJSON?.reloadRequired) {
                    location.reload();
                }
            }
        });
    }
}
