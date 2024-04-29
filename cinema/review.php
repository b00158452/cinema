<?php
class Review{
    private $review_id;
    private $guest_id;
    private $film_id;
    private $rating;
    private $comment;

    public function __construct($review_id = null, $guest_id = null, $film_id = null, $rating = null, $comment = null) {
        $this->review_id = $review_id;
        $this->guest_id = $guest_id;
        $this->film_id = $film_id;
        $this->rating = $rating;
        $this->comment = $comment;
    }

    // Getters
    public function getReviewId() {
        return $this->review_id;
    }

    public function getGuestId() {
        return $this->guest_id;
    }

    public function getFilmId() {
        return $this->film_id;
    }

    public function getRating() {
        return $this->rating;
    }

    public function getComment() {
        return $this->comment;
    }

    // Setters
    public function setReviewId($review_id) {
        $this->review_id = $review_id;
    }

    public function setGuestId($guest_id) {
        $this->guest_id = $guest_id;
    }

    public function setFilmId($film_id) {
        $this->film_id = $film_id;
    }

    public function setRating($rating) {
        $this->rating = $rating;
    }

    public function setComment($comment) {
        $this->comment = $comment;
    }
}
?>