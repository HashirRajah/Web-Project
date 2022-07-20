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
    $scripts = ["category.js", "https://kit.fontawesome.com/a076d05399.js"];
    //quick links
    $quickLinks = [
        ["title" => "Starters", "color" => "primary", "icon" => "./images/starter.png", "description" => "View, manage recent or previous orders"], 
        ["title" => "Main Course", "color" => "secondary", "icon" => "./images/maincourse.png", "description" => "View, manage flagged reviews"], 
        ["title" => "Desserts", "color" => "danger", "icon" => "./images/dessert.png" , "description"=> "View, manage staff"], 
        ["title" => "Drinks", "color" => "success", "icon" => "./images/drink.png", "description" => "View, add, remove and modify menu items"],
        ["title" => "Add Category", "color" => "success", "icon" => "./images/plus.png", "description" => "View, add, remove and modify menu items"]
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
    <p id="welcome-message" class="m-0 lead" >Hello <?php echo $_SESSION["user-logged-in"]["first_name"]; ?> </p>
    <h1 class="text-dark m-0">Food Category</h1>
    <!--quick links-->
    <section id="quick-links" style="display: none">
        <div class="row my-3 align-items-center justify-content-center text-center">
            <?php foreach($quickLinks as $ql): ?>
                <div class="col-8 col-md-3">
                    <div class="card border-1 border-dark shadow rounded my-3 bg-dark text-white">
                        <div class="card-body">
                            <p class="card-title fs-1 lead"><?php echo $ql["title"]; ?></p>
                            <p class="card-subtitle lead py-3"><img src="<?php echo $ql["icon"]; ?>"></img></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

</div>
<?php include("./include/docEnd.php"); ?>