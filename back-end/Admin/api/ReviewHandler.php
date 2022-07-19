<?php
    //
    require_once("SimpleRest.php");
    require_once("DatabaseController.php");
    //ReviewHandler class
    class ReviewHandler extends SimpleRest {
        //attributes
        private $dbConn = null;

        //methods
        //constructor
        function __construct(){
            $this->dbConn = new DatabaseController();
        }
        //get flagged reviews
        public function getFlaggedReviews(){
            //sql
            $sql = "SELECT username, order_id, food_id, comment FROM food_order_review WHERE flag = 1;";
            //execute query
            $flaggedComments = $this->dbConn->selectQuery($sql);
            if($flaggedComments["status"] === "error"){
                $statusCode = 404;
            } else {
                $statusCode = 200;
            }
            //
            $requestContentType = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : null;
		    $this ->setHttpHeaders($requestContentType, $statusCode);
            //
            echo $this->encodeJson($flaggedComments);
        }
        //ban review
        public function banReview($data){
            //
            $statusCode = 200;
            //
            $response = array("status" => "", "message" => "");
            //validations
            $valid = false;
            //
            if(!isset($data["order_id"])){
                $response["status"] = "error";
                $response["message"] = "no-order-id-supplied";
                echo $this->encodeJson($response);
                die();
            } else {
                $order_id = $data["order_id"];
            }
            //
            if(!isset($data["food_id"])){
                $response["status"] = "error";
                $response["message"] = "no-food-id-supplied";
                echo $this->encodeJson($response);
                die();
            } else {
                $food_id = $data["food_id"];
            }
            //
            if(!isset($data["username"])){
                $response["status"] = "error";
                $response["message"] = "no-username-supplied";
                echo $this->encodeJson($response);
                die();
            } else {
                $username = $data["username"];
                $valid = true;
            }
            //if valid
            if($valid){
                //sql 
                $update = "UPDATE food_order_review SET flag = ?, status = ? WHERE order_id = ? AND food_id = ? AND username = ?;";
                //data
                $ban = "banned";
                $flag = 0;
                $data = [$flag, $ban, $order_id, $food_id, $username];
                //
                $result = $this->dbConn->cudQuery($update, $data);
                //
                $statusCode = ($result["status"] === "error") ? 404 : 200;
                if($result["row-count"] > 0){
                    $response["status"] = "success";
                    $response["message"] = "comment-banned";
                } else {
                    $response["status"] = "failure";
                    $response["message"] = "query-failed";
                }

            }
            //headers
            $requestContentType = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : null;
		    $this ->setHttpHeaders($requestContentType, $statusCode);
            //
            echo $this->encodeJson($response);
        }
        //accept review
        public function acceptReview($data){
            //
            $statusCode = 200;
            //
            $response = array("status" => "", "message" => "");
            //validations
            $valid = false;
            //
            if(!isset($data["order_id"])){
                $response["status"] = "error";
                $response["message"] = "no-order-id-supplied";
                echo $this->encodeJson($response);
                die();
            } else {
                $order_id = $data["order_id"];
            }
            //
            if(!isset($data["food_id"])){
                $response["status"] = "error";
                $response["message"] = "no-food-id-supplied";
                echo $this->encodeJson($response);
                die();
            } else {
                $food_id = $data["food_id"];
            }
            //
            if(!isset($data["username"])){
                $response["status"] = "error";
                $response["message"] = "no-username-supplied";
                echo $this->encodeJson($response);
                die();
            } else {
                $username = $data["username"];
                $valid = true;
            }
            //if valid
            if($valid){
                //sql 
                $update = "UPDATE food_order_review SET flag = ?, status = ? WHERE order_id = ? AND food_id = ? AND username = ?;";
                //data
                $val = "valid";
                $flag = 0;
                $data = [$flag, $val, $order_id, $food_id, $username];
                //
                $result = $this->dbConn->cudQuery($update, $data);
                //
                $statusCode = ($result["status"] === "error") ? 404 : 200;
                if($result["row-count"] > 0){
                    $response["status"] = "success";
                    $response["message"] = "comment-accepted";
                } else {
                    $response["status"] = "failure";
                    $response["message"] = "query-failed";
                }

            }
            //headers
            $requestContentType = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : null;
		    $this ->setHttpHeaders($requestContentType, $statusCode);
            //
            echo $this->encodeJson($response);
        }
        //destructor
        function __destructor(){
            $this->dbConn = null;
        }
    }
?>