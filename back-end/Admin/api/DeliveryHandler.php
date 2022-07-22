<?php
    //
    require_once("SimpleRest.php");
    require_once("DatabaseController.php");
    //OrderHandler class
    class DeliveryHandler extends SimpleRest {
        //attributes
        private $dbConn = null;

        //methods
        //constructor
        function __construct(){
            $this->dbConn = new DatabaseController();
        }
        //get order details
        public function getDeliveryDetails($data){
            //
            $statusCode = 200;
            //
            $response = [
                "status" => "error",
                "delivery_details" => null
            ];
            //
            if(isset($data["order_id"])){
                $order_id = $data["order_id"];
                //sql
                $sql = "SELECT  * 
                        FROM    delivery 
                        WHERE   order_id = ?;";
                             
                //qurery
                $result = $this->dbConn->selectQuery($sql, [$order_id]);
                //
                $statusCode = ($result["status"] === "error") ? 404 : 200;
                //
                $response["status"] = $result["status"];
                $response["delivery_details"] = $result["data"];
                    
                
            } else {
                $response["status"] = "no-order_id";
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