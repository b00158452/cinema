<?php
session_start();

// If the user is already authenticated, redirect to the main page
if (isset($_SESSION['user_id'])) {
    header('Location: /cinema');
}

require_once 'conection.php';
require_once 'user_reader.php';

// Establish connection with the database
$conn = Conection::ConectionDB();

// Create a UserReader object with the database connection
$reader = new UserReader($conn);

// Get the array of users using the UserReader object
$users = $reader->getUsers();

$message = '';

// If the login form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if both email and password are provided
    if (isset($_POST['mail']) && isset($_POST['password'])) {
        $mail = $_POST['mail'];
        $password = $_POST['password'];

        // Loop through users to verify credentials
        foreach ($users as $user) {
            // Check credentials based on user type
            if ($user->getMail() === $mail) {
                if ($user instanceof Guest && password_verify($password, $user->getPassword())) {
                    $_SESSION['user_id'] = $user->getId();
                    header('Location: /cinema');
                    exit();
                } elseif ($user->getPassword() === $password) {
                    $_SESSION['user_id'] = $user->getId();
                    header('Location: /cinema');
                    exit();
                }
            }
        }

        $message = 'Sorry, those credentials do not match';
    } else {
        $message = 'Please provide both mail and password';
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>

<?php require 'partials/header.php' ?>

<h1>Login</h1>
<span>or <a href="signup.php">Sign Up</a></span>

<?php if (!empty($message)) : ?>
    <p><?= $message ?></p>
<?php endif; ?>

<form action="login.php" method="post">
    <input type="text" name="mail" placeholder="Enter your mail">
    <input type="password" name="password" placeholder="Enter your password">
    <input type="submit" value="Send">
</form>

</body>
</html>
