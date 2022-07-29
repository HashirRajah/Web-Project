<?php
    //start session
    require_once("./classes/FoodItem.php");
    require_once("./classes/Cart.php");
    session_start();
    //
    //handle cart
    if(isset($_SESSION["cart"]) && isset($_SESSION["order-info"]) && isset($_SESSION["item-objects"])){
        foreach($_POST as $key => $value){
            //removing items
            if(preg_match("/remove_/", $value)){
                $id = substr($value, 7);
                $id = intval($id);
                $_SESSION["cart"]->remove($id);
            }
            //incrementing items
            if(preg_match("/increment_/", $value)){
                $id = substr($value, 10);
                $id = intval($id);
                $_SESSION["cart"]->incrementItem($id);
            }
            //decrementing items
            if(preg_match("/decrement_/", $value)){
                $id = substr($value, 10);
                $id = intval($id);
                $_SESSION["cart"]->decrementItem($id);
            }
            //adding items
            if(preg_match("/add_/", $value)){
                $id = substr($value, 3);
                //echo $id;
                $_SESSION["cart"]->add($_SESSION[$id]);
                //print_r($_SESSION["cart"]);
            }
        }
    }
    $items = array();
    //
    foreach(($_SESSION["cart"]->getItems()) as $item){
        $itm = [
            "id" => $item->getId(),
            "name" => $item->getName(),
            "unit_price" => $item->getUnitPrice(),
            "img_link" => $item->getImageLink(),
            "qty" => $item->getQty()
        ];
        //
        array_push($items, $itm);
    }
    //
    $cartDetails = [
        "total_items" => $_SESSION["cart"]->getTotalItems(),
        "total_price" => $_SESSION["cart"]->getTotalPrice(),
        "items" => $items
    ];
    //
    echo json_encode($cartDetails, JSON_PRETTY_PRINT);

?>