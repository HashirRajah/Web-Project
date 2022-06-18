<?php
    //start session
    session_start();
    //check if user is logged in
    if(!isset($_SESSION["user-logged-in"])){
        header("Location: login.php?destination=dashboard");
        die();
    }
    //page meta data
    $title = "Dashboard";
    $moreStyle = false;

?>
<?php include("./include/docStart.php"); ?>
<?php include("./include/navbar.php"); ?>
<!--Welcome message-->
<br />
<br />
<br />
<div class="container-fluid m-3">Hello <?php echo $_SESSION["user-logged-in"]["first_name"]; ?>, Welcome back</div>
<!--Statistics-->
<section id="stats">
    <p>stats here</p>
</section>
<!--recent orders-->
<section id="recent-orders">
    <p>recent orders here</p>
</section>
<!--flagged comments-->
<section id="flagged-comments">
    <p>flagged comments here</p>
</section>
<?php include("./include/docEnd.php"); ?>