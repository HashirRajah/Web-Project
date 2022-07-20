//after dom is loaded
$(document).ready(function(){
    //display animation for quick links
    $("#quick-links").fadeIn(2000);
    //
    $(document).on("click", "#quick-links .card", function() {
        let url = $(this).attr("id");
        window.location.href = url;
    });
});
