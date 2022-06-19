//after dom is loaded
$(document).ready(function(){
    //get flagged comments every 5 seconds
    getFlaggedComments();
    setInterval(getFlaggedComments, 5000);

    //display animation for quick links
    $("#quick-links").fadeIn(2000);
});

//functions
const getFlaggedComments = () => {
    const URL = "http://localhost/restaurantProject/back-end/Admin/get_data/getFlaggedReviews.php";
    let result;
    $.getJSON(URL, function(data){
        
    });
};


