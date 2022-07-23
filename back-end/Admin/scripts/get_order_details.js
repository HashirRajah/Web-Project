//after dom is loaded
$(document).ready(function(){
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    //get details
    let orderID = "";
    if(typeof urlParams.get('order_id') === "string"){
        orderID = urlParams.get('order_id');
        getOrderDetails(orderID);
        //delivery
        if(urlParams.get('type') === "delivery"){
            getDeliveryDetails(orderID);
        }
    } else {
        getOrderDetails(null);
    }
    
    //view payment details
    $(document).on("click", ".view-payment-details", function() {
        window.location.href = `payments.php?order_id=${orderID}`;
    });
    
});


//
function getOrderDetails(order_id) {
    //api url
    let URL = "http://localhost/Web-Project/back-end/Admin/api/order-details?order_id=" + order_id;
    $.ajax({
        url: URL,
        accepts: "application/json",
        method: "GET",
        cache: false,
        error: function(xhr){
            alert("An error occured: " + xhr.status + " " + xhr.statusText);
        }
    }).done(function(data){
        data = JSON.parse(data);
        //
        let html;
        if(data.order_details !== "no-data" && data.order_details !== null){
            $.each(data.order_details, function(i, order){
                html += `
                <tr>
                    <td>${order.item_id}</td>
                    <td>${order.name}</td>
                    <td>
                        ${order.price}
                    </td>
                    <td>
                        ${order.qty}
                    </td>
                </tr>
                `;
            });
            //add contents
            $("table#order-det tbody").html(html);
        } else {
            html = data.status;
            $("#message").addClass("bg-danger fs-4 lead text-white").html(html);
        }
    });
};

//get delivery details
function getDeliveryDetails(order_id) {
    //api url
    let URL = "http://localhost/Web-Project/back-end/Admin/api/delivery?order_id=" + order_id;
    $.ajax({
        url: URL,
        accepts: "application/json",
        method: "GET",
        cache: false,
        error: function(xhr){
            alert("An error occured: " + xhr.status + " " + xhr.statusText);
        }
    }).done(function(data){
        data = JSON.parse(data);
        //
        let html;
        if(data.delivery_details !== "no-data" && data.delivery_details !== null){
            $.each(data.delivery_details, function(i, delivery){
                html += `
                <tr>
                    <td>${delivery.id}</td>
                    <td>${delivery.street}</td>
                    <td>
                        ${delivery.city}
                    </td>
                    <td>
                        ${delivery.house_number}
                    </td>
                    <td>${delivery.status}</td>
                    <td>${delivery.delivey_instructions}</td>
                    <td>${delivery.delivery_date}</td>
                </tr>
                `;
            });
            //add contents
            $("div#delivery").css({"display":"block"});
            $("table#delivery-det tbody").html(html);
        } else {
            html = data.status;
            $("#message").addClass("bg-danger fs-4 lead text-white").html(html);
        }
    });
};

