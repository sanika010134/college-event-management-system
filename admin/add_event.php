<?php
require_once "../config/database.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $event_date = $_POST['event_date'];
    $location = $conn->real_escape_string($_POST['location']);
    $max_capacity = (int)$_POST['max_capacity']; // Get capacity from form
    
    // Process Image Upload
    $image_path = NULL;
    if (isset($_FILES['poster']) && $_FILES['poster']['error'] == 0) {
        $target_dir = "../uploads/";
        $file_name = time() . "_" . basename($_FILES["poster"]["name"]);
        $target_file = $target_dir . $file_name;
        
        $check = getimagesize($_FILES["poster"]["tmp_name"]);
        if($check !== false) {
            if (move_uploaded_file($_FILES["poster"]["tmp_name"], $target_file)) {
                $image_path = "uploads/" . $file_name; 
            } else {
                $error = "Sorry, there was an error saving your file.";
            }
        } else {
            $error = "File is not a valid image.";
        }
    }

    if (empty($error)) {
        $image_sql = $image_path ? "'$image_path'" : "NULL";
        // Include max_capacity in the INSERT statement
        $sql = "INSERT INTO events (title, description, event_date, location, image_path, max_capacity) 
                VALUES ('$title', '$description', '$event_date', '$location', $image_sql, $max_capacity)";

        if ($conn->query($sql)) {
            $success = "Event created successfully!";
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Event - CEMS Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav>
        <h1>CEMS Admin</h1>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="add_event.php">Add Event</a></li>
            <li><a href="registrations.php">View Registrations</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Create a New Event</h2>
        <?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
        <?php if($success) echo "<p style='color:green;'>$success</p>"; ?>

        <!-- Added enctype attribute required for file uploads -->
        <form method="POST" action="" enctype="multipart/form-data">
            <label>Event Title:</label><br>
            <input type="text" name="title" required><br><br>

            <label>Date & Time:</label><br>
            <input type="datetime-local" name="event_date" required><br><br>

            <label>Location (e.g., Main Auditorium):</label><br>
            <input type="text" name="location" required><br><br>

            <label>Maximum Capacity:</label><br>
            <input type="number" name="max_capacity" min="1" value="50" required><br><br>

            <!-- New Image Upload Field -->
            <label>Event Poster (Image):</label><br>
            <input type="file" name="poster" accept="image/*"><br><br>

            <label>Description:</label><br>
            <textarea name="description" rows="5" required></textarea><br><br>

            <button type="submit">Publish Event</button>
        </form>
    </div>
</body>
</html>