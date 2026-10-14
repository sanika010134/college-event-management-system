<?php
require_once "config/database.php";

if (!isset($_GET['id'])) {
    header("Location: events.php");
    exit();
}

$id = (int)$_GET['id'];
$result = $conn->query("SELECT * FROM events WHERE id = $id");

if ($result->num_rows == 0) {
    die("Event not found.");
}

$event = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo htmlspecialchars($event['title']); ?> - CEMS</title>
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
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="container">
        <h2><?php echo htmlspecialchars($event['title']); ?></h2>
        
        <div style="background: #f9f9f9; padding: 20px; border-radius: 8px; margin-top: 20px;">
            <p><strong>Date & Time:</strong> <?php echo date('F d, Y \a\t h:i A', strtotime($event['event_date'])); ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
            <hr style="border: 0; border-top: 1px solid #ddd; margin: 20px 0;">
            <p><strong>Description:</strong></p>
            <p style="line-height: 1.6;"><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
            
            <br>
            <?php if(isset($_SESSION['user_id'])): ?>
                <form action="register_event.php" method="POST">
                    <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                    <button type="submit" style="background-color: #27ae60; padding: 12px 24px; font-size: 1.1rem;">Register Now</button>
                </form>
            <?php else: ?>
                <p><em>You must <a href="login.php">log in</a> to register for this event.</em></p>
            <?php endif; ?>
        </div>
        
        <br>
        <a href="events.php">&larr; Back to Events</a>
    </div>
    
    <script src="js/script.js"></script>
</body>
</html>