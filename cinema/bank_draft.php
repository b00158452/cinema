<?php
// bank_draft.php

require_once 'payment.php'; // Include the payment.php file where the Payment class is defined

class BankDraft extends Payment {
    public $name;
    public $bank;

    // Constructor
    public function __construct($name, $bank) {
        $this->name = $name;
        $this->bank = $bank;
    }

    // Specific getter and setter methods for BankDraft
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getBank() {
        return $this->bank;
    }

    public function setBank($bank) {
        $this->bank = $bank;
    }
}
?>

