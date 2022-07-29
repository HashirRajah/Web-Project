<?php
    //
    require_once("SimpleRest.php");
    require_once("DatabaseController.php");
    //OrderHandler class
    class MenuHandler extends SimpleRest {
        //attributes
        private $dbConn = null;

        //methods
        //constructor
        function __construct(){
            $this->dbConn = new DatabaseController();
        }
        //add
        public function add($data){
            $response = array("status" => "", "message" => "");
            //validations
            $valid = false;
            //name
            if(empty($data["name"]) || !isset($data["name"])){
                $response["status"] = "error";
                $response["message"] = "no-name-supplied";
                echo $this->encodeJson($response);
                return;
            } else {
                if(!preg_match("/^([A-Z][a-z]+)(\s[A-Z][a-z]+)*$/", $data["name"])){
                    $response["status"] = "error";
                    $response["message"] = "Name should consist of at least one word, starting with an uppercase letter followed by lowercase characters";
                    echo $this->encodeJson($response);
                    return;
                }
            }
            //description
            if(empty($data["desc"]) || !isset($data["desc"])){
                $response["status"] = "error";
                $response["message"] = "no-description-supplied";
                echo $this->encodeJson($response);
                return;
            } else {
                if(!preg_match("/^([A-Z][a-z]+)(\s[A-Za-z][a-z]+)*$/", $data["desc"])){
                    $response["status"] = "error";
                    $response["message"] = "Description should consist of at least one word, starting with an uppercase letter followed by lowercase characters";
                    echo $this->encodeJson($response);
                    return;
                }
            }
            //price
            if(empty($data["price"]) || !isset($data["price"])){
                $response["status"] = "error";
                $response["message"] = "no-price-supplied";
                echo $this->encodeJson($response);
                return;
            } else {
                if(!preg_match("/^[\d]+\.[\d]+$/", $data["price"])){
                    $response["status"] = "error";
                    $response["message"] = "Price should consist of only numbers and decimals";
                    echo $this->encodeJson($response);
                    return;
                }
            }
            //image link
            if(empty($data["img_link"]) || !isset($data["img_link"])){
                $response["status"] = "error";
                $response["message"] = "no-image-supplied";
                echo $this->encodeJson($response);
                return;
            }
            //cat_id
            if(empty($data["cat_id"]) || !isset($data["cat_id"])){
                $response["status"] = "error";
                $response["message"] = "no-cat_id-supplied";
                echo $this->encodeJson($response);
                return;
                
            } else {
                //get category
                $url = "http://localhost/Web-Project/back-end/Admin/api/menu-category?cat-id=" . $data["cat_id"];
                $json_data = file_get_contents($url);
                //
                $api_response = json_decode($json_data, true);
                //
                if($api_response["menu-categories"] !== "no-data"){
                    $valid = true;
                } else {
                    $response["status"] = "error";
                    $response["message"] = "invalid-cat_id";
                    echo $this->encodeJson($response);
                    return;
                }
            }
            //if all valid
            if($valid){
                //sql
                $sql = "INSERT INTO food_items(name, description, unit_price, cat_id) VALUES(?,?,?,?);";
                $sql2 = "INSERT INTO food_item_images(id, link, alt) VALUES(?,?,?);";
                //bind params
                $args1 = [
                    $data["name"],
                    $data["desc"],
                    $data["price"],
                    $data["cat_id"]
                ];
                
                //
                $result = $this->dbConn->cudQuery($sql, $args1);
                //
                $statusCode = ($result["status"] === "error") ? 404 : 200;
                if($result["status"] === "success"){
                    $response["status"] = "success";
                    $response["message"] = "Insert successful";
                } else {
                    $response["status"] = "error";
                    $response["message"] = "insert-fails";
                }
                //
                $result = $this->dbConn->selectQuery("SELECT MAX(id) AS max_id FROM food_items;");
                if($result["status"] === "success"){
                    //
                    $args2 = [$result["data"][0]["max_id"], $data["img_link"], "{$data['name']} image"];
                    //
                    $result = $this->dbConn->cudQuery($sql2, $args2);
                    if($result["status"] !== "success"){
                        $response["status"] = "success";
                        $response["message"] = "image-upload-fail";
                    }
                } else {
                    $response["status"] = "success";
                    $response["message"] = "image-upload-fail";
                }
                
            }
            //headers
            $requestContentType = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : null;
		    $this ->setHttpHeaders($requestContentType, $statusCode);
            //
            echo $this->encodeJson($response);
        }
        //delete
        public function delete($data){
            //
            $statusCode = 200;
            //
            $response = array("status" => "error", "message" => "");
            //
            if(isset($data["item_id"])){
                $id = $data["item_id"];
                //sql
                $sql = "DELETE FROM food_items WHERE id = ?;";
                $sql2 = "DELETE FROM food_item_images WHERE id = ?;";
                //
                $args = [
                    ["sql" => $sql, "data" => [$id]],
                    ["sql" => $sql2, "data" => [$id]]
                ];
                //
                $result = $this->dbConn->transaction($args);
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
                $response["message"] = "no-item-id-supplied";
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
            //response
            $response = array("status" => "", "message" => "");
            //
            if(!isset($data["item_id"])){
                $response["status"] = "error";
                $response["message"] = "no-item-id-supplied";
                echo $this->encodeJson($response);
                return;
            } 
            //
            $item_id = $data["item_id"];
            //get details
            $url = "http://localhost/Web-Project/back-end/Admin/api/menu?item_id=" . $item_id;
            //
            $json_data = file_get_contents($url);
            //
            $api_response = json_decode($json_data, true);
            //print_r($api_response);
            //return;
            //
            if($api_response["menu-items"] === "no-data"){
                $response["status"] = "error";
                $response["message"] = "item-not-found";
                echo $this->encodeJson($response);
                return;
            }
            //
            if($api_response["status"] === "success"){
                $dataUpdate = json_decode($data["item_details"], true);
                //sql
                $sql = "UPDATE food_items SET";
                //
                $i = 0;
                $args = array();
                $size = count($dataUpdate);
                foreach($dataUpdate as $key => $value){
                    if($i != 0 && $i != $size){
                        $sql .= ",";
                    }
                    $sql .= " $key = ?";
                    $i++;
                    //
                    array_push($args, $value);
                }
                $sql .= " WHERE id = ?;";
                array_push($args, $item_id);
                // $response["message"] = $sql;
                // echo $this->encodeJson($response);
                // return;
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
            }
            //headers
            $requestContentType = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : null;
		    $this ->setHttpHeaders($requestContentType, $statusCode);
            //
            echo $this->encodeJson($response);
        }
        //get food items
        public function getMenuItems($data = null){
            $response = [
                "status" => "",
                "menu-items" => null
            ];
            //sql 
            $sql = "SELECT * FROM food_items f, food_item_images i WHERE f.id = i.id";
            //specific id
            if(isset($data["item_id"])){
                $item_id = $data["item_id"];
                $sql .= " AND f.id = ?";
            }
            //specific category
            else if(isset($data["category"])){
                $category = $data["category"];
                $sql .= " AND cat_id IN (SELECT id FROM food_category WHERE name = ?)";
            }
            $sql .= ";";
            //
            if(isset($item_id)){
                $args = array($item_id);
            } else if(isset($category)){
                $args = array($category);
            }
            //
            $result = (!isset($args)) ? $this->dbConn->selectQuery($sql) : $this->dbConn->selectQuery($sql, $args);
            //
            $statusCode = ($result["status"] === "error") ? 404 : 200;
            //
            $response["status"] = $result["status"];
            $response["menu-items"] = $result["data"];
            
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