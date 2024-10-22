<?php
session_start();
include 'db_connection.php';

if(isset($_POST['feedback']))
{
    $userid = $_POST['txtUserID'];
    $type = $_POST['type'];
    $description = $_POST['description'];

    // Prepare the SQL statement to prevent SQL injection
    // Omitting the status field to let the database apply the default value
    $stmt = $conn->prepare("INSERT INTO tblfeedback (uid, type, descr, date) VALUES (?, ?, ?, CURRENT_TIMESTAMP)");
    $stmt->bind_param("sss", $userid, $type, $description);

    if($stmt->execute())
    {
        $_SESSION['FMSG'] = "Feedback Submitted";
        header("Location: index.php");
        die();
    }
    else
    {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
