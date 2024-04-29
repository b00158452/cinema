<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /cinema');
    exit();
}

require_once 'conection.php';
require_once 'showtime.php';


$conn = Conection::ConectionDB();

// Retrieve the maximum payment ID
$sql = "SELECT MAX(payment_id) AS max_payment_id FROM payment";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$max_payment_id = $result['max_payment_id'];

// Increment the maximum payment ID to generate a new payment ID
$next_payment_id = $max_payment_id + 1;
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Payment Method</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php require 'partials/header.php'; ?>

<h1>Select Payment Method</h1>

<?php
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['payment_method'])) {
    // Validate and sanitize user input
    $payment_method = $_POST['payment_method'];
    $showtime_id = $_POST['showtime_id'];
    $seat_id = $_POST['seat_id'];

    // Based on the selected payment method, display the appropriate form fields
    switch ($payment_method) {
        case 'credit':
            // Display credit card payment form
            include 'partials/credit_payment_form.php';
            break;

        case 'bank':
            // Display bank draft payment form
            include 'partials/bank_draft_payment_form.php';
            break;

        case 'cash':
            // Display cash payment details
            include 'partials/cash_payment_details.php';
            break;

        default:
            echo "Invalid payment method selected.";
    }
}
?>

<!-- Form to select payment method -->
<form method="post">
    <button type="submit" name="payment_method" value="credit">Credit Card</button>
    <button type="submit" name="payment_method" value="cash">Cash</button>
    <button type="submit" name="payment_method" value="bank">Bank Draft</button>
    <input type="hidden" name="showtime_id" value="<?php echo htmlspecialchars($_POST['showtime_id']); ?>">
    <input type="hidden" name="seat_id" value="<?php echo htmlspecialchars($_POST['seat_id']); ?>">
</form>

</body>
</html>
z