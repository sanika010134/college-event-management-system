<?php
require_once "../config/database.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Fetch all events that have at least one registration
$sql = "SELECT e.title, u.name, u.email, r.registered_at 
        FROM registrations r 
        JOIN events e ON r.event_id = e.id 
        JOIN users u ON r.user_id = u.id 
        ORDER BY e.event_date ASC, r.registered_at ASC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Registrations - CEMS</title>
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
        <h2>Student Registrations</h2>
        
        <!-- New Download Button -->
        <a href="export_csv.php">
            <button style="background-color: #27ae60; margin-bottom: 20px;">Download as Excel (CSV)</button>
        </a>
        
        <table>
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Time of Registration</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo date('M d, Y h:i A', strtotime($row['registered_at'])); ?></td>
                </tr>
                <?php endwhile; ?>
                
                <?php if($result->num_rows == 0): ?>
                    <tr><td colspan="4">No students have registered for any events yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>