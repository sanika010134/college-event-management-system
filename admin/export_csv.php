<?php
require_once "../config/database.php";

// Protect the route
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Set headers to force the browser to download a CSV file
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=event_registrations.csv');

// Create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// Write the column headers to the Excel/CSV file
fputcsv($output, array('Event Title', 'Student Name', 'College Email', 'Registration Date'));

// Fetch the exact same data shown on the registrations page
$sql = "SELECT e.title, u.name, u.email, r.registered_at 
        FROM registrations r 
        JOIN events e ON r.event_id = e.id 
        JOIN users u ON r.user_id = u.id 
        ORDER BY e.event_date ASC, r.registered_at ASC";

$result = $conn->query($sql);

// Loop through the database results and write them to the file row by row
while ($row = $result->fetch_assoc()) {
    fputcsv($output, array(
        $row['title'], 
        $row['name'], 
        $row['email'], 
        date('M d, Y h:i A', strtotime($row['registered_at']))
    ));
}

// Close the file stream
fclose($output);
exit();
?>