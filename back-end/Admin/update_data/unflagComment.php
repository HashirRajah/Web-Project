<?php
    if(isset($_POST["review-details"])){
        header("Content-Type: application/json");
        //response
        $response = array("status" => "", "message" => "");
        //validations
        $valid = false;
        if(!array_filter($_POST["review-details"])){
            $response["status"] = "error";
            $response["message"] = "no-data-supplied";
            echo json_encode($response, JSON_PRETTY_PRINT);
            die();
        }
        //
        if(!isset($_POST["review-details"]["order-id"])){
            $response["status"] = "error";
            $response["message"] = "no-order-id-supplied";
            echo json_encode($response, JSON_PRETTY_PRINT);
            die();
        } else {
            $order_id = $_POST["review-details"]["order-id"];
        }
        //
        if(!isset($_POST["review-details"]["food-id"])){
            $response["status"] = "error";
            $response["message"] = "no-food-id-supplied";
            echo json_encode($response, JSON_PRETTY_PRINT);
            die();
        } else {
            $food_id = $_POST["review-details"]["food-id"];
        }
        //
        if(!isset($_POST["review-details"]["username"])){
            $response["status"] = "error";
            $response["message"] = "no-username-supplied";
            echo json_encode($response, JSON_PRETTY_PRINT);
            die();
        } else {
            $username = $_POST["review-details"]["username"];
            $valid = true;
        }
        //if valid
        if($valid){
            //connect to db
            require_once("../database/db_connect.php");
            //sql 
            $update = "UPDATE food_order_review SET flag = ?, status = ? WHERE order_id = ? AND food_id = ? AND username = ?;";
            $stmt = $conn->prepare($update, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            //bind params
            $val = "valid";
            $flag = 0;
            $stmt->bindParam(1, $flag);
            $stmt->bindParam(2, $val);
            $stmt->bindParam(3, $order_id);
            $stmt->bindParam(4, $food_id);
            $stmt->bindParam(5, $username);
            //
            $status = $stmt->execute();
            if($status){
                $response["status"] = "success";
                $response["message"] = "comment-banned";
            } else {
                $response["status"] = "failure";
                $response["message"] = "query-failed";
            }
            //disconnect to db
            include_once("../database/db_disconnect.php");
        }
        //
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
?>