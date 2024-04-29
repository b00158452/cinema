<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /cinema');
    exit();
}

require_once 'conection.php'; 
require_once 'showtime.php';

$conn = Conection::ConectionDB();

$showtime_id = $_POST['showtime_id'];

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

$selected_seats = array();

$sql = "SELECT seat_id FROM booking WHERE showtime_id = :showtime_id AND room_id = :room_id";
$stmt = $conn->prepare($sql);
$showtime_id = $showtime->getShowtimeId();
$room_id = $showtime->getRoomId();
$stmt->bindParam(':showtime_id', $showtime_id, PDO::PARAM_INT);
$stmt->bindParam(':room_id', $room_id, PDO::PARAM_INT);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $selected_seats[] = $row['seat_id'];
}

$seats = array();

$sql = "SELECT * FROM seat WHERE room_id = :room_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':room_id', $room_id, PDO::PARAM_INT);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $seats[] = $row['seat_id'];
}

$reserved_seats = array_intersect($selected_seats, $seats);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Seats</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php require 'partials/header.php'; ?>
<h1>Map of Seats</h1>

<div class="seat-map" style="display: flex; flex-wrap: wrap; max-width: 2000px; justify-content: center;">
    <?php foreach ($seats as $seat): ?>
        <?php
            $seatId = $seat;
            $isReserved = in_array($seatId, $reserved_seats);
            $class = $isReserved ? 'reserved' : 'available';

            // Obtener información del asiento de la base de datos
            $sql_seat_info = "SELECT seatRow, seatColumn FROM seat WHERE seat_id = :seat_id";
            $stmt_seat_info = $conn->prepare($sql_seat_info);
            $stmt_seat_info->bindParam(':seat_id', $seatId, PDO::PARAM_INT);
            $stmt_seat_info->execute();
            $seat_info = $stmt_seat_info->fetch(PDO::FETCH_ASSOC);
            $seatRow = $seat_info['seatRow'];
            $seatColumn = $seat_info['seatColumn'];
        ?>
        <?php if ($class === 'available'): ?>
            <form action="summary.php" method="post">
                <input type="hidden" name="showtime_id" value="<?php echo $showtime->getShowtimeId(); ?>">
                <input type="hidden" name="seat_id" value="<?php echo $seatId; ?>">
                <button type="submit" class="seat <?php echo $class; ?>">
                    <?php echo $seatRow . $seatColumn; ?> <!-- Mostrar seatRow concatenado con seatColumn -->
                </button>
            </form>
        <?php else: ?>
            <div class="seat <?php echo $class; ?>">
                <?php echo $seatRow . $seatColumn; ?> <!-- Mostrar seatRow concatenado con seatColumn -->
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>


<style>
    .seat {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: inline-block;
        margin: 5px;
        cursor: pointer;
        position: relative; /* Para posicionar correctamente los números */
        text-align: center; /* Alineación del texto */
        line-height: 50px; /* Altura de línea igual a la altura del asiento */
    }

    .reserved {
        background-color: red;
    }

    .available {
        background-color: green;
    }

    .seat a {
        color: black; /* Cambia el color del texto a negro */
        text-decoration: none; /* Elimina el subrayado */
        display: block; /* Hace que el enlace se comporte como un bloque */
        width: 100%; /* Ajusta el ancho al 100% del contenedor */
        height: 100%; /* Ajusta la altura al 100% del contenedor */
    }
</style>



</body>
</html>
