<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /cinema');
    exit();
}

require_once 'conection.php';
require_once 'booking.php';

$conn = Conection::ConectionDB();

$user_id = $_SESSION['user_id'];
//Query to know the guest_id using user_id
$stmt_guest_id = $conn->prepare("SELECT guest_id FROM guest WHERE guest_user_id = :user_id");
$stmt_guest_id->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_guest_id->execute();
$row = $stmt_guest_id->fetch(PDO::FETCH_ASSOC);
$guest_id = $row['guest_id'];

// Prepared statement
$sql = "SELECT * FROM booking WHERE guest_id = :guest_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':guest_id', $guest_id, PDO::PARAM_INT);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$bookings = array();

foreach ($results as $row) {
    $booking = new Booking();

    $booking->setBookingId($row['booking_id']);
    $booking->setGuestId($row['guest_id']);
    $booking->setRoomId($row['room_id']);
    $booking->setShowtimeId($row['showtime_id']);
    $booking->setSeatId($row['seat_id']);
    $booking->setPaymentId($row['payment_id']);

    $bookings[] = $booking;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php require 'partials/header.php'; ?>

<h1>Your Bookings</h1>

<?php
// Iterate over each booking in the $bookings array
foreach ($bookings as $booking) {
    // Get the guest_id, showtime_id, and seat_id of the current booking
    $guest_id = $booking->getGuestId();
    $showtime_id = $booking->getShowtimeId();
    $seat_id = $booking->getSeatId();

    // Perform additional queries using the obtained values
    // For example:
    // Query to get guest information
    $stmt_guest_info = $conn->prepare("SELECT * FROM guest WHERE guest_id = :guest_id");
    $stmt_guest_info->bindParam(':guest_id', $guest_id, PDO::PARAM_INT);
    $stmt_guest_info->execute();
    $guest_info = $stmt_guest_info->fetch(PDO::FETCH_ASSOC);

    // Query to get showtime information
    $stmt_showtime_info = $conn->prepare("SELECT * FROM showtime WHERE showtime_id = :showtime_id");
    $stmt_showtime_info->bindParam(':showtime_id', $showtime_id, PDO::PARAM_INT);
    $stmt_showtime_info->execute();
    $showtime_info = $stmt_showtime_info->fetch(PDO::FETCH_ASSOC);

    $film_id = $showtime_info['film_id'];
    $stmt_film_info = $conn->prepare("SELECT * FROM film WHERE film_id = :film_id");
    $stmt_film_info->bindParam(':film_id', $film_id, PDO::PARAM_INT);
    $stmt_film_info->execute();
    $film_info = $stmt_film_info->fetch(PDO::FETCH_ASSOC);

    // Query to get seat information
    $stmt_seat_info = $conn->prepare("SELECT * FROM seat WHERE seat_id = :seat_id");
    $stmt_seat_info->bindParam(':seat_id', $seat_id, PDO::PARAM_INT);
    $stmt_seat_info->execute();
    $seat_info = $stmt_seat_info->fetch(PDO::FETCH_ASSOC);

    // Use the obtained information to display or perform other operations
    // For example, display guest, showtime, and seat information
    echo '<div>';
    echo '<p>Booking Mail: ' . $guest_info['mail'] . '</p>';
    echo '<p>Film: ' . $film_info['title'] . '</p>';
    echo '<p>Date: ' . $showtime_info['date'] . '</p>';
    echo '<p>Time: ' . $showtime_info['time'] . '</p>';
    echo '<p>Room Nº: ' . $showtime_info['room_id'] . '</p>';
    echo '<p>Seat Row: ' . $seat_info['seatRow'] . ', Seat Column: ' . $seat_info['seatColumn'] . '</p>';
    echo "<br>";
    echo '</div>';

    $booking_id = $booking->getBookingId();

    // Form to cancel the booking
    echo '<form action="cancel_booking.php" method="post">';
    echo '<input type="hidden" name="booking_id" value="' . $booking_id . '">';
    echo '<input type="submit" value="Cancel Booking">';
    echo '</form>';

    echo "---------------------------------------------------------------";
    echo "<br>";
}
?>
</body>
</html>

