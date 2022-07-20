<?php 
    //start session
    session_start();
    //
    // include_once("./include/functions.php");
    include_once("./database/db_connect.php");
    //
    $queryString = "";
    //location to redirect user
    if(isset($_GET["destination"])){
        $location = "Location: " . htmlspecialchars($_GET["destination"]) . ".php";
        $queryString = "?destination={$_GET['destination']}";
    } else {
        $location = "Location: index.php";   
    }
    //form validation
    $data = array("firstName" => "", "lastName" => "", "phoneNumber" => "", "username" => "", "email" => "", "password" => "");
    $errors = array("firstNameErr" => "", "lastNameErr" => "", "phoneNumberErr" => "", "usernameErr" => "", "emailErr" => "", "passwordErr" => "");
    if(isset($_POST["submit"])){
        //check for empty form
        //first name
        if(!isset($_POST["first-name"]) || empty($_POST["first-name"])){
            $errors["firstNameErr"] = "First Name is required!";
        } else {
            $data["firstName"] = sanitize_input($_POST["first-name"]);
            if(!preg_match("/^[A-Z][a-z]+( [A-Z][a-z]+)*$/", $data["firstName"])){
                $errors["firstNameErr"] = "First name should consist of one or more words, starting with an uppercase letter followed by lowercase characters, and separated by spaces";
            }
        } 
        //last name
        if(!isset($_POST["last-name"]) || empty($_POST["last-name"])){
            $errors["lastNameErr"] = "Last Name is required!";
        } else {
            $data["lastName"] = sanitize_input($_POST["last-name"]);
            if(!preg_match("/^[A-Z][a-z]+$/", $data["lastName"])){
                $errors["lastNameErr"] = "Last name should consist of one word, starting with an uppercase letter followed by lowercase characters";
            }
        }
        //phone number
        if(!isset($_POST["phone-number"]) || empty($_POST["phone-number"])){
            $errors["phoneNumberErr"] = "Phone number is required!";
        } else {
            $data["phoneNumber"] = sanitize_input($_POST["phone-number"]);
            if(!preg_match("/^[\d]+$/", $data["phoneNumber"])){
                $errors["phoneNumberErr"] = "Phone number should consist of only numbers";
            }
        } 
        //username
        if(!isset($_POST["username"]) || empty($_POST["username"])){
            $errors["usernameErr"] = "Username is required!";
        } else {
            $data["username"] = sanitize_input($_POST["username"]);
            //if username already exists
            $sql = "SELECT * FROM users WHERE username = '{$data['username']}';";
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $result = $conn->query($sql);
            $user = $result->fetch(PDO::FETCH_ASSOC);
            if($user){
                if($user["username"]){
                    $errors["usernameErr"] = "Username already taken. Choose another one";
                }
            }
        }
        //email
        if(!isset($_POST["email"]) || empty($_POST["email"])){
            $errors["emailErr"] = "Email is required!";
        } else {
            $data["email"] = sanitize_input($_POST["email"]);
            if(!preg_match("/^[a-z\d\.-]+@[a-z\d-]+\.[a-z]{2,8}(\.[a-z]{2,8})*$/", $data["email"])){
                $errors["emailErr"] = "Email must be a valid address, e.g. me@mydomain.com";
            }
        } 
        //password
        if(!isset($_POST["password"]) || empty($_POST["password"])){
            $errors["passwordErr"] = "Password is required!";
        } else {
            $data["password"] = sanitize_input($_POST["password"]);
            if(!preg_match("/^[\w@-]{8,20}$/", $data["password"])){
                $errors["passwordErr"] = "Password must be alphanumeric (@, _ and - are also allowed) and be 8 - 20
                characters";
            }
        } 
        //if no errors
        if(!array_filter($errors)){
            $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
            $type = "customer";
            //prepared statement
            $insert = "INSERT INTO users VALUES(?,?,?,?,?,?,?);";
            $stmt = $conn->prepare($insert, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->bindParam(1, $data['username']);
            $stmt->bindParam(2, $data['firstName']);
            $stmt->bindParam(3, $data['lastName']);
            $stmt->bindParam(4, $data['email']);
            $stmt->bindParam(5, $hashed_password);
            $stmt->bindParam(6, $data['phoneNumber']);
            $stmt->bindParam(7, $type);
            $status = $stmt->execute();

            //if successful redirect user
            if($status){
                //
                $sql = "SELECT * FROM users WHERE username = '{$data['username']}';";
                $result = $conn->query($sql);
                $newUser = $result->fetch(PDO::FETCH_ASSOC);

                //disconnect db
                include_once("./database/db_disconnect.php");
                $_SESSION["user-logged-in"] = $newUser;
                //print_r($_SESSION["user-logged-in"]);
                header($location);
                die();
            }
        }
    }

    //
    $title = "AddStaff";
    $moreStyle = true;
    $styleSheetNames = ["addStaff.css"];
?>


<?php include_once("./include/docStart.php"); ?>
<?php include_once("./include/navbar.php"); ?>

<!--heading-->
<br><br>
<div class="text-center section-heading  p-3 m-0  ">
            <h2> Hello <span> <?php echo $_SESSION["user-logged-in"]["username"]; ?> </span></h2>
            <p class="lead">Add a Staff</p>
</div>
<!--edit profile form-->
<section class="background-image" >
    <div class="container-lg text-center p-5">
        <div class="row justify-content-center form_bg text-white">
            <div class="col-lg-6 mx-auto">
                <!-- <div class="row text-center">
                    <i class="bi bi-person-circle fs-1"></i>
                    <h3 class="text-warning"><?php echo $_SESSION["user-logged-in"]["username"]; ?></h3>
                </div> -->

                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . $queryString; ?>" method="POST">
                    <div>
                        <label class="fs-6 " for="first-name">First Name</label>
                        <div class="input-wrapper">
                            <i class="bi bi-person-circle fs-3"></i>
                            <input type="text" name="first-name" id="first-name" class= "form-control" placeholder="Enter First Name" value="<?php echo $data['firstName']; ?>" />
                        </div>
                        <div class="text-danger">
                            <?php echo $errors["firstNameErr"]; ?>
                        </div>
                    </div>
                    <div>
                        <label class="fs-6 " for="last-name">Last Name</label>
                        <div class="input-wrapper">
                            <i class="bi bi-person-circle fs-3"></i>
                            <input type="text" name="last-name" id="last-name" class= "form-control" placeholder="Enter Last Name" value="<?php echo $data['lastName']; ?>" />
                        </div>
                        <div class="text-danger">
                            <?php echo $errors["lastNameErr"]; ?>
                        </div>
                    </div>
                    <div>
                        <label class="fs-6 " for="phone-number fs-3">Phone Number</label>
                        <div class="input-wrapper">
                            <i class="bi bi-telephone-fill fs-3"></i>
                            <input type="text" name="phone-number" id="phone-number" class= "form-control" placeholder="Enter Phone Number" value="<?php echo $data['phoneNumber']; ?>" />
                        </div>
                        <div class="text-danger">
                            <?php echo $errors["phoneNumberErr"]; ?>
                        </div>
                    </div>
                    <div>
                        <label class="fs-6 " for="username">Username</label>
                        <div class="input-wrapper">
                            <i class="bi bi-person-circle fs-3"></i>
                            <input type="text" name="username" id="username" class= "form-control" placeholder="Enter username" value="<?php echo $data['username']; ?>" />
                        </div>
                        <div class="text-danger">
                            <?php echo $errors["usernameErr"]; ?>
                        </div>
                    </div>
                    <div>
                        <label class="fs-6 " for="email">Email</label>
                        <div class="input-wrapper">
                            <i class="bi bi-envelope-fill fs-3"></i>
                            <input type="email" name="email" id="email" class= "form-control" placeholder="Enter Email" value="<?php echo $data['email']; ?>" />
                        </div>
                        <div class="text-danger">
                            <?php echo $errors["emailErr"]; ?>
                        </div>
                    </div>
                    <div>
                        <label class="fs-6 " for="password">Password</label>
                        <div class="input-wrapper">
                            <i class="bi bi-file-lock2 fs-3"></i>
                            <input type="password" name="password" id="password"  class= "form-control" />
                        </div>
                        <div class="text-danger">
                            <?php echo $errors["passwordErr"]; ?>
                        </div>
                    </div>
                    <input class="btn btn-warning btn-lg btn-info my-2 mb-3 " type="submit" name="submit" value="Add Staff">
                </form>
            </div>
        </div>
    </div>
</section>


<?php include_once("./include/docEnd.php"); ?>