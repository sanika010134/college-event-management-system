<?php
require_once "config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Join registrations and events tables to get the user's schedule
$sql = "SELECT e.title, e.event_date, e.location, r.registered_at 
        FROM registrations r 
        JOIN events e ON r.event_id = e.id 
        WHERE r.user_id = $user_id 
        ORDER BY e.event_date ASC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Events - CEMS</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav>
        <h1>Campus Events</h1>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="events.php">Browse Events</a></li>
            <li><a href="my_events.php">My Registrations</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>My Registered Events</h2>
        <?php if(isset($_GET['msg'])) echo "<p style='color:green;'>" . htmlspecialchars($_GET['msg']) . "</p>"; ?>

        <table>
            <thead>
                <tr>
                    <th>Event Title</th>
                    <th>Date & Time</th>
                    <th>Location</th>
                    <th>Registered On</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo date('M d, Y h:i A', strtotime($row['event_date'])); ?></td>
                    <td><?php echo htmlspecialchars($row['location']); ?></td>
                    <td><?php echo date('M d, Y', strtotime($row['registered_at'])); ?></td>
                </tr>
                <?php endwhile; ?>
                
                <?php if($result->num_rows == 0): ?>
                    <tr><td colspan="4">You haven't registered for any events yet. <a href="events.php">Find some here!</a></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>