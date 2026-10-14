<?php
require_once "../config/database.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $event_date = $_POST['event_date'];
    $location = $conn->real_escape_string($_POST['location']);

    $sql = "UPDATE events SET title='$title', description='$description', event_date='$event_date', location='$location' WHERE id=$id";

    if ($conn->query($sql)) {
        $success = "Event updated successfully!";
    } else {
        $error = "Error updating event: " . $conn->error;
    }
}

// Fetch current data to pre-fill the form
$result = $conn->query("SELECT * FROM events WHERE id = $id");
if ($result->num_rows == 0) {
    die("Event not found.");
}
$event = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Event - CEMS</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav>
        <h1>CEMS Admin</h1>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="add_event.php">Add Event</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Edit Event</h2>
        <?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
        <?php if($success) echo "<p style='color:green;'>$success</p>"; ?>

        <form method="POST" action="">
            <label>Event Title:</label><br>
            <input type="text" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required><br>

            <label>Date & Time:</label><br>
            <input type="datetime-local" name="event_date" value="<?php echo date('Y-m-d\TH:i', strtotime($event['event_date'])); ?>" required><br>

            <label>Location:</label><br>
            <input type="text" name="location" value="<?php echo htmlspecialchars($event['location']); ?>" required><br>

            <label>Description:</label><br>
            <textarea name="description" rows="5" required><?php echo htmlspecialchars($event['description']); ?></textarea><br>

            <button type="submit">Update Event</button>
            <a href="dashboard.php" style="margin-left:10px; text-decoration:none;">
                <button type="button" style="background-color:#7f8c8d;">Back to Dashboard</button>
            </a>
        </form>
    </div>
</body>
</html>