<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /cinema');
    exit();
}

require_once 'conection.php';
require_once 'review.php';

$conn = Conection::ConectionDB();

$film_id = $_POST['film_id'];

$sql = "SELECT * FROM review WHERE film_id = :film_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':film_id', $film_id, PDO::PARAM_INT);
$stmt->execute();

$reviews = array(); 


while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $review = new Review();
    $review->setReviewId($row['review_id']);
    $review->setGuestId($row['guest_id']);
    $review->setFilmId($row['film_id']);
    $review->setRating($row['rating']);
    $review->setComment($row['comment']);

    $reviews[] = $review; 
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reviews List</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php require 'partials/header.php'; ?>
    <h1>List of Reviews</h1>   
    
    <?php foreach ($reviews as $review): ?>
    <div class="review">
        <p><strong>Rating:</strong> <?php echo $review->getRating(); ?></p>
        <p><strong>Comment:</strong> <?php echo $review->getComment(); ?></p>
        <br>
    </div>
<?php endforeach; ?>

</body>
</html>