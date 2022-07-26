<?php
    //
    require_once("SimpleRest.php");
    require_once("DatabaseController.php");
    //PaymentHandler class
    class PaymentHandler extends SimpleRest {
        //attributes
        private $dbConn = null;

        //methods
        //constructor
        function __construct(){
            $this->dbConn = new DatabaseController();
        }
        //add
        public function add($data){
            //
            $statusCode = 200;
            //
            $response = array("status" => "error", "message" => "");
            //
            if(!isset($data["order_id"])){
                $response["message"] = "no-order-id";
                echo $this->encodeJson($response);
                return;
            }
            //
            if(!isset($data["amount"])){
                $response["message"] = "no-amount";
                echo $this->encodeJson($response);
                return;
            }
            //
            $sql = "INSERT INTO payments(order_id, amount, direction, date, status) VALUES(?,?,?,CURDATE(),?);";
            //
            $args = [
                $data["order_id"],
                $data["amount"],
                1,
                "paid"
            ];
            //
            $result = $this->dbConn->cudQuery($sql, $args);
            //
            $statusCode = ($result["status"] === "error") ? 404 : 200;
            //
            if($result["row-count"] > 0){
                $response["status"] = "success";
                $response["message"] = "Insert successful";
            } else {
                $response["status"] = "failure";
                $response["message"] = "Insert fail";
            }
            //
            //headers
            $requestContentType = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : null;
		    $this ->setHttpHeaders($requestContentType, $statusCode);
            //
            echo $this->encodeJson($response);
        }
        //get payments
        public function getPayments($data = null){
            //
            $response = [
                "status" => "no-records",
                "payment_details" => null
            ];
            //sql
            $sql = "SELECT  p.id, order_id, amount, p.date, p.status, username
                    FROM    payments p, orders o
                    WHERE   p.order_id = o.id";
            
            if(isset($data["order_id"])){
                $order_id = $data["order_id"];
                $sql .= " AND order_id = ?";
            }
            //
            if(isset($data["payment-status"])){
                $status = $data["payment-status"];
                $sql .= " AND p.status = ?";
            }
            //
            $sql .= " ORDER BY p.date;";
            //
            if(isset($order_id) || isset($status)){
                $args = array();
            }
            //prepared statement
            if(isset($order_id)){
                array_push($args, $order_id);
            }
            //
            if(isset($status)){
                array_push($args, $status);
            }
            //
            $result = (isset($args)) ? $this->dbConn->selectQuery($sql, $args) : $this->dbConn->selectQuery($sql);
            //$result = $this->dbConn->selectQuery($sql);
            //
            $statusCode = ($result["status"] === "error") ? 404 : 200;
            //
            $response["status"] = $result["status"];
            $response["payment_details"] = $result["data"];
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