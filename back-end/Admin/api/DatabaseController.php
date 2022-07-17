<?php
    //DatabaseController class
    class DatabaseController {
        //attributes
        //set db credentials
        private $conn = null;
        private $dbCredentials = [
            "host" => "localhost",
            "username" => "hashirRajah",
            "password" => '$hashir1234',
            "dbName" => "restaurant_project"
        ];
        
        //methods
        //constructor
        function __construct(){
            //set data source name(DSN)
            $DSN = "mysql:host={$this->dbCredentials['host']};dbname={$this->dbCredentials['dbName']}";
            //create PDO object
            try {
                $this->conn = new PDO($DSN, $this->dbCredentials["username"], $this->dbCredentials["password"]);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch(PDOException $e) {
                echo "<div><strong>CONNECTION ERROR</strong>: " . $e->getMessage() . "</div>";
            }
        }
        //prepared statement
        public function preparedStatement($sql){
            $stmt = $this->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            return $stmt;
        }
        //select
        public function selectQuery($sql, $data = null){
            //
            $response = ["status" => "", "data" => null];
            //
            $stmt = $this->preparedStatement($sql);
            //execute query
            if(!isset($data)){
                $status = $stmt->execute();
            } else {
                $status = $stmt->execute($data);
            }
            //
            if($status){
                $response["status"] = "success";
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($result) > 0){
                    $response["data"] = $result;
                } else {
                    $response["data"] = "no-data";
                }
            } else {
                $response["status"] = "error";
            }
            //
            return $response;
        }
        //create, update, delete
        public function cudQuery($sql, $data){
            //
            $response = ["status" => "", "row-count" => ""];
            //
            $stmt = $this->preparedStatement($sql);
            //execute query
            $status = $stmt->execute($data);
            //
            if($status){
                $response["status"] = "success";
                $response["row-count"] = $stmt->rowCount();
            } else {
                $response["status"] = "error";
            }
            //
            return $response;
        }
        //destructor
        function __destruct(){
            $this->conn = null;
        }

    }
?>