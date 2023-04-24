import { orderData } from "./resource/order-fetch.js";

const formatDate = (date) => {
    const dateObj = new Date(date);
    return dateObj.toLocaleDateString('en-GB', {day: 'numeric', month: 'short', year: 'numeric'});
}

const container = $('#order-paginator'),
    perPage = 5;

let currentPage = 1;


orderData.fetchOrdersByPage(currentPage, perPage)
    .then((orderData) => {
        // Clean container before rendering
        container.empty();

        const {ordersNumber, orders} = orderData;
        let index = perPage * (currentPage - 1) + 1;
        orders.forEach((order) => {
            const captionText = $('<div>').addClass('order-record');
            const row = $('<div>').addClass('row');
            const info = $('<div>').addClass('info');
            const h2 = $('<h2>').text('#' + index + ' ' + order.order_type);
            const p1 = $('<p>');
            const status = order.status;
            
            if (status === 'Ongoing') {
                p1.append('Ongoing by ' + formatDate(order.date) + ' at ' + order.time_slot);
                const cancelBtn = $('<button>').attr({
                    type: 'submit',
                    name: 'submitCancelling',
                    class: 'cancel-btn'
                }).text('Cancel');
                cancelBtn.click(function() {
                    cancelOrder(this, order.order_id);
                });
                p1.append(cancelBtn);
            } else if (status === 'Completed') {
                p1.text('Completed on ' + formatDate(order.date) + ' at ' + order.time_slot);
            } else if (status === 'Cancelled') {
                const span = $('<span>').addClass('cancelled').text('Cancelled');
                p1.append(span);
            }
            
            const p2 = $('<p>').text('Driver: ' + order.name + ' ' + order.surname);
            const price = $('<div>').addClass('price').text(order.price + ' EUR');
            
            info.append(h2, p1, p2);
            row.append(info, price);
            captionText.append(row);
            container.append(captionText);
            
            index++;
        });
    });

