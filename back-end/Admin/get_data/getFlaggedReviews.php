<?php
    //
    $data = array("status" => "", "flaggedComments" => null);
    //connect to db
    require_once("../database/db_connect.php");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //sql
    $sql = "SELECT username, order_id, food_id, comment FROM food_order_review WHERE flag = 1;";
    //query
    $result = $conn->query($sql);
    //fetch all result in an assoc array
    $flaggedComments = $result->fetchAll(PDO::FETCH_ASSOC);
    //check if there is no flagged comments
    if(count($flaggedComments) === 0){
        $data["status"] = "-";
    } else {
        $data["status"] = "+";
        $data["flaggedComments"] = $flaggedComments;
    }
    //disconnect to db
    include_once("../database/db_disconnect.php");
    //
    header("Content-Type: application/json");
    echo json_encode($data, JSON_PRETTY_PRINT);
?>