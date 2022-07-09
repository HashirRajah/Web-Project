<?php
    //
    if(isset($_POST["staff-username"])){
        $type = "staff";
        //
        $response = array("status" => "", "message" => "");
        $username = $_POST["staff-username"];
        //connect to db
        require_once("../database/db_connect.php");
        //sql
        $sql = "DELETE FROM users WHERE username = ? AND type = ?;";
        $stmt = $conn->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $type);
        $status = $stmt->execute();
        //
        if($status){
            $response["status"] = "success";
            $response["message"] = "Delete successful";
        } else {
            $response["status"] = "error";
            $response["message"] = "Delete failed";
        }
        //disconnect to db
        include_once("../database/db_disconnect.php");
        //
        header("Content-Type: application/json");
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
?>