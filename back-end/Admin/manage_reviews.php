<?php
    //start session
    session_start();
    //includes
    include_once("./database/db_connect.php");
    //page info
    $title = "Manage Reviews";
    $moreStyle = false;
    //check if user is not logged in
    if(!isset($_SESSION["user-logged-in"])){
        header("Location: login.php?destination=manage_reviews");
        die();
    }
    //process 
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        //prepared stmt
        $update = "UPDATE food_order_review SET flag = ?, status = ? WHERE order_id = ? AND food_id = ?;";
        $stmt = $conn->prepare($update, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        //
        foreach($_POST as $key => $value){
            if(preg_match("/comment_operation_/", $key)){
                $subString = substr($key, 18);
                list($order_id, $food_id) = explode("_", $subString);
                //
                $flag = 0;
                if($value == "accept"){
                    $valid = "valid";
                    $stmt->bindParam(1, $flag);
                    $stmt->bindParam(2, $valid);
                    $stmt->bindParam(3, $order_id);
                    $stmt->bindParam(4, $food_id);

                    $s = $stmt->execute();

                } elseif ($value == "ban"){
                    //echo "banned";
                    $ban = "banned";
                    $stmt->bindParam(1, $flag);
                    $stmt->bindParam(2, $ban);
                    $stmt->bindParam(3, $order_id);
                    $stmt->bindParam(4, $food_id);

                    $s = $stmt->execute();
                }
            }
            
        }
    }
    // fetch flagged reviews
    $sql = "SELECT * FROM food_order_review WHERE flag = 1;";
    //query
    $result = $conn->query($sql);
    //fetch all results
    $flagged_comments = $result->fetchAll(PDO::FETCH_ASSOC);


    
    //disconnect to db
    include_once("./database/db_disconnect.php");
?>
<?php include_once("./include/docStart.php"); ?>
<?php include_once("./include/navbar.php"); ?>

<div class="container-fluid text-center p-5">
    <div class="row pt-4">
        <div class="col-md-3"></div>
        <div class="col-md-6 p-3">
            <div class="row text-dark">
                <h1 class="text-uppercase">Flagged Comments</h1>
            </div>
            <div class="row">
                <div class="container-fluid shadow m-2 p-3 bg-body rounded p-5">
                    <div class="row p-1 text-uppercase">
                        <div class="col-md-3 p-1">
                            <h5 class="text-warning">username</h5>
                        </div>
                        <div class="col-md-5 p-1">
                            <h5 class="text-warning">comment</h5>
                        </div>
                        <div class="col-md-4 p-1">
                            <h5 class="text-warning">operation</h5>
                        </div>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div class="container text-start text-uppercase">
                        <?php foreach($flagged_comments as $comment): ?>
                            <div class="row p-1">
                                <div class="col-md-3 p-1 border border-2 border-warning">
                                    <?php echo $comment["username"]; ?>
                                </div>
                                <div class="col-md-5 p-1 border border-2 border-warning">
                                    <?php echo $comment["comment"]; ?>
                                </div>
                                <div class="col-md-4 p-1 border border-2 border-warning">
                                    <i class="bi bi-check2-circle"></i>
                                    <label for="mode" class="form-label">Accept</label>
                                    <input type="radio" class="form-check-input mx-1" name="comment_operation_<?php echo $comment["order_id"] . "_" . $comment["food_id"]; ?>" id="mode"  value="accept" >
                                    <input type="radio" class="form-check-input" name="comment_operation_<?php echo $comment["order_id"] . "_" . $comment["food_id"]; ?>" id="mode"  value="ban">
                                    <i class="bi bi-x-circle-fill"></i>
                                    <label for="mode" class="form-label">Ban</label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                        <input type="submit" class="btn btn-lg rounded btn-warning" name="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>

<?php include_once("./include/docEnd.php"); ?>