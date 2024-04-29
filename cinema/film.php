<?php
class Film{
    //Properties
    private $film_id;
    private $title;
    private $duration;
    private $genre;
    private $rating;
    private $description;

    function set_film_id($film_id){
        $this->film_id = $film_id;
    }

    function get_film_id(){
        return $this->film_id;
    }

    function set_title($title){
        $this->title = $title;
    }

    function get_title(){
        return $this->title;
    }

    function set_duration($duration){
        $this->duration = $duration;
    }

    function get_duration(){
        return $this->duration;
    }

    function set_genre($genre){
        $this->genre = $genre;
    }

    function get_genre(){
        return $this->genre;
    }

    function set_rating($rating){
        $this->rating = $rating;
    }

    function get_rating(){
        return $this->rating;
    }

    function set_description($description){
        $this->description = $description;
    }

    function get_description(){
        return $this->description;
    }

    function displayFilm(){
        echo "Film ID: " . $this->get_film_id();
        echo "<br>";
        echo "Title: " . $this->get_title();
        echo "<br>";
        echo "Duration: " . $this->get_duration();
        echo "<br>";
        echo "Genre: " . $this->get_genre();
        echo "<br>";
        echo "Rating: " . $this->get_rating();
        echo "<br>";
        echo "Description: " . $this->get_description();
        echo "<br>";
        echo "<br>";
    }

}
?>