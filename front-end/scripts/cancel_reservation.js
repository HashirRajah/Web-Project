//after dom is loaded
$(document).ready(function(){
    //
    $(document).on("click", ".cancel", function(){
        let id = $(this).attr("id");
        cancelReservation(id);
    });
    
});
//
function cancelReservation(id) {
    //api url
    let URL = "http://localhost/Web-Project/back-end/Admin/api/reservation";
    $.ajax({
        url: URL, 
        accepts: "application/json",
        method: "PUT",
        data: {
            operation: "cancel",
            reservation_id: id
        },
        cache: false, 
        error: function(xhr){
            alert("An error occured: " + xhr.status + " " + xhr.statusText);
        }
    }).done(function(data){
        data = JSON.parse(data);
        if(data.message === "reservation-cancelled"){
            html = "Reservation cancelled";
            $("#message").addClass("bg-success fs-4 lead text-white").html(html);
        } else {
            html = "Unexpected error<br />Reservation could not be cancelled.";
            $("#message").addClass("bg-danger fs-4 lead text-white").html(html);
        }
    });
};



