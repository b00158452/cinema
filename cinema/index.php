<?php
session_start();

require 'conection.php';
$conn = Conection::ConectionDB();

// Verificar si el usuario está autenticado
if (isset($_SESSION['user_id'])) {
    // Obtener el tipo de usuario desde la sesión
    $user_id = $_SESSION['user_id'];

    // Consultar el tipo de usuario en la base de datos
    $sql = "SELECT * FROM user WHERE user_id = $user_id";
    $result = $conn->query($sql);

    if ($result !== false) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $user_type = $row['role_user'];

        //Guardar el rol en la sesion
        $_SESSION['role_user'] = $user_type;

        // Mostrar contenido según el tipo de usuario
        switch ($user_type) {
            case 1:
                $welcome_message = "Welcome Admin";
                // Mostrar enlaces para el usuario administrador
                $admin_links = true;
                break;
            case 2:
                $welcome_message = "Welcome Employee";
                //Mostrar enlaces para el usuario empleado
                $employee_links = true;
                break;
            case 3:
                $welcome_message = "Welcome Guest";
                //Mostrar enlaces para el usuario guest
                $guest_links = true;
                break;
            default:
                $welcome_message = "Unknown User";
        }
    } else {
        // No se pudo encontrar el usuario en la base de datos
        $welcome_message = "Unknown User";
    }
} else {
    // Si el usuario no está autenticado, mostrar mensaje para iniciar sesión
    $welcome_message = "Please Login or Sign Up";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TU Dublin Cinema</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <script>
        function checkLogin() {
            // Check if the user is logged in
            if (!isLoggedIn()) {
                // If not logged in, prompt the user to create an account or log in
                alert("You need to create an account or log in before you can book a ticket.");
                // Redirect the user to the login page
                window.location.href = "login.php";
            } else {
                // If logged in, allow the user to book a ticket
                alert("Redirecting to ticket booking page...");
                // You can redirect the user to the ticket booking page here
            }
        }

        // Function to check if the user is logged in (Replace this with your actual login check logic)
        function isLoggedIn() {
            return false; // Replace false with your actual login check
        }
    </script>
</head>
<body>
<header>
    <h1>Welcome to TU Dublin Cinema</h1>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="contactus.php">Contact Us</a></li>
            <li><a href="about.php">About Us</a></li>
        </ul>
    </nav>
    <?php require 'partials/header.php' ?>

    <h1><?= $welcome_message ?></h1>

    <?php if (isset($_SESSION['user_id'])) : ?>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a> or
        <a href="signup.php">SignUp</a>
    <?php endif; ?>

    <?php if (isset($admin_links) && $admin_links) : ?>
        <div class="admin-links">
            <h2>Admin Links</h2>

            <a href="list_of_films.php">List of films</a><br><br>
            <a href="insert_film.php">Insert a film</a><br><br>
            <a href="insert_show.php">Insert show for film</a><br><br>
            <a href="cancel_showtime.php">Cancel show for film</a>

        </div>
    <?php endif; ?>

    <?php if(isset($guest_links) && $guest_links) : ?>
        <div class="guest-links">
            <h2>Guest Links</h2>
            <a href="list_of_films.php">List of films</a><br><br>
            <a href="your_bookings.php">Your Bookings</a><br><br>
        </div>
    <?php endif; ?>

    <?php if(isset($employee_links) && $employee_links) : ?>
        <div class="employee-links">
            <h2>Employee Links</h2>
            <a href="list_of_films.php">List of films</a><br><br>
            <a href="show_cancellations.php">Show Cancellations</a><br><br>
        </div>
    <?php endif; ?>

</header>


<main>
    <section id="movies" class="section">
        <h2>Latest Movies</h2>
        <!-- Movie posters and information -->
        <div class="movie-grid">
            <div class="movie">
                <img src="images/movie1.jpeg" alt="Movie 1">
                <h3>The Shawshank Redemption</h3>
                <p>Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.</p>
                <button onclick="checkLogin()">Book a Ticket</button>
            </div>
            <div class="movie">
                <img src="images/movie2.jpeg" alt="Movie 2">
                <h3>The Godfather</h3>
                <p>The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son.</p>
                <button onclick="checkLogin()">Book a Ticket</button>
            </div>
            <div class="movie">
                <img src="images/movie3.jpeg" alt="Movie 3">
                <h3>Forrest Gump</h3>
                <p>The presidencies of Kennedy and Johnson, the events of Vietnam, Watergate and other historical events unfold from the perspective of an Alabama man with an IQ of 75, whose only desire is to be reunited with his childhood sweetheart.</p>
                <button onclick="checkLogin()">Book a Ticket</button>
            </div>
            <div class="movie">
                <img src="images/movie4.jpeg" alt="Movie 4">
                <h3>The Dark Knight</h3>
                <p>When the menace known as The Joker emerges from his mysterious past, he wreaks havoc and chaos on the people of Gotham. The Dark Knight must accept one of the greatest psychological and physical tests of his ability to fight injustice.</p>
                <button onclick="checkLogin()">Book a Ticket</button>
            </div>
        </div>
    </section>

    <section id="events" class="section">
        <h2>Special Movies</h2>
        <!-- Movie images and information -->
        <div class="event-grid">
            <div class="event">
                <img src="images/movie1.gif" alt="Movie 1">
                <h3>Sci-Fi Thriller</h3>
                <p>Experience the excitement with our thrilling sci-fi movie featuring cutting-edge special effects.</p>
                <a href="#">Learn More</a>
            </div>
            <div class="event">
                <img src="images/movie2.gif" alt="Movie 2">
                <h3>Romantic Drama</h3>
                <p>Get ready to be swept away by the romance in our heartwarming drama film.</p>
                <a href="#">Learn More</a>
            </div>
            <div class="event">
                <img src="images/movie3.gif" alt="Movie 3">
                <h3>Action Adventure</h3>
                <p>Join the adventure with our action-packed movie filled with thrilling stunts and epic battles.</p>
                <a href="#">Learn More</a>
            </div>
            <div class="event">
                <img src="images/movie4.gif" alt="Movie 4">
                <h3>Animated Family Film</h3>
                <p>Bring the whole family for a fun-filled movie experience with our charming animated film.</p>
                <a href="#">Learn More</a>
            </div>
        </div>
    </section>


</main>

<footer>
    <p>&copy; 2024 TU Dublin Cinema. All rights reserved.</p>
</footer>
</body>


</html>
