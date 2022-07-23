//after dom is loaded
$(document).ready(function(){
    //
    $('.carousel').carousel({
        interval: false,
    });
    //
    let queryString = "?date=now"
    //change pending or paid
    $(".state-change").click(function() {
        let status = $(this).siblings(".carousel-inner").children(".active").children("p").text();
        switch(status){
            case "pending":
                queryString = "?reservation-status=pending";
                getReservations(queryString);
                break;
            case "completed":
                queryString = "?reservation-status=completed";
                getReservations(queryString);
                break;
            case "cancelled":
                queryString = "?reservation-status=cancelled";
                getReservations(queryString);
                break;
            case "all":
                queryString = "";
                getReservations(queryString);
                break;
            case "today":
                queryString = "?date=now";
                getReservations(queryString);
                break;
        }
    });
    //
    getReservations(queryString);
    setInterval(getReservations(queryString), 30000);
    
});
//functions
const getReservations = (qs) => {
    //api url
    let URL = "http://localhost/Web-Project/back-end/Admin/api/reservation" + qs;
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
        if(data.reservation_details !== "no-data"){
            let html = ``;
            $.each(data.reservation_details, function(i, reservation){
                html += `
                <tr>
                    <td>${reservation.id}</td>
                    <td>${reservation.username}</td>
                    <td>
                        ${reservation.date}
                    </td>
                    <td>
                        ${reservation.time_slot}
                    </td>
                    <td>${reservation.no_of_people}</td>
                    <td>${reservation.status}</td>
                </tr>
                `;
            });
            $("#reservation-count").html("");
            //add content to table
            $("table#reservations tbody").html(html);
        } else {
            $("table#reservations tbody").html("");
            //
            html = "No Reservations.";
            $("#reservation-count").html(html);
        }
    });
};
//




