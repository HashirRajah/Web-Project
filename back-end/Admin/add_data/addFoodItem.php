<?php
    //if data sent through post request 
    if(isset($_POST["item"])){
        $response = array("status" => "", "message" => "");
        //validations
        $valid = false;
        //no data sent
        if(!array_filter($_POST["item"])){
            $response["status"] = "error";
            $response["message"] = "no-data-supplied";
        }
        //name
        if(empty($_POST["item"]["name"]) || !isset($_POST["item"]["name"])){
            $response["status"] = "error";
            $response["message"] = "no-name-supplied";
        }
        //description
        if(empty($_POST["item"]["desc"]) || !isset($_POST["item"]["desc"])){
            $response["status"] = "error";
            $response["message"] = "no-description-supplied";
        }
        //price
        if(empty($_POST["item"]["price"]) || !isset($_POST["item"]["price"])){
            $response["status"] = "error";
            $response["message"] = "no-price-supplied";
        }
        //cat_id
        if(empty($_POST["item"]["cat_id"]) || !isset($_POST["item"]["cat_id"])){
            $response["status"] = "error";
            $response["message"] = "no-cat_id-supplied";
        } else {
            //get category
            $url = "../get_data/getMenuCategories?cat-id=" . $_POST["item"]["cat_id"];
            $json_data = file_get_contents($url);
            //
            $data = json_decode($json_data, false);
            //
            if($data->status === "success"){
                $valid = true;
            } else {
                $response["status"] = "error";
                $response["message"] = "invalid-cat_id";
            }
        }
        //if all valid
        if($valid){
            //connect to db
            require_once("../database/db_connect.php");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //sql
            $sql = "INSERT INTO food_items(name, description, unit_price, cat_id) VALUES(?,?,?,?);";
            $stmt = $conn->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            //bind params
            $stmt->bindParam(1, $_POST["item"]["name"]);
            $stmt->bindParam(2, $_POST["item"]["desc"]);
            $stmt->bindParam(3, $_POST["item"]["price"]);
            $stmt->bindParam(4, $_POST["item"]["cat_id"]);
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