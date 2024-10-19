<?php
session_start();
//
//// Check if the admin is logged in (assuming admin login is already implemented)
//if (!isset($_SESSION['admin'])) {
//    header("Location: admin_login.php");
//    exit();
//}

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "test");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Approve or Deny property based on admin action
if (isset($_POST['approve'])) {
    $pid = $_POST['pid'];
    $sql = "UPDATE property SET status = 'Allow' WHERE pid = $pid";
    mysqli_query($conn, $sql);
} elseif (isset($_POST['deny'])) {
    $pid = $_POST['pid'];
    $sql = "UPDATE property SET status = 'Denied' WHERE pid = $pid";
    mysqli_query($conn, $sql);
}

// Fetch properties with status 'Pending' for approval
$sql = "SELECT * FROM property WHERE status = 'Pending'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Approve Properties</title>
</head>
<body>
    <h2>Pending Property Requests</h2>

    <?php
    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Property ID</th>
                    <th>Category ID</th>
                    <th>Address</th>
                    <th>Rent</th>
                    <th>Bedrooms</th>
                    <th>Bathrooms</th>
                    <th>Parking</th>
                    <th>Description</th>
                    <th>Size</th>
                    <th>Action</th>
                </tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . $row['pid'] . "</td>
                    <td>" . $row['cid'] . "</td>
                    <td>" . $row['adress'] . "</td>
                    <td>" . $row['rent'] . "</td>
                    <td>" . $row['bedroom'] . "</td>
                    <td>" . $row['bathroom'] . "</td>
                    <td>" . ($row['parking'] ? 'Yes' : 'No') . "</td>
                    <td>" . $row['description'] . "</td>
                    <td>" . $row['size'] . " sq.ft</td>
                    <td>
                        <form action='aprove.php' method='POST'>
                            <input type='hidden' name='pid' value='" . $row['pid'] . "'>
                            <input type='submit' name='approve' value='Approve'>
                            <input type='submit' name='deny' value='Deny'>
                        </form>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No pending property requests.";
    }

    mysqli_close($conn);
    ?>
</body>
</html>
