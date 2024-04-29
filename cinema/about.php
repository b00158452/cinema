<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>About Us - TU DUBLIN CINEMA</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/about.css"> <!-- Including the CSS file for styling -->

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li> <!-- Link to the Home page -->
            <li><a href="contactus.php">Contact Us</a></li> <!-- Link to the Contact Us page -->
            <li><a href="about.php">About Us</a></li> <!-- Link to the About Us page -->
        </ul>
    </nav>

</head>
<body>

<?php require 'partials/header.php' ?> <!-- Including the header partial -->

<h1><?= $welcome_message ?></h1> <!-- Displaying the welcome message -->

<?php if (isset($_SESSION['user_id'])) : ?>
    <a href="logout.php">Logout</a> <!-- Link to the Logout page -->
<?php else: ?>
    <a href="login.php">Login</a> or <!-- Link to the Login page -->
    <a href="signup.php">SignUp</a> <!-- Link to the SignUp page -->
<?php endif; ?>

<?php if (isset($admin_links) && $admin_links) : ?>
    <div class="admin-links">
        <h2>Admin Links</h2>

        <a href="list_of_films.php">List of films</a><br><br> <!-- Link to the List of Films page -->
        <a href="insert_film.php">Insert a film</a><br><br> <!-- Link to the Insert Film page -->
        <a href="insert_show.php">Insert show for film</a><br><br> <!-- Link to the Insert Show page -->
        <a href="cancel_showtime.php">Cancel show for film</a> <!-- Link to the Cancel Showtime page -->

    </div>
<?php endif; ?>

<?php if(isset($guest_links) && $guest_links) : ?>
    <div class="guest-links">
        <h2>Guest Links</h2>
        <a href="list_of_films.php">List of films</a><br><br> <!-- Link to the List of Films page -->
        <a href="your_bookings.php">Your Bookings</a><br><br> <!-- Link to the Your Bookings page -->
    </div>
<?php endif; ?>

<?php if(isset($employee_links) && $employee_links) : ?>
    <div class="employee-links">
        <h2>Employee Links</h2>
        <a href="list_of_films.php">List of films</a><br><br> <!-- Link to the List of Films page -->
        <a href="show_cancellations.php">Show Cancellations</a><br><br> <!-- Link to the Show Cancellations page -->
    </div>
<?php endif; ?>

<div class="content">
    <h2>About Us</h2>
    <p>Welcome to TU Dublin Cinema, your premier destination for movie entertainment in Dublin. Situated at the heart of the city, we provide a state-of-the-art cinematic experience for movie lovers of all ages.</p>

    <h3>Our Mission</h3>
    <p>At TU Dublin Cinema, our mission is to bring the magic of movies to our community. We strive to create an inclusive and welcoming environment where everyone can enjoy the latest blockbusters, independent films, and classic favorites.</p>

    <h3>Our Facilities</h3>
    <p>Our cinema features modern amenities designed to enhance your movie-going experience. From comfortable seating and crystal-clear digital projection to gourmet concessions and convenient parking, we have everything you need for a memorable night at the movies.</p>

    <h3>Contact Us</h3>
    <p>If you have any questions, feedback, or inquiries, please don't hesitate to get in touch with us. You can reach our customer service team by phone at (01) 123-4567 or by email at info@tudublincinema.com. We're here to help!</p>
</div>

<footer>
    <div class="container">
        <p>&copy; 2024 TU Dublin Cinema. All rights reserved.</p> <!-- Copyright notice -->
    </div>

</footer>

</body>
</html>
