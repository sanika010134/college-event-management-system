<?php
require_once "../config/database.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$result = $conn->query("SELECT * FROM events ORDER BY event_date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard - CEMS</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav>
        <h1>CEMS Admin</h1>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="add_event.php">Add Event</a></li>
            <!-- Integrated Link -->
            <li><a href="registrations.php">View Registrations</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Manage Events</h2>
        <a href="add_event.php"><button style="margin-bottom: 20px;">+ Create New Event</button></a>

        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Date & Time</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo date('M d, Y h:i A', strtotime($row['event_date'])); ?></td>
                    <td><?php echo htmlspecialchars($row['location']); ?></td>
                    <td>
                        <a href="edit_event.php?id=<?php echo $row['id']; ?>">Edit</a> | 
                        <a href="delete_event.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php if($result->num_rows == 0): ?>
                    <tr><td colspan="4">No events found. Create one!</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>