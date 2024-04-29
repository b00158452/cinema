<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Your email address where you want to receive messages
    $to = "your_email@example.com";

    // Subject of your email
    $subject = "Contact Form Submission";

    // Compose the email message
    $body = "Name: $name\n";
    $body .= "Email: $email\n\n";
    $body .= "Message:\n$message";

    // Set headers
    $headers = "From: $email";

    // Attempt to send the email
    if (mail($to, $subject, $body, $headers)) {
        $success_message = "Your message has been sent successfully!";
    } else {
        $error_message = "Oops! Something went wrong, please try again later.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contact Us</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="contactus.php">Contact Us</a></li>
            <li><a href="about.php">About Us</a></li>
        </ul>
    </nav>
</head>
<body>

<?php require 'partials/header.php' ?>

<h1>Contact Us</h1>

<?php if (isset($success_message)) : ?>
    <div class="success-message"><?= $success_message ?></div>
<?php endif; ?>

<?php if (isset($error_message)) : ?>
    <div class="error-message"><?= $error_message ?></div>
<?php endif; ?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" required><br><br>

    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="message">Message:</label><br>
    <textarea id="message" name="message" rows="4" required></textarea><br><br>

    <input type="submit" value="Submit">
</form>
<footer>
    <div class="container">
        <p>&copy; 2024 TU Dublin Cinema. All rights reserved.</p>
    </div>

</body>
</html>
