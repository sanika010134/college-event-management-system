<?php
require_once "config/database.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - College Event System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav>
        <h1>Campus Events</h1>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="events.php">Browse Events</a></li>
            
            <?php if(isset($_SESSION['user_id'])): ?>
                <li><a href="my_events.php">My Registrations</a></li>
                <li>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</li>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <main class="container">
        <?php if(isset($_SESSION['user_id'])): ?>
            <h2>Welcome to the College Event Portal</h2>
            <p>Check out the latest hackathons, coding competitions, and campus activities.</p>
            <a href="events.php"><button>View Upcoming Events</button></a>
        <?php else: ?>
            <h2>Join the Campus Community</h2>
            <p>Please log in or register to browse and sign up for upcoming college events.</p>
        <?php endif; ?>
    </main>
</body>
</html>