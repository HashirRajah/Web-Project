//after dom is loaded
$(document).ready(function(){

    getStarters();
    getMainCourse();
    getDessert();
    getDrinks();
   
    $(document).on("click", ".options", function(){

        $("ul.list-group").css({"display":"none"});

        if($(this).siblings("ul.list-group").hasClass("active-option")){
            $(this).siblings("ul.list-group").css({"display":"none"}).removeClass("active-option");;
        }
        else{
            $(this).siblings("ul.list-group").css({"display":"block"}).addClass("active-option");
        }

        
    });

    $(document).on("click", ".edit", function(){

        window.location.href = `editMenu.php?item_id=`;

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
                        <img src= "../../front-end.$starters["link"]; " >
                        <div class="details">
                            <div class="details-sub">
                                <h5>${item.name}</h5>
                                <h1 class="price">RS${item.unit_price}</h1>
                            </div>
                            <p class="lead">${item.description}</p>
                            <i class="options bi bi-three-dots-vertical"></i>

                            <ul style="display:none;" class="list-group">
                                <li class="list-group-item edit">Edit</li>
                                <li class="list-group-item">Delete</li> 
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
                        <img src= "../../front-end.$starters["link"]; " >
                        <div class="details">
                            <div class="details-sub">
                                <h5>${item.name}</h5>
                                <h1 class="price">RS${item.unit_price}</h1>
                            </div>
                            <p class="lead">${item.description}</p>
                            <i class="options bi bi-three-dots-vertical"></i>

                            <ul style="display:none;" class="list-group">
                                <li class="list-group-item edit">Edit</li>
                                <li class="list-group-item">Delete</li> 
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
                        <img src= "../../front-end.$starters["link"]; " >
                        <div class="details">
                            <div class="details-sub">
                                <h5>${item.name}</h5>
                                <h1 class="price">RS${item.unit_price}</h1>
                            </div>
                            <p class="lead">${item.description}</p>
                            <i class="options bi bi-three-dots-vertical"></i>

                            <ul style="display:none;" class="list-group">
                                <li class="list-group-item edit">Edit</li>
                                <li class="list-group-item">Delete</li> 
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
                        <img src= "../../front-end.$starters["link"]; " >
                        <div class="details">
                            <div class="details-sub">
                                <h5>${item.name}</h5>
                                <h1 class="price">RS${item.unit_price}</h1>
                            </div>
                            <p class="lead">${item.description}</p>
                            <i class="options bi bi-three-dots-vertical"></i>

                            <ul style="display:none;" class="list-group">
                                <li class="list-group-item edit">Edit</li>
                                <li class="list-group-item">Delete</li> 
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

