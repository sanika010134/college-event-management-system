<?php require_once "config/database.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>About - CEMS</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav>
        <h1>Campus Events</h1>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="events.php">Browse Events</a></li>
            <li><a href="about.php">About</a></li>
            <?php if(isset($_SESSION['user_id'])): ?>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="container">
        <h2>About the College Event Management System</h2>
        <p>The College Event Management System (CEMS) is a centralized platform designed to streamline the organization, discovery, and registration of campus activities.</p>
        <p><strong>For Students:</strong> Easily browse upcoming hackathons, cultural fests, and guest lectures, and manage your registrations in one place.</p>
        <p><strong>For Administrators:</strong> Quickly publish new events, update schedules, and track student attendance with our dedicated admin dashboard.</p>
    </div>
</body>
</html>