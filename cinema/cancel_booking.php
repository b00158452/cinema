<?php
session_start();

// Redirect to the cinema page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: /cinema');
    exit();
}

require_once 'conection.php'; // Including the file that establishes a database connection

$conn = Conection::ConectionDB(); // Establishing a database connection

$booking_id = $_POST['booking_id']; // Getting the booking ID from the POST data
$user_id = $_SESSION['user_id']; // Getting the user ID from the session

// Query to retrieve the guest_id using user_id
$stmt_guest_id = $conn->prepare("SELECT guest_id FROM guest WHERE guest_user_id = :user_id");
$stmt_guest_id->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_guest_id->execute();
$row = $stmt_guest_id->fetch(PDO::FETCH_ASSOC);
$guest_id = $row['guest_id'];

// Query to get the next available cancellation ID
$stmt_next_id = $conn->prepare("SELECT cancellation_id FROM cancellation ORDER BY cancellation_id DESC LIMIT 1");
$stmt_next_id->execute();
$row = $stmt_next_id->fetch(PDO::FETCH_ASSOC);
$next_id = $row ? $row['cancellation_id'] + 1 : 1;

// Query to get the latest employee ID
$stmt_id = $conn->prepare("SELECT employee_id FROM employee ORDER BY employee_id DESC LIMIT 1");
$stmt_id->execute();
$row = $stmt_id->fetch(PDO::FETCH_ASSOC);
$employee_id = $row ? $row['employee_id'] : 1;

// Process cancellation form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['reason'])) {
        $reason = $_POST['reason']; // Get the reason for cancellation from the form
        // Insert cancellation record into the database
        $stmt_cancel_booking = $conn->prepare("INSERT INTO cancellation (cancellation_id, booking_id, employee_id, reason) 
                                              VALUES (:cancellation_id, :booking_id, :employee_id, :reason)");
        $stmt_cancel_booking->bindParam(':cancellation_id', $next_id, PDO::PARAM_INT);
        $stmt_cancel_booking->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        $stmt_cancel_booking->bindParam(':employee_id', $employee_id, PDO::PARAM_INT);
        $stmt_cancel_booking->bindParam(':reason', $reason, PDO::PARAM_STR);
        $stmt_cancel_booking->execute();

        // Update booking status to 'revision'
        $stmt_update_booking = $conn->prepare("UPDATE booking SET status = 'revision' WHERE booking_id = :booking_id");
        $stmt_update_booking->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        $stmt_update_booking->execute();

        // Redirect to the cinema page after cancellation
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
    <title>Cancel Booking</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php require 'partials/header.php'; ?>
<h1>Cancel Booking</h1>

<!-- Form for cancelling booking -->
<form action="cancel_booking.php" method="post">
    <label for="reason">Reason:</label><br>
    <textarea id="reason" name="reason" rows="4" cols="50" required></textarea><br>
    <!-- Hidden input field to store the booking ID -->
    <?php echo '<input type="hidden" name="booking_id" value="' . $booking_id . '">'; ?>
    <?php echo "<br>"; ?>
    <input type="submit" value="Cancel Booking">
</form>

</body>
</html>
