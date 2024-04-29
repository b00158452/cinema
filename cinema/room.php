<?php
class Room {
    private $roomId;
    private $capacity;
    private $adminId;
    private $seats = array();

    public function __construct($roomId, $capacity, $adminId) {
        $this->roomId = $roomId;
        $this->capacity = $capacity;
        $this->adminId = $adminId;
    }

    public function getRoomId() {
        return $this->roomId;
    }

    public function getCapacity() {
        return $this->capacity;
    }

    public function getAdminId() {
        return $this->adminId;
    }

    public function addSeat($seatId, $row, $column, $availability) {
        $this->seats[] = new Seat($seatId, $this, $row, $column, $availability);
    }

    public function getSeats() {
        return $this->seats;
    }
}
?>