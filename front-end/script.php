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

 //
 $sql = "SELECT * FROM food_category ORDER BY name DESC;";
 $result = $conn->query($sql);
            //fetch all results
 $items = $result->fetchAll(PDO::FETCH_ASSOC);
 //
 $dbCredentials["dbName"] = "laravel_restaurant_demo";
 //
 $DSN = "mysql:host={$dbCredentials['host']};dbname={$dbCredentials['dbName']}";
 //
 try {
    $conn = new PDO($DSN, $dbCredentials["username"], $dbCredentials["password"]);

} catch(PDOException $e) {
    echo "<div><strong>CONNECTION ERROR</strong>: " . $e->getMessage() . "</div>";
}
//
 foreach($items as $item){
    $insert = "INSERT INTO categories(name, created_at, updated_at) VALUES('{$item["name"]}', CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP())";
    $conn->exec($insert);
 }

?>