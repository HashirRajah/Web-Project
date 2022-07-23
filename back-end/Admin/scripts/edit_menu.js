//after dom is loaded
$(document).ready(function(){

    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    
    if(typeof urlParams.get('item_id') === "string"){
        let id = urlParams.get('item_id');
        getItemInfo(id);
    }
    
});


//functions
function getItemInfo(id) {
    //api url
    let URL = "http://localhost/Web-Project/back-end/Admin/api/menu?item_id=" + id;
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
        if(data['menu-items'] !== "no-data"){
            $("#food-name").attr("placeholder", data['menu-items'][0].name);
            $("#price").attr("placeholder", data['menu-items'][0].unit_price);
            $("#desc").html(data['menu-items'][0].description);
            getCategory(data['menu-items'][0].cat_id);
        } else {
            html = data['menu-items'];
            window.location.href = `#`;
            $("#message").addClass("bg-danger fs-4 lead text-white").html(html);
        }
    });
};
//
//functions
function getCategory(id) {
    //api url
    let URL = "http://localhost/Web-Project/back-end/Admin/api/menu-category?cat-id=" + id;
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
        if(data['menu-categories'] !== "no-data"){
            $("#category").attr("placeholder", data['menu-categories'][0].name);
        } else {
            html = data['menu-categories'];
            window.location.href = `#`;
            $("#message").addClass("bg-danger fs-4 lead text-white").html(html);
        }
    });
};


