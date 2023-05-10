// Import the orderData object from the order-fetch.js module.
import { orderData } from "./resource/order-fetch.js";

// Get the container and pager elements by their IDs and set the number of orders to display per page.
const container = $('#container'),
    pager = $('#order-pager'),
    perPage = 5;

let pagesNumber;

// Define a function to format dates in a specific way.
const formatDate = (date) => {
    const dateObj = new Date(date);
    return dateObj.toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
}

// Define a function to render the orders for the specified page and number per page.
const renderOrders = (desiredPage, perPage) => {

    // Define a nested function to update the pager based on the number of orders and the current page.
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

    // Fetch the orders for the specified page and number per page.
    orderData.fetchOrdersByPage(desiredPage, perPage)
        .then((data) => {
            // Clear the container before rendering.
            container.empty();
            const { ordersNumber, orders } = data;

            // Handle the case where there are no orders.
            if (ordersNumber != 0) {
                var element = document.getElementById('no-orders');
                if (element) {
                    element.style.display = 'none';
                }
            }

            // Update the pager based on the number of orders and the current page.
            updatePager(ordersNumber, desiredPage);
            let index = perPage * (desiredPage - 1) + 1;
            orders.forEach((order) => {
                // Create the HTML elements for each order record.
                const captionText = $('<div>').addClass('order-record');
                const row = $('<div>').addClass('row');
                const info = $('<div>').addClass('info');
                const h2 = $('<h2>').text('#' + index + ' ' + order.order_type);
                const p1 = $('<p>');
                const status = order.status;

                // Customize the display of the order status and add a cancel button if the order is ongoing.
                if (status === 'Ongoing') {
                    p1.append('Ongoing by ' + formatDate(order.date) + ' at ' + order.time_slot);

                    // Create a cancel button for ongoing orders and add a click handler.
                    const cancelBtn = $('<button>').attr({
                        type: 'submit',
                        name: 'submitCancelling',
                        class: 'cancel-btn'
                    }).text('Cancel');
                    cancelBtn.click(function () {
                        cancelOrder(this, order.order_id);
                        const spanInfo = $('<span>').addClass('cancelled').text(' The driver would\'ve arrived at ' + formatDate(order.date) + ' at ' + order.time_slot);
                    p1.append(spanInfo);
                    });
                    p1.append(cancelBtn);
                } else if (status === 'Completed') {
                    // Display the completion date and time for completed orders.
                    p1.text('Completed on ' + formatDate(order.date) + ' at ' + order.time_slot);
                } else if (status === 'Cancelled') {
                    // Display a "Cancelled" label for cancelled orders and include the date and time slot.
                    const spanCancelled = $('<span>').addClass('cancelled').text('Cancelled');
                    p1.append(spanCancelled);
                    const spanInfo = $('<span>').addClass('cancelled').text(' The driver would\'ve arrived at ' + formatDate(order.date) + ' at ' + order.time_slot);
                    p1.append(spanInfo);
                }

                // Create the HTML elements for the driver name and order price.
                const p2 = $('<p>').text('Driver: ' + order.name + ' ' + order.surname);
                const price = $('<div>').addClass('price').text('Price: ' + order.price + ' EUR');

                // Append the HTML elements to the container.
                info.append(h2, p1, p2);
                row.append(info, price);
                captionText.append(row);
                container.append(captionText);

                // Increment the index to keep track of the order numbers.
                index++;

            });
        });
}

renderOrders(1, perPage);
