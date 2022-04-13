<?php
    //set db credentials
    $dbCredentials = ["host" => "localhost", "username" => "hashirRajah", "password" => '$hashir1234', "dbName" => "restaurant_project"];

    //set data source name(DSN)
    $DSN = "mysql:host={$dbCredentials['host']};dbname={$dbCredentials['dbName']}";

    //create PDO object
    try {
        $conn = new PDO($DSN, $dbCredentials["username"], $dbCredentials["password"]);

    } catch(PDOException $e) {
        echo "<div><strong>CONNECTION ERROR</strong>: " . $e->getMessage() . "</div>";
    }
?>