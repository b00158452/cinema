<?php

class Booking {
    private $booking_id;
    private $guest_id;
    private $room_id;
    private $showtime_id;
    private $seat_id;
    private $payment_id;


    public function __construct() {}

    // Getter and setter methods for booking_id
    public function getBookingId() {
        return $this->booking_id;
    }

    public function setBookingId($booking_id) {
        $this->booking_id = $booking_id;
    }

    // Getter and setter methods for guest_id
    public function getGuestId() {
        return $this->guest_id;
    }

    public function setGuestId($guest_id) {
        $this->guest_id = $guest_id;
    }

    // Getter and setter methods for room_id
    public function getRoomId() {
        return $this->room_id;
    }

    public function setRoomId($room_id) {
        $this->room_id = $room_id;
    }

    // Getter and setter methods for showtime_id
    public function getShowtimeId() {
        return $this->showtime_id;
    }

    public function setShowtimeId($showtime_id) {
        $this->showtime_id = $showtime_id;
    }

    // Getter and setter methods for seat_id
    public function getSeatId() {
        return $this->seat_id;
    }

    public function setSeatId($seat_id) {
        $this->seat_id = $seat_id;
    }

    // Getter and setter methods for payment_id
    public function getPaymentId() {
        return $this->payment_id;
    }

    public function setPaymentId($payment_id) {
        $this->payment_id = $payment_id;
    }
}
?>
