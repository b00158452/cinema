<?php

class Cancellation {
    private $cancellation_id;
    private $booking_id;
    private $employee_id;
    private $reason;

    public function __construct() {}

    public function getCancellationId() {
        return $this->cancellation_id;
    }

    public function setCancellationId($cancellation_id) {
        $this->cancellation_id = $cancellation_id;
    }

    public function getBookingId() {
        return $this->booking_id;
    }

    public function setBookingId($booking_id) {
        $this->booking_id = $booking_id;
    }

    public function getEmployeeId() {
        return $this->employee_id;
    }

    public function setEmployeeId($employee_id) {
        $this->employee_id = $employee_id;
    }

    public function getReason() {
        return $this->reason;
    }

    public function setReason($reason) {
        $this->reason = $reason;
    }
}

?>
