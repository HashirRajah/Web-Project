<?php
    //
    require_once("SimpleRest.php");
    require_once("DatabaseController.php");
    //OrderHandler class
    class OrderHandler extends SimpleRest {
        //attributes
        private $dbConn = null;

        //methods
        //constructor
        function __construct(){
            $this->dbConn = new DatabaseController();
        }
        //update order
        public function completeOrder($data){
            //
            $statusCode = 200;
            //
            $response = array("status" => "", "message" => "");
            //validations
            $valid = false;
            //
            if(!isset($data["order-id"])){
                $response["status"] = "error";
                $response["message"] = "no-order-id-supplied";
                echo $this->encodeJson($response);
                return;
            } else {
                $order_id = $data["order-id"];
                //
                //if order-id invalid
                $sql = "SELECT * FROM orders WHERE id = ?;";
                //
                $result = $this->dbConn->selectQuery($sql, [$order_id]);
                if($result["data"] === "no-data"){
                    $response["status"] = "error";
                    $response["message"] = "invalid-order-id";
                    echo $this->encodeJson($response);
                    return;
                }

                $valid = true;
            }
            //if valid
            if($valid){
                //sql 
                $update = "UPDATE orders SET status = ? WHERE id = ?;";
                //data
                $status = "completed";
                $data = [$status, $order_id];
                //
                $result = $this->dbConn->cudQuery($update, $data);
                //
                $statusCode = ($result["status"] === "error") ? 404 : 200;
                if($result["row-count"] > 0){
                    $response["status"] = "success";
                    $response["message"] = "order-completed";
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
        //get orders
        public function getOrders($data = null){
            //
            $statusCode = 200;
            //
            $response = [
                "status" => "no-records",
                "orders" => null
            ];
            //query
            $sql = "SELECT * FROM orders WHERE product_type = 'food'";
            //
            if(isset($data["order-status"])){
                switch($data["order-status"]){
                    case "completed":
                        $sql .= " AND status = 'completed'";
                        break;
                    case "pending":
                        $sql .= " AND status = 'pending'";
                        break;
                }
            }
            //
            if(isset($data["type"])){
                switch($data["type"]){
                    case "pick-up":
                        $sql .= " AND type = 'pick-up'";
                        break;
                    case "delivery":
                        $sql .= " AND type = 'delivery'";
                        break;
                }
            }
            $sql .= ";";
            //execute query
            $result = $this->dbConn->selectQuery($sql);
            //
            $statusCode = ($result["status"] === "error") ? 404 : 200;
            //
            $response["status"] = $result["status"];
            $response["orders"] = $result["data"];
            
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