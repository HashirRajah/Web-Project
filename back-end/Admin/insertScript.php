<?php
    require_once("./database/db_connect.php");
    //data needed
    $query = "SELECT id, date FROM orders;";
    $result = $conn->query($query);
    $data = $result->fetchAll(PDO::FETCH_ASSOC);
    //sql
    $sql = "INSERT INTO payments(order_id, amount, direction, date, status) VALUES(?, ?, ?, ?, ?);";
    $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    //
    $direction = 1;
    //
    $query = "SELECT SUM(unit_price) FROM food_items;";
    $result = $conn->query($query);
    $amount = $result->fetchColumn();
    //echo $amount;
    //
    $status = "paid";
    //
    foreach($data as $d){
        $stmt->bindParam(1, $d["id"]);
        $stmt->bindParam(2, $amount);
        $stmt->bindParam(3, $direction);
        $stmt->bindParam(4, $d["date"]);
        $stmt->bindParam(5, $status);

        $stmt->execute();
    }
    //
    $stmt = null;
    include_once("./database/db_disconnect.php");
?>