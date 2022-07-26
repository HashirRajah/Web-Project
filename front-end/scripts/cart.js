//after dom is loaded
$(document).ready(function(){
    //
    $(".add").click(function() {
        let id = $(this).attr("id");
        addItem(id);
    });
});

//api url
const URL = "http://localhost/Web-Project/front-end/order.php";
//ban comment
function addItem(id) {
    $.ajax({
        url: URL,
        data: {
            id: id
        },
        method: "POST",
        cache: false,
        error: function(xhr){
            alert("An error occured: " + xhr.status + " " + xhr.statusText);
        }
    }).done(function(data){
        let html = `
        <div class="container">
            <div class="row">
                <div class="col-sm-4 text-center">
                    <img src="<?php echo ($_SESSION["cart"]->getItems())[count($_SESSION["cart"]->getItems()) - 1]->getImageLink(); ?>" class="img-fluid rounded-pill" alt="<?php echo ($_SESSION["cart"]->getItems())[count($_SESSION["cart"]->getItems()) - 1]->getName() . " image"; ?>" style="width:50px;height:50px">
                </div>
                <div class="col-sm-3 text-start">
                    <?php echo ($_SESSION["cart"]->getItems())[count($_SESSION["cart"]->getItems()) - 1]->getName(); ?>
                </div>
                <div class="col-sm-2 text-start fw-bold">
                    <?php echo ($_SESSION["cart"]->getItems())[count($_SESSION["cart"]->getItems()) - 1]->getUnitPrice(); ?>
                </div>
                <div class="col-sm-3 text-end fw-bold">
                    <input type="submit" class="btn btn-sm btn-danger text-uppercase p-1" name="remove_<?php echo ($_SESSION["cart"]->getItems())[count($_SESSION["cart"]->getItems()) - 1]->getId(); ?>" value="remove">
                </div>
            </div>
            <div class="row m-4">
                <div class="col-sm-5 text-end">
                    <input type="submit" class="btn btn-sm btn-outline-danger text-uppercase p-1 fw-bolder" name="decrement_<?php echo ($_SESSION["cart"]->getItems())[count($_SESSION["cart"]->getItems()) - 1]->getId(); ?>" value="-">
                </div>
                <div class="col-sm-2 text-center"><?php echo ($_SESSION["cart"]->getItems())[count($_SESSION["cart"]->getItems()) - 1]->getQty(); ?></div>
                <div class="col-sm-5 text-start">
                    <input type="submit" class="btn btn-sm btn-outline-success text-uppercase p-1 fw-bolder" name="increment_<?php echo ($_SESSION["cart"]->getItems())[count($_SESSION["cart"]->getItems()) - 1]->getId(); ?>" value="+">
                </div>
            </div>
        </div>
        `;
        //
        //$(".all-items").append(html);
    });
};

