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
        //add an order
        public function add($data){
            //
            $statusCode = 200;
            //
            $response = array("status" => "error", "message" => "", "order_id" => "");
            //validations
            $sql = "INSERT INTO orders(date, time, discount, status, username, type, product_type) VALUES(CURDATE(),?,?,?,?,?,?);";
            //
            $args = [
                $data["time"],
                0,
                "pending",
                $data["username"],
                $data["type"],
                "food"
            ];
            //
            $result = $this->dbConn->cudQuery($sql, $args);
            //
            if($result["row-count"] == 0){
                $response["status"] = "error";
                $response["message"] = "could not insert order";
                echo $this->encodeJson($response);
                return;
            }
            $result = $this->dbConn->selectQuery("SELECT MAX(id) AS max_id FROM orders;");
            $order_id = "";
            if($result["status"] === "success"){
                //
                $order_id = $result["data"][0]["max_id"];
                $response["order_id"] = $order_id;
            }
            //
            if($data["type"] == "delivery"){
                $sql = "INSERT INTO delivery(order_id, street, city, house_number, status, delivey_instructions) VALUES(?,?,?,?,?,?);";
                //
                $args = [
                    $order_id,
                    $data["street"],
                    $data["city"],
                    $data["house_number"],
                    "pending",
                    $data["del_ins"]
                ];
                $result = $this->dbConn->cudQuery($sql, $args);
                //
                if($result["row-count"] == 0){
                    $response["status"] = "error";
                    $response["message"] = "could not insert order";
                    echo $this->encodeJson($response);
                    return;
                }
            }
            //
            $queries = array();
            //
            $data["cart"] = json_decode($data["cart"], true);
            //
            $sql = "INSERT INTO food_order_details VALUES(?,?,?,?,?)";
            foreach($data["cart"] as $item){
                $args = [
                    $order_id,
                    $item["id"],
                    $item["price"],
                    $item["qty"],
                    0
                ];
                //
                $query = ["sql" => $sql, "data" => $args];
                //
                array_push($queries, $query);
            }
            //
            $result = $this->dbConn->transaction($queries);
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
            //headers
            $requestContentType = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : null;
		    $this ->setHttpHeaders($requestContentType, $statusCode);
            //
            echo $this->encodeJson($response);
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
            if(!isset($data["order_id"])){
                $response["status"] = "error";
                $response["message"] = "no-order-id-supplied";
                echo $this->encodeJson($response);
                return;
            } else {
                $order_id = $data["order_id"];
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