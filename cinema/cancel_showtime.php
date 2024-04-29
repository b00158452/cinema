<?php
session_start();

// Redirect to the cinema page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: /cinema');
    exit();
}

require_once 'conection.php';
require_once 'showtime.php';

$conn = Conection::ConectionDB(); // Establishing a database connection

// Get the list of existing films
$stmt_films = $conn->query("SELECT film_id, title FROM film");
$films = $stmt_films->fetchAll(PDO::FETCH_ASSOC);

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['film_id'])) {
    $film_id = $_POST['film_id'];

    // Prepare the query to get the showtimes associated with the selected film
    $stmt_showtimes = $conn->prepare("SELECT * FROM showtime WHERE film_id = :film_id");
    $stmt_showtimes->bindParam(':film_id', $film_id, PDO::PARAM_INT);
    $stmt_showtimes->execute();
    $showtimes = $stmt_showtimes->fetchAll(PDO::FETCH_ASSOC);
}

// Check if the showtime cancellation form has been submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['showtime_id'])) {
    $showtime_id = $_POST['showtime_id'];

    // Delete the showtime from the database
    $stmt_delete_showtime = $conn->prepare("DELETE FROM showtime WHERE showtime_id = :showtime_id");
    $stmt_delete_showtime->bindParam(':showtime_id', $showtime_id, PDO::PARAM_INT);
    $stmt_delete_showtime->execute();

    // Reload the page to reflect the changes
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cancel Showtime</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php require 'partials/header.php'; ?>

<h1>Cancel Showtime</h1>

<!-- Form to select a film -->
<form action="cancel_showtime.php" method="post">
    <label for="film_id">Select a Film:</label>
    <select id="film_id" name="film_id" required>
        <option value="">Select Film</option>
        <?php foreach ($films as $film): ?>
            <option value="<?php echo $film['film_id']; ?>"><?php echo $film['title']; ?></option>
        <?php endforeach; ?>
    </select>
    <br>
    <br>
    <input type="submit" value="Show Showtimes">
</form>

<!-- Display showtimes for the selected film -->
<?php if (isset($showtimes)): ?>
    <h2>Showtimes for Selected Film</h2>
    <ul>
        <?php foreach ($showtimes as $showtime): ?>
            Date: <?php echo $showtime['date']; ?>,
            Time: <?php echo $showtime['time']; ?>,
            Room: <?php echo $showtime['room_id']; ?>
            <!-- Form to cancel a showtime -->
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <input type="hidden" name="showtime_id" value="<?php echo $showtime['showtime_id']; ?>">
                <input type="submit" value="Cancel Showtime">
            </form>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

</body>
</html>
