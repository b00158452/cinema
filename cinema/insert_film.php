<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /cinema');
    exit();
}

require_once 'conection.php';

$conn = Conection::ConectionDB();

//Query to know the next film id
$stmt_next_id = $conn->prepare("SELECT film_id FROM film ORDER BY film_id DESC LIMIT 1");
$stmt_next_id->execute();
$row = $stmt_next_id->fetch(PDO::FETCH_ASSOC);
$next_id = $row ? $row['film_id'] + 1 : 1;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Process the form data
    $title = $_POST['title'];
    $duration = $_POST['duration'];
    $genre = $_POST['genre'];
    $rating = $_POST['rating'];
    $description = $_POST['description'];

    // Perform insertion into the database
    $stmt = $conn->prepare("INSERT INTO film (film_id, title, duration, genre, rating, description) VALUES (:film_id, :title, :duration, :genre, :rating, :description)");
    $stmt->bindParam(':film_id', $next_id, PDO::PARAM_INT);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':duration', $duration, PDO::PARAM_INT);
    $stmt->bindParam(':genre', $genre, PDO::PARAM_STR);
    $stmt->bindParam(':rating', $rating, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->execute();

    // Redirect to a success page or another part of the application
    header('Location: /cinema');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Insert Film</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php require 'partials/header.php'; ?>
<h1>Insert a New Film</h1>
<form action="insert_film.php" method="post">
    <label for="title">Title:</label><br>
    <input type="text" id="title" name="title" required><br>

    <label for="duration">Duration (minutes):</label><br>
    <input type="text" id="duration" name="duration" required><br>

    <?php echo "<br>"; ?>

    <label for="genre">Genre:</label><br>
    <input type="text" id="genre" name="genre" required><br>

    <label for="rating">Rating:</label><br>
    <input type="text" id="rating" name="rating" required><br>

    <label for="description">Description:</label><br>
    <textarea id="description" name="description" rows="4" cols="50" required></textarea><br>

    <?php echo "<br>"; ?>

    <input type="submit" value="Submit">
</form>
</body>
</html>
