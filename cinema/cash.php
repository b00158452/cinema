<?php
// cash.php

require_once 'payment.php';
// Include the payment.php file where the Payment class is defined

class Cash extends Payment {
    public $cash_tendered;

    // Constructor
    public function __construct($cash_tendered) {
        $this->cash_tendered = $cash_tendered;
    }


// Specific getter and setter methods for Cash
    public function getCashTendered() {
        return $this->cash_tendered;
    }

    public function setCashTendered($cash_tendered) {
        $this->cash_tendered = $cash_tendered;
    }
}
?>
