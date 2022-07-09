<?php
    $data = ["status" => "", "data" => null];
    //connect to db
    require_once("../database/db_connect.php");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //sql
    $sql = "SELECT * FROM food_category";
    if(isset($_GET["cat-id"])){
        $cat_id = $_GET["cat-id"];
        $sql .= " WHERE id = ?";
    }
    $sql .= ";";
    //
    $stmt = $conn->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    //
    if(isset($cat_id)){
        $stmt->bindParam(1, $cat_id);
    }
    //
    $status = $stmt->execute();
    if($status){
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($result) > 0){
            $data["status"] = "success";
            $data["data"] = $result;
        } else {
            $data["status"] = "error";
            $data["data"] = "no-data";
        }
    } else {
        $data["status"] = "error";
        $data["data"] = "failed-query";
    }
    //disconnect to db
    include_once("../database/db_disconnect.php");
    //
    header("Content-Type: application/json");
    echo json_encode($data, JSON_PRETTY_PRINT);

?>