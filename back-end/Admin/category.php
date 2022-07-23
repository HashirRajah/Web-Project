<?php
    //start session
    session_start();
    //check if user is logged in
    if(!isset($_SESSION["user-logged-in"])){
        header("Location: login.php?destination=dashboard");
        die();
    }
    //page meta data
    $title = "Menu";
    $moreStyle = false;
    $scripts = ["category.js"];
    //get categories
    //quick links
    $quickLinks = [
        ["title" => "Starters", "id" => 1, "icon" => "./images/starter.png"], 
        ["title" => "Main Course", "id" => 2, "icon" => "./images/maincourse.png"], 
        ["title" => "Desserts", "id" => 3, "icon" => "./images/dessert.png"], 
        ["title" => "Drinks", "id" => 4, "icon" => "./images/drink.png"]
    ];
    //
    $i = 0;
?>
<?php include("./include/docStart.php"); ?>
<?php include("./include/navbar.php"); ?>
<!--Welcome message-->
<br />
<br />
<br />
<div class="container-fluid m-3">
    <!--welcome-->
    <h1 class="text-dark m-0 text-center">Choose Category</h1>
    <!--quick links-->
    <section id="quick-links" style="display: none">
            <?php foreach($quickLinks as $ql): ?>
                <?php if($i % 2 === 0): ?>
                    <div class="row my-3 align-items-center justify-content-center text-center">
                <?php endif; ?>
                <div class="col-8 col-md-3">
                    <div id="<?php echo $ql["id"]; ?>" class="card border-1 border-dark shadow rounded my-3 bg-dark text-white">
                        <div class="card-body">
                            <p class="card-title fs-1 lead"><?php echo $ql["title"]; ?></p>
                            <p class="card-subtitle lead py-3"><img src="<?php echo $ql["icon"]; ?>"></img></p>
                        </div>
                    </div>
                </div>
                <?php if($i % 2 !== 0): ?>
                    </div>
                <?php endif; ?>
                <?php $i++; ?>
            <?php endforeach; ?>
    </section>

</div>
<?php include("./include/docEnd.php"); ?>