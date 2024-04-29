<?php

class Showtime {
    private $showtime_id;
    private $film_id;
    private $date;
    private $time;
    private $room_id;

    public function getShowtimeId() {
        return $this->showtime_id;
    }

    public function setShowtimeId($showtime_id) {
        $this->showtime_id = $showtime_id;
    }

    public function getFilmId() {
        return $this->film_id;
    }

    public function setFilmId($film_id) {
        $this->film_id = $film_id;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getTime() {
        return $this->time;
    }

    public function setTime($time) {
        $this->time = $time;
    }

    public function getRoomId() {
        return $this->room_id;
    }

    public function setRoomId($room_id) {
        $this->room_id = $room_id;
    }
}

?>
