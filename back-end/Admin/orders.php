<?php
    //start session
    session_start();
    //page info
    $title = "Orders";
    $moreStyle = true;
    $styleSheetNames = ["payments.css"];
    //js files
    $scripts = ["get_orders.js"];
    //check if user is not logged in
    if(!isset($_SESSION["user-logged-in"])){
        header("Location: login.php?destination=orders");
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
                <h1 class="text-uppercase">Orders</h1>
                <div class="row">
                    <div class="col-5"></div>
                    <div class="col-2">
                        <div id="carouselExampleIndicators" class="carousel" data-bs-ride="false">
                            <div class="carousel-inner text-uppercase">
                                <div class="carousel-item active" data-bs-interval="false">
                                    <p>pending</p>
                                </div>
                                <div class="carousel-item">
                                    <p>completed</p>
                                </div>
                            </div>
                            <button class="carousel-control-prev completed-or-pending" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next completed-or-pending" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="col-5"></div>
                </div>
                <div class="row">
                    <div class="col-5"></div>
                    <div class="col-2">
                        <div id="pick-up_delivery" class="carousel" data-bs-ride="false">
                            <div class="carousel-inner text-uppercase">
                                <div class="carousel-item active" data-bs-interval="false">
                                    <p>pick-up</p>
                                </div>
                                <div class="carousel-item">
                                    <p>delivery</p>
                                </div>
                            </div>
                            <button class="carousel-control-prev pick-up-or-delivery" type="button" data-bs-target="#pick-up_delivery" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next pick-up-or-delivery" type="button" data-bs-target="#pick-up_delivery" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="col-5"></div>
                </div>
            </div>
            <div id="message" class="p-2 m-2 rounded"></div>
            <div class="row">
                <div class="container-fluid shadow m-2 p-3 bg-body rounded p-5">
                    <div>
                        <table class="table" id="orders">
                            <thead>
                                <tr class="table-warning text-uppercase">
                                <th scope="col">order-id</th>
                                <th scope="col">username</th>
                                <th scope="col">date</th>
                                <th scope="col">time</th>
                                <th scope="col">discount</th>
                                <th scope="col">order-details</th>
                                <th scope="col">payment-details</th>
                                <th scope="col">complete-order</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div id="order-count" class="p-2 m-2 rounded"></div>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>

<?php include_once("./include/docEnd.php"); ?>