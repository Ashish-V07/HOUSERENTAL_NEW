<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['email'])) {
    header("Location: /houserental-master/homlisti/my-account/index.php");
    exit();
}

// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'house_rental');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$email = $_SESSION['email'];
$user_query = "SELECT id FROM tbl_users WHERE email = '$email'";
$user_result = mysqli_query($conn, $user_query);
//$row= mysqli_fetch_assoc($user_result);
//$uid=$row['id'];

if ($user_result && mysqli_num_rows($user_result) > 0) {
    $user_row = mysqli_fetch_assoc($user_result);
    $user_id = $user_row['id']; // Logged-in user's ID
} else {
    die("User not found.");
}

// Handle rent request submission

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['property_id'])) {
    $property_id = $_POST['property_id'];

    // Fetch the property owner's ID (Not used in this case, but keeping the query for potential validation)
    $owner_query = "SELECT uid FROM property WHERE pid = '$property_id'";
    $owner_result = mysqli_query($conn, $owner_query);

    if ($owner_result && mysqli_num_rows($owner_result) > 0) {
        // Insert the rent request into the rental_applications table
        $insert_query = "INSERT INTO rental_applications (property_id, user_id) VALUES ('$property_id', '$user_id')";
        
        if (mysqli_query($conn, $insert_query)) {
            $_SESSION['rentmsg'] = "Your rent request has been submitted successfully! Wait for Owner's mail";
               header("Location: /houserental-master/homlisti/NEWDashboard.php");
exit();
        } else {
             $_SESSION['rentmsg'] = "Error submitting the rent request: " . mysqli_error($conn);
                 header("Location: /houserental-master/homlisti/NEWDashboard.php");
exit();
        }
    } else {
        $_SESSION['rentmsg'] = "Invalid property.";
            header("Location: /houserental-master/homlisti/NEWDashboard.php");
exit();
    }
}

?>
