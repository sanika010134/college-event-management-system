<?php
session_start(); // Required for login state

$host = "localhost";
$username = "root";
$password = "";
$database = "college_event_system";
$port = 3306;

$conn = new mysqli($host, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>