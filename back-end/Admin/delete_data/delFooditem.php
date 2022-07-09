<?php
    //
    if(isset($_POST["item-id"])){
        $response = array("status" => "", "message" => "");
        $id = $_POST["item-id"];
        //connect to db
        require_once("../database/db_connect.php");
        //sql to delete item
        $sql = "DELETE FROM food_items WHERE id = ?;";
        $stmt = $conn->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt->bindParam(1, $id);
        //sql to delete item image
        $sql2 = "DELETE FROM food_item_images WHERE id = ?;";
        $stmt2 = $conn->prepare($sql2, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->bindParam(1, $id);
        //
        header("Content-Type: application/json");
        $response["status"] = "error";
        $response["message"] = "Delete failed";
        //
        $conn->beginTransaction();
        $status = $stmt->execute();
        //
        if(!$status){
            $conn->rollBack();
            echo json_encode($response, JSON_PRETTY_PRINT);
            die();
        }
        $status = $stmt2->execute();
        if(!$status){
            $conn->rollBack();
            echo json_encode($response, JSON_PRETTY_PRINT);
            die();
        } else {
            $response["status"] = "success";
            $response["message"] = "Delete successful";
        }
        $conn->commit();
        //
        //disconnect to db
        include_once("../database/db_disconnect.php");
        //
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
?>