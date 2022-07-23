<?php 
   //start session
   session_start();
   //
   $title = "Menu";
   $moreStyle = true;
   $styleSheetNames = ["addStaff.css", "payments.css"];
   $scripts = ["add_item.js"];
   //check if user is not logged in
   if(!isset($_SESSION["user-logged-in"])){
       header("Location: login.php?destination=staffs");
       die();
   }
?>


<?php include_once("./include/docStart.php"); ?>
<?php include_once("./include/navbar.php"); ?>

<!--heading-->
<br><br>
<div class="text-center section-heading p-3 m-0 ">
    <h2> Hello <span> <?php echo $_SESSION["user-logged-in"]["username"]; ?> </span></h2>
    <p class="lead">Add a Menu Item</p>
    <div id="message" class="p-2 m-2 rounded"></div>
    <div class="row">
    <div class="col-5"></div>
        <div class="col-2">
            <div id="carouselExampleIndicators" class="carousel" data-bs-ride="false">
                <div class="carousel-inner text-uppercase">
                    <div class="carousel-item active starters" data-bs-interval="false">
                        <p>starters</p>
                    </div>
                    <div class="carousel-item main">
                        <p>main course</p>
                    </div>
                    <div class="carousel-item dessert">
                        <p>dessert</p>
                    </div>
                    <div class="carousel-item drinks">
                        <p>drinks</p>
                    </div>
                </div>
                <button class="carousel-control-prev state-change" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next state-change" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div class="col-5"></div>
    </div>
</div>
<!--edit profile form-->
<section class="background-image" >
    <div class="container-lg text-center p-5">
        <div class="row justify-content-center form_bg text-white">
            <div class="col-lg-6 mx-auto">
                <form action="" method="">
                    <div>
                        <label class="fs-6 " for="first-name">Food Name</label>
                        <div class="input-wrapper">
                            <input type="text" name="food-name" id="food-name" class= "form-control" placeholder="Enter Food Name" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="desc">Food Description </label>
                        <textarea class="form-control" id="desc" rows="3"></textarea>
                    </div>
                    <div>
                        <label class="fs-6 " for="phone-number fs-3">Price</label>
                        <div class="input-wrapper">
                            <input type="text" name="price" id="price" class= "form-control" placeholder="Enter Price" value="" />
                        </div>
                    </div>
                    <div>
                        <div class="input-wrapper">
                         <label class="fs-6 " for="phone-number fs-3">Upload Food Item Image</label>
                          <input type="file" class="form-control" id="link" />
                        </div>
                    </div>
                </form>
                <button class="btn btn-warning btn-lg my-2 mb-3" id="submit">Add Food Item</button>
            </div>
        </div>
    </div>
</section>
<?php include_once("./include/docEnd.php"); ?>