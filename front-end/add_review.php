<?php
    //start session
    session_start();
    $title = "Add Review";
    $moreStyle = true;
    $styleSheetNames = ["add_reviews.css"];
    //include
    include_once("./include/functions.php");
    //if user not logged in
    if(!isset($_SESSION["user-logged-in"])){
        header("Location: login.php?destination=add_review");
        die();
    }
    //db connect
    include_once("./database/db_connect.php");
    //find items that have not yet been reviewed
    $sql = "SELECT order_id, item_id, name FROM food_order_details, food_items, orders WHERE food_order_details.item_id = food_items.id AND food_order_details.order_id = orders.id AND food_order_details.reviewed = 0 AND orders.username = '{$_SESSION['user-logged-in']['username']}';";
    //query
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $result = $conn->query($sql);
    //fetch all results
    $items = $result->fetchAll(PDO::FETCH_ASSOC);
    //no items
    if($result->rowCount() == 0){
        $_SESSION["review_items"] = false;
    } else {
        $_SESSION["review_items"] = true;
    }
    //processing comments
    $data = array("date" => date('Y-m-d'), "rating" => "", "comment" => "", "item" => "");
    $errors = array("ratingErr" => "", "itemErr" => "");
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        if(!isset($_POST["item"])){
            $errors["itemErr"] = "Select an item!";
        } else {
            $data["item"] = $_POST["item"];
            list($orderId, $itemId) = explode("_", $_POST["item"]);
        }
        if(!isset($_POST["rating"])){
            $errors["ratingErr"] = "Rating Required!";
        } elseif($_POST["rating"] == 0) {
            $errors["ratingErr"] = "Rating Required!";
        } else {
            $data["rating"] = $_POST["rating"];
        }
        if(isset($_POST["comment"])){
            $data["comment"] = sanitize_input($_POST["comment"]);
        }
        //if no errors
        if(!array_filter($errors) && $_SESSION["review_items"]){
            $insert = "INSERT INTO food_order_review(username, order_id, food_id, date, comment, rating) VALUES(?,?,?,?,?,?);";
            $stmt = $conn->prepare($insert, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->bindParam(1, $_SESSION["user-logged-in"]["username"]);
            $stmt->bindParam(2, $orderId);
            $stmt->bindParam(3, $itemId);
            $stmt->bindParam(4, $data["date"]);
            $stmt->bindParam(5, $data["comment"]);
            $stmt->bindParam(6, $data["rating"]);
            //
            $update = "UPDATE food_order_details SET reviewed = ? WHERE order_id = ? AND item_id = ?;";
            $stmt_1 = $conn->prepare($update, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $reviewed = 1;
            $stmt_1->bindParam(1, $reviewed);
            $stmt_1->bindParam(2, $orderId);
            $stmt_1->bindParam(3, $itemId);

            //transaction
            $conn->beginTransaction();
            $status = $stmt->execute();
            if(!$status){
                $conn->rollBack();
                die();
            }
            $status = $stmt_1->execute();
            if(!$status){
                $conn->rollBack();
                die();
            }
            //commit
            $conn->commit();
            //redirect user
            if($status){
                header("Location: index.php");
                die();
            }
        }
    }
    //db disconnect
    include_once("./database/db_disconnect.php");
?>
<?php include_once("./include/docStart.php"); ?>
<?php include_once("./include/navbar.php"); ?>
<!--heading-->
<br><br><br>
<div class="text-center section-heading p-5 m-0 ">       
    <?php if($_SESSION["review_items"]): ?>
        <p class="lead fw-bold">Tell us about your experience</p>
        <p class="lead fw-bold text-danger"> All the star (*) marked boxes must be filled up.</p>
    <?php else: ?>
        <h1 class="fw-bold text-danger">No orders to Review</h1>
    <?php endif; ?>
</div>
<!--add review form-->
<section class="background-image" >
    <?php if($_SESSION["review_items"]): ?>
        <div class="container-lg text-center p-5">
            <div class="row justify-content-center form_bg text-white">
                <div class="col-lg-6 mx-auto">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                        <br>
                        <select name="item" class="form-select" required>
                            <option value="">Select food item</option>
                            <?php foreach($items as $item): ?>
                                <option value="<?php echo $item['order_id'] . '_' . $item['item_id']; ?>" <?php if(($item['order_id'] . '_' . $item['item_id']) == $data["item"]) {echo "selected";} ?>><?php echo $item["name"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="text-danger"><?php echo $errors["itemErr"]; ?></div>
                        <br><br>
                        <select class="form-select" name="rating" aria-label="Default select example" required>
                            <option value="0">Please rate your food<span class="text-danger fw-bold">*</span></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="3">4</option>
                            <option value="3">5</option>
                        </select>
                        <div class="text-danger"><?php echo $errors["ratingErr"]; ?></div>
                        <br><br>
                        <div class="form-row py-2">
                            <div class="form-floating">
                                <textarea class="form-control" name="comment" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 200px"><?php echo $data["comment"]; ?></textarea>
                                <label for="floatingTextarea2">Describe your experience</label>
                            </div>
                        </div>
                        <input class="btn btn-warning btn-lg btn-info my-2 mb-3 " type="submit" name="submit" value="POST">
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>
<?php include_once("./include/footer.php"); ?>
<?php include_once("./include/docEnd.php"); ?>