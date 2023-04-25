import { orderData } from "./resource/order-fetch.js";

// Call the function to hide the specified div

const container = $('#container'),
    pager = $('#order-pager'),
    perPage = 5;

let pagesNumber;

const formatDate = (date) => {
    const dateObj = new Date(date);
    return dateObj.toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
}

const renderOrders = (desiredPage, perPage) => {

    const updatePager = (ordersNumber, currentPage) => {
        const pagesNumberBuffer = Math.ceil(ordersNumber / perPage);

        if (pagesNumberBuffer > 1) {
            pagesNumber = pagesNumberBuffer;
            pager.empty();
            const list = $('<ul>');
            for (let i = 0; i < pagesNumber; i++) {
                const page = i + 1;
                const listItem = $('<li>');

                listItem.on('click', function () {
                    renderOrders(page, perPage);
                });

                if (page == currentPage) {
                    listItem.addClass('active-page');
                }
                listItem.text(page);
                list.append(listItem);
            }
            pager.append(list);
        }
    }

    orderData.fetchOrdersByPage(desiredPage, perPage)
        .then((data) => {
            // Clean container before rendering
            container.empty();
            const { ordersNumber, orders } = data;

            // Handle no orders case
            if (ordersNumber != 0) {
                    var element = document.getElementById('no-orders');
                    if (element) {
                        element.style.display = 'none';
                    }
            }

            updatePager(ordersNumber, desiredPage);
            let index = perPage * (desiredPage - 1) + 1;
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
                    cancelBtn.click(function () {
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
                const price = $('<div>').addClass('price').text('Price: ' + order.price + ' EUR');

                info.append(h2, p1, p2);
                row.append(info, price);
                captionText.append(row);
                container.append(captionText);

                index++;
            });
        });
}

renderOrders(1, perPage);
