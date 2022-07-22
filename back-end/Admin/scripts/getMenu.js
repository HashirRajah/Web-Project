//after dom is loaded
$(document).ready(function(){
   
    $(".options").click(function(){

        $("ul.list-group").css({"display":"none"});

        if($(this).siblings("ul.list-group").hasClass("active-option")){
            $(this).siblings("ul.list-group").css({"display":"none"}).removeClass("active-option");;
        }
        else{
            $(this).siblings("ul.list-group").css({"display":"block"}).addClass("active-option");
        }

        
    });

    $(".edit").click(function(){

        window.location.href = `editMenu.php?item_id=`;

    });
});


