<?php
    //
    $data = [
        "status" => "no-records",
        "payment_details" => null
    ];
    //connect to db
    require_once("../database/db_connect.php");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //sql
    $sql = "SELECT  p.id, order_id, amount, p.date, p.status, username
            FROM    payments p, orders o
            WHERE   p.order_id = o.id";
    //
    if(isset($_GET["order_id"])){
        $order_id = $_GET["order_id"];
        $sql .= " AND order_id = :order_id";
    }
    //
    if(isset($_GET["status"])){
        $status = $_GET["status"];
        $sql .= " AND p.status = :status";
    }
    //
    $sql .= " ORDER BY date;";
    //prepared statement
    $stmt = $conn->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    if(isset($order_id)){
        $stmt->bindParam(':order_id', $order_id);
    }
    //
    if(isset($status)){
        $stmt->bindParam(':status', $status);
    }
    //
    $result = $stmt->execute();
    if($result){
        $payment_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($payment_details) > 0){
            $data["status"] = "successful";
            $data["payment_details"] = $payment_details;
        }
    } else {
        $data["status"] = "failure";
    }
    //
    $stmt = null;
    //diconnect to db
    include_once("../database/db_disconnect.php");
    //
    header("Content-Type: application/json");
    echo json_encode($data, JSON_PRETTY_PRINT);
?>