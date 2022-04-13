<?php
    //start session
    require_once("./classes/FoodItem.php");
    require_once("./classes/Cart.php");
    session_start();
    //imports
    include_once("./include/functions.php");
    //connect to database
    include_once("./database/db_connect.php");
    //check if user is signed in
    if(!isset($_SESSION["user-logged-in"])){
        header("Location: login.php?destination=payment");
        die();
    }
    //payment
    if(!isset($_SESSION["make-payment"])){
        $_SESSION["make-payment"] = false;
    }
    //cart
    if(!isset($_SESSION["cart"])){
        header("Location: order.php");
        die();
    }
    //
    if(isset($_POST["pay"])){
        $_SESSION["make-payment"] = true;
    }
    //
    $title = "Payment";
    $moreStyle = false;
    //
    $data = array("card-number" => "", "expiry-date" => "");
    $errors = array("card-numberErr" => "", "expiry-dateErr" => "");

?>
<?php include_once("./include/docStart.php"); ?>
<?php include_once("./include/navbar.php"); ?>

<div class="container-fluid text-center bg-light p-5">
    <div class="row pt-4">
        <div class="col-md-3"></div>
        <?php if($_SESSION["make-payment"]): ?>
            <div class="col-md-6 p-3">
                <div class="row text-warning">
                    <h1 class="text-uppercase ">Payment</h1>
                    <p class="lead fw-bold m-0 text-danger">Your accounts's email and phone number will be used for contacting purposes. Make sure to update them if neccessary.</p>
                    <a href="edit_profile.php?destination=payment" class="link-warning">Update account</a>
                    <p class="lead fw-bold text-danger"> All the star (*) marked boxes must be filled up.</p>
                </div>
                <div class="row">
                    <div class="container-fluid shadow m-2 p-3 bg-body rounded p-5">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                            <div class="container text-start">
                                <!-- card number -->
                                <label for="card-number" class="form-label text-left">Card number</label>
                                <span class="text-danger fw-bold">*</span>
                                <input type="text" name="card-number" id="card-number" class="form-control mb-2"  value="<?php echo $data['card-number']; ?>" pattern="/^[0-9]+$/" required/>
                                <div class="text-danger"><?php echo $errors["card-numberErr"]; ?></div>
            
                                <!-- expiry date -->
                                <label for="expiry-date" class="form-label">Expiry date</label>
                                <span class="text-danger fw-bold">*</span>
                                <input type="date" class="form-control" name="expiry-date" id="expiry-date"  value="<?php echo $data['expiry-date']?>" required />
                                <div class="text-danger"><?php echo $errors["expiry-dateErr"]; ?></div>
                                <div class="text-center"><input type="submit" class="btn btn-warning btn-lg rounded-pill mt-4" name="submit" value="Pay"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="col-md-6 p-3">
                <div class="row text-warning">
                    <h1 class="text-uppercase ">Order Details</h1>
                    <p class="lead fw-bold m-0 text-danger"></p>
                    <a href="order.php" class="link-danger">Modify order</a>
                </div>
                <div class="row">
                    <div class="container-fluid shadow m-2 p-3 bg-body rounded p-5">
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
                        <div class="border border-bottom border-3 border-dark"></div>
                        <?php foreach(($_SESSION["cart"]->getItems()) as $item): ?>
                            <div class="container">
                                <div class="row p-3">
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
                                        <?php echo $item->getQty(); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
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
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                            <div class="container text-start">
                            </div>
                            <div class="text-center"><input type="submit" class="btn btn-warning btn-lg rounded-pill mt-4" name="pay" value="NEXT"></div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-md-3"></div>
    </div>
</div>
<?php include_once("./include/footer.php"); ?>
<?php include_once("./include/docEnd.php"); ?>