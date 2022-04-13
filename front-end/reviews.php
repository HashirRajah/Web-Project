<?php
    //start session
    session_start();
    $title = "Reviews";
    $moreStyle = true;
    $styleSheetNames = ["index.css"];
    //includes
    include("./database/db_connect.php");
    //retreive item
    $fooditem = array();
    $queryString = "";
    if($_SERVER["REQUEST_METHOD"] === "GET" || $_SERVER["REQUEST_METHOD"] === "POST"){
        $queryString = "?category={$_GET["category"]}&id={$_GET["id"]}";
        if(isset($_GET["category"]) && isset($_SESSION[$_GET["category"]])){
            foreach($_SESSION[$_GET["category"]] as $item){
                if($item["id"] == $_GET["id"]){
                    $fooditem = $item;
                    break;
                }
            }
            //fetch reviews
            //session var name
            $string = "reviews_" . $_GET['id'];
            if(!isset($_SESSION[$string])){
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //sql statement
                $sql = "SELECT * FROM food_order_review WHERE food_id = {$_GET['id']} AND status <> 'banned';";
                //query
                $result = $conn->query($sql);
                //fetch all results
                $_SESSION[$string] = $result->fetchAll(PDO::FETCH_ASSOC);
            }
            //print_r($_SESSION[$string]);
        }
    }
    //flagged comments
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        foreach($_POST as $key => $value){
            if(preg_match("/flag_/", $key)){
                $pk = substr($key, 5);
                list($username, $order_id, $food_id) = explode( "_", $pk);
                //change flag to 1
                $flag = 1;
                $update = "UPDATE food_order_review SET flag = ? WHERE username = ? AND order_id = ? AND food_id = ?;";
                $stmt = $conn->prepare($update, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->bindParam(1, $flag);
                $stmt->bindParam(2, $username);
                $stmt->bindParam(3, $order_id);
                $stmt->bindParam(4, $food_id);
                $status = $stmt->execute();
            }
        }
    }
    //disconnect to db
    include("./database/db_disconnect.php");
    //
    $first = true;
?>

<?php include_once("./include/docStart.php"); ?>
<?php include_once("./include/navbar.php"); ?>
<!--Review for specific item-->
<br />
<br />
<br />
<div class="section-heading p-5 m-0 d-flex align-items-center justify-content-center">
        <h3>&mdash; <?php echo $fooditem["name"]; ?> &mdash;</h3>
</div>

<div class="container-fluid bg-secondary p-5">
    <div class="row">
        <div class="col-md-5 p-0">
            <div class="row mb-5">
                <img src="<?php echo $fooditem["link"]; ?>" alt="<?php echo $fooditem["alt"]; ?>" class="img-fluid border border-4 border-warning p-0">
            </div>
            <div class="row">
                <p class="lead text-white text-center"><?php echo $fooditem["description"]; ?></p>
            </div>
        </div>
        <div class="col-md-7 p-5">
            <div id="reviews" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach($_SESSION[$string] as $comment): ?>
                        <?php if($first): ?>
                            <div class="carousel-item active" data-bs-interval="10000">
                            <?php $first = false; ?>
                        <?php else: ?>
                            <div class="carousel-item">
                        <?php endif; ?>
                            <div class="bg-secondary">
                                <div class="text-center text-warning">
                                    <div>
                                        <i class="bi bi-person-circle fs-1"></i>
                                    </div>
                                    <p><?php echo $comment["username"]; ?></p>
                                </div>
                                <div class="text-center">
                                    <p class="lead text-white"><?php echo $comment["comment"]; ?></p>
                                    <div class="container-fluid d-flex align-items-center justify-content-center my-5">
                                        <?php for($i = 0;$i < intval($comment["rating"]);$i++): ?>
                                            <i class="bi bi-star-fill me-2 text-warning"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <div class="container-fluid d-flex align-items-center justify-content-center my-5">
                                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . $queryString; ?>" method="POST">
                                            <!-- <i class="bi bi-flag-fill fs-1 text-danger" title="flag this comment"></i> -->
                                            <input type="submit" name="flag_<?php echo $comment["username"] . "_" . $comment["order_id"] . "_" . $comment["food_id"]; ?>" class="btn btn-danger rounded text-warning text-center fw-bold fs-6 border border-2 border-warning" value="|>" onclick="alert('Comment Flagged!')">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#reviews" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#reviews" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
</div>
<?php include_once("./include/footer.php"); ?>
<?php include_once("./include/docEnd.php"); ?>