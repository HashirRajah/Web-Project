<?php
    //
    $data = array("status" => "", "food-items" => null);
    //connect to db
    require_once("../database/db_connect.php");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //sql 
    $sql = "SELECT * FROM food_items";
    //specific id
    if(isset($_GET["item_id"])){
        $item_id = $_GET["item_id"];
        $sql .= " WHERE id = ?";
    }
    //specific category
    else if(isset($_GET["category"])){
        $category = $_GET["category"];
        $sql .= " WHERE cat_id IN (SELECT id FROM food_category WHERE name = ?)";
    }
    $sql .= ";";
    //prepared statement
    $stmt = $conn->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    //
    if(isset($item_id)){
        $stmt->bindParam(1, $item_id);
    } else if(isset($category)){
        $stmt->bindParam(1, $category);
    }
    //
    $status = $stmt->execute();
    //
    if($status){
        $food_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($food_items) > 0){
            $data["status"] = "success";
            $data["food-items"] = $food_items;
        } else {
            $data["status"] = "no-data";
        }
    }
    //disconnect to db
    include_once("../database/db_disconnect.php");
    //return data
    header("Content-Type: application/json");
    echo json_encode($data, JSON_PRETTY_PRINT);

?>