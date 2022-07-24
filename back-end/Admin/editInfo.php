<?php 
    //start session
    session_start();
    //
    $title = "Info";
    $moreStyle = true;
    $styleSheetNames = ["addStaff.css"];
    $scripts = ["info.js"];
    //check if user is not logged in
    if(!isset($_SESSION["user-logged-in"])){
        header("Location: login.php?destination=editInfo");
        die();
    }
?>


<?php include_once("./include/docStart.php"); ?>
<?php include_once("./include/navbar.php"); ?>

<!--heading-->
<br><br>
<div class="text-center section-heading p-3 m-0 ">
    <p class="lead">Edit Restaurant Info</p>
    <div id="message" class="p-2 m-2 rounded"></div>
</div>
<!--edit profile form-->
<section class="background-image" >
    <div class="container-lg text-center p-5">
        <div class="row justify-content-center form_bg text-white">
            <div class="container mx-auto">
                <form action="" method="">
                    <div class="row">
                        <div class="col-md-6">
                            <div>
                                <label class="fs-6 " for="name">Restaurant Name</label>
                                <div class="input-wrapper" >
                                    <input type="text" name="name" id="name" class= "form-control" placeholder="" value=""  />
                                </div>
                            </div>
                            <div>
                                <div class="input-wrapper">   
                                    <label class="fs-6 " for="capacity">Capacity</label>
                                    <input type="number" name="capacity" id="capacity" class= "form-control" placeholder="" value="" />
                                </div> 
                            </div>
                            <div>
                                <div class="input-wrapper">   
                                    <label class="fs-6 " for="insta-link">Halal Certificate</label>
                                    <input type="text" name="certificate" id="certificate" class= "form-control" placeholder="" value="" />
                                </div> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <label class="fs-6 " for="street">Street</label>
                                <div class="input-wrapper">
                                    <input type="text" name="street" id="street" class= "form-control" placeholder="" value="" />
                                </div>
                            </div>
                            <div>
                                <label class="fs-6 " for="city">City</label>
                                <div class="input-wrapper">
                                    <input type="text" name="city" id="city" class= "form-control" placeholder="" value="" />
                                </div>
                            </div>  
                            <div>
                                <label class="fs-6 " for="location">Location</label>
                                <div class="input-wrapper">
                                    <input type="text" name="location" id="location" class= "form-control" placeholder="" value="" />
                                </div>
                            </div>  
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div>
                                <div class="input-wrapper">   
                                    <label class="fs-6 " for="opening-hour fs-3">Opening Hour</label>
                                    <input type="text" name="op-hr" id="op-hr" class="form-control" placeholder="" value="" />
                                </div> 
                            </div>
                            <div>
                                <div class="input-wrapper">   
                                    <label class="fs-6 " for="closing-hour fs-3">Closing Hour</label>
                                    <input type="text" name="cl-hr" id="cl-hr" class= "form-control" placeholder="" value="" />
                                </div> 
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div>
                                <div class="input-wrapper">   
                                    <label class="fs-6 " for="meta-link">Facebook</label>
                                    <input type="text" name="meta-link" id="meta-link" class= "form-control" placeholder="" value="" />
                                </div> 
                            </div>
                            <div>
                                <div class="input-wrapper">   
                                    <label class="fs-6 " for="insta-link">Instagram</label>
                                    <input type="text" name="insta-link" id="insta-link" class= "form-control" placeholder="" value="" />
                                </div> 
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div>
                                <div class="input-wrapper">   
                                    <label class="fs-6 " for="email">Email</label>
                                    <input type="text" name="email" id="email" class= "form-control" placeholder="" value="" />
                                </div> 
                            </div>
                            <div>
                                <div class="input-wrapper">   
                                    <label class="fs-6 " for="phone-number">phone#</label>
                                    <input type="text" name="phone-number" id="phone-number" class= "form-control" placeholder="" value="" />
                                </div> 
                            </div>
                        </div>
                    </div>
                </form>
                <button class="btn btn-warning btn-lg btn-info my-2 mb-3" id="submit">Edit</button>
            </div>
        </div>
    </div>
</section>


<?php include_once("./include/docEnd.php"); ?>