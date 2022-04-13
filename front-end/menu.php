<?php
    //start session
    session_start();
    //page info
    $title = "Menu";
    $moreStyle = true;
    $styleSheetNames = ["index.css"];
    //store menu in session variable
    if(!isset($_SESSION["menu"]) || !isset($_SESSION["menu-images"])){
        //connect to database
        include("./database/db_connect.php");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //sql statement
        $sql = "SELECT * FROM food_items, food_item_images WHERE food_items.id = food_item_images.id;";
        //query
        $result = $conn->query($sql);
        //fetch all results
        $_SESSION["menu"] = $result->fetchAll(PDO::FETCH_ASSOC);
        //seperate according to categories
        $_SESSION["starters"] = array();
        $_SESSION["main-courses"] = array();
        $_SESSION["desserts"] = array();
        $_SESSION["drinks"] = array();
        foreach($_SESSION["menu"] as $item){
            switch($item["cat_id"]){
                case 1:
                    array_push($_SESSION["starters"], $item);
                    break;                    
                case 2:
                    array_push($_SESSION["main-courses"], $item);
                    break;
                case 3:
                    array_push($_SESSION["desserts"], $item);
                    break;
                case 4:
                    array_push($_SESSION["drinks"], $item);
                    break;                  
            }
        }
        
        //disconnect database
        include("./database/db_disconnect.php");
    }
    //
    $s = $m = $de = $dr = 0;
?>
<?php include_once("./include/docStart.php")?>
<?php include_once("./include/navbar.php")?>
<!--Page content start-->
<br>
<br>
<br>
<!--starter-->
<section id="starters">
    <div class="section-heading p-5 m-0 d-flex align-items-center justify-content-center">
        <h3>&mdash; Starters &mdash;</h3>
    </div>
    <div class="container-fluid bg-secondary p-5 text-white text-center">
            <?php foreach($_SESSION["starters"] as $starters): ?>
                <?php if($s % 3 === 0): ?>
                    <div class="row">
                <?php endif; ?>
                <div class="col-md-4 p-5">
                    <h4 class="text-warning"><?php echo $starters["name"]; ?></h4>
                    <div class="container-fluid  border border-3 border-warning my-5 rounded d-flex justify-content-center align-items-center p-0"><img src="<?php echo $starters["link"]; ?>" alt="<?php echo $starters["alt"]; ?>" class="img-fluid"></div>
                    <p class="lead"><?php echo $starters["description"]; ?></p>
                    <a href="reviews.php?category=starters&id=<?php echo $starters["id"]; ?>" class="btn btn-lg rounded btn-warning">Learn more</a>
                </div>
                <?php if(($s + 1) % 3 === 0): ?>
                    </div>
                <?php endif; ?>
                <?php $s++;?>
            <?php endforeach; ?>
    </div>
</section>
<!--main dish-->
<section id="main-dish">
    <div class="section-heading p-5 m-0 d-flex align-items-center justify-content-center">
        <h3>&mdash; Main Course &mdash;</h3>
    </div>
    <div class="container-fluid bg-secondary p-5 text-white text-center">
            <?php foreach($_SESSION["main-courses"] as $mainCourse): ?>
                <?php if($m % 3 === 0): ?>
                    <div class="row">
                <?php endif; ?>
                <div class="col-md-4 p-5">
                    <h4 class="text-warning"><?php echo $mainCourse["name"]; ?></h4>
                    <div class="container-fluid  border border-3 border-warning my-5 rounded d-flex justify-content-center align-items-center p-0"><img src="<?php echo $mainCourse["link"]; ?>" alt="<?php echo $mainCourse["alt"]; ?>" class="img-fluid"></div>
                    <p class="lead"><?php echo $mainCourse["description"]; ?></p>
                    <a href="reviews.php?category=main-courses&id=<?php echo $mainCourse["id"]; ?>" class="btn btn-lg rounded btn-warning">Learn more</a>
                </div>
                <?php if(($m + 1) % 3 === 0): ?>
                    </div>
                <?php endif; ?>
                <?php $m++;?>
            <?php endforeach; ?>
    </div>
</section>
<!--desserts-->
<section id="desserts">
    <div class="section-heading p-5 m-0 d-flex align-items-center justify-content-center">
        <h3>&mdash; Desserts &mdash;</h3>
    </div>
    <div class="container-fluid bg-secondary p-5 text-white text-center">
            <?php foreach($_SESSION["desserts"] as $desserts): ?>
                <?php if($de % 3 === 0): ?>
                    <div class="row">
                <?php endif; ?>
                <div class="col-md-4 p-5">
                    <h4 class="text-warning"><?php echo $desserts["name"]; ?></h4>
                    <div class="container-fluid  border border-3 border-warning my-5 rounded d-flex justify-content-center align-items-center p-0"><img src="<?php echo $desserts["link"]; ?>" alt="<?php echo $desserts["alt"]; ?>" class="img-fluid"></div>
                    <p class="lead"><?php echo $desserts["description"]; ?></p>
                    <a href="reviews.php?category=desserts&id=<?php echo $desserts["id"]; ?>" class="btn btn-lg rounded btn-warning">Learn more</a>
                </div>
                <?php if(($de + 1) % 3 === 0): ?>
                    </div>
                <?php endif; ?>
                <?php $de++;?>
            <?php endforeach; ?>
    </div>
</section>
<!--drinks-->
<section id="drinks">
    <div class="section-heading p-5 m-0 d-flex align-items-center justify-content-center">
        <h3>&mdash; Drinks &mdash;</h3>
    </div>
    <div class="container-fluid bg-secondary p-5 text-white text-center">
            <?php foreach($_SESSION["drinks"] as $drinks): ?>
                <?php if($dr % 3 === 0): ?>
                    <div class="row">
                <?php endif; ?>
                <div class="col-md-4 p-5">
                    <h4 class="text-warning"><?php echo $drinks["name"]; ?></h4>
                    <div class="container-fluid  border border-3 border-warning my-5 rounded d-flex justify-content-center align-items-center p-0"><img src="<?php echo $drinks["link"]; ?>" alt="<?php echo $drinks["alt"]; ?>" class="img-fluid"></div>
                     <p class="lead"><?php echo $drinks["description"]; ?></p>
                     <a href="reviews.php?category=drinks&id=<?php echo $drinks["id"]; ?>" class="btn btn-lg rounded btn-warning">Learn more</a>
                </div>
                <?php if(($dr + 1) % 3 === 0): ?>
                    </div>
                <?php endif; ?>
                <?php $dr++;?>
            <?php endforeach; ?>
    </div>
</section>


<!--Page content end-->
<?php include_once("./include/footer.php")?>
<?php include_once("./include/docEnd.php")?>