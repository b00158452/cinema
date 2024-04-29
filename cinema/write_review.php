<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /cinema');
    exit();
}

require_once 'conection.php'; 
require_once 'review.php';

$conn = Conection::ConectionDB();

// We recover film_id from Post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Query to know the next review id
    $stmt_next_id = $conn->prepare("SELECT review_id FROM review ORDER BY review_id DESC LIMIT 1");
    $stmt_next_id->execute();
    $row = $stmt_next_id->fetch(PDO::FETCH_ASSOC);
    $next_id = $row ? $row['review_id'] + 1 : 1;

    //We recover user_id from session
    $user_id = $_SESSION['user_id'];

    //Query to know the guest_id using user_id
    $stmt_guest_id = $conn->prepare("SELECT guest_id FROM guest WHERE guest_user_id = :user_id");
    $stmt_guest_id->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt_guest_id->execute();
    $row = $stmt_guest_id->fetch(PDO::FETCH_ASSOC);
    $guest_id = $row['guest_id'];

    $film_id = $_POST['film_id'];

    // Verify if rating and comment are present
    if (isset($_POST['rating'], $_POST['comment'])) {
        $rating = $_POST['rating'];
        $comment = $_POST['comment'];

        // Create a new Review object
        $review = new Review();
        $review->setReviewId($next_id);
        $review->setGuestId($guest_id);
        $review->setFilmId($film_id);
        $review->setRating($rating);
        $review->setComment($comment);

        // Prepare the SQL query to insert the new review into the database
        $sql = "INSERT INTO review (review_id, guest_id, film_id, rating, comment) VALUES (:review_id, :guest_id, :film_id, :rating, :comment)";
        $stmt = $conn->prepare($sql);

        // Bind the query parameters with the values from the Review object
        $stmt->bindParam(':review_id', $review->getReviewId(), PDO::PARAM_INT);
        $stmt->bindParam(':guest_id', $review->getGuestId(), PDO::PARAM_INT);
        $stmt->bindParam(':film_id', $review->getFilmId(), PDO::PARAM_INT);
        $stmt->bindParam(':rating', $review->getRating(), PDO::PARAM_STR);
        $stmt->bindParam(':comment', $review->getComment(), PDO::PARAM_STR);

        // Execute the query
        $stmt->execute();

        header('Location: /cinema');
        exit();

    } else {
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write Review</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php require 'partials/header.php'; ?>

<h1>Write Review</h1>

<form action="write_review.php" method="post">
    <label for="rating">Rating:</label>
    <input type="number" step="0.1" min="0" max="10" id="rating" name="rating" required><br>

    <label for="comment">Comment:</label><br>
    <textarea id="comment" name="comment" rows="4" cols="50" required></textarea><br>

    <input type="hidden" name="film_id" value="<?php echo $film_id; ?>">

    <input type="submit" value="Submit">
</form>

</body>
</html>

