<?php
    //start session
    session_start();
    //page info
    $title = "EditProfile";
    $moreStyle = true;
    $styleSheetNames = ["edit-profile.css"];
    //imports
    include_once("./include/functions.php");
    include_once("./database/db_connect.php");

    //check if user is logged in
    if(!isset($_SESSION["user-logged-in"])){
        header("Location: login.php");
        die();
    }
    //
    $queryString = "";
    if(isset($_GET["destination"])){
        $location = "Location: " . htmlspecialchars($_GET["destination"]) . ".php";
        $queryString = "?destination={$_GET['destination']}";
    } else {
        $location = "Location: index.php";   
    }
    //form validation
    $data = array("phoneNumber" => "", "email" => "", "old-password" => "", "new-password" => "");
    $errors = array("phoneNumberErr" => "", "emailErr" => "", "old-passwordErr" => "", "new-passwordErr" => "");
    if(isset($_POST["submit"])){
        //phone number
        if(!empty($_POST["phone-number"])){
            $data["phoneNumber"] = sanitize_input($_POST["phone-number"]);
            if(!preg_match("/^[\d]+$/", $data["phoneNumber"])){
                $errors["phoneNumberErr"] = "Phone number should consist of only numbers";
            }
        } 
        //email
        if(!empty($_POST["email"])){
            $data["email"] = sanitize_input($_POST["email"]);
            if(!preg_match("/^[a-z\d\.-]+@[a-z\d-]+\.[a-z]{2,8}(\.[a-z]{2,8})*$/", $data["email"])){
                $errors["emailErr"] = "Email must be a valid address, e.g. me@mydomain.com";
            }
        } 
        //password
        if(!empty($_POST["new-password"]) && empty($_POST["old-password"])){
            $errors["old-passwordErr"] = "Enter password!";
        }
        if(!empty($_POST["old-password"])){
            $data["new-password"] = sanitize_input($_POST["new-password"]);
            $data["old-password"] = sanitize_input($_POST["old-password"]);
            //check old password
            if(!password_verify($data["old-password"], $_SESSION["user-logged-in"]["password_hash"])){
                $errors["old-passwordErr"] = "Invalid password!";
            }
            if(!preg_match("/^[\w@-]{8,20}$/", $data["new-password"])){
                $errors["new-passwordErr"] = "Password must be alphanumeric (@, _ and - are also allowed) and be 8 - 20
                characters";
            }
        } 
        //if no errors
        if(!array_filter($errors) && array_filter($data)){
            $i = 0;
            $conn->beginTransaction();
            foreach($data as $newData){
                if(!empty($newData) && $i != 2){
                    switch($i){
                        case 0:
                            $update = "UPDATE users SET phone_number = ? WHERE username = ?;";
                            $stmt = $conn->prepare($update, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                            $stmt->bindParam(1, $newData);
                            $stmt->bindParam(2, $_SESSION["user-logged-in"]["username"]);
                            $status = $stmt->execute();
                            if(!$status){
                                $conn->rollBack();
                                die();
                            }
                            break;
                        case 1:
                            $update = "UPDATE users SET email = ? WHERE username = ?;";
                            $stmt = $conn->prepare($update, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                            $stmt->bindParam(1, $newData);
                            $stmt->bindParam(2, $_SESSION["user-logged-in"]["username"]);
                            $status = $stmt->execute();
                            if(!$status){
                                $conn->rollBack();
                                die();
                            }
                            break;
                        case 3:
                            $hashed_password = password_hash($newData, PASSWORD_DEFAULT);
                            $update = "UPDATE users SET password_hash = ? WHERE username = ?;";
                            $stmt = $conn->prepare($update, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                            $stmt->bindParam(1, $hashed_password);
                            $stmt->bindParam(2, $_SESSION["user-logged-in"]["username"]);
                            $status = $stmt->execute();
                            if(!$status){
                                $conn->rollBack();
                                die();
                            }
                            break;
                    }
                }
                $i++;
            }
            $conn->commit();
            if($status){
                //
                $sql = "SELECT * FROM users WHERE username = '{$_SESSION['user-logged-in']['username']}';";
                $result = $conn->query($sql);
                $userUpdated = $result->fetch(PDO::FETCH_ASSOC);

                //disconnect db
                include_once("./database/db_disconnect.php");
                $_SESSION["user-logged-in"] = $userUpdated;
                //print_r($_SESSION["user-logged-in"]);
                header($location);
                die();
            }
        }
    }

?>
<?php include_once("./include/docStart.php"); ?>
<?php include_once("./include/navbar.php"); ?>
<!--heading-->
<br><br><br>
<div class="text-center section-heading p-5 m-0 ">
            <h2> Hello <span> <?php echo $_SESSION["user-logged-in"]["username"]; ?> </span></h2>
            <p class="lead">Update your profile</p>
</div>
<!--edit profile form-->
<section class="background-image" >
    <div class="container-lg text-center p-5">
        <div class="row justify-content-center form_bg text-white">
            <div class="col-lg-6 mx-auto">
                <div class="row text-center">
                    <i class="bi bi-person-circle fs-1"></i>
                    <h3 class="text-warning"><?php echo $_SESSION["user-logged-in"]["username"]; ?></h3>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . $queryString; ?>" method="POST">
                    <div class="form-row py-2">
                        <div class="form-group ">
                            <label for="email" class="form-label"> Change Email</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Enter a new email address" value="<?php echo $data['email']; ?>">
                        </div>
                        <div class="text-danger">
                            <?php echo $errors["emailErr"]; ?>
                        </div>
                    </div>
                    <div class="form-row py-2">
                        <div class="form-group ">
                            <label for="phone-number" class="form-label"> Change  Phone Number</label>
                            <input type="text"  class="form-control" name="phone-number" id="phone-number" placeholder="Enter new Phone Number" value="<?php echo $data['phoneNumber']; ?>" >
                        </div>
                        <div class="text-danger">
                            <?php echo $errors["phoneNumberErr"]; ?>
                        </div>
                    </div>
                    <div class="form-row py-2">
                        <div class="form-group ">
                            <label for="old-password" class="form-label"> Old password</label>
                            <input type="password" class="form-control" name="old-password" id="old-password " placeholder="Enter old password " value="<?php echo $data['old-password']; ?>">
                        </div>
                        <div class="text-danger">
                            <?php echo $errors["old-passwordErr"]; ?>
                        </div>
                    </div>
                    <div class="form-row py-2">
                        <div class="form-group ">
                            <label for="new-password" class="form-label"> New password</label>
                            <input type="password" class="form-control" name="new-password" id="new-password " placeholder="Enter new password" value="<?php echo $data['new-password']; ?>">
                        </div>
                        <div class="text-danger">
                            <?php echo $errors["new-passwordErr"]; ?>
                        </div>
                    </div>
                    <input class="btn btn-warning btn-lg btn-info my-2 mb-3 " type="submit" name="submit" value="Save Changes">
                </form>
            </div>
        </div>
    </div>
</section>

<?php include_once("./include/footer.php"); ?>
<?php include_once("./include/docEnd.php"); ?>