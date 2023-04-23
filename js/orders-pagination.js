import { orderData } from "./resource/order-fetch.js";
const container = $('#order-paginator'),
    perPage = 5;

orderData.fetchOrdersByPage(123,123);


let currentPage = 1;
