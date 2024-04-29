<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /cinema');
    exit();
}

require_once 'conection.php';
require_once 'showtime.php';

$conn = Conection::ConectionDB();

//Prepared Statement
$sql = "SELECT * FROM showtime WHERE film_id = :film_id";

$stmt = $conn->prepare($sql);

$film_id = $_POST['film_id'];
$stmt->bindParam(":film_id", $film_id, PDO::PARAM_INT);

$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$showtimes = array();

foreach($results as $row){
    $showtime = new Showtime();
    $showtime->setShowtimeId($row['showtime_id']);
    $showtime->setFilmId($row['film_id']);
    $showtime->setDate($row['date']);
    $showtime->setTime($row['time']);
    $showtime->setRoomId($row['room_id']);

    $showtimes[] = $showtime;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Show</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <ul>
        <li><a href="payment_method.php">payment method</a></li>

    </ul>
</head>
<body>

<?php require 'partials/header.php'; ?>

<h1>Select Show</h1>

<div>
    <?php
    // Mostrar los detalles de cada Showtime en el array $showtimes
    foreach ($showtimes as $showtime) {
        echo "<span class='showtime-details'>";
        echo "Date: " . $showtime->getDate(). "   ";
        echo "Time: " . $showtime->getTime(). "   ";
        echo "Room Nº: " . $showtime->getRoomId();
        echo "</span>";

        // Formulario dentro del bucle para cada showtime
        echo "<form action='select_seats.php' method='post'>";
        echo "<input type='hidden' name='showtime_id' value='" . $showtime->getShowtimeId() . "'>";
        echo "<input type='submit' value='Select Seats'>";
        echo "</form>";
    }
    ?>
</div>

</body>
</html>

