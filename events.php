<?php
require_once "config/database.php";

// Fetch all future events, including the current registration count
$result = $conn->query("SELECT e.*, (SELECT COUNT(*) FROM registrations WHERE event_id = e.id) as current_regs 
                        FROM events e WHERE e.event_date >= NOW() ORDER BY e.event_date ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Browse Events - CEMS</title>
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
        <h2>Upcoming Events</h2>
        <?php if(isset($_GET['msg'])) echo "<p style='color:green;'>" . htmlspecialchars($_GET['msg']) . "</p>"; ?>
        <?php if(isset($_GET['err'])) echo "<p style='color:red;'>" . htmlspecialchars($_GET['err']) . "</p>"; ?>
        
        <div class="event-list">
            <?php while($row = $result->fetch_assoc()): ?>
                <div style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px;">

                    <!-- Integrated Link with Image -->
                    <a href="event_details.php?id=<?php echo $row['id']; ?>" style="text-decoration: none; color: #2c3e50;">
                        <?php if(!empty($row['image_path'])): ?>
                            <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="Event Poster" style="width: 100%; height: 180px; object-fit: cover; border-radius: 5px; margin-bottom: 10px;">
                        <?php else: ?>
                            <div style="width: 100%; height: 180px; background: #f0f2f5; display: flex; align-items: center; justify-content: center; border-radius: 5px; margin-bottom: 10px; color: #95a5a6; font-size: 0.9rem;">
                                No Image Provided
                            </div>
                        <?php endif; ?>
                        <h3 style="margin-top: 5px;"><?php echo htmlspecialchars($row['title']); ?></h3>
                    </a>
                    
                    <p><strong>Date:</strong> <?php echo date('M d, Y h:i A', strtotime($row['event_date'])); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
                    <p><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                    
                    <!-- NEW: Display Capacity Tracker -->
                    <p style="color: #e67e22; font-weight: bold;">
                        Spots Filled: <?php echo $row['current_regs']; ?> / <?php echo $row['max_capacity']; ?>
                    </p>

                    <?php if(isset($_SESSION['user_id'])): ?>
                        <form action="register_event.php" method="POST">
                            <input type="hidden" name="event_id" value="<?php echo $row['id']; ?>">
                            <button type="submit">Register for this Event</button>
                        </form>
                    <?php else: ?>
                        <p><a href="login.php">Log in to register</a></p>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
            
            <?php if($result->num_rows == 0): ?>
                <p>No upcoming events at the moment. Check back later!</p>
            <?php endif; ?>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>