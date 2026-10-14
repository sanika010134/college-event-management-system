<?php
require_once "config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['event_id'])) {
    $user_id = $_SESSION['user_id'];
    $event_id = (int)$_POST['event_id'];

    // 1. Check if user is already registered
    $check_sql = "SELECT id FROM registrations WHERE user_id = $user_id AND event_id = $event_id";
    if ($conn->query($check_sql)->num_rows > 0) {
        header("Location: events.php?err=You are already registered for this event.");
        exit();
    } 

    // 2. Check current capacity
    $cap_sql = "SELECT max_capacity, (SELECT COUNT(*) FROM registrations WHERE event_id = $event_id) as current_regs 
                FROM events WHERE id = $event_id";
    $cap_result = $conn->query($cap_sql);
    $cap_data = $cap_result->fetch_assoc();

    if ($cap_data['current_regs'] >= $cap_data['max_capacity']) {
        header("Location: events.php?err=Sorry, this event has reached maximum capacity!");
        exit();
    }

    // 3. If space is available, register the student
    $insert_sql = "INSERT INTO registrations (user_id, event_id) VALUES ($user_id, $event_id)";
    if ($conn->query($insert_sql)) {
        header("Location: my_events.php?msg=Successfully registered for the event!");
        exit();
    } else {
        header("Location: events.php?err=Registration failed. Please try again.");
        exit();
    }
} else {
    header("Location: events.php");
    exit();
}
?>