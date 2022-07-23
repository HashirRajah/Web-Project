<?php 
    //start session
    session_start();
    //
    // include_once("./include/functions.php");
    include_once("./database/db_connect.php");
    //
    $queryString = "";
    //location to redirect user
    // if(isset($_GET["destination"])){
    //     $location = "Location: " . htmlspecialchars($_GET["destination"]) . ".php";
    //     $queryString = "?destination={$_GET['destination']}";
    // } else {
    //     $location = "Location: index.php";   
    // }
    

    //
    $title = "EditInfo";
    $moreStyle = true;
    $styleSheetNames = ["addStaff.css"];
?>


<?php include_once("./include/docStart.php"); ?>
<?php include_once("./include/navbar.php"); ?>

<!--heading-->
<br><br>
<div class="text-center section-heading p-3 m-0 ">
            <!-- <h2> Hello <span> <?php echo $_SESSION["user-logged-in"]["username"]; ?> </span></h2> -->
            <p class="lead">Edit Restaurant Info</p>
</div>
<!--edit profile form-->
<section class="background-image" >
    <div class="container-lg text-center p-5">
        <div class="row justify-content-center form_bg text-white">
            <div class="col-lg-6 mx-auto">
                <!-- <div class="row text-center">
                    <i class="bi bi-person-circle fs-1"></i>
                    <h3 class="text-warning"><?php echo $_SESSION["user-logged-in"]["username"]; ?></h3>
                </div> -->

                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . $queryString; ?>" method="POST">
                    <div >
                        <label class="fs-6 " for="restaurant-name">Restaurant Name</label>
                        <div class="input-wrapper" >
                            
                            <input type="text" name="food-name" id="food-name" class= "form-control" placeholder="The Crazy Chef" value=""  />
                        </div>
                    
                    </div>

                    <div>
                        <label class="fs-6 " for="city fs-3">Street</label>
                        <div class="input-wrapper">
                            
                            <input type="text" name="street" id="city" class= "form-control" placeholder="street" value="" />
                        </div>
                    
                    </div>
                 
                    <div>
                        <label class="fs-6 " for="city fs-3">City</label>
                        <div class="input-wrapper">
                            
                            <input type="text" name="city" id="city" class= "form-control" placeholder="City" value="" />
                        </div>
                    
                    </div>

                    <div>
                        <label class="fs-6 " for="city fs-3">Location</label>
                        <div class="input-wrapper">
                            
                            <input type="text" name="city" id="city" class= "form-control" placeholder="City" value="" />
                        </div>
                    
                    </div>

                    <div>
                        <div class="input-wrapper">   
                         <label class="fs-6 " for="capacity fs-3">Capacity</label>
                         <input type="text" name="city" id="city" class= "form-control" placeholder="" value="" />
                        </div> 
                    </div>

                    <div>
                        <div class="input-wrapper">   
                         <label class="fs-6 " for="email fs-3">Email</label>
                         <input type="text" name="city" id="city" class= "form-control" placeholder="" value="" />
                        </div> 
                    </div>

                    <div>
                        <div class="input-wrapper">   
                         <label class="fs-6 " for="opening-hour fs-3">Opening Hour</label>
                         <input type="text" name="city" id="city" class= "form-control" placeholder="" value="" />
                        </div> 
                    </div>
                    <div>
                        <div class="input-wrapper">   
                         <label class="fs-6 " for="closing-hour fs-3">Closing Hour</label>
                         <input type="text" name="city" id="city" class= "form-control" placeholder="" value="" />
                        </div> 
                    </div>
                    <div>
                        <div class="input-wrapper">   
                         <label class="fs-6 " for="facebook fs-3">Facebook</label>
                         <input type="text" name="city" id="city" class= "form-control" placeholder="" value="" />
                        </div> 
                    </div>
                    <div>
                        <div class="input-wrapper">   
                         <label class="fs-6 " for="instagram fs-3">Instagram</label>
                         <input type="text" name="city" id="city" class= "form-control" placeholder="" value="" />
                        </div> 
                    </div>





                    


                    
                    <input class="btn btn-warning btn-lg btn-info my-2 mb-3 " type="submit" name="submit" value="Save Changes">
                </form>
            </div>
        </div>
    </div>
</section>


<?php include_once("./include/docEnd.php"); ?>