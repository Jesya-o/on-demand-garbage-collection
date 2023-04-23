export const orderData = {
    ordersNumber: null,
    ordersBuffer: [],
    url: null,

    getUrl: function () {
        if (this.url === null) {
            this.url = url.substring(0, url.lastIndexOf('/')) + '/api/fetch-orders.php';
        }
        return this.url;
    },
    
    fetchOrdersByPage: function (desiredPage, ordersPerPage) {
        const clientKeyElement = $('#client_key');
        const clientKey = clientKeyElement.length > 0 ? clientKeyElement.text() : null;

        // ajax request
        $.ajax({
            type: 'GET',
            url: url.substring(0, url.lastIndexOf('/')) + '/api/fetch-orders.php',
            data: { desiredPage: desiredPage, ordersPerPage: ordersPerPage },
            beforeSend: (xhr) => {
                xhr.setRequestHeader ("Authorization", clientKey);
            },
            success: (data) => {
                console.log('success');
                console.log(data);
            },
            error: (data) => {
                console.log('error');
                console.log(data);
            }
        });
    },

    getTotalOrders: function () {
        return this.ordersNumber;
    }
};
