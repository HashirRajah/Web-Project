<?php
    //start session
    session_start();


    $title = "View Reservation";
    $moreStyle = true;
    $styleSheetNames = ["view-order.css"];

    include_once("./include/functions.php");
    include_once("./database/db_connect.php");
?>


<?php include_once("./include/docStart.php"); ?>
<?php include_once("./include/navbar.php"); ?>

<!--heading-->
<br><br><br>
<div class="text-center section-heading p-5 m-0 ">
    <h2> Hello <span> <?php echo $_SESSION["user-logged-in"]["username"]; ?> </span></h2>
    <h1 class="lead">No current reservations</h1>
</div>
<section >
</section>
<?php include_once("./include/footer.php"); ?>
<?php include_once("./include/docEnd.php"); ?>