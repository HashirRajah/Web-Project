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
    //
    $(document).on("click", ".complete-reservation", function(){
        let id = $(this).attr("id");
        completeReservation(id);
        getReservations(queryString);
    });
    
});
//functions
function getReservations(qs) {
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
        let sts = data.reservation_details[0].status;
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
                `;
                //
                if(reservation.status === "pending"){
                    html += `
                    <td class="">
                        <svg height="25" width="25">
                            <circle id="${reservation.id}" class="complete-reservation" cx="12.5" cy="12.5" r="10" stroke="black" stroke-width="3" fill="GreenYellow" />
                        </svg>
                    </td>
                    `;
                }
                //
                html += `</tr>`;
            });
            $("#reservation-count").html("");
            //add content to table
            $("table#reservations tbody").html(html);
            //
            if(sts === "pending"){
                if(document.querySelector("table#reservations thead tr th.reservation-completion-col") === null){
                    $("table#reservations thead tr").append('<th class="reservation-completion-col" scope="col">complete-reservation</th>');
                }
            } else {
                $(".reservation-completion-col").remove();
            }
        } else {
            $("table#reservations tbody").html("");
            //
            html = "No Reservations.";
            $("#reservation-count").html(html);
        }
    });
};
//
function completeReservation(id) {
    //api url
    let URL = "http://localhost/Web-Project/back-end/Admin/api/reservation";
    $.ajax({
        url: URL, 
        accepts: "application/json",
        method: "PUT",
        data: {
            operation: "complete",
            reservation_id: id
        },
        cache: false, 
        error: function(xhr){
            alert("An error occured: " + xhr.status + " " + xhr.statusText);
        }
    }).done(function(data){
        data = JSON.parse(data);
        if(data.message === "reservation-completed"){
            html = "Reservation completed";
            $("#message").addClass("bg-success fs-4 lead text-white").html(html);
        } else {
            html = "Unexpected error<br />Reservation could not be completed.";
            $("#message").addClass("bg-danger fs-4 lead text-white").html(html);
        }
    });
};



