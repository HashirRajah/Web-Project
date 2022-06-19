<?php
    //
    $data = [
        "status" => "no-data",
        "staff_details" => null
    ];
    //connect to db
    require_once("../database/db_connect.php");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //sql
    $sql = "SELECT  username, first_name, last_name, email, phone_number
            FROM    users
            WHERE   type = 'staff'";
    //
    if(isset($_GET["username"])){
        $staff_username = $_GET["username"];
        $sql .= " AND username = :username";
    }
    //
    $sql .= ";";
    //prepared statement
    $stmt = $conn->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    if(isset($staff_username)){
        $stmt->bindParam(':username', $staff_username);
    }
    //execute query
    $status = $stmt->execute();
    if($status){
        $staff_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($staff_details) > 0){
            $data["status"] = "successful";
            $data["staff_details"] = $staff_details;
        }
    } else {
        $data["status"] = "failure";
    }
    //
    $stmt = null;
    //disconnect to db
    include_once("../database/db_disconnect.php");
    //
    header("Content-Type: application/json");
    echo json_encode($data, JSON_PRETTY_PRINT);

?>