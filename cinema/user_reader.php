<?php

require_once 'user.php';
require_once 'guest.php';
require_once 'admin.php';
require_once 'employee.php';

class UserReader{
    private $conn;

    const ADMIN = 1;
    const EMPLOYEE = 2;
    const GUEST = 3;

    //Constructor of User Reader
    public function __construct($conn){
        $this->conn = $conn;
    }

    public function getUsers(){
        //Creates a users array
        $users = array();

        //Query to obtain all the users of the database
        $sql = "SELECT * FROM user";
        //Saves the results obtained from the query
        $result = $this->conn->query($sql);

        if($result->rowCount() > 0){
            //Loop that ends when there are no more rows in the result
            //With every iteration, $row contains one row of the result of the query
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                //Depending on the role of the user, makes a query for different users (Admin, Guest, Employee)
                switch($row['role_user']){
                    case self::ADMIN:
                        $user = $this->getAdmin($row['user_id']);
                        break;
                    
                    case self::EMPLOYEE:
                        $user = $this->getEmployee($row['user_id']);
                        break;
                    
                    case self::GUEST:
                        $user = $this->getGuest($row['user_id']);
                        break;

                    default:
                        //We put continue 2 because que want to continue the 2nd loop (switch)
                        continue 2;
                }

                //If the $user is not null, it will be added to the array
                if($user !== null){
                    $users[] = $user;
                }
            }
        }

        return $users;
    }

    //Obtains the admin details
    private function getAdmin($user_id){
        //Query to obtain admin details using user_id
        $sql = "SELECT * FROM admin WHERE admin_user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($stmt->rowCount() == 1){
            //Returns an Admin object
            return new Admin($row['admin_id'], $row['mail'], $row['password'], $row['admin_user_id']);
        }else{
            //If there is no Admin found for this user_id
            return null;
        }
    }

    //Obtains the employee details
    private function getEmployee($user_id){
        //Query to obtain employee details using user_id
        $sql = "SELECT * FROM employee WHERE employee_user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($stmt->rowCount() == 1){
            //Returns an Employee object
            return new Employee($row['employee_id'], $row['mail'], $row['password'], $row['employee_user_id']);
        }else{
            //If there is no Employee found for this user_id
            return null;
        }
    }

    //Obtains the guest details
    private function getGuest($user_id){
        //Query to obtain guest details using user_id
        $sql = "SELECT * FROM guest WHERE guest_user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($stmt->rowCount() == 1){
            //Returns a Guest object
            return new Guest($row['guest_id'], $row['username'], $row['mail'], $row['password'], $row['guest_user_id']);
        }else{
            //If there is no Guest found for this user_id
            return null;
        }
    }
}
?>
