<?php
    //start session
    session_start();
    //
    $title = "View Orders";
    $moreStyle = true;
    $styleSheetNames = ["view-order.css"];

    include_once("./include/functions.php");
    include_once("./database/db_connect.php");

       
     
        
        
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $username = $_SESSION["user-logged-in"]["username"];
       
        $sql = "SELECT * FROM orders WHERE username = $username AND status = 'pending'" ;
        $result = $conn->query($sql);
                //fetch all results
        $order = $result->fetchAll(PDO::FETCH_ASSOC);
       
        $sql = "SELECT * FROM food_order_details WHERE order_id = {$order['order_id']}";
        $result = $conn->query($sql);
                //fetch all results
        $items = $result->fetchAll(PDO::FETCH_ASSOC);
        

        


?>
<?php include_once("./include/docStart.php"); ?>
<?php include_once("./include/navbar.php"); ?>
<!--heading-->
<br><br><br>
<div class="text-center section-heading p-5 m-0 ">
    <h2> Hello <span> <?php echo $_SESSION["user-logged-in"]["username"]; ?> </span></h2>
    <h1 class="lead">No current orders</h1>
</div>

<section >
<table border=1>
        <caption>Orders</caption>
        <thead>
        <tr>
            <th>Id</th>
            <th>Date</th>
            <th>Time </th>
            <th>Discount</th>
            <th>type</th>
        </tr>
        </thead>
        <tbody>
        <?php
            while($reservations->fetch(PDO::FETCH_ASSOC))
            { 
            
            echo '<td>' . $order['id'] . '</td>';
            echo '<td>' . $order['date'] . '</td>';
            echo '<td>' . $order['time'] . '</td>';
            echo '<td>' . $order['discount'] . '</td>';
            echo '<td>' . $order['status'] . '</td>';
            echo '<td>' . $order['type'] . '</td>';
            }//end while
        ?>  
        </tbody>
    </table>

</section>

<?php include_once("./include/footer.php"); ?>
<?php include_once("./include/docEnd.php"); ?>