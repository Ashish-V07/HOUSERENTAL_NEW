<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['user_id'];
    $newStatus = $_POST['status'];

    // Update the user's status in the database
    $query = "UPDATE tbl_users SET User_Status = '$newStatus' WHERE id = $userId";
    if (mysqli_query($conn, $query)) {
        echo "Status updated successfully.";
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
}
?>