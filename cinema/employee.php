<?php
require_once 'user.php'; // Assuming that the User class is already defined

class Employee extends User {
    private $employee_id;
    private $mail;
    private $password;
    private $employee_user_id;

    public function __construct($employee_id, $mail, $password, $employee_user_id) {
        $this->employee_id = $employee_id;
        $this->mail = $mail;
        $this->password = $password;
        $this->employee_user_id = $employee_user_id;
    }

    // Specific getter and setter methods for Employee
    public function getEmployeeId() {
        return $this->employee_id;
    }

    public function setEmployeeId($employee_id) {
        $this->employee_id = $employee_id;
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
        return $this->employee_user_id;
    }

    public function setId($employee_user_id) {
        $this->employee_user_id = $employee_user_id;
    }
}

?>
