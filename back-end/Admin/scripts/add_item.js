//after dom is loaded
$(document).ready(function(){
    //
    $('.carousel').carousel({
        interval: false,
    });
    //submit form
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    
    let cat_id = "";
    if(typeof urlParams.get('cat_id') === "string"){
        cat_id = urlParams.get('cat_id');
        $(".starters").removeClass("active");
        switch(cat_id){
            case "1":
                $(".starters").addClass("active");
                break;
            case "2":
                $(".main").addClass("active");
                break;
            case "3":
                $(".dessert").addClass("active");
                break;
            case "4":
                $(".drinks").addClass("active");
                break;
        }
    }
    //
    $(".state-change").click(function() {
        let status = $(this).siblings(".carousel-inner").children(".active").children("p").text();
        switch(status){
            case "starters":
                cat_id = 1;
                break;
            case "main course":
                cat_id = 2;
                break;
            case "dessert":
                cat_id = 3;
                break;
            case "drinks":
                cat_id = 4;
                break;
        }
    });
    
    $(document).on("click", "#submit", function() {
        let name = $("#link").val();
        let arr = name.split('\\');
        let link = `./${arr[arr.length - 1]}`;

        let item = {
            name: $("#food-name").val(),
            desc: $("#desc").val(),
            price: $("#price").val(),
            link: link,
            cat_id: cat_id,
        };
        addItem(item);
    });
});

//api url
const URL = "http://localhost/Web-Project/back-end/Admin/api/menu";
//ban comment
function addItem(item) {
    $.ajax({
        url: URL,
        data: {
            name: item.name,
            desc: item.desc,
            price: item.price,
            img_link: item.link,
            cat_id: item.cat_id
        },
        accepts: "application/json",
        method: "POST",
        cache: false,
        error: function(xhr){
            alert("An error occured: " + xhr.status + " " + xhr.statusText);
        }
    }).done(function(data){
        data = JSON.parse(data);
        //
        let html;
        if(data.message === "Insert successful"){
            window.location.href = `menu.php?message=${data.message}`;
        } else {
            html = data.message;
            window.location.href = `#`;
            $("#message").addClass("bg-danger fs-4 lead text-white").html(html);
        }
    });
};

