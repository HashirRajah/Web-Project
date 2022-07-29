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
       
        $sql = "SELECT * FROM orders WHERE username = '$username' AND status = 'pending' limit 1" ;
        $result = $conn->query($sql);
                //fetch all results
        $orders = $result->fetchAll(PDO::FETCH_ASSOC);
        // print_r($order);
        // die();
       
        if(count($orders) > 0){
            $sql = "SELECT * FROM food_order_details f, food_items i WHERE f.item_id = i.id AND order_id = {$orders[0]['id']}";
            $result = $conn->query($sql);
                    //fetch all results
            $items = $result->fetchAll(PDO::FETCH_ASSOC);
            //
            if($orders[0]['type'] === "delivery"){
                $sql = "SELECT * FROM delivery WHERE order_id = {$orders[0]['id']}";
                $result = $conn->query($sql);
                        //fetch all results
                $delDet = $result->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        

        


?>
<?php include_once("./include/docStart.php"); ?>
<?php include_once("./include/navbar.php"); ?>
<!--heading-->
<br><br><br>
<div class="text-center section-heading p-5 m-0 ">
    <h2> Hello <span> <?php echo $_SESSION["user-logged-in"]["username"]; ?> </span></h2>
    <h1 class="lead">Current orders</h1>
</div>
<?php if(count($orders) > 0): ?>
    <div class="container-fluid text-center p-5">
        <div class="row pt-4">
            <div class="col-md-1"></div>
            <div class="col-md-10 p-3">
                <div class="row text-dark">
                    <h1 class="text-uppercase">Orders</h1>
                </div>
                <div id="message" class="p-2 m-2 rounded fs-3">
                </div>
                <div class="row">
                    <div class="container-fluid shadow m-2 p-3 bg-body rounded p-5">
                        <div>
                            <table class="table table-hover" id="order">
                                <thead>
                                    <tr class="table-warning text-uppercase">
                                        <th scope="col">id</th>
                                        <th scope="col">date</th>
                                        <th scope="col">time</th>
                                        <th scope="col">discount</th>
                                        <th scope="col">status</th>
                                        <th scope="col">type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach($orders as $order)
                                    { 
                                        echo '<tr>';
                                        echo '<td>' . $order['id'] . '</td>';
                                        echo '<td>' . $order['date'] . '</td>';
                                        echo '<td>' . $order['time'] . '</td>';
                                        echo '<td>' . $order['discount'] . '</td>';
                                        echo '<td>' . $order['status'] . '</td>';
                                        echo '<td>' . $order['type'] . '</td>';
                                        echo '</tr>';
                                    }//end for
                                ?> 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php if($orders[0]['type'] === "delivery"): ?>
                    <div class="row" id="delivery">
                        <div class="container-fluid shadow m-2 p-3 bg-body rounded p-5">
                            <div>
                                <table class="table table-hover" id="delivery-det">
                                    <thead>
                                        <tr class="table-success text-uppercase">
                                            <th scope="col">street</th>
                                            <th scope="col">city</th>
                                            <th scope="col">house#</th>
                                            <th scope="col">instructions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        foreach($delDet as $del)
                                        { 
                                            echo '<tr>';
                                            echo '<td>' . $del['street'] . '</td>';
                                            echo '<td>' . $del['city'] . '</td>';
                                            echo '<td>' . $del['house_number'] . '</td>';
                                            echo '<td>' . $del['delivey_instructions'] . '</td>';
                                            echo '</tr>';
                                        }//end for
                                    ?> 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="row">
                    <div class="container-fluid shadow m-2 p-3 bg-body rounded p-5">
                        <div>
                            <table class="table table-hover" id="order-det">
                                <thead>
                                        <tr class="table-primary text-uppercase">
                                        <th scope="col">item-id</th>
                                        <th scope="col">name</th>
                                        <th scope="col">price</th>
                                        <th scope="col">quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach($items as $item)
                                    { 
                                        echo '<tr>';
                                        echo '<td>' . $item['item_id'] . '</td>';
                                        echo '<td>' . $item['name'] . '</td>';
                                        echo '<td>' . $item['price'] . '</td>';
                                        echo '<td>' . $item['qty'] . '</td>';
                                        echo '</tr>';
                                    }//end for
                                ?> 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
<?php endif; ?>
<?php include_once("./include/footer.php"); ?>
<?php include_once("./include/docEnd.php"); ?>