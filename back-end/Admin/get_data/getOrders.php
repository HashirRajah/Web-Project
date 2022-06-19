<?php
    //
    $data = [
        "status" => "no-records",
        "orders" => null
    ];
    //connect to db
    require_once("../database/db_connect.php");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //query
    $sql = "SELECT * FROM orders WHERE product_type = 'food'";
    //
    if(isset($_GET["status"])){
        switch($_GET["status"]){
            case "completed":
                $sql .= " AND status = 'completed'";
                break;
            case "pending":
                $sql .= " AND status = 'pending'";
                break;
        }
    }
    //
    if(isset($_GET["type"])){
        switch($_GET["type"]){
            case "pick-up":
                $sql .= " AND type = 'pick-up'";
                break;
            case "delivery":
                $sql .= " AND type = 'delivery'";
                break;
        }
    }
    $sql .= ";";
    //execute query
    $result = $conn->query($sql);
    if($result->rowCount() > 0){
        $data["status"] = "successful";
        $data["orders"] = $result->fetchAll(PDO::FETCH_ASSOC);
    }
    //disconnect to db
    include_once("../database/db_disconnect.php");
    //
    header("Content-Type: application/json");
    echo json_encode($data, JSON_PRETTY_PRINT);
?>