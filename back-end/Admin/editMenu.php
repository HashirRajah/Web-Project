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
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . $queryString; ?>" method="POST">
                    <div>
                        <label class="fs-6 " for="food-name">Update Name</label>
                        <div class="input-wrapper">
                            <input type="text" name="food-name" id="food-name" class= "form-control" placeholder="" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="desc">Update Food Description </label>
                        <textarea class="form-control" id="desc" rows="3"></textarea>
                    </div>
                    <div>
                        <label class="fs-6 " for="price">Update Price</label>
                        <div class="input-wrapper">
                            <input type="text" name="price" id="price" class= "form-control" placeholder="" value="" />
                        </div>
                    </div>
                    <div>
                        <label class="fs-6 " for="phone-number fs-3">Update Category</label>
                        <div class="input-wrapper">
                            <input type="text" name="category" id="category" class= "form-control" placeholder="" value="" />
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