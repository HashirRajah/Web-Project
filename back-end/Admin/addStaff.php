<?php 
    //start session
    session_start();
    //
    $title = "AddStaff";
    $moreStyle = true;
    $styleSheetNames = ["addStaff.css"];
    $scripts = ["add_staff.js"];
    //check if user is not logged in
    if(!isset($_SESSION["user-logged-in"])){
        header("Location: login.php?destination=order_details");
        die();
    }
    
?>


<?php include_once("./include/docStart.php"); ?>
<?php include_once("./include/navbar.php"); ?>

<!--heading-->
<br><br>
<div class="text-center section-heading  p-3 m-0  ">
            <h2> Hello <span> <?php echo $_SESSION["user-logged-in"]["username"]; ?> </span></h2>
            <p class="lead">Add a Staff</p>
            <div id="message" class="p-2 m-2 rounded"></div>
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

                <form action="" method="">
                    <div>
                        <label class="fs-6 " for="first-name">First Name</label>
                        <div class="input-wrapper">
                            <i class="bi bi-person-circle fs-3"></i>
                            <input type="text" name="first-name" id="first-name" class= "form-control" placeholder="Enter First Name" value="" />
                        </div>
                    </div>
                    <div>
                        <label class="fs-6 " for="last-name">Last Name</label>
                        <div class="input-wrapper">
                            <i class="bi bi-person-circle fs-3"></i>
                            <input type="text" name="last-name" id="last-name" class= "form-control" placeholder="Enter Last Name" value="" />
                        </div>
                    </div>
                    <div>
                        <label class="fs-6 " for="phone-number fs-3">Phone Number</label>
                        <div class="input-wrapper">
                            <i class="bi bi-telephone-fill fs-3"></i>
                            <input type="text" name="phone-number" id="phone-number" class= "form-control" placeholder="Enter Phone Number" value="" />
                        </div>
                    </div>
                    <div>
                        <label class="fs-6 " for="username">Username</label>
                        <div class="input-wrapper">
                            <i class="bi bi-person-circle fs-3"></i>
                            <input type="text" name="username" id="username" class= "form-control" placeholder="Enter username" value="" />
                        </div>
                    </div>
                    <div>
                        <label class="fs-6 " for="email">Email</label>
                        <div class="input-wrapper">
                            <i class="bi bi-envelope-fill fs-3"></i>
                            <input type="email" name="email" id="email" class= "form-control" placeholder="Enter Email" value="" />
                        </div>
                    </div>
                    <div>
                        <label class="fs-6 " for="password">Password</label>
                        <div class="input-wrapper">
                            <i class="bi bi-file-lock2 fs-3"></i>
                            <input type="password" name="password" id="password"  class= "form-control" />
                        </div>
                    </div>
                </form>
                <button class="btn btn-warning btn-lg btn-info my-2 mb-3" id="submit">Add</button>
            </div>
        </div>
    </div>
</section>


<?php include_once("./include/docEnd.php"); ?>