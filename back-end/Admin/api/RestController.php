<?php
    //
    require_once("ReviewHandler.php");
    require_once("MenuHandler.php");
    require_once("MenuCategoryHandler.php");
    require_once("OrderHandler.php");
    require_once("OrderDetailsHandler.php");
    require_once("PaymentHandler.php");
    require_once("StaffHandler.php");
    require_once("DeliveryHandler.php");
    //RestController request methods
    $operations = [
        "POST" => "create",
        "GET" => "read",
        "PUT" => "update",
        "DELETE" => "delete"
    ];
    //
    $operation = $operations[$_SERVER["REQUEST_METHOD"]];
    //put request
    $_SERVER['REQUEST_METHOD']==="PUT" ? parse_str(file_get_contents('php://input', false , null, 0 , $_SERVER['CONTENT_LENGTH'] ), $_PUT): $_PUT=array();
    //delete request
    $_SERVER['REQUEST_METHOD']==="DELETE" ? parse_str(file_get_contents('php://input', false , null, 0 , $_SERVER['CONTENT_LENGTH'] ), $_DELETE): $_DELETE=array();
    //
    $resource = "";
    if(isset($_GET["resource"])){
        $resource = $_GET["resource"];
    }
    //
    switch($resource){
        case "review":
            //
            $reviewHandler = new ReviewHandler();
            //
            switch($operation){
                case "read":
                    $reviewHandler->getFlaggedReviews();
                    break;
                case "update":
                    ($_PUT["operation"] === "accept") ? $reviewHandler->acceptReview($_PUT): $reviewHandler->banReview($_PUT);
                    break;
            }
            break;
        case "staff":
            $staffHandler = new StaffHandler();
            //
            switch($operation){
                case "read":
                    $staffHandler->getStaffs($_GET);
                    break;
                case "delete":
                    $staffHandler->delete($_DELETE);
                    break;
                case "create":
                    $staffHandler->add($_POST);
                    break;
            }
            break;
        case "payment":
            $paymentHandler = new PaymentHandler();
            //
            switch($operation){
                case "read":
                    $paymentHandler->getPayments($_GET);
                    break;
            }
            break;
        case "order-details":
            //
            $orderDetailsHandler = new OrderDetailsHandler();
            //
            switch($operation){
                case "read":
                    $orderDetailsHandler->getOrderDetails($_GET);
                    break;
            }
            break;
        case "order":
            //
            $orderHandler = new OrderHandler();
            //
            switch($operation){
                case "read":
                    $orderHandler->getOrders($_GET);
                    break;
                case "update":
                    $orderHandler->completeOrder($_PUT);
                    break;
            }
            break;
        case "menu-category":
            //
            $menuCatHandler = new MenuCategoryHandler();
            //
            switch($operation){
                case "read":
                    $menuCatHandler->getMenuItemsCategory($_GET);
                    break;
                case "update":
                    $menuCatHandler->update($_PUT);
                    break;
                case "create":
                    $menuCatHandler->add($_POST);
                    break;
            }
            break;
        case "menu":
            //
            $menuHandler = new MenuHandler();
            //
            switch($operation){
                case "read":
                    $menuHandler->getMenuItems($_GET);
                    break;
                case "update":
                    $menuHandler->update($_PUT);
                    break;
                case "create":
                    $menuHandler->add($_POST);
                    break;
                case "delete":
                    $menuHandler->delete($_DELETE);
                    break;
            }
            break;
        case "delivery":
            //
            $deliveryHandler = new DeliveryHandler();
            //
            switch($operation){
                case "read":
                    $deliveryHandler->getDeliveryDetails($_GET);
                    break;
            }
            break;
    }
?>