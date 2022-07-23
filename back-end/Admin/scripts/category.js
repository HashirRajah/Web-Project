//after dom is loaded
$(document).ready(function(){
    //display animation for quick links
    $("#quick-links").fadeIn(1000);
    //
    $(document).on("click", "#quick-links .card", function() {
        let cat_id = $(this).attr("id");
        window.location.href = `addMenuItems.php?cat_id=${cat_id}`;
    });
});



