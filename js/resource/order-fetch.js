// Define an object named 'orderData' and export it
export const orderData = {
    // Initialize 'url' property to null
    url: null,

    // Define a method named 'getUrl' to get the URL for fetching orders
    getUrl: function () {
        // Check if 'url' property is null
        if (this.url === null) {
            // If it is null, get the current URL and set 'url' property to the API endpoint
            const currentUrl = window.location.href;
            this.url = currentUrl.substring(0, currentUrl.lastIndexOf('/')) + '/api/fetch-orders.php';
        }
        // Return 'url' property
        return this.url;
    },

    // Define a method named 'fetchOrdersByPage' to fetch orders by page
    fetchOrdersByPage: function (desiredPage, ordersPerPage) {
        // Get the client key from the DOM if it exists
        const clientKeyElement = $('#client_key');
        const clientKey = clientKeyElement.length > 0 ? clientKeyElement.text() : null;

        // Save a reference to 'this' for use inside the Promise callback
        const self = this;

        // Return a Promise that will resolve with the response data or reject with an error message
        return new Promise((resolve, reject) => {
            // Send an AJAX GET request to the API endpoint with the desired page and orders per page as data
            $.ajax({
                type: 'GET',
                url: self.getUrl(),
                data: { desiredPage: desiredPage, ordersPerPage: ordersPerPage },
                beforeSend: (xhr) => {
                    // Set the 'Authorization' header with the client key
                    xhr.setRequestHeader("Authorization", clientKey);
                },
                success: (response) => {
                    // If the request is successful, resolve the Promise with the response data
                    resolve(response);
                },
                error: (data) => {
                    // If the request fails, reject the Promise with an error message and log the error to the console
                    reject(':(((');
                    console.log('error');
                    console.log(data);
                }
            });
        });
    }
};
