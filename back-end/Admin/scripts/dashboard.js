//after dom is loaded
$(document).ready(function(){
    //time
    let now = new Date();
    clock();
    setTimeout(function() {
        setInterval(clock, 60000);
    },  (60 - now.getSeconds()) * 1000);
    //display animation for quick links
    $("#quick-links").fadeIn(1000);
    //
    $(document).on("click", "#quick-links .card", function() {
        let url = $(this).attr("id");
        window.location.href = url;
    });
    //load pending orders
    let status = "pending";
    let queryString = `?order-status=${status}`;
    getOrders(queryString);
    setInterval(getOrders(queryString), 5000);
    //load reviews
    getFlaggedComments();
    setInterval(getFlaggedComments, 10000);
    //see orders
    $(document).on("click", "#more-orders", function() {
        window.location.href = "orders.php";
    });
    //see reviews
    $(document).on("click", "#more-reviews", function() {
        window.location.href = "manage_reviews.php";
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
        cache: false, 
        error: function(xhr){
            alert("An error occured: " + xhr.status + " " + xhr.statusText);
        }
    }).done(function(data){
        data = JSON.parse(data);
        if(data.orders !== "no-data"){
            let html = ``;
            //
            $.each(data.orders, function(i, order){
                if(i == 5){
                    return false;
                }
                html += `
                <tr>
                    <td class="order-id" >${order.id}</td>
                    <td class="username" >${order.username}</td>
                    <td>
                        ${order.time}
                    </td>
                    <td class="discount" >${order.type}</td>
                </tr>
                `;
            });
            $("#order-count").html("");
            //add content to table
            $("table#orders tbody").html(html);
        } else {
            $("table#orders tbody").html("");
            //
            html = "No Orders.";
            $("#order-count").html(html);
        }
    });
};
//
//functions
const getFlaggedComments = () => {
    //api url
    let URL = "http://localhost/Web-Project/back-end/Admin/api/review";
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
        if(data.data !== "no-data"){
            let html = ``;
            $.each(data.data, function(i, flaggedReview){
                if(i == 5){
                    return false;
                }
                html += `
                <tr>
                    <td class="username" >${flaggedReview.username}</td>
                    <td>${flaggedReview.comment}</td>
                </tr>
                `;
            });
            //
            $("#number-of-flagged-reviews").html("");
            //add content to table
            $("table#flagged-reviews tbody").html(html);
        } else {
            $("table#flagged-reviews tbody").html("");
            //
            html = "No flagged reviews.";
            $("#number-of-flagged-reviews").html(html);
        }
    });
};
//
function clock() {
    let time = new Date();
    let currentTime = `${time.getHours()}:${time.getMinutes()}`
    //
    $("#time").html(currentTime);
}