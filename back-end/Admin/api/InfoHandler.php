<?php
    //
    require_once("SimpleRest.php");
    require_once("DatabaseController.php");
    //PaymentHandler class
    class InfoHandler extends SimpleRest {
        //attributes
        private $dbConn = null;

        //methods
        //constructor
        function __construct(){
            $this->dbConn = new DatabaseController();
        }
        //get payments
        public function getRestaurantInfo(){
            //
            $response = [
                "status" => "no-records",
                "info" => null
            ];
            //sql
            $sql = "SELECT  *
                    FROM    restaurant_info;";
                    
            //
            $result = $this->dbConn->selectQuery($sql);
            //$result = $this->dbConn->selectQuery($sql);
            //
            $statusCode = ($result["status"] === "error") ? 404 : 200;
            //
            $response["status"] = $result["status"];
            $response["info"] = $result["data"];
            //headers
            $requestContentType = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : null;
		    $this ->setHttpHeaders($requestContentType, $statusCode);
            //
            echo $this->encodeJson($response);
        }
        //update
        public function update($data){
            //
            $statusCode = 200;
            //response
            $response = array("status" => "", "message" => "");  
            //
            
            $dataUpdate = $data["info_details"];
            //sql
            $sql = "UPDATE restaurant_info SET";
            //
            $i = 0;
            $args = array();
            foreach($dataUpdate as $key => $value){
                if($i != 0 && $i != (count($dataUpdate) - 1)){
                    $sql .= ",";
                }
                $sql .= " $key = ?";
                $i++;
                //
                array_push($args, $value);
            }
            $sql .= " WHERE id = ?;";
            array_push($args, $item_id);
            //
            $result = $this->dbConn->cudQuery($sql, $args);
            //
            $statusCode = ($result["status"] === "error") ? 404 : 200;
            if($result["status"] === "success"){
                $response["status"] = "success";
                $response["message"] = "update-successful";
            } else {
                $response["status"] = "error";
                $response["message"] = "update-fails";
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