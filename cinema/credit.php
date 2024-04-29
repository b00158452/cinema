<?php
// credit.php

require_once 'payment.php'; // Include the payment.php file where the Payment class is defined

class Credit extends Payment {
    public $number;
    public $type;
    public $exp_date;
    public $name;

    // Constructor
    public function __construct($number, $type, $exp_date, $name) {
        $this->number = $number;
        $this->type = $type;
        $this->exp_date = $exp_date;
        $this->name = $name;
    }

    // Specific getter and setter methods for Credit
    public function getNumber() {
        return $this->number;
    }

    public function setNumber($number) {
        $this->number = $number;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getExpDate() {
        return $this->exp_date;
    }

    public function setExpDate($exp_date) {
        $this->exp_date = $exp_date;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }
}

?>
