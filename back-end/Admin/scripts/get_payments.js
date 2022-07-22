//after dom is loaded
$(document).ready(function(){
    //
    $('.carousel').carousel({
        interval: false,
    });
    //
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    
    if(typeof urlParams.get('order_id') === "string"){
        let orderID = urlParams.get('order_id');
        getPaymentById(orderID);
    } else {
        //get pending payments
        getPendingPayments();
        //update payments after 9 secs
        setInterval(getPayments, 9000);
    }
    //change pending or paid
    $(".paid-or-pending").click(function() {
        let status = $(this).siblings(".carousel-inner").children(".active").children("p").text();
        if(status === "pending"){
            getPendingPayments();
        } else {
            getPaidPayments();
        }
    });
    
});
//functions
const getPendingPayments = () => {
    //api url
    let URL = "http://localhost/Web-Project/back-end/Admin/api/payment?payment-status=pending";
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
        if(data.payment_details !== "no-data"){
            let html = ``;
            $.each(data.payment_details, function(i, payments){
                html += `
                <tr>
                    <td>${payments.order_id}</td>
                    <td>${payments.username}</td>
                    <td>
                        ${payments.amount}
                    </td>
                    <td>
                        ${payments.date}
                    </td>
                    <td>${payments.status}</td>
                </tr>
                `;
            });
            $("#payments-count").removeClass("bg-warning");
            $("#payments-count").html("");
            //add content to table
            $("table#payments tbody").html(html);
        } else {
            $("table#payments tbody").html("");
            //
            html = "No Payments.";
            $("#payments-count").addClass("bg-warning fs-4 lead text-white").html(html);
        }
    });
};

const getPaidPayments = () => {
    //api url
    let URL = "http://localhost/Web-Project/back-end/Admin/api/payment?payment-status=paid";
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
        if(data.payment_details !== "no-data"){
            let html = ``;
            $.each(data.payment_details, function(i, payments){
                html += `
                <tr>
                    <td>${payments.order_id}</td>
                    <td>${payments.username}</td>
                    <td>
                        ${payments.amount}
                    </td>
                    <td>
                        ${payments.date}
                    </td>
                    <td>${payments.status}</td>
                </tr>
                `;
            });
            $("#payments-count").removeClass("bg-warning");
            $("#payments-count").html("");
            //add content to table
            $("table#payments tbody").html(html);
        } else {
            $("table#payments tbody").html("");
            //
            html = "No Payments.";
            $("#payments-count").addClass("bg-warning fs-4 lead text-white").html(html);
        }
    });
};
//
const getPaymentById = (id) => {
    //api url
    let URL = `http://localhost/Web-Project/back-end/Admin/api/payment?order_id=${id}`;
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
        if(data.payment_details !== "no-data"){
            let html = ``;
            $.each(data.payment_details, function(i, payments){
                html += `
                <tr>
                    <td>${payments.order_id}</td>
                    <td>${payments.username}</td>
                    <td>
                        ${payments.amount}
                    </td>
                    <td>
                        ${payments.date}
                    </td>
                    <td>${payments.status}</td>
                </tr>
                `;
                let cls = payments.status;
                //
                if(cls === "paid"){
                    $(".pending").removeClass("active");
                } 
                $("." + cls).addClass("active");
            });
            $("#payments-count").removeClass("bg-warning");
            $("#payments-count").html("");
            //add content to table
            $("table#payments tbody").html(html);
            //
        } else {
            $("table#payments tbody").html("");
            //
            html = "No Payments.";
            $("#payments-count").addClass("bg-warning fs-4 lead text-white").html(html);
        }
    });
};
//
function getPayments() {
    let status = $(".active").children("p").text();
    if(status === "pending"){
        getPendingPayments();
    } else {
        getPaidPayments();
    }
}



