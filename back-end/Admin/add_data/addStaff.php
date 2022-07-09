<?php
    //
    if(isset($_POST["staff"])){
        $data = $_POST["staff"];
        //
        $response = array("status" => "", "message" => "");
        //validations
        $valid = false;
        //
        if(!array_filter($data)){
            $response["status"] = "error";
            $response["message"] = "no-data-supplied";
        }
        //
        if($valid){
            $type = "staff";
            $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
            //connect to db
            require_once("../database/db_connect.php");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //sql
            $sql = "INSERT INTO users() VALUES(?,?,?,?,?,?,?);";
            $stmt = $conn->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            //bind params
            $stmt->bindParam(1, $data['username']);
            $stmt->bindParam(2, $data['firstName']);
            $stmt->bindParam(3, $data['lastName']);
            $stmt->bindParam(4, $data['email']);
            $stmt->bindParam(5, $hashed_password);
            $stmt->bindParam(6, $data['phoneNumber']);
            $stmt->bindParam(7, $type);
            //
            $status = $stmt->execute();
            //
            if($status){
                $response["status"] = "success";
                $response["message"] = "Insert successful";
            } else {
                $response["status"] = "failure";
                $response["message"] = "Insert fail";
            }
            //disconnect to db
            include_once("../database/db_disconnect.php");
        }
        //
        header("Content-Type: application/json");
        echo json_encode($response, JSON_PRETTY_PRINT);
    }

?>