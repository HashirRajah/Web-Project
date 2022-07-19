<?php
    //start session
    session_start();
    //page info
    $title = "Login";
    $moreStyle = false;
    $queryString = "";
    //location to redirect user
    if(isset($_GET["destination"])){
        $location = "Location: " . htmlspecialchars($_GET["destination"]) . ".php";
        $queryString = "?destination={$_GET['destination']}";
    } else {
        $location = "Location: dashboard.php";   
    }
    //
    $data = array("username" => "", "password" => "");
    $error = "";
    
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        //validations
        if(!isset($_POST["username"]) || empty($_POST["username"])){
            $error = "Username is required!";
        } else {
            $data["username"] = $_POST["username"];
        }
        if(!isset($_POST["password"]) || empty($_POST["password"])){
            $error = "Password is required!";
        } else {
            $data["password"] = $_POST["password"];
        }
        //redirect user
        if($error === ""){
            //database
            //connect to db
            include_once("./database/db_connect.php");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //query
            $sql = "SELECT * FROM users WHERE username = ? AND type = ?;";
            //execute query
            $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->bindParam(1, $data["username"]);
            $type = "admin";
            $stmt->bindParam(2, $type);
            $status = $stmt->execute();
            if($status && $stmt->rowCount() > 0){
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if(password_verify($data["password"], $user["password_hash"])){
                    $_SESSION["user-logged-in"] = $user;
                    include_once("./database/db_disconnect.php");
                    //
                    header($location);
                    die();
                } else {
                    $error = "Your credentials seem to be wrong<br />Try again or make sure you are a registered user:(";
                }

                //check
            } else {
                $error = "Your credentials seem to be wrong<br />Try again or make sure you are a registered user:(";
            }
            
        }
    }
    
    
?>

<?php include_once("./include/docStart.php"); ?>
<?php include_once("./include/navbar.php"); ?>

<div class="container-fluid text-center p-5">
    <div class="row pt-4">
        <div class="col-md-3"></div>
        <div class="col-md-6 p-3">
            <div class="row text-dark">
                <h1 class="text-uppercase">login</h1>
            </div>
            <div class="row">
                <div class="container-fluid shadow m-2 p-3 bg-body rounded p-5">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div class="container text-start text-uppercase">
                        <label for="" class="form-label mb-3">username</label>
                        <input type="text" class="form-control mb-3" name="username" value="<?php echo $data["username"]; ?>" required>

                        <label for="" class="form-label mb-3">password</label>
                        <input type="password" class="form-control mb-3" name="password" value="<?php echo $data["password"]; ?>" required>
                        <div class="text-danger my-3 text-center fs-6 fw-bold"><?php echo $error; ?></div>
                    </div>
                        <input type="submit" class="btn btn-lg rounded btn-warning" name="submit" value="Login">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>

<?php include_once("./include/docEnd.php"); ?>