<?php 
    //start session
    session_start();
    //
    $title = "Menu";
    $moreStyle = true;
    $styleSheetNames = ["addStaff.css"];
    $scripts = ["edit_menu.js"];
    //check if user is not logged in
    if(!isset($_SESSION["user-logged-in"])){
        header("Location: login.php?destination=editMenu");
        die();
    }
?>


<?php include_once("./include/docStart.php"); ?>
<?php include_once("./include/navbar.php"); ?>

<!--heading-->
<br><br>
<div class="text-center section-heading p-3 m-0 ">
    <h2> Hello <span> <?php echo $_SESSION["user-logged-in"]["username"]; ?> </span></h2>
    <p class="lead">Edit a Menu Item</p>
    <div id="message" class="p-2 m-2 rounded"></div>
</div>
<!--edit profile form-->
<section class="background-image" >
    <div class="container-lg text-center p-5">
        <div class="row justify-content-center form_bg text-white">
            <div class="col-lg-6 mx-auto">
                <form action="" method="">
                    <div>
                        <label class="fs-6 " for="riptionname">Update Name</label>
                        <div class="input-wrapper">
                            <input type="text" name="name" id="name" class= "form-control" placeholder="" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Update Food Description </label>
                        <textarea class="form-control" id="description" rows="3"></textarea>
                    </div>
                    <div>
                        <label class="fs-6 " for="unit_price">Update Price</label>
                        <div class="input-wrapper">
                            <input type="text" name="unit_price" id="unit_price" class= "form-control" placeholder="" value="" />
                        </div>
                    </div>
                    <div>
                        <label class="fs-6 " for="cat_id">Update Category</label>
                        <div class="input-wrapper">
                            <select type="text" name="cat_id" id="cat_id" class= "form-control">
                            </select>
                        </div>
                    </div>
                    <div>
                    </div>
                </form>
                <button class="btn btn-warning btn-lg my-2 mb-3" id="submit">Edit</button>
            </div>
        </div>
    </div>
</section>
<?php include_once("./include/docEnd.php"); ?>