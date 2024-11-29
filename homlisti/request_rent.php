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
        $owner_row = mysqli_fetch_assoc($owner_result);
        $owner_id = $owner_row['uid']; // Property owner's ID

        if ($owner_id == $user_id) {
            $_SESSION['rentmsg'] = "You cannot request to rent your own property.";
            header("Location: /houserental-master/homlisti/NEWDashboard.php");
            exit();
        }
    }
     $asql = "SELECT aadhar,mobile FROM tbl_users WHERE id = '$user_id'";
 $rent = "SELECT rid FROM tblrent WHERE uid = '$user_id'";
  $rentRes = mysqli_query($conn, $rent);
    $rentResult = mysqli_fetch_assoc($rentRes);
  if ($rentResult['rid'] > 0) {
       
        $_SESSION['rentmsg'] = "You are already rented one house";
            header("Location: /houserental-master/homlisti/NEWDashboard.php");
            exit();
    }
    $ar = mysqli_query($conn, $asql);
    $res = mysqli_fetch_assoc($ar);
    if (!$res['aadhar'] > 0 or !$res['mobile'] > 0) {
       
        $_SESSION['rentmsg'] = "Addhar & mobile  is not updated please update Profile";
            header("Location: /houserental-master/homlisti/NEWDashboard.php");
            exit();
    }
    
    if ($owner_result && mysqli_num_rows($owner_result) > 0) {
        // Insert the rent request into the rental_applications table
        $check_query = "SELECT * FROM rental_applications 
                    WHERE property_id = '$property_id' 
                    AND user_id = '$user_id' 
                    AND status IN ('Pending', 'Accepted')";
        $check_result = mysqli_query($conn, $check_query);

        if ($check_result && mysqli_num_rows($check_result) > 0) {
            $_SESSION['rentmsg'] = "You have already submitted a rent request for this property, and it's still pending or has been accepted.";
            header("Location: /houserental-master/homlisti/NEWDashboard.php");
            exit();
        } else {
            $insert_query = "INSERT INTO rental_applications (property_id, user_id) VALUES ('$property_id', '$user_id')";
            $insert = mysqli_query($conn, $insert_query);
        }
        if ($insert) {
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
