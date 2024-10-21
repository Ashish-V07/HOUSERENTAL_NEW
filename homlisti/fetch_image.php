<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "house_rental";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
$email = $_SESSION['email']; // Assuming user_id is in the session

$sql = "SELECT profile_image FROM tbl_users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    header("Content-type: image/jpeg"); // Change based on image type
    echo $row['profile_image']; // Output the image binary data
} else {
    echo "No image found.";
}

$conn->close();
?>
