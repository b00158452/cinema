<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /cinema');
    exit();
}

require_once 'conection.php';
require_once 'showtime.php';


$conn = Conection::ConectionDB();

$sql = "SELECT MAX(payment_id) AS max_payment_id FROM payment";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$max_payment_id = $result['max_payment_id'];

$next_payment_id = $max_payment_id + 1;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summary</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php require 'partials/header.php'; ?>

<h1>Select Payment Method</h1>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['payment_method'])){
        $payment_method = $_POST['payment_method'];
        $showtime_id = $_POST['showtime_id'];
        $seat_id = $_POST['seat_id'];

        switch($payment_method){
            case 'credit':
                echo '<form method="post" action="payment_processing.php">';
                echo '<input type="hidden" name="showtime_id" value="' . htmlspecialchars($showtime_id) . '">';
                echo '<input type="hidden" name="seat_id" value="' . htmlspecialchars($seat_id) . '">';
                echo '<input type="hidden" name="payment_method" value="' . htmlspecialchars($payment_method) . '">';
                echo '<input type="hidden" name="next_payment_id" value="' . htmlspecialchars($next_payment_id) . '">';
                echo 'Card Number';
                echo '<br>';
                echo '<input type="text" name="card_number" required><br>';
                echo '<br>';
                echo 'Card Type';
                echo '<br>';
                echo '<input type="text" name="type" required><br>';
                echo '<br>';
                echo 'Expiration Date';
                echo '<br>';
                echo '<input type="date" name="exp_date" required><br>';
                echo '<br>';
                echo 'Cardholder Name';
                echo '<br>';
                echo '<input type="text" name="name" required><br>';
                echo '<br>';
                echo '<input type="submit" value="Submit Payment">';
                echo '</form>';
                break;


            case 'bank':
                echo '<form method="post" action="payment_processing.php">';
                echo '<input type="hidden" name="showtime_id" value="' . htmlspecialchars($showtime_id) . '">';
                echo '<input type="hidden" name="seat_id" value="' . htmlspecialchars($seat_id) . '">';
                echo '<input type="hidden" name="payment_method" value="' . htmlspecialchars($payment_method) . '">';
                echo '<input type="hidden" name="next_payment_id" value="' . htmlspecialchars($next_payment_id) . '">';
                echo 'Bank Name';
                echo '<br>';
                echo '<input type="text" name="bank_name" required><br>';
                echo '<br>';
                echo 'Account Name';
                echo '<br>';
                echo '<input type="text" name="account_name" required><br>';
                echo '<br>';
                echo '<input type="submit" value="Submit Payment">';
                echo '</form>';
                break;

            case 'cash':
                $cash_tendered = "I must pay the amount of 5.00 Euros at the cashier to enter the TU Dublin Cinema";
                echo '<form method="post" action="payment_processing.php">';
                echo '<input type="hidden" name="showtime_id" value="' . htmlspecialchars($showtime_id) . '">';
                echo '<input type="hidden" name="seat_id" value="' . htmlspecialchars($seat_id) . '">';
                echo '<input type="hidden" name="payment_method" value="' . htmlspecialchars($payment_method) . '">';
                echo '<input type="hidden" name="next_payment_id" value="' . htmlspecialchars($next_payment_id) . '">';
                echo '<input type="hidden" name="cash_tendered" value="' . htmlspecialchars($cash_tendered) . '">';
                echo 'Cash Tendered';
                echo '<br>';
                echo '<br>';
                echo $cash_tendered;
                echo '<br>';
                echo '<br>';
                echo '<input type="submit" value="Submit Payment">';
                echo '</form>';
                break;
        }

    }
}


?>




<form method="post">
    <button type="submit" name="payment_method" value="credit">Credit Card</button>
    <button type="submit" name="payment_method" value="cash">Cash</button>
    <button type="submit" name="payment_method" value="bank">Bank Draft</button>
    <input type="hidden" name="showtime_id" value="<?php echo $_POST['showtime_id']; ?>">
    <input type="hidden" name="seat_id" value="<?php echo $_POST['seat_id']; ?>">
</form>

</body>
</html>