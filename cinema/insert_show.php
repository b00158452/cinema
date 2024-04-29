<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /cinema');
    exit();
}

require_once 'conection.php';

$conn = Conection::ConectionDB();

//Query to know the next show id
$stmt_next_id = $conn->prepare("SELECT showtime_id FROM showtime ORDER BY showtime_id DESC LIMIT 1");
$stmt_next_id->execute();
$row = $stmt_next_id->fetch(PDO::FETCH_ASSOC);
$next_id = $row ? $row['showtime_id'] + 1 : 1;

// Obtener lista de películas existentes
$stmt_films = $conn->query("SELECT film_id, title FROM film");
$films = $stmt_films->fetchAll(PDO::FETCH_ASSOC);

// Obtener lista de salas existentes
$stmt_rooms = $conn->query("SELECT room_id FROM room");
$rooms = $stmt_rooms->fetchAll(PDO::FETCH_COLUMN);


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Procesar los datos del formulario
    $film_id = $_POST['film_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $room_id = $_POST['room_id'];

    // Realizar la inserción en la base de datos
    $stmt = $conn->prepare("INSERT INTO showtime (showtime_id, film_id, date, time, room_id) VALUES (:showtime_id, :film_id, :date, :time, :room_id)");
    $stmt->bindParam(':showtime_id', $next_id, PDO::PARAM_INT);
    $stmt->bindParam(':film_id', $film_id, PDO::PARAM_INT);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':time', $time);
    $stmt->bindParam(':room_id', $room_id, PDO::PARAM_INT);
    $stmt->execute();

    // Redireccionar a una página de éxito o a otra parte de la aplicación
    header('Location: /cinema');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Insert Showtime</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php require 'partials/header.php'; ?>
<h1>Insert a New Showtime</h1>
<form action="insert_show.php" method="post">
    <label for="film_id">Film:</label><br>
    <select id="film_id" name="film_id" required>
        <?php foreach ($films as $film): ?>
            <option value="<?php echo $film['film_id']; ?>"><?php echo $film['title']; ?></option>
        <?php endforeach; ?>
    </select><br>

    <?php echo "<br>"; ?>

    <label for="date">Date:</label><br>
    <input type="date" id="date" name="date" required><br>

    <?php echo "<br>"; ?>

    <label for="time">Time:</label><br>
    <input type="time" id="time" name="time" required><br>

    <?php echo "<br>"; ?>

    <label for="room_id">Room:</label><br>
    <select id="room_id" name="room_id" required>
    <?php foreach ($rooms as $room_id): ?>
        <option value="<?php echo $room_id; ?>"><?php echo $room_id; ?></option>
    <?php endforeach; ?>
    </select><br>


    <?php echo "<br>"; ?>

    <input type="submit" value="Submit">
</form>
</body>
</html>
