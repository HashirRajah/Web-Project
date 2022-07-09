<?php
    if(isset($_POST["item_details"])){
        header("Content-Type: application/json");
        //response
        $response = array("status" => "", "message" => "");
        //
        $item_id = $_POST["item_details"]["item_id"];
        //get details
        $url = "../get_data/getMenuItems?item_id=" . $item_id;
        //
        $json_data = file_get_contents($url);
        //
        $data = json_decode($json_data);
        //
        if($data["status"] != "success"){
            $response["status"] = "error";
            $response["message"] = "item-not-found";
            echo json_encode($response, JSON_PRETTY_PRINT);
            die();
        }
        //
        if($data["status"] === "success"){
            $dataUpdate = $_POST["item_details"];
            //connect to db
            require_once("../database/db_connect.php");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //sql
            $sql = "UPDATE food_items SET";
            //
            $i = 0;
            foreach($dataUpdate as $key => $value){
                if($i != 0 && $i != (count($dataUpdate) - 1)){
                    $sql .= ",";
                }
                $sql .= " $key = ?";
                $i++;
            }
            $sql .= " WHERE id = ?;";
            //
            $stmt = $conn->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            //
            $col = 1;
            foreach($dataUpdate as $key => $value){
                $stmt->bindParam($col, $value);
                $col++;
            }
            $stmt->bindParam($col, $item_id);
            //
            $status = $stmt->execute();
            if($status){
                $response["status"] = "success";
                $response["message"] = "update-successful";
            } else {
                $response["status"] = "error";
                $response["message"] = "update-fails";
            }
            //disconnect to db
            include_once("../database/db_disconnect.php");
            //
            echo json_encode($response, JSON_PRETTY_PRINT);
        }
    }
?>