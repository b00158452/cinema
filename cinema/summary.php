<?php
//Me he traido showtime_id y seat_id

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /cinema');
    exit();
}

require_once 'conection.php';
require_once 'showtime.php';

$showtime_id = $_POST['showtime_id'];
$conn = Conection::ConectionDB();

$sql = "SELECT * FROM showtime WHERE showtime_id = :showtime_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':showtime_id', $showtime_id, PDO::PARAM_INT);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);

$showtime = new Showtime();
$showtime->setShowtimeId($row['showtime_id']);
$showtime->setFilmId($row['film_id']);
$showtime->setDate($row['date']);
$showtime->setTime($row['time']);
$showtime->setRoomId($row['room_id']);

$film_id = $showtime->getFilmId();
$sql = "SELECT title FROM film WHERE film_id = :film_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':film_id', $film_id, PDO::PARAM_INT);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);

$film_title = $row['title'];
$showtime_date = $showtime->getDate();
$showtime_time = $showtime->getTime();
$showtime_room = $showtime->getRoomId();

$seat_id = $_POST['seat_id'];
$sql = "SELECT seatRow, seatColumn FROM seat WHERE seat_id = :seat_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':seat_id', $seat_id, PDO::PARAM_INT);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);

$seat_row = $row['seatRow'];
$seat_column = $row['seatColumn'];
$amount = "5.00 Euros";
?>


<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summary</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
</head>
<body>
<?php require 'partials/header.php'; ?>
<h1>Summary of the Booking</h1>

<div>
    <?php
    echo "Name of the film: " . $film_title;
    echo "<br>";
    echo "<br>";
    echo "Date: " . $showtime_date;
    echo "<br>";
    echo "<br>";
    echo "Time: " . $showtime_time;
    echo "<br>";
    echo "<br>";
    echo "Room Nº: " . $showtime_room;
    echo "<br>";
    echo "<br>";
    echo "Seat: " . $seat_row;
    echo $seat_column;
    echo "<br>";
    echo "<br>";
    echo "Amount: " . $amount;
    echo "<br>";
    echo "<br>";
    ?>
</div>

<form action="payment_method.php" method="post"> 
            <input type="hidden" name="showtime_id" value="<?php echo $showtime->getShowtimeId(); ?>">
            <input type="hidden" name="seat_id" value="<?php echo $seat_id; ?>">
            <input type="submit" value="Go to Payment">
</form>
    
</body>
</html>