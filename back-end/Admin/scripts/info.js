//after dom is loaded
$(document).ready(function(){
    getInfo();
});


//functions
function getInfo() {
    //api url
    let URL = "http://localhost/Web-Project/back-end/Admin/api/info";
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
        if(data['info'] !== "no-data"){
            $("#name").attr("placeholder", data['info'][0].name);
            $("#street").attr("placeholder", data['info'][0].street);
            $("#city").attr("placeholder", data['info'][0].city);
            $("#location").attr("placeholder", data['info'][0].googleMap_location);
            $("#email").attr("placeholder", data['info'][0].email);
            $("#capacity").attr("placeholder", data['info'][0].capacity);
            $("#op-hr").attr("placeholder", data['info'][0].opening_hr);
            $("#cl-hr").attr("placeholder", data['info'][0].closing_hr);
            $("#meta-link").attr("placeholder", data['info'][0].facebook_link);
            $("#insta-link").attr("placeholder", data['info'][0].instagram_link);
            $("#phone-number").attr("placeholder", data['info'][0].phone_number);
            $("#certificate").attr("placeholder", data['info'][0].halal_certificate);
        } else {
            html = data['info'];
            window.location.href = `#`;
            $("#message").addClass("bg-danger fs-4 lead text-white").html(html);
        }
    });
};
//



