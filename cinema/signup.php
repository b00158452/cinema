<?php
    require 'conection.php';
    $conn = Conection::ConectionDB();
    $message='';

    if(!empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['mail']) && !empty($_POST['password']) 
       && !empty($_POST['username'])){

        //Get the maximum current ID from the user table
        $sql_max_user_id = "SELECT MAX(user_id) AS max_user_id FROM user";
        $statement_max_user_id = $conn->prepare($sql_max_user_id);
        $statement_max_user_id->execute();
        $result_max_user_id = $statement_max_user_id->fetch(PDO::FETCH_ASSOC);
        $next_user_id = $result_max_user_id['max_user_id'] + 1;

        //Insert data into user table using next user ID
        $sql1 = "INSERT INTO user (user_id, name, surname, role_user) VALUES (:user_id, :name, :surname, 3)";
        $statement1 = $conn->prepare($sql1);
        $statement1->bindParam(':user_id', $next_user_id);
        $statement1->bindParam(':name', $_POST['name']);
        $statement1->bindParam(':surname', $_POST['surname']);

        //Get the newly inserted user ID
        $user_id = $next_user_id;

        //Get maximum current ID from guest table
        $sql_max_guest_id = "SELECT MAX(guest_id) AS max_guest_id FROM guest";
        $statement_max_guest_id = $conn->prepare($sql_max_guest_id);
        $statement_max_guest_id->execute();
        $result_max_guest_id = $statement_max_guest_id->fetch(PDO::FETCH_ASSOC);
        $next_guest_id = $result_max_guest_id['max_guest_id'] + 1;

        //Continue inserting data into the guest table
        $sql2 = "INSERT INTO guest (guest_id, username, mail, password, guest_user_id) VALUES (:guest_id, :username, :mail, :password, :user_id)";
        $statement2 = $conn->prepare($sql2);
        $statement2->bindParam(':guest_id', $next_guest_id);
        $statement2->bindParam(':username', $_POST['username']);
        $statement2->bindParam(':mail', $_POST['mail']);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $statement2->bindParam(':password', $password);
        $statement2->bindParam(':user_id', $user_id);

        //Run both queries
        if($statement1->execute() && $statement2->execute()){
            $message = 'Successfully created new user';
        }else{
            $message = 'Sorry there must have been an issue creating your account';
        }
    }
?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="uf-8">
        <title>Sign Up</title>
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"> 
        <link rel="stylesheet" href="assets/css/signup.css">
    </head>
    <body>
        <?php require 'partials/header.php' ?>

        <?php if(!empty($message)): ?>
            <p><?= $message ?></p>
        <?php endif; ?>


        <h1>Sign Up</h1>
        <span>or <a href="login.php">Login</a></span>

        <form action="signup.php" method="post">
            <input type="text" name="name" placeholder="Enter your name">
            <input type="text" name="surname" placeholder="Enter your surname">
            <input type="text" name="mail" placeholder="Enter your mail">
            <input type="text" name="username" placeholder="Enter your username">
            <input type="password" name="password" placeholder="Enter your password">
            <input type="submit" value="Send">
        </form>

    </body>
</html>