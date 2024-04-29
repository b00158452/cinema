<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /cinema');
    exit();
}

require_once 'conection.php';
require_once 'credit.php';
require_once 'payment.php';
require_once 'cash.php';
require_once 'bank_draft.php';
require_once 'booking.php';

$conn = Conection::ConectionDB();

$sql = "SELECT MAX(booking_id) AS max_booking_id FROM booking";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$max_booking_id = $result['max_booking_id'];

$next_booking_id = $max_booking_id + 1;


//Recover guest_id
//We recover user_id from session
$user_id = $_SESSION['user_id'];

//Query to know the guest_id using user_id
$stmt_guest_id = $conn->prepare("SELECT guest_id FROM guest WHERE guest_user_id = :user_id");
$stmt_guest_id->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_guest_id->execute();
$row = $stmt_guest_id->fetch(PDO::FETCH_ASSOC);
$guest_id = $row['guest_id'];

//Recover room_id
$showtime_id = $_POST['showtime_id'];

$sql = "SELECT room_id FROM showtime WHERE showtime_id = :showtime_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':showtime_id', $showtime_id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$room_id = $row['room_id'];

//Max cash_id
$sql = "SELECT MAX(cash_id) AS max_cash_id, MAX(credit_id) AS max_credit_id, MAX(bank_id) AS max_bank_id FROM payment";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$max_cash_id = $result['max_cash_id'];
$max_credit_id = $result['max_credit_id'];
$max_bank_id = $result['max_bank_id'];

$next_cash_id = $max_cash_id + 1;
$next_credit_id = $max_credit_id + 1;
$next_bank_id = $max_bank_id + 1;


$seat_id = $_POST['seat_id'];
$payment_id = $_POST['next_payment_id'];
$payment_method = $_POST['payment_method'];
$amount = 5.00;
$live_status = "live";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['payment_method'])){
        $payment_method = $_POST['payment_method'];
        switch($payment_method){
            case 'credit':
                $card_number = $_POST['card_number'];
                $card_type = $_POST['type'];
                $card_exp_date = $_POST['exp_date'];
                $card_name  = $_POST['name'];
                
                $credit_card = new Credit($card_number, $card_type, $card_exp_date, $card_name);
                $sql = "INSERT INTO credit (number, type, exp_date, name) VALUES (:number, :type, :exp_date, :name)";
                $stmt = $conn->prepare($sql);

                // Bind the query parameters with the values from the Review object
                $stmt->bindParam(':number', $credit_card->getNumber(), PDO::PARAM_INT);
                $stmt->bindParam(':type', $credit_card->getType(), PDO::PARAM_STR);
                $stmt->bindParam(':exp_date', $credit_card->getExpDate(), PDO::PARAM_STR);
                $stmt->bindParam(':name', $credit_card->getName(), PDO::PARAM_STR);
                // Execute the query
                $stmt->execute();

                $payment = new Payment($payment_id, null, $next_credit_id, null, $amount);

                $sql = "INSERT INTO payment (payment_id, cash_id, credit_id, bank_id, amount) VALUES (:payment_id, null, :credit_id, null, :amount)";
                $stmt = $conn->prepare($sql);

                // Bind the query parameters with the values from the Review object
                $stmt->bindParam(':payment_id', $payment->getPaymentId(), PDO::PARAM_INT);
                $stmt->bindParam(':credit_id', $payment->getCreditId(), PDO::PARAM_INT);
                $stmt->bindParam(':amount', $payment->getAmount(), PDO::PARAM_INT);
                // Execute the query
                $stmt->execute();
                break;

            case 'bank':
                $bank = $_POST['bank_name'];
                $name = $_POST['account_name'];

                $bank_draft = new BankDraft($bank, $name);

                $sql = "INSERT INTO bank_draft (name, bank) VALUES (:name, :bank)";
                $stmt = $conn->prepare($sql);

                // Bind the query parameters with the values from the Review object
                $stmt->bindParam(':name', $bank_draft->getName(), PDO::PARAM_STR);
                $stmt->bindParam(':bank', $bank_draft->getBank(), PDO::PARAM_STR);
                // Execute the query
                $stmt->execute();

                $payment = new Payment($payment_id, null, null, $next_bank_id, $amount);

                $sql = "INSERT INTO payment (payment_id, cash_id, credit_id, bank_id, amount) VALUES (:payment_id, null, null, :bank_id, :amount)";
                $stmt = $conn->prepare($sql);

                // Bind the query parameters with the values from the Review object
                $stmt->bindParam(':payment_id', $payment->getPaymentId(), PDO::PARAM_INT);
                $stmt->bindParam(':bank_id', $payment->getBankId(), PDO::PARAM_INT);
                $stmt->bindParam(':amount', $payment->getAmount(), PDO::PARAM_INT);
                // Execute the query
                $stmt->execute();
                break;

            case 'cash':
                $cash_tendered = $_POST['cash_tendered'];

                $cash = new Cash($cash_tendered);

                $sql = "INSERT INTO cash (cash_tendered) VALUES (:cash_tendered)";
                $stmt = $conn->prepare($sql);

                // Bind the query parameters with the values from the Review object
                $stmt->bindParam(':cash_tendered', $cash->getCashTendered(), PDO::PARAM_STR);
                // Execute the query
                $stmt->execute();

                $payment = new Payment($payment_id, $next_cash_id, null, null, $amount);

                $sql = "INSERT INTO payment (payment_id, cash_id, credit_id, bank_id, amount) VALUES (:payment_id, :cash_id, null, null, :amount)";
                $stmt = $conn->prepare($sql);

                // Bind the query parameters with the values from the Review object
                $stmt->bindParam(':payment_id', $payment->getPaymentId(), PDO::PARAM_INT);
                $stmt->bindParam(':cash_id', $payment->getCashId(), PDO::PARAM_INT);
                $stmt->bindParam(':amount', $payment->getAmount(), PDO::PARAM_INT);
                // Execute the query
                $stmt->execute();
                break;
            }

            $booking = new Booking();
            $booking->setBookingId($next_booking_id);
            $booking->setGuestId($guest_id);
            $booking->setRoomId($room_id);
            $booking->setShowtimeId($showtime_id);
            $booking->setPaymentId($payment_id);
            $booking->setSeatId($seat_id);

            $sql = "INSERT INTO booking (booking_id, guest_id, room_id, showtime_id, payment_id, seat_id, status) VALUES (:booking_id, :guest_id, :room_id, :showtime_id, :payment_id, :seat_id, :status)";
            $stmt = $conn->prepare($sql);

            // Bind the query parameters with the values from the Review object
            $stmt->bindParam(':booking_id', $booking->getBookingId(), PDO::PARAM_INT);
            $stmt->bindParam(':guest_id', $booking->getGuestId(), PDO::PARAM_INT);
            $stmt->bindParam(':room_id', $booking->getRoomId(), PDO::PARAM_INT);
            $stmt->bindParam(':showtime_id', $booking->getShowtimeId(), PDO::PARAM_INT);
            $stmt->bindParam(':payment_id', $booking->getPaymentId(), PDO::PARAM_INT);
            $stmt->bindParam(':seat_id', $booking->getSeatId(), PDO::PARAM_INT);
            $stmt->bindParam(':status', $live_status, PDO::PARAM_STR);
            // Execute the query
            $stmt->execute();
            header('Location: /cinema');
            exit();

    }
}
?>
