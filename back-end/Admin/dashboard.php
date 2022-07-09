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
    $scripts = ["get_flagged_reviews.js"];
    //quick links
    $quickLinks = [
        ["title" => "Orders", "color" => "primary", "icon" => "bi bi-card-list", "description" => "View, manage recent or previous orders"], 
        ["title" => "Reviews", "color" => "secondary", "icon" => "bi bi-chat-square-text-fill", "description" => "View, manage flagged reviews"], 
        ["title" => "Staffs", "color" => "danger", "icon" => "bi bi-people-fill", "description" => "View, manage staff"], 
        ["title" => "Menu", "color" => "success", "icon" => "bi bi-menu-down", "description" => "View, add, remove and modify menu items"]
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
    <p id="welcome-message" class="m-0 lead" >Hello <?php echo $_SESSION["user-logged-in"]["first_name"]; ?>, Welcome back</p>
    <h1 class="text-dark m-0">Dashboard</h1>
    <!--quick links-->
    <section id="quick-links" style="display: none">
        <div class="row my-3 align-items-center justify-content-center text-center">
            <?php foreach($quickLinks as $ql): ?>
                <div class="col-8 col-md-3">
                    <div class="card border-1 border-dark shadow rounded my-3 bg-dark text-white">
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
    <section id="stats">
    
    </section>
    <!--recent orders-->
    <section id="recent-orders">
    
    </section>
    <!--flagged comments-->
    <section id="flagged-comments">
    
    </section>
</div>
<?php include("./include/docEnd.php"); ?>