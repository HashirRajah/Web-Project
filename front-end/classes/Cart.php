<?php
    //include fooditem class
    //include("./classes/FoodItem.php");
    //cart class
    class Cart {
        //data members
        private $items;
        private $totalPrice;
        private $discount;
        private $totalItems;
        //constructor
        function __construct(){
            $this->items = array();
            $this->totalPrice = 0;
            $this->discount = 0;
            $this->totalItems = 0;
        }
        //public functions
        //setters and getters
        //total price
        public function setTotalPrice($totalPrice){
            $this->totalPrice = $totalPrice;
        }
        public function getTotalPrice(){
            $this->calculateTotalPrice();
            return $this->totalPrice;
        }
        //discount
        public function setDiscount($discount){
            $this->discount = $discount;
        }
        public function getDiscount(){
            return $this->discount;
        }
        public function setTotalItems($number){
            $this->totalItems = $number;
        }
        public function getTotalItems(){
            return $this->totalItems;
        }
        //adding and removing items
        public function add($item){
            if($this->contains($item->getId()) === -1){
                array_push($this->items, $item);
            } else {
                $this->items[$this->contains($item->getId())]->increment();
            }
            //update price
            $this->totalPrice += $item->getUnitPrice();
            //update number of items
            $this->totalItems++;
        }
        //increment qty
        public function incrementItem($id){
            for($i = 0;$i < sizeof($this->items);$i++){
                if($this->items[$i]->getId() === $id){
                    $this->items[$i]->increment();
                    $this->totalPrice = $this->calculateTotalPrice();
                    $this->totalItems++;
                    break;
                }
            }
        }
        //decrement qty
        public function decrementItem($id){
            for($i = 0;$i < sizeof($this->items);$i++){
                if($this->items[$i]->getId() === $id){
                    if($this->items[$i]->getQty() == 1){
                        $this->remove($this->items[$i]->getId());
                    } else {
                        $this->items[$i]->decrement();
                        $this->totalPrice = $this->calculateTotalPrice();
                        $this->totalItems--;
                    }
                    break;
                }
            }
        }
        public function remove($id){
            if($this->contains($id) != -1){
                //new array
                $updatedItems = array();
                for($i = 0;$i < sizeof($this->items);$i++){
                    if($i != $this->contains($id)){
                        array_push($updatedItems, $this->items[$i]);
                    }
                }
                //update price
                $this->totalPrice -= ($this->items[$this->contains($id)]->getUnitPrice() * $this->items[$this->contains($id)]->getQty());
                //update number of items
                $this->totalItems -= $this->items[$this->contains($id)]->getQty();
                $this->items = $updatedItems;
            }
        }
        public function getItems(){
            return $this->items;
        }
        //price and applying discount
        public function applyDiscount(){
            $this->totalPrice -= ($this->discount * $this->totalPrice);
        }
        //search for item in cart
        public function contains($id){
            for($i = 0;$i < sizeof($this->items);$i++){
                if($this->items[$i]->getId() === $id){
                    return $i;
                }
            }
            return -1;
        }
        public function calculateTotalPrice(){
            $total = 0;
            for($i = 0;$i < sizeof($this->items);$i++){
                $total += ($this->items[$i]->getQty() * $this->items[$i]->getUnitPrice());
            }
            $this->totalPrice = $total;
        }

    };

?>