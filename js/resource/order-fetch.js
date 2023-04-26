export const orderData = {
    url: null,

    getUrl: function () {
        if (this.url === null) {
            const currentUrl = window.location.href;
            this.url = currentUrl.substring(0, currentUrl.lastIndexOf('/')) + '/api/fetch-orders.php';
        }
        return this.url;
    },

    fetchOrdersByPage: function (desiredPage, ordersPerPage) {
        const clientKeyElement = $('#client_key');
        const clientKey = clientKeyElement.length > 0 ? clientKeyElement.text() : null;
        const self = this;
        // ajax request
        return new Promise((resolve, reject) => {
            $.ajax({
                type: 'GET',
                url: self.getUrl(),
                data: { desiredPage: desiredPage, ordersPerPage: ordersPerPage },
                beforeSend: (xhr) => {
                    xhr.setRequestHeader("Authorization", clientKey);
                },
                success: (response) => {
                    resolve(response);
                },
                error: (data) => {
                    // Handle error...
                    reject(':(((');
                    console.log('error');
                    console.log(data);
                }
            });
        });
    }
};
