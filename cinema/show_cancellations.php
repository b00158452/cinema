<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /cinema');
    exit();
}

require_once 'conection.php'; 
require_once 'cancellation.php';
require_once 'booking.php';

$conn = Conection::ConectionDB();
$status_revision = "revision"; 
$cancel_confirmation = 0;

// Consulta para obtener las reservas con estado "revision"
$sql = "SELECT * FROM booking WHERE status = :status";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':status', $status_revision, PDO::PARAM_STR);
$stmt->execute();

$bookings_id = array(); 

// Almacenar los booking_id de las reservas con estado "revision"
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $bookings_id[] = $row['booking_id']; 
}

// Obtener las cancelaciones de la tabla cancellation
$sql_cancellations = "SELECT * FROM cancellation";
$stmt_cancellations = $conn->prepare($sql_cancellations);
$stmt_cancellations->execute();

$cancellations = array();

while ($row = $stmt_cancellations->fetch(PDO::FETCH_ASSOC)) {
    $cancellation = new Cancellation();
    $cancellation->setCancellationId($row['cancellation_id']);
    $cancellation->setBookingId($row['booking_id']);
    $cancellation->setEmployeeId($row['employee_id']);
    $cancellation->setReason($row['reason']);

    $cancellations[] = $cancellation; 
}

if($_SERVER["REQUEST_METHOD"] === "POST"){
    if(isset($_POST['cancel_confirmation']) && $_POST['cancel_confirmation'] === "1"){
        $booking_id = $_POST['booking_id'];

        // Consulta para borrar la reserva de la tabla booking
        $sql_delete_booking = "DELETE FROM booking WHERE booking_id = :booking_id";
        $stmt_delete_booking = $conn->prepare($sql_delete_booking);
        $stmt_delete_booking->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        $stmt_delete_booking->execute();

        header('Location: /cinema');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Cancellations</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php require 'partials/header.php'; ?>
<h1>List of Cancellations</h1>
<?php
foreach($cancellations as $cancellation){
    $booking_id = $cancellation->getBookingId();
    $reason = $cancellation->getReason();
    $cancellation_id = $cancellation->getCancellationId();

    // Obtener información adicional de la reserva (por ejemplo, el correo electrónico del invitado)
    $stmt_guest_info = $conn->prepare("SELECT * FROM guest WHERE guest_id IN (SELECT guest_id FROM booking WHERE booking_id = :booking_id)");
    $stmt_guest_info->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
    $stmt_guest_info->execute();
    $guest_info = $stmt_guest_info->fetch(PDO::FETCH_ASSOC);
    $guest_mail = $guest_info['mail'];

    // Mostrar información de la cancelación
    echo '<div>';
    echo '<p>Booking Mail: ' . $guest_mail . '</p>';
    echo '<p>Booking ID: ' . $booking_id . '</p>';
    echo '<p>Reason: ' . $reason . '</p>'; 
    echo "<br>";
    echo '</div>';

    // Formulario para confirmar la cancelación
    echo '<form action="show_cancellations.php" method="post">';
    echo '<input type="hidden" name="cancellation_id" value="' . $cancellation_id . '">';
    echo '<input type="hidden" name="booking_id" value="' . $booking_id . '">';
    echo '<input type="hidden" name="cancel_confirmation" value="1">';
    echo '<input type="submit" value="Cancel Booking">';
    echo '</form>';

    echo "---------------------------------------------------------------";
    echo "<br>";
}

?>
</body>
</html>
