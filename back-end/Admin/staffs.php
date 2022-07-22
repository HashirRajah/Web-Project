<?php
    //start session
    session_start();
    //page info
    $title = "Staffs";
    $moreStyle = false;
    //$styleSheetNames = [".css"];
    //js files
    $scripts = ["get_staffs.js"];
    //check if user is not logged in
    if(!isset($_SESSION["user-logged-in"])){
        header("Location: login.php?destination=staffs");
        die();
    }
?>
<?php include_once("./include/docStart.php"); ?>
<?php include_once("./include/navbar.php"); ?>

<div class="container-fluid text-center p-5">
    <div class="row pt-4">
        <div class="col-md-1"></div>
        <div class="col-md-10 p-3">
            <div class="row text-dark">
                <div class="col-3"></div>
                <div class="col-6"><h1 class="text-uppercase">Staffs</h1></div>
                <div class="col-3 text-end">
                    <img id="add-staff" src="./images/plus.png" alt="+">
                    <span class="p-2 fs-4 text-dark">Add</span>
                </div>
            </div>
            <div id="message" class="p-2 m-2 rounded <?php if(isset($_GET["message"])){ echo 'bg-success fs-4 lead text-white'; } ?>"><?php if(isset($_GET["message"])){ echo htmlspecialchars($_GET["message"]); } ?></div>
            <div class="row">
                <div class="container-fluid shadow m-2 p-3 bg-body rounded p-5">
                    <div>
                        <table class="table table-hover" id="staffs">
                            <thead>
                                <tr class="table-warning text-uppercase">
                                <th scope="col">username</th>
                                <th scope="col">first-name</th>
                                <th scope="col">last-name</th>
                                <th scope="col">email</th>
                                <th scope="col">phone#</th>
                                <th scope="col">delete</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div id="staff-count" class="p-2 m-2 rounded"></div>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>
<?php include_once("./include/docEnd.php"); ?>