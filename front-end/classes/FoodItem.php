<?php
    //session_start();
    //food item class
    class FoodItem {
        //data members
        private $id;
        private $name;
        private $unitPrice;
        private $qty;
        private $imageLink;
        //constructor
        function __construct($id, $name, $unitPrice, $imageLink){
            $this->id = $id;
            $this->name = $name;
            $this->unitPrice = $unitPrice;
            $this->qty = 1;
            $this->imageLink = $imageLink;
        }
        //public functions
        //getters
        public function getId(){
            return $this->id;
        }
        public function getName(){
            return $this->name;
        }
        public function getUnitPrice(){
            return $this->unitPrice;
        }
        public function getQty(){
            return $this->qty;
        }
        public function getImageLink(){
            return $this->imageLink;
        }
        //increment and decrement qty
        public function increment(){
            $this->qty++;
        }
        public function decrement(){
            $this->qty--;
        }

    };

?>