<?php
    //start session
    require_once("./classes/FoodItem.php");
    require_once("./classes/Cart.php");
    session_start();
    //page info
    $moreStyle = true;
    $styleSheetNames = ["order.css", "edit-profile.css"];
    $title = "Order";
    //imports
    include_once("./include/functions.php");
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
<br />
<?php if(!$_SESSION["bool"]): ?>
    <div class="text-center section-heading p-5 m-0 ">
        <h2> Hello <span> <?php echo $_SESSION["user-logged-in"]["username"]; ?> </span></h2>
        <p class="lead">Please provide details for order</p>
        <p class="lead fw-bold text-danger"> All the star (*) marked boxes must be filled up.</p>
    </div>
<section class="background-image p-5">
    <div class="container-lg text-center  ">
        <div class="row justify-content-center form_bg text-white">
            <div class="col-lg-6 mx-auto">
                <?php if(!isset($_SESSION["order-method"])): ?>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                        <div class="form-row py-2  fs-3">
                            <div class="form-group p-5">
                                <i class="bi bi-truck fs-3"></i>
                                <label for="mode" class="form-label">Delivery</label>
                                <input type="radio" class="form-check-input mx-5" name="mode" id="mode"  value="delivery" >
                                <i class="bi bi-house"></i>
                                <label for="mode" class="form-label">Pickup</label>
                                <input type="radio" class="form-check-input mx-5" name="mode" id="mode"  value="pick-up">
                            </div>
                        </div>
                        <input class="btn btn-warning btn-lg btn-info my-2 mb-3 " type="submit" name="submit" value="Next">
                    </form>
                <?php else: ?>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                        <div class="form-row py-2">
                            <div class="form-group ">
                                <label for="time" class="form-label">Time</label>
                                <span class="text-danger fw-bold">*</span>
                                <select name="time" id="time" class="form-select" required>
                                    <?php while($timeSlot < $closingTime): ?>
                                        <option class="form-control" value="<?php echo date('G:i:s', $timeSlot); ?>" <?php if(date('G:i:s', $timeSlot) === $data["time"]) {echo "selected";} ?>><?php echo date('G:i', $timeSlot); ?></option>
                                        <?php $timeSlot += (strtotime("00:30:00") - strtotime("00:00:00")); ?>
                                    <?php endwhile; ?>
                                </select>
                                <div class="text-danger"><?php echo $errors["timeErr"]; ?></div>
                            </div>
                        </div>
                        <?php if($_SESSION["order-method"] === "delivery"): ?>
                            <div class="form-row py-2">
                                <div class="form-group ">
                                    <label for="house_no" class="form-label">House Number</label>
                                    <input type="text" class="form-control" name="house_no" id="house_no" value="<?php echo $data['house_number']; ?>"/>
                                    <div class="text-danger"><?php echo $errors["house_numberErr"]; ?></div>
                                </div>
                            </div>
                            <div class="form-row py-2">
                                <div class="form-group ">
                                    <label for="street" class="form-label">Street</label>
                                    <span class="text-danger fw-bold">*</span>
                                    <input type="text" class="form-control" name="street" id="street" value="<?php echo $data['street']; ?>" title="Should consist of only letters and -" required>
                                    <div class="text-danger"><?php echo $errors["streetErr"]; ?></div>
                                </div>
                            </div>
                            <div class="form-row py-2">
                                <div class="form-group ">
                                    <label for="city" class="form-label">City</label>
                                    <span class="text-danger fw-bold">*</span>
                                    <input type="text" class="form-control" name="city" id="city" value="<?php echo $data['city']; ?>"  title="Should consist of only letters and -" required>
                                    <div class="text-danger"><?php echo $errors["cityErr"]; ?></div>
                                </div>
                            </div>
                            <div class="form-row py-2">
                                <div class="form-floating">
                                    <textarea class="form-control" name="delivery-instructions" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 200px">
                                        <?php echo $data["delivery-instructions"]; ?>
                                    </textarea>
                                    <label for="floatingTextarea2">Enter delivery instructions</label>
                                </div>
                            </div>
                        <?php endif; ?>
                        <input class="btn btn-warning btn-lg btn-info my-2 mb-3 " type="submit" name="submit" value="Next">
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php else: ?>
    <!--items-->
    <!--Starters-->
    <div class="heading p-5 m-0 d-flex align-items-center justify-content-center">  
        <h3>&mdash; STARTERS &mdash; </h3>
    </div>
    <div class="menu bg-light py-5">
        <?php foreach($_SESSION["starters"] as $starters): ?>
            <div class="food-items">
                <img src="<?php echo $starters["link"]; ?>"  >
                <div class="details">
                    <div class="details-sub">
                        <h5><?php echo $starters["name"]; ?></h5>
                        <h1 class="price">RS<?php echo " " . $starters["unit_price"]; ?></h1>
                    </div>
                     <p class="lead"><?php echo $starters["description"]; ?></p>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                        <input type="submit" name="add_<?php echo $starters["id"]; ?>" class="btn btn-lg btn-warning rounded" value="Add to cart">
                    </form>
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
                <img src="<?php echo $main["link"]; ?>"  >
                <div class="details">
                    <div class="details-sub">
                        <h5><?php echo $main["name"]; ?></h5>
                        <h1 class="price">RS<?php echo " " . $main["unit_price"]; ?></h1>
                    </div>
                     <p class="lead"><?php echo $main["description"]; ?></p>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                        <input type="submit" name="add_<?php echo $main["id"]; ?>" class="btn btn-lg btn-warning rounded" value="Add to cart">
                    </form>
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
                <img src="<?php echo $dessert["link"]; ?>"  >
                <div class="details">
                    <div class="details-sub">
                        <h5><?php echo $dessert["name"]; ?></h5>
                        <h1 class="price">RS<?php echo " " . $dessert["unit_price"]; ?></h1>
                    </div>
                     <p class="lead"><?php echo $dessert["description"]; ?></p>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                        <input type="submit" name="add_<?php echo $dessert["id"]; ?>" class="btn btn-lg btn-warning rounded" value="Add to cart">
                    </form>
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
                <img src="<?php echo $drink["link"]; ?>"  >
                <div class="details">
                    <div class="details-sub">
                        <h5><?php echo $drink["name"]; ?></h5>
                        <h1 class="price">RS<?php echo " " . $drink["unit_price"]; ?></h1>
                    </div>
                     <p class="lead"><?php echo $drink["description"]; ?></p>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                        <input type="submit" name="add_<?php echo $drink["id"]; ?>" class="btn btn-lg btn-warning rounded" value="Add to cart">
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<!--offcanvas-->
<div class="offcanvas offcanvas-end" tabindex="-1" id="cart" aria-labelledby="cart-Label">
    <div class="offcanvas-header">
        <h4 class="offcanvas-title" id="cart-Label">Cart</h4>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
       <?php if(!empty($_SESSION["cart"]->getItems())): ?>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <?php foreach(($_SESSION["cart"]->getItems()) as $item): ?>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-4 text-center">
                                <img src="<?php echo $item->getImageLink(); ?>" class="img-fluid rounded-pill" alt="<?php echo $item->getName() . " image"; ?>" style="width:50px;height:50px">
                            </div>
                            <div class="col-sm-3 text-start">
                                <?php echo $item->getName(); ?>
                            </div>
                            <div class="col-sm-2 text-start fw-bold">
                                <?php echo $item->getUnitPrice(); ?>
                            </div>
                            <div class="col-sm-3 text-end fw-bold">
                                <input type="submit" class="btn btn-sm btn-danger text-uppercase p-1" name="remove_<?php echo $item->getId(); ?>" value="remove">
                            </div>
                        </div>
                        <div class="row m-4">
                            <div class="col-sm-5 text-end">
                                <input type="submit" class="btn btn-sm btn-outline-danger text-uppercase p-1 fw-bolder" name="decrement_<?php echo $item->getId(); ?>" value="-">
                            </div>
                            <div class="col-sm-2 text-center"><?php echo $item->getQty(); ?></div>
                            <div class="col-sm-5 text-start">
                                <input type="submit" class="btn btn-sm btn-outline-success text-uppercase p-1 fw-bolder" name="increment_<?php echo $item->getId(); ?>" value="+">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </form>
            <div class="container border-top border-bottom border-3 border-dark">
                <div class="row p-3">
                    <div class="col-sm-6 text-uppercase">Number of items</div>
                    <div class="col-sm-6 text-danger text-end fw-bold"><?php echo $_SESSION["cart"]->getTotalItems(); ?></div>
                </div>
                <div class="row p-3">
                    <div class="col-sm-6 text-uppercase">total cost</div>
                    <div class="col-sm-6 text-danger text-end fw-bold"><?php echo "Rs " . $_SESSION["cart"]->getTotalPrice(); ?></div>
                </div>
            </div>
            <div class="p-5">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div>
                        <i class="bi bi-truck"></i>
                        <label for="mode" class="form-label ms-2 me-5">Delivery</label>
                        <input type="radio" class="form-check-input" name="mode" id="mode"  <?php if($_SESSION["order-method"] === "delivery") {echo "checked";} ?> value="delivery" >
                    </div>
                    <div>
                        <i class="bi bi-house"></i>
                        <label for="mode" class="form-label ms-2 me-5">Pickup&nbsp;&nbsp;</label>
                        <input type="radio" class="form-check-input" name="mode" id="mode"  <?php if($_SESSION["order-method"] === "pick-up") {echo "checked";} ?> value="pick-up">
                    </div>
                    <div class="p-1 d-flex align-items-center justify-content-center text-center">
                        <input type="submit" class="btn btn-sm btn-outline-success text-uppercase p-1 fw-bolder" name="" value="CHANGE">
                    </div>
                    <div class="fs-6">
                        <div class="row">
                            <p class="text-start">Time:<span class="fw-bold"><?php echo  " " . date("G:i", strtotime($_SESSION["order-details"]["time"])); ?></span></p>
                        </div>
                        <?php if($_SESSION["order-method"] === "delivery"): ?>
                            <div class="row">
                                <p class="text-start">House Number:<span class="fw-bold"><?php echo  " " . $_SESSION["order-details"]["house_number"]; ?></span></p>
                            </div>
                            <div class="row">
                                <p class="text-start">Street:<span class="fw-bold"><?php echo  " " . $_SESSION["order-details"]["street"]; ?></span></p>
                            </div>
                            <div class="row">
                                <p class="text-start">City:<span class="fw-bold"><?php echo  " " . $_SESSION["order-details"]["city"]; ?></span></p>
                            </div>
                            <div class="row">
                                <p class="text-start">Delivery-instructions:<span class="fw-bold"><?php echo  " " . $_SESSION["order-details"]["delivery-instructions"]; ?></span></p>
                            </div>
                        <?php endif; ?>
                        <div class="p-1 d-flex align-items-center justify-content-center text-center">
                            <input type="submit" class="btn btn-sm btn-outline-success text-uppercase p-1 fw-bolder" name="edit_details" value="EDIT">
                        </div>
                    </div>
                </form>
            </div>
            <div class="container text-center mt-3 mb-3">
                <a href="payment.php" class="btn btn-lg btn-warning text-uppercase">checkout</a>
            </div>
       <?php else: ?>
            <div class="container">
                <p class="lead text-center text-danger fw-bold">
                    Your cart is currently empty
                </p>
            </div>
       <?php endif; ?>
    </div>
</div>
<?php include_once("./include/footer.php"); ?>
<?php include_once("./include/docEnd.php"); ?>