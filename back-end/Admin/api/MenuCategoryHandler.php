<?php
    //
    require_once("SimpleRest.php");
    require_once("DatabaseController.php");
    //OrderHandler class
    class MenuCategoryHandler extends SimpleRest {
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
            //validations
            $valid = false;
            //name
            if(!isset($data["name"]) || empty($data["name"])){
                $response["message"] = "Name is required!";
                echo $this->encodeJson($response);
                return;
            } else {
                if(!preg_match("/^[A-Z][a-z]+( [A-Z][a-z]+)*$/", $data["name"])){
                    $response["message"] = "Name should consist of one or more words, starting with an uppercase letter followed by lowercase characters, and separated by spaces";
                    echo $this->encodeJson($response);
                    return;
                } else {
                   $valid = true;
                }
            } 
            //
            if($valid){
                //sql
                $sql = "INSERT INTO food_category(name) VALUES(?);";
                $args = [$data["name"]];
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
        //update
        public function update($data){
            //
            $statusCode = 200;
            //
            $response = array("status" => "error", "message" => "");
            //validations
            $valid = false;
            //id
            //name
            if(!isset($data["cat-id"])){
                $response["message"] = "no-category-id-supplied";
                echo $this->encodeJson($response);
                return;
            } else {
                //if cat-id invalid
                $sql = "SELECT * FROM food_category WHERE id = ?;";
                //
                $result = $this->dbConn->selectQuery($sql, [$data["cat-id"]]);
                if($result["data"] === "no-data"){
                    $response["status"] = "error";
                    $response["message"] = "invalid-category-id";
                    echo $this->encodeJson($response);
                    return;
                }
            }
            //name
            if(!isset($data["name"]) || empty($data["name"])){
                $response["message"] = "Name is required!";
                echo $this->encodeJson($response);
                return;
            } else {
                if(!preg_match("/^[A-Z][a-z]+( [A-Z][a-z]+)*$/", $data["name"])){
                    $response["message"] = "Name should consist of one or more words, starting with an uppercase letter followed by lowercase characters, and separated by spaces";
                    echo $this->encodeJson($response);
                    return;
                } else {
                   $valid = true;
                }
            } 
            //
            if($valid){
                //sql
                $sql = "UPDATE food_category SET name = ? WHERE id = ?;";
                $args = [$data["name"], $data["cat-id"]];
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
        //get category
        public function getMenuItemsCategory($data = null){
            $response = [
                "status" => "",
                "menu-categories" => null
            ];
            //sql
            $sql = "SELECT * FROM food_category";
            if(isset($data["cat-id"])){
                $cat_id = $data["cat-id"];
                $sql .= " WHERE id = ?";
            }
            $sql .= ";";
            //
            $result = (!isset($cat_id)) ? $this->dbConn->selectQuery($sql) : $this->dbConn->selectQuery($sql, [$cat_id]);
            //
            $statusCode = ($result["status"] === "error") ? 404 : 200;
            //
            $response["status"] = $result["status"];
            $response["menu-categories"] = $result["data"];
            
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