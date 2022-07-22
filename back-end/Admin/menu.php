<?php
    //start session
     require_once("./classes/FoodItem.php");
    // require_once("./classes/Cart.php");
    session_start();
    //page info
    $moreStyle = true;
    $styleSheetNames = ["editMenu.css"];
    $scripts = ["getMenu.js"];
    $title = "editMenu";
    //imports
    
    //connect to database
    include_once("./database/db_connect.php");
    //check if user is signed in
    if(!isset($_SESSION["user-logged-in"])){
        header("Location: login.php?destination=order");
        die();
    }
    if(!isset($_SESSION["cart"])){
        $_SESSION["cart"] = new Cart();
    }
    //
    if(!isset($_SESSION["order-info"])){
        $_SESSION["order-info"] = array();
    }
    if(!isset($_SESSION["bool"])){
        $_SESSION["bool"] = false;
    }
    //items
    if(!isset($_SESSION["menu"]) || !isset($_SESSION["menu-images"])){
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
    }
    $catNames = array("starters", "main-courses", "desserts", "drinks");
    //create item objects
    if(!isset($_SESSION["item-objects"])){
        for($i = 0;$i < 4;$i++){
            foreach ($_SESSION[$catNames[$i]] as $fItem) {
                $string = "_" . $fItem["id"];
                $id = intval($fItem["id"]);
                $_SESSION[$string] = new FoodItem($id, $fItem["name"], $fItem["unit_price"], $fItem["link"]);
            }
        }
        $_SESSION["item-objects"] = "set";
    }
    //times
    $sql = "SELECT opening_hr, closing_hr FROM restaurant_info;";
    //query statement
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $result = $conn->query($sql);
    //fetch result
    $operatingHours = $result->fetch(PDO::FETCH_ASSOC);
    //timeSlots
    $timeSlot = strtotime($operatingHours["opening_hr"]);
    $closingTime = strtotime($operatingHours['closing_hr']);
    //
    $data = array("date" => date('Y-m-d'), "time" => date("G:i:s", $timeSlot), "house_number" => "", "street" => "", "city" => "", "delivery-instructions" => "");
    $errors = array("dateErr" => "", "timeErr" => "", "house_numberErr" => "", "streetErr" => "", "cityErr" => "", "delivery-instructionsErr" => "");
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        if(isset($_SESSION["order-details"])){
            $data = $_SESSION["order-details"];
        }
        //edit details
        if(isset($_POST["edit_details"])){
            $_SESSION["bool"] = false;
        }
        //order details
        if(isset($_POST["mode"])){
            $_SESSION["order-method"] = $_POST["mode"];
        }
        //validations
        //
        if($_SESSION["order-method"] === "delivery" && empty($data["street"])){
            $_SESSION["bool"] = false;
        }
        if($_SESSION["order-method"] === "delivery"){
            //validations
            if(isset($_POST["street"])){
                $data["street"] = sanitize_input($_POST["street"]);
                if(!preg_match("/^[\s\w-]+$/", $data["street"])){
                    $errors["streetErr"] = "Should consist of only letters and -";
                }
            } else {
                $errors["streetErr"] = "Enter street name!";
            }
            //city
            if(isset($_POST["city"])){
                $data["city"] = sanitize_input($_POST["city"]);
                if(!preg_match("/^[\s\w-]+$/", $data["city"])){
                    $errors["cityErr"] = "Should consist of only letters and -";
                }
            } else {
                $errors["cityErr"] = "Enter city name!";
            }
            //house number
            if(isset($_POST["house_no"])){
                $data["house_number"] = sanitize_input($_POST["house_no"]);
                if(!preg_match("/^[\d]+$/", $data["house_number"])){
                    $errors["house_numberErr"] = "Should consist of only numbers";
                }
            }
            //delivery instructions
            if(isset($_POST["delivery-instructions"])){
                $data["delivery-instructions"] = sanitize_input($_POST["delivery-instructions"]);
            } 
        }
        //time
        if(isset($_POST["time"])){
            $data["time"] = $_POST["time"];
            if(strtotime($data["time"]) < (strtotime(date("G:i:s")) + (strtotime("02:15:00") - strtotime("00:00:00")))){
                $errors["timeErr"] = "Invalid time!";
            } else {
                //if no errors
                if(!array_filter($errors)){
                    $_SESSION["bool"] = true;
                    $_SESSION["order-details"] = $data;
                }
            }
        }
        //handle cart
        if(isset($_SESSION["cart"]) && isset($_SESSION["order-info"]) && isset($_SESSION["item-objects"])){
            foreach($_POST as $key => $value){
                //removing items
                if(preg_match("/remove_/", $key)){
                    $id = substr($key, 7);
                    $id = intval($id);
                    $_SESSION["cart"]->remove($id);
                }
                //incrementing items
                if(preg_match("/increment_/", $key)){
                    $id = substr($key, 10);
                    $id = intval($id);
                    $_SESSION["cart"]->incrementItem($id);
                }
                //decrementing items
                if(preg_match("/decrement_/", $key)){
                    $id = substr($key, 10);
                    $id = intval($id);
                    $_SESSION["cart"]->decrementItem($id);
                }
                //adding items
                if(preg_match("/add_/", $key)){
                    $id = substr($key, 3);
                    //echo $id;
                    $_SESSION["cart"]->add($_SESSION[$id]);
                    //print_r($_SESSION["cart"]);
                }
            }
        }
    } 
    //$_SESSION["bool"] = true;

    //disconnect database
    include("./database/db_disconnect.php");
?>
<?php include_once("./include/docStart.php"); ?>
<?php include_once("./include/navbar.php")?>
<br />
<br />

    

    <!--items-->
    <!--Starters-->
    <div class="heading2 p-5 m-0 d-flex align-items-center justify-content-center">  
        <h3>&mdash; EDIT MENU &mdash; </h3>
    </div>
    <div class="heading p-3 m-0 d-flex align-items-center justify-content-center">  
        <h3>&mdash; STARTERS &mdash; </h3>
    </div>
    <div class="menu bg-light py-5">
        <?php foreach($_SESSION["starters"] as $starters): ?>
            <div class="food-items">
                <img src="<?php echo "../../front-end".$starters["link"]; ?>"  >
                <div class="details">
                    <div class="details-sub">
                        <h5><?php echo $starters["name"]; ?></h5>
                        <h1 class="price">RS<?php echo " " . $starters["unit_price"]; ?></h1>
                    </div>
                     <p class="lead"><?php echo $starters["description"]; ?></p>
                     <i class="options bi bi-three-dots-vertical"></i>

                     <ul style="display:none;" class="list-group">
                        <li class="list-group-item edit">Edit</li>
                        <li class="list-group-item">Delete</li> 
                    </ul>

                     
                    
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <!--Main courses-->
    <div class="heading p-5 m-0 d-flex align-items-center justify-content-center text-uppercase">  
        <h3>&mdash; main course &mdash; </h3>
    </div>
    <div class="menu bg-light py-5">
        <?php foreach($_SESSION["main-courses"] as $main): ?>
            <div class="food-items">
                <img src="<?php echo "../../front-end".$main["link"]; ?>"  >
                <div class="details">
                    <div class="details-sub">
                        <h5><?php echo $main["name"]; ?></h5>
                        <h1 class="price">RS<?php echo " " . $main["unit_price"]; ?></h1>
                    </div>
                     <p class="lead"><?php echo $main["description"]; ?></p>
                     <i class="options bi bi-three-dots-vertical"></i>
                     <ul style="display:none;" class="list-group">
                        <li class="list-group-item edit">Edit</li>
                        <li class="list-group-item">Delete</li>  
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <!--desserts-->
    <div class="heading p-5 m-0 d-flex align-items-center justify-content-center text-uppercase">  
        <h3>&mdash; desserts &mdash; </h3>
    </div>
    <div class="menu bg-light py-5">
        <?php foreach($_SESSION["desserts"] as $dessert): ?>
            <div class="food-items">
                <img src="<?php echo "../../front-end". $dessert["link"]; ?>"  >
                <div class="details">
                    <div class="details-sub">
                        <h5><?php echo $dessert["name"]; ?></h5>
                        <h1 class="price">RS<?php echo " " . $dessert["unit_price"]; ?></h1>
                    </div>
                     <p class="lead"><?php echo $dessert["description"]; ?></p>
                     <i class="options bi bi-three-dots-vertical"></i>
                     
                     <ul style="display:none;" class="list-group">
                        <li class="list-group-item edit">Edit</li>
                        <li class="list-group-item">Delete</li>  
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <!--drinks-->
    <div class="heading p-5 m-0 d-flex align-items-center justify-content-center text-uppercase">  
        <h3>&mdash; drinks &mdash; </h3>
    </div>
    <div class="menu bg-light py-5">
        <?php foreach($_SESSION["drinks"] as $drink): ?>
            <div class="food-items">
                <img src="<?php echo "../../front-end". $drink["link"]; ?>"  >
                <div class="details">
                    <div class="details-sub">
                        <h5><?php echo $drink["name"]; ?></h5>
                        <h1 class="price">RS<?php echo " " . $drink["unit_price"]; ?></h1>
                    </div>
                     <p class="lead"><?php echo $drink["description"]; ?></p>
                     <i class=" options bi bi-three-dots-vertical"></i>
                     <ul style="display:none;" class="list-group">
                        <li class="list-group-item edit">Edit</li>
                        <li class="list-group-item">Delete</li>  
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    </div>


<?php include_once("./include/docEnd.php"); ?>