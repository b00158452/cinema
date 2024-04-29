<?php
class Seat {
    private $seatId;
    private $room;
    private $row;
    private $column;

    public function __construct($seatId, $room, $row, $column) {
        $this->seatId = $seatId;
        $this->room = $room;
        $this->row = $row;
        $this->column = $column;

    }

    public function getSeatId() {
        return $this->seatId;
    }

    public function getRoom() {
        return $this->room;
    }

    public function getRow() {
        return $this->row;
    }

    public function getColumn() {
        return $this->column;
    }
}
?>