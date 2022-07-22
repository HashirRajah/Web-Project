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
            <div id="message" class="p-2 m-2 rounded fs-3">
            </div>
            <div class="row">
                <div class="container-fluid shadow m-2 p-3 bg-body rounded p-5">
                    <div>
                        <table class="table table-hover" id="order">
                            <thead>
                                <tr class="table-warning text-uppercase">
                                    <th scope="col">username</th>
                                    <th scope="col">date</th>
                                    <th scope="col">time</th>
                                    <th scope="col">discount</th>
                                    <th scope="col">type</th>
                                    <th scope="col">payment-details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php if(isset($_GET["username"])){ echo htmlspecialchars($_GET["username"]); } ?></td>
                                    <td><?php if(isset($_GET["date"])){ echo htmlspecialchars($_GET["date"]); } ?></td>
                                    <td><?php if(isset($_GET["time"])){ echo htmlspecialchars($_GET["time"]); } ?></td>
                                    <td><?php if(isset($_GET["discount"])){ echo htmlspecialchars($_GET["discount"]); } ?></td>
                                    <td><?php if(isset($_GET["type"])){ echo htmlspecialchars($_GET["type"]); } ?></td>
                                    <td>
                                        <img class="view-payment-details" src="./images/plus2.png" alt="+">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row" id="delivery" style="display:none">
                <div class="container-fluid shadow m-2 p-3 bg-body rounded p-5">
                    <div>
                        <table class="table table-hover" id="delivery-det">
                            <thead>
                                <tr class="table-success text-uppercase">
                                    <th scope="col">delivery-id</th>
                                    <th scope="col">street</th>
                                    <th scope="col">city</th>
                                    <th scope="col">house#</th>
                                    <th scope="col">status</th>
                                    <th scope="col">instructions</th>
                                    <th scope="col">delivered-at</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="container-fluid shadow m-2 p-3 bg-body rounded p-5">
                    <div>
                        <table class="table table-hover" id="order-det">
                            <thead>
                                    <tr class="table-primary text-uppercase">
                                    <th scope="col">item-id</th>
                                    <th scope="col">name</th>
                                    <th scope="col">price</th>
                                    <th scope="col">quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>

<?php include_once("./include/docEnd.php"); ?>