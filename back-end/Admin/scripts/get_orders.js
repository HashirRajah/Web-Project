$(document).ready(function(){
    //
    $('.carousel').carousel({
        interval: false,
    });
    //
    let type = "pick-up";
    let status = "pending";
    let queryString = `?order-status=${status}&type=${type}`;
    //
    getOrders(queryString);
    //completed-pending
    $(".completed-or-pending").click(function() {
        status = $(this).siblings(".carousel-inner").children(".active").children("p").text();
        queryString = `?order-status=${status}&type=${type}`;
        getOrders(queryString);
    });
    //pick-up-delivery
    $(".pick-up-or-delivery").click(function() {
        type = $(this).siblings(".carousel-inner").children(".active").children("p").text();
        queryString = `?order-status=${status}&type=${type}`;
        getOrders(queryString);
    });
    //update orders each 9 secs
    function getPayments() {
        type = $("#pick-up_delivery .active").children("p").text();
        status = $("#carouselExampleIndicators .active").children("p").text();
        queryString = `?order-status=${status}&type=${type}`;
        getOrders(queryString);
    }
    //
    setInterval(getPayments, 9000);
    //load more details
    //complete an order
    $(document).on("click", ".complete-order", function() {
        let o_id = $(this).parent().parent().siblings(".order-id").text();
        //
        completeOrder(o_id);
        getOrders(queryString);
    });
    //view order details
    $(document).on("click", ".view-order-details", function() {
        let o_id = $(this).parent().siblings(".order-id").text();
        window.location.href = `order_details.php?order_id=${o_id}`;
    });
    //view payment details
    $(document).on("click", ".view-payment-details", function() {
        let o_id = $(this).parent().siblings(".order-id").text();
        window.location.href = `payments.php?order_id=${o_id}`;
    });

});
//functions
function getOrders(queryString) {
    //api url
    let URL = "http://localhost/Web-Project/back-end/Admin/api/order" + queryString;
    $.ajax({
        url: URL, 
        accepts: "application/json",
        method: "GET", 
        error: function(xhr){
            alert("An error occured: " + xhr.status + " " + xhr.statusText);
        }
    }).done(function(data){
        data = JSON.parse(data);
        if(data.orders !== "no-data"){
            let html = ``;
            $.each(data.orders, function(i, order){
                html += `
                <tr>
                    <td class="order-id" >${order.id}</td>
                    <td>${order.username}</td>
                    <td>
                        ${order.date}
                    </td>
                    <td>
                        ${order.time}
                    </td>
                    <td>${order.discount}</td>
                    <td>
                        <img class="view-order-details" src="./images/plus2.png" alt="+">
                    </td>
                    <td>
                        <img class="view-payment-details" src="./images/plus2.png" alt="+">
                    </td>
                    <td>
                        <svg height="25" width="25">
                            <circle class="complete-order" cx="12.5" cy="12.5" r="10" stroke="black" stroke-width="3" fill="GreenYellow" />
                        </svg>
                    </td>
                </tr>
                `;
            });
            $("#order-count").removeClass("bg-warning");
            $("#order-count").html("");
            //add content to table
            $("table#orders tbody").html(html);
        } else {
            $("table#orders tbody").html("");
            //
            html = "No Orders.";
            $("#order-count").addClass("bg-warning fs-4 lead text-white").html(html);
        }
    });
};
//
function completeOrder(order_id) {
    let URL = "http://localhost/Web-Project/back-end/Admin/api/order";
    $.ajax({
        url: URL,
        data: {
            order_id: order_id
        },
        accepts: "application/json",
        method: "PUT", 
        error: function(xhr){
            alert("An error occured: " + xhr.status + " " + xhr.statusText);
        }
    }).done(function(data){
        data = JSON.parse(data);
        //
        let html;
        if(data.message === "order-completed"){
            html = "Order completed";
            $("#message").addClass("bg-success fs-4 lead text-white").html(html);
            getFlaggedComments();
        } else {
            html = "Unexpected error<br />Order could not be completed.";
            $("#message").addClass("bg-danger fs-4 lead text-white").html(html);
        }
    });
}
