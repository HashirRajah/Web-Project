<?php
    //start session
    session_start();
    //page info
    $title = "Orders";
    $moreStyle = false;
    //$styleSheetNames = [".css"];
    //js files
    $scripts = ["get_order_details.js"];
    //check if user is not logged in
    if(!isset($_SESSION["user-logged-in"])){
        header("Location: login.php?destination=order_details");
        die();
    }
?>
<?php include_once("./include/docStart.php"); ?>
<?php include_once("./include/navbar.php"); ?>

<div class="container-fluid text-center p-5">
    <div class="row pt-4">
        <div class="col-md-1"></div>
        <div class="col-md-10 p-3">
            <div class="row text-dark">
                <h1 class="text-uppercase">Order #<?php if(isset($_GET["order_id"])){ echo htmlspecialchars($_GET["order_id"]); } ?></h1>
            </div>
            <div id="message" class="p-2 m-2 rounded"></div>
            <div class="row">
                <div class="container-fluid shadow m-2 p-3 bg-body rounded p-5">
                    
                    <div id="order-count" class="p-2 m-2 rounded"></div>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>

<?php include_once("./include/docEnd.php"); ?>