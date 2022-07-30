<?php
    //
    require_once("SimpleRest.php");
    require_once("DatabaseController.php");
    //PaymentHandler class
    class ReservationHandler extends SimpleRest {
        //attributes
        private $dbConn = null;

        //methods
        //constructor
        function __construct(){
            $this->dbConn = new DatabaseController();
        }
        //get reservations
        public function getReservations($data = null){
            //
            $response = [
                "status" => "no-records",
                "reservation_details" => null
            ];
            //sql
            $WHERE = "WHERE";
            $sql = "SELECT  *
                    FROM    reservations";
            
            if(isset($data["date"])){
                $sql .= " $WHERE date = CURDATE()";
                $WHERE = "AND";
            }
            //
            if(isset($data["reservation-status"])){
                $status = $data["reservation-status"];
                $sql .= " $WHERE status = ?";
            }
            //
            $sql .= " ORDER BY date;";
            //
            if(isset($status)){
                $args = array();
                array_push($args, $status);
            }
            //
            $result = (isset($args)) ? $this->dbConn->selectQuery($sql, $args) : $this->dbConn->selectQuery($sql);
            //$result = $this->dbConn->selectQuery($sql);
            //
            $statusCode = ($result["status"] === "error") ? 404 : 200;
            //
            $response["status"] = $result["status"];
            $response["reservation_details"] = $result["data"];
            //headers
            $requestContentType = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : null;
		    $this ->setHttpHeaders($requestContentType, $statusCode);
            //
            echo $this->encodeJson($response);
        }
        //cancel reservation
        public function cancel($data){
            //
            $statusCode = 200;
            //
            $response = array("status" => "", "message" => "");
            //validations
            $valid = false;
            //
            if(!isset($data["reservation_id"])){
                $response["status"] = "error";
                $response["message"] = "no-reservation-id-supplied";
                echo $this->encodeJson($response);
                return;
            } else {
                $reservation_id = $data["reservation_id"];
                //
                //if order-id invalid
                $sql = "SELECT * FROM reservations WHERE id = ?;";
                //
                $result = $this->dbConn->selectQuery($sql, [$reservation_id]);
                if($result["data"] === "no-data"){
                    $response["status"] = "error";
                    $response["message"] = "invalid-reservation-id";
                    echo $this->encodeJson($response);
                    return;
                }

                $valid = true;
            }
            //if valid
            if($valid){
                //sql 
                $update = "UPDATE reservations SET status = ? WHERE id = ?;";
                //data
                $status = "cancelled";
                $data = [$status, $reservation_id];
                //
                $result = $this->dbConn->cudQuery($update, $data);
                //
                $statusCode = ($result["status"] === "error") ? 404 : 200;
                if($result["row-count"] > 0){
                    $response["status"] = "success";
                    $response["message"] = "reservation-cancelled";
                } else {
                    $response["status"] = "failure";
                    $response["message"] = "query-failed";
                }
                //
                //sql 
                $delete = "DELETE FROM tables_used WHERE id = ?;";
                //data
                $data = [$reservation_id];
                //
                $result = $this->dbConn->cudQuery($delete, $data);
                //
                $statusCode = ($result["status"] === "error") ? 404 : 200;
                if($result["row-count"] > 0){
                    $response["status"] = "success";
                    $response["message"] = "reservation-cancelled";
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
        //complete reservation
        public function complete($data){
            //
            $statusCode = 200;
            //
            $response = array("status" => "", "message" => "");
            //validations
            $valid = false;
            //
            if(!isset($data["reservation_id"])){
                $response["status"] = "error";
                $response["message"] = "no-reservation-id-supplied";
                echo $this->encodeJson($response);
                return;
            } else {
                $reservation_id = $data["reservation_id"];
                //
                //if order-id invalid
                $sql = "SELECT * FROM reservations WHERE id = ?;";
                //
                $result = $this->dbConn->selectQuery($sql, [$reservation_id]);
                if($result["data"] === "no-data"){
                    $response["status"] = "error";
                    $response["message"] = "invalid-reservation-id";
                    echo $this->encodeJson($response);
                    return;
                }

                $valid = true;
            }
            //if valid
            if($valid){
                //sql 
                $update = "UPDATE reservations SET status = ? WHERE id = ?;";
                //data
                $status = "completed";
                $data = [$status, $reservation_id];
                //
                $result = $this->dbConn->cudQuery($update, $data);
                //
                $statusCode = ($result["status"] === "error") ? 404 : 200;
                if($result["row-count"] > 0){
                    $response["status"] = "success";
                    $response["message"] = "reservation-completed";
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