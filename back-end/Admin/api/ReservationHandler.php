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
        //get payments
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
        //destructor
        function __destructor(){
            $this->dbConn = null;
        }
    }

?>