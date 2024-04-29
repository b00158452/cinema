<?php
require_once 'user.php'; // Assuming the User class is already defined

class Admin extends User {
    private $admin_id;
    private $mail;
    private $password;
    private $admin_user_id;

    public function __construct($admin_id, $mail, $password, $admin_user_id) {
        $this->admin_id = $admin_id;
        $this->mail = $mail;
        $this->password = $password;
        $this->admin_user_id = $admin_user_id;
    }

    // Admin-specific getters and setters
    public function getAdminId() {
        return $this->admin_id;
    }

    public function setAdminId($admin_id) {
        $this->admin_id = $admin_id;
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
        return $this->admin_user_id;
    }

    public function setId($admin_user_id) {
        $this->admin_user_id = $admin_user_id;
    }
}
?>

