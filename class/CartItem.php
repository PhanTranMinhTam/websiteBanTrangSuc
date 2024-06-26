<?php
    class CartItem {
        public $proid, $qty;
        // public $price;
        public function __construct($proid, $qty)
        {
            $this->proid = $proid;
            $this->qty = $qty;
            // $this->price = $price;
        }
    }