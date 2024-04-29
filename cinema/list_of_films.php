<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /cinema');
    exit();
}

require_once 'conection.php';
require_once 'film.php';

$conn = Conection::ConectionDB();

$user_id = $_SESSION['user_id'];
$sql = "SELECT role_user FROM user WHERE user_id = $user_id";
$stmt = $conn->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$user_role = $row['role_user'];

$sql = "SELECT * FROM film";
$stmt = $conn->query($sql);
$films = array();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $film = new Film();
    $film->set_film_id($row['film_id']);
    $film->set_title($row['title']);
    $film->set_duration($row['duration']);
    $film->set_genre($row['genre']);
    $film->set_rating($row['rating']);
    $film->set_description($row['description']);

    $films[] = $film;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Films List</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php require 'partials/header.php'; ?>

<h1>Films</h1>

<?php foreach ($films as $film): ?>
    <div class="film">
        <?php $film->displayFilm(); ?>
        <!-- Form 1: Select Show -->
        <?php if ($user_role == 3): ?>
            <form action="select_show.php" method="post">
                <input type="hidden" name="film_id" value="<?php echo $film->get_film_id(); ?>">
                <input type="submit" value="Select Show">
            </form>
        <?php endif; ?>

        <!-- Form 2: Write Review -->
        <?php if ($user_role == 3): ?>
            <form action="write_review.php" method="post">
                <input type="hidden" name="film_id" value="<?php echo $film->get_film_id(); ?>">
                <input type="submit" value="Write Review">
            </form>
        <?php endif; ?>

        <!-- Form 3: View Reviews -->
        <form action="view_reviews.php" method="post">
            <input type="hidden" name="film_id" value="<?php echo $film->get_film_id(); ?>">
            <input type="submit" value="View Reviews">
        </form>
    </div>
<?php endforeach; ?>

</body>
</html>



