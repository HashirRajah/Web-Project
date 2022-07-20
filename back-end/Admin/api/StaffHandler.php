<?php
    //
    require_once("SimpleRest.php");
    require_once("DatabaseController.php");
    //StaffHandler class
    class StaffHandler extends SimpleRest {
        //attributes
        private $dbConn = null;

        //methods
        //constructor
        function __construct(){
            $this->dbConn = new DatabaseController();
        }
        //add staff
        public function add($data){
            //
            $statusCode = 200;
            //
            $response = array("status" => "error", "message" => "");
            //validations
            $valid = false;
            //
            if(!array_filter($data)){
                $response["status"] = "error";
                $response["message"] = "no-data-supplied";
                echo $this->encodeJson($response);
                return;
            }
            //first name
            if(!isset($data["firstName"]) || empty($data["firstName"])){
                $response["message"] = "First Name is required!";
                echo $this->encodeJson($response);
                return;
            } else {
                if(!preg_match("/^[A-Z][a-z]+( [A-Z][a-z]+)*$/", $data["firstName"])){
                    $response["message"] = "First name should consist of one or more words, starting with an uppercase letter followed by lowercase characters, and separated by spaces";
                    echo $this->encodeJson($response);
                    return;
                }
            } 
            //last name
            if(!isset($data["lastName"]) || empty($data["lastName"])){
                $response["message"] = "Last Name is required!";
                echo $this->encodeJson($response);
                return;
            } else {
                if(!preg_match("/^[A-Z][a-z]+$/", $data["lastName"])){
                    $response["message"] = "Last name should consist of one word, starting with an uppercase letter followed by lowercase characters";
                    echo $this->encodeJson($response);
                    return;
                }
            }
            //phone number
            if(!isset($data["phoneNumber"]) || empty($data["phoneNumber"])){
                $response["message"] = "Phone number is required!";
                echo $this->encodeJson($response);
                return;
            } else {
                if(!preg_match("/^[\d]+$/", $data["phoneNumber"])){
                    $response["message"] = "Phone number should consist of only numbers";
                    echo $this->encodeJson($response);
                    return;
                }
            } 
            //username
            if(!isset($data["username"]) || empty($data["username"])){
                $response["message"] = "Username is required!";
                echo $this->encodeJson($response);
                return;
            } else {
                //if username already exists
                $sql = "SELECT * FROM users WHERE username = ?;";
                //
                $result = $this->dbConn->selectQuery($sql, [$data["username"]]);
                if($result["data"] !== "no-data" && isset($result["data"])){
                    $response["message"] = "Username already taken. Choose another one";
                    echo $this->encodeJson($response);
                    return;
                }
            }
            //email
            if(!isset($data["email"]) || empty($data["email"])){
                $response["message"] = "Email is required!";
                echo $this->encodeJson($response);
                return;
            } else {
                if(!preg_match("/^[a-z\d\.-]+@[a-z\d-]+\.[a-z]{2,8}(\.[a-z]{2,8})*$/", $data["email"])){
                    $response["message"] = "Email must be a valid address, e.g. me@mydomain.com";
                    echo $this->encodeJson($response);
                    return;
                }
            } 
            //password
            if(!isset($data["password"]) || empty($data["password"])){
                $response["message"] = "Password is required!";
                echo $this->encodeJson($response);
                return;
            } else {
                if(!preg_match("/^[\w@-]{8,20}$/", $data["password"])){
                    $response["message"] = "Password must be alphanumeric (@, _ and - are also allowed) and be 8 - 20 characters";
                    echo $this->encodeJson($response);
                    return;
                } else {
                    $valid = true;
                }
            } 
            //
            if($valid){
                $type = "staff";
                $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
                //sql
                $sql = "INSERT INTO users() VALUES(?,?,?,?,?,?,?);";
                $args = [
                    $data['username'],
                    $data['firstName'],
                    $data['lastName'],
                    $data['email'],
                    $hashed_password,
                    $data['phoneNumber'],
                    $type
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
            }
            //headers
            $requestContentType = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : null;
		    $this ->setHttpHeaders($requestContentType, $statusCode);
            //
            echo $this->encodeJson($response);
        }
        //delete staff
        public function delete($data){
            //
            $statusCode = 200;
            //
            $response = array("status" => "error", "message" => "");
            //
            if(isset($data["username"])){
                $type = "staff";
                //
                $username = $data["username"];
                //sql
                $sql = "DELETE FROM users WHERE username = ? AND type = ?;";
                //
                $args = [
                    $username,
                    $type
                ];
                //
                $result = $this->dbConn->cudQuery($sql, $args);
                //
                $statusCode = ($result["status"] === "error") ? 404 : 200;
                //
                if($result["row-count"] > 0){
                    $response["status"] = "success";
                    $response["message"] = "Delete successful";
                } else {
                    $response["status"] = "error";
                    $response["message"] = "Delete failed";
                }
            } else {
                $response["status"] = "fail";
                $response["message"] = "no-username-supplied";
            }
            //headers
            $requestContentType = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : null;
		    $this ->setHttpHeaders($requestContentType, $statusCode);
            //
            echo $this->encodeJson($response);
        }
        //get staffs
        public function getStaffs($data = null){
            $response = [
                "status" => "no-data",
                "staff_details" => null
            ];
            //sql
            $sql = "SELECT  username, first_name, last_name, email, phone_number
                    FROM    users
                    WHERE   type = 'staff'";
            //
            if(isset($data["username"])){
                $staff_username = array($data["username"]);
                $sql .= " AND username = ?";
            }
            //
            $sql .= ";";
            //execute query
            (!isset($staff_username)) ? $result = $this->dbConn->selectQuery($sql): $result = $this->dbConn->selectQuery($sql, $staff_username);
            //statuscode
            $statusCode = ($result["status"] === "error") ? 404 : 200;
            //
            if($result["data"] === "no-data"){
                $response["status"] = "no-data";
            } else {
                $response["status"] = "successful";
                $response["staff_details"] = $result["data"];   
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