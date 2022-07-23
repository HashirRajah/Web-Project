<?php
    //start session
    session_start();
    //check if user is logged in
    if(!isset($_SESSION["user-logged-in"])){
        header("Location: login.php?destination=dashboard");
        die();
    }
    //page meta data
    $title = "Dashboard";
    $moreStyle = false;
    $scripts = ["dashboard.js", "charts.js"];
    //quick links
    $quickLinks = [
        ["title" => "Orders", "link" => "orders.php", "icon" => "bi bi-card-list", "description" => "View, manage recent or previous orders"], 
        ["title" => "Reviews", "link" => "manage_reviews.php", "icon" => "bi bi-chat-square-text-fill", "description" => "View, manage flagged reviews"], 
        ["title" => "Staffs", "link" => "staffs.php", "icon" => "bi bi-people-fill", "description" => "View, manage staff"], 
        ["title" => "Menu", "link" => "menu.php", "icon" => "bi bi-menu-down", "description" => "View, add, remove and modify menu items"]
    ];

?>
<?php include("./include/docStart.php"); ?>
<?php include("./include/navbar.php"); ?>
<!--Welcome message-->
<br />
<br />
<br />
<div class="container-fluid m-3">
    <!--welcome-->
    <div class="row">
        <div class="col-sm-6">
            <p id="welcome-message" class="m-0 lead" >Hello <?php echo $_SESSION["user-logged-in"]["first_name"]; ?>, Welcome back</p>
            <h1 class="text-dark m-0">Dashboard</h1>
        </div>
        <div class="col-sm-6">
            <div class="text-end fs-2" id="time"></div>
            <div class="text-end fs-4"><?php echo date("l, d F Y"); ?></div>
        </div>
    </div>
    <!--quick links-->
    <section id="quick-links" style="display: none">
        <div class="row my-3 align-items-center justify-content-center text-center">
            <?php foreach($quickLinks as $ql): ?>
                <div class="col-8 col-md-3">
                    <div id="<?php echo $ql['link']; ?>" class="card border-1 border-dark shadow rounded my-3 bg-dark text-white">
                        <div class="card-body">
                            <p class="card-title fs-1 lead"><?php echo $ql["title"]; ?></p>
                            <p class="card-subtitle lead py-3"><i class="fs-2 <?php echo $ql["icon"]; ?>"></i></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <!--Statistics-->
    <section id="stats" class="mt-5 mb-2">
        <div class="row">
            <div class="container col-lg-6">
                <div class="row text-center">
                    <h4 class="">Weekly Sales</h4>
                    <div class="container">
                        <canvas id="chart-1"></canvas>
                    </div>
                </div>
            </div>
            <div class="container col-lg-6">
                <div class="row text-center">
                    <h4 class="">Monthly sales-<?php echo date("Y"); ?></h4>
                    <div class="container">
                        <canvas id="chart-2"></canvas>
                    </div>
                </div>
            </div>
        </div>  
    </section>
    <div class="row">
        <!--recent orders-->
        
        <div class="col-lg-6 text-center p-4">
            <section id="recent-orders">
            <div class="row text-dark">
                <h4 class="">Recent Orders</h4>
            </div>
            <div class="row">
                <div class="container-fluid shadow p-4 bg-body rounded">
                    <div>
                        <table class="table table-hover" id="orders">
                            <thead>
                                <tr class="table-warning text-uppercase">
                                <th scope="col">id</th>
                                <th scope="col">username</th>
                                <th scope="col">time</th>
                                <th scope="col">type</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div id="order-count" class="p-2 m-2 rounded fs-4 lead text-dark"></div>
                    <div class="row px-5" ><button class="btn btn-warning btn-lg my-2 mb-3" id="more-orders">See More</button></div>
                </div>
            </div>
            </section>
        </div>
        <!--flagged comments-->
        <div class="col-lg-6 text-center p-4">
            <section id="flagged-comments">
            <div class="row text-dark">
                <h4 class="">Flagged Reviews</h4>
            </div>
            <div class="row">
                <div class="container-fluid shadow p-4 bg-body rounded">
                    <div>
                        <table class="table table-hover" id="flagged-reviews">
                            <thead>
                                <tr class="table-warning text-uppercase">
                                <th scope="col">username</th>
                                <th scope="col">comment</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div id="number-of-flagged-reviews" class="p-2 m-2 rounded fs-4 lead text-dark"></div>
                    <div class="row px-5" ><button class="btn btn-warning btn-lg my-2 mb-3" id="more-reviews">See More</button></div>
                </div>
            </div>
            </section>
        </div>
        
    </div>
</div>
<?php include("./include/docEnd.php"); ?>