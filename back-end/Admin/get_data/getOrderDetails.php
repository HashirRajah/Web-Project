<?php
    //
    $data = [
        "status" => "failure",
        "order_details" => null
    ];
    //connect to db
    require_once("../database/db_connect.php");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //
    if(isset($_GET["order_id"])){
        $order_id = $_GET["order_id"];
        //sql
        $sql = "SELECT  order_id, item_id, price, qty 
                FROM    food_order_details 
                WHERE   order_id = ?;";
        //prepared statement
        $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->bindParam(1, $order_id);
        //qurery
        $status = $stmt->execute();
        if($status){
            $order_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //
            $stmt = null;
            if(count($order_details) > 0){
                $data["status"] = "successful";
                $data["order_details"] = $order_details;
            }
        }
    } else {
        $data["status"] = "no-order_id";
    }
    //
    //disconnect to db
    include_once("../database/db_disconnect.php");
    //
    header("Content-Type: application/json");
    echo json_encode($data, JSON_PRETTY_PRINT);
?>