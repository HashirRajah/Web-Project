//after dom is loaded
$(document).ready(function(){

    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    //
    let id = "";
    //
    if(typeof urlParams.get('item_id') === "string"){
        id = urlParams.get('item_id');
        getAllCategory();
        getItemInfo(id);
    }
    //
    $("#submit").click(function() {
        let details = {};
        let arrayOfKeys = [
            "name",
            "description",
            "unit_price",
            "cat_id"
        ];
        //
        arrayOfKeys.forEach(function(item){
            if($("#" + item).val() != ""){
                details[item] = $("#" + item).val();
            }
        })
        //
        //console.log(details);
        editItem(id, details);
    });
    
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
            $("#name").attr("placeholder", data['menu-items'][0].name);
            $("#unit_price").attr("placeholder", data['menu-items'][0].unit_price);
            $("#description").html(data['menu-items'][0].description);
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
            $("#" + data['menu-categories'][0].id).attr("selected", "selected");
        } else {
            html = data['menu-categories'];
            window.location.href = `#`;
            $("#message").addClass("bg-danger fs-4 lead text-white").html(html);
        }
    });
};
//
//functions
function getAllCategory() {
    //api url
    let URL = "http://localhost/Web-Project/back-end/Admin/api/menu-category";
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
            let html = ``;
            $.each(data['menu-categories'], function(i, cat){
                html += `
                    <option id="${cat.id}" value="${cat.id}">${cat.name}</option>
                `;
            });
            //
            $("#cat_id").html(html);
        } else {
            html = data['menu-categories'];
            window.location.href = `#`;
            $("#message").addClass("bg-danger fs-4 lead text-white").html(html);
        }
    });
};
//functions
function editItem(id, details) {
    details = JSON.stringify(details);
    
    //api url
    let URL = "http://localhost/Web-Project/back-end/Admin/api/menu";
    $.ajax({
        url: URL, 
        accepts: "application/json",
        data: {
            item_id: id,
            item_details: details
        },
        method: "PUT",
        cache: false, 
        error: function(xhr){
            alert("An error occured: " + xhr.status + " " + xhr.statusText);
        }
    }).done(function(data){
        console.log(data);
        data = JSON.parse(data);
        if(data['message'] === "update-successful"){
            window.location.href = `menu.php?message=${data['message']}`;
        } else {
            html = data['message'];
            window.location.href = `#`;
            $("#message").addClass("bg-danger fs-4 lead text-white").html(html);
        }
    });
};

