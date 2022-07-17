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

        }
        //delete
        public function delete($data){

        }
        //update
        public function update($data){

        }
        //get food items
        public function getMenuItems($data = null){

        }
        //get category
        public function getMenuItemsCategory($data = null){

        }
        //destructor
        function __destructor(){
            $this->dbConn = null;
        }
    }
?>