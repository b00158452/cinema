<?php 
class User {
    private $user_id;
    private $name;
    private $surname;
    private $role_user;

    // Constructor
    public function __construct($user_id, $name, $surname, $role_user) {
        $this->user_id = $user_id;
        $this->name = $name;
        $this->surname = $surname;
        $this->role_user = $role_user;
    }

    // Getters y setters
    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function setSurname($surname) {
        $this->surname = $surname;
    }

    public function getRoleUser() {
        return $this->role_user;
    }

    public function setRoleUser($role_user) {
        $this->role_user = $role_user;
    }
}
?>
