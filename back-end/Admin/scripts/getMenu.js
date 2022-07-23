//after dom is loaded
$(document).ready(function(){

    getStarters();
    getMainCourse();
    getDessert();
    getDrinks();
   
    $(document).on("click", ".options", function(){

        $("ul.list-group").css({"display":"none"});

        if($(this).siblings("ul.list-group").hasClass("active-option")){
            $(this).siblings("ul.list-group").fadeOut().removeClass("active-option");;
        }
        else{
            $(this).siblings("ul.list-group").fadeIn(900).addClass("active-option");
        }

        
    });
    //edit
    $(document).on("click", ".edit", function(){
        let id = $(this).siblings(".item-id").text();
        window.location.href = `editMenu.php?item_id=${id}`;
    });
    //delete
    $(document).on("click", ".delete-item", function() {
        let id = $(this).siblings(".item-id").text();
        let cat = $(this).siblings(".category").text();
        //
        deleteItem(id, cat);
    });
    //
    $(document).on("click", "#add-item", function() {
        window.location.href = `category.php`;
    });

});


//functions
function getStarters() {
    //api url
    let URL = "http://localhost/Web-Project/back-end/Admin/api/menu?category=Starter";
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
            let html = ``;
           
            //
            $.each(data['menu-items'], function(i, item){
                html += `
                   <div class="food-items">
                        <img src= "../../front-end${item.link}" >
                        <div class="details">
                            <div class="details-sub">
                                <h5>${item.name}</h5>
                                <h1 class="price">RS${item.unit_price}</h1>
                            </div>
                            <p class="lead">${item.description}</p>
                            <i class="options bi bi-three-dots-vertical"></i>

                            <ul style="display:none;" class="list-group">
                                <li class="list-group-item edit">Edit</li>
                                <li class="list-group-item delete-item">Delete</li>
                                <li class="item-id" style="display:none" >${item.id}</li>
                                <li class="category" style="display:none" >starters</li>
                            </ul>   
                        </div>
                    </div>
                `;
            });

            //add content to table
            $("#starters").html(html);
            //
            
        } else {
            
        }
    });
};

function getMainCourse() {
    //api url
    let URL = "http://localhost/Web-Project/back-end/Admin/api/menu?category=Main Course";
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
            let html = ``;
           
            //
            $.each(data['menu-items'], function(i, item){
                html += `
                   <div class="food-items">
                        <img src= "../../front-end${item.link}" >
                        <div class="details">
                            <div class="details-sub">
                                <h5>${item.name}</h5>
                                <h1 class="price">RS${item.unit_price}</h1>
                            </div>
                            <p class="lead">${item.description}</p>
                            <i class="options bi bi-three-dots-vertical"></i>

                            <ul style="display:none;" class="list-group">
                                <li class="list-group-item edit">Edit</li>
                                <li class="list-group-item delete-item">Delete</li>
                                <li class="item-id" style="display:none" >${item.id}</li>
                                <li class="category" style="display:none" >main</li>
                            </ul>   
                        </div>
                    </div>
                `;
            });

            //add content to table
            $("#main-course").html(html);
            //
            
        } else {
            
        }
    });
};

function getDessert() {
    //api url
    let URL = "http://localhost/Web-Project/back-end/Admin/api/menu?category=Dessert";
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
            let html = ``;
           
            //
            $.each(data['menu-items'], function(i, item){
                html += `
                   <div class="food-items">
                        <img src= "../../front-end${item.link}" >
                        <div class="details">
                            <div class="details-sub">
                                <h5>${item.name}</h5>
                                <h1 class="price">RS${item.unit_price}</h1>
                            </div>
                            <p class="lead">${item.description}</p>
                            <i class="options bi bi-three-dots-vertical"></i>

                            <ul style="display:none;" class="list-group">
                                <li class="list-group-item edit">Edit</li>
                                <li class="list-group-item delete-item">Delete</li>
                                <li class="item-id" style="display:none" >${item.id}</li>
                                <li class="category" style="display:none" >dessert</li> 
                            </ul>   
                        </div>
                    </div>
                `;
            });

            //add content to table
            $("#dessert").html(html);
            //
            
        } else {
            
        }
    });
};

function getDrinks() {
    //api url
    let URL = "http://localhost/Web-Project/back-end/Admin/api/menu?category=Drinks";
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
            let html = ``;
           
            //
            $.each(data['menu-items'], function(i, item){
                html += `
                   <div class="food-items">
                        <img src= "../../front-end${item.link}" >
                        <div class="details">
                            <div class="details-sub">
                                <h5>${item.name}</h5>
                                <h1 class="price">RS${item.unit_price}</h1>
                            </div>
                            <p class="lead">${item.description}</p>
                            <i class="options bi bi-three-dots-vertical"></i>

                            <ul style="display:none;" class="list-group">
                                <li class="list-group-item edit">Edit</li>
                                <li class="list-group-item delete-item">Delete</li>
                                <li class="item-id" style="display:none" >${item.id}</li>
                                <li class="category" style="display:none" >drinks</li>
                            </ul>   
                        </div>
                    </div>
                `;
            });

            //add content to table
            $("#drinks").html(html);
            //
            
        } else {
            
        }
    });
};
//
//
function deleteItem(id, cat) {
    let URL = "http://localhost/Web-Project/back-end/Admin/api/menu";
    $.ajax({
        url: URL,
        data: {
            item_id: id
        },
        accepts: "application/json",
        cache: false,
        method: "DELETE", 
        error: function(xhr){
            alert("An error occured: " + xhr.status + " " + xhr.statusText);
        }
    }).done(function(data){
        data = JSON.parse(data);
        //
        let html;
        if(data.message === "Delete successful"){
            html = "Delete completed";
            window.location.href = `#`;
            $("#message").addClass("bg-success fs-4 lead text-white").html(html);
            switch(cat){
                case "main":
                    getMainCourse();
                    break;
                case "dessert":
                    getDessert();
                    break;
                case "starters":
                    getStarters();
                    break;
                case "drinks":
                    getDrinks();
                    break;
            }
        } else {
            html = "Unexpected error<br />Item could not be deleted.<br />";
            html += data.message;
            $("#message").addClass("bg-danger fs-4 lead text-white").html(html);
        }
    });
}

