<?php
    //start session
    session_start();


    $title = "View Reservation";
    $moreStyle = true;
    $styleSheetNames = ["view-order.css"];

    include_once("./include/functions.php");
    include_once("./database/db_connect.php");

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $username = $_SESSION["user-logged-in"]["username"];
   
    $sql = "SELECT * FROM reservations WHERE username = $username AND status = 'pending'" ;
    $result = $conn->query($sql);
            //fetch all results
    $reservations = $result->fetchAll(PDO::FETCH_ASSOC);
   
 
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
    <table border=1>
        <caption>Reservations</caption>
        <thead>
        <tr>
            <th>Id</th>
            <th>Date</th>
            <th>Time Slot</th>
            <th>No of People</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <?php
            while($reservations->fetch(PDO::FETCH_ASSOC))
            { 
            
            echo '<td>' . $reservations['id'] . '</td>';
            echo '<td>' . $reservations['date'] . '</td>';
            echo '<td>' . $reservations['time_slot'] . '</td>';
            echo '<td>' . $reservations['no_of_people'] . '</td>';
            echo '<td>' . $reservations['status'] . '</td>';

            
            }//end while
        ?>  
        </tbody>
    </table>
</section>
<?php include_once("./include/footer.php"); ?>
<?php include_once("./include/docEnd.php"); ?>