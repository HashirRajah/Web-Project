<?php
    //
    require_once("SimpleRest.php");
    require_once("DatabaseController.php");
    //OrderHandler class
    class OrderHandler extends SimpleRest {
        //attributes
        private $dbConn = null;

        //methods
        //constructor
        function __construct(){
            $this->dbConn = new DatabaseController();
        }
        //update order
        public function updateOrder($data){

        }
        //get orders
        public function getOrders($data = null){

        }
        //destructor
        function __destructor(){
            $this->dbConn = null;
        }
    }
?>