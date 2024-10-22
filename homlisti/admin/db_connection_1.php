<?php
$servername = "localhost";
$username = "root"; // Database username
$password = ""; // Database password
$dbname = "house_rental"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>