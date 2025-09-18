<?php
$host = "localhost";
$username = "root";
$password = ""; // Default for XAMPP
$database = "health";

$conn = new mysqli($host, $username, $password, $database);

// Check for connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
