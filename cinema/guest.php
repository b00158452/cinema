<?php
require_once 'user.php'; // Incluir la clase User antes de la clase Guest

class Guest extends User {
    private $guest_id;
    private $username;
    private $mail;
    private $password;
    private $guest_user_id;

    public function __construct($guest_id, $username, $mail, $password, $guest_user_id) {
        $this->guest_id = $guest_id;
        $this->username = $username;
        $this->mail = $mail;
        $this->password = $password;
        $this->guest_user_id = $guest_user_id;
    }

    // Getters y setters específicos de Guest
    public function getGuestId() {
        return $this->guest_id;
    }

    public function setGuestId($guest_id) {
        $this->guest_id = $guest_id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getMail() {
        return $this->mail;
    }

    public function setMail($mail) {
        $this->mail = $mail;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getId() {
        return $this->guest_user_id;
    }

    public function setId($guest_user_id) {
        $this->guest_user_id = $guest_user_id;
    }
}
?>


