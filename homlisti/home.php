<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
if ($_SESSION['email'] == "22bmiit150@gmail.com") {
    header("Location: /houserental-master/homlisti/admin/dashboard.php");
    exit();
}


$conn = mysqli_connect("localhost", "root", "", "house_rental");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$uname = $_SESSION['email'];
$sql = "SELECT id FROM tbl_users WHERE email = '$uname'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$uid = $row['id'];  // Fetch user ID

// Fetch properties
$properties_sql = "SELECT * FROM property WHERE uid = '$uid'";
$properties_result = mysqli_query($conn, $properties_sql);

?>

<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Properties</title>
    <style>

        /* Main content styles */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            padding-left: 240px; /* Create space for the sidebar */
            background-color: #f8f9fa;
        }

        h2 {
            margin: 20px;
        }

        /* Table styles */
        table {
            width: 95%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Responsive table */
        @media (max-width: 768px) {
            body {
                padding-left: 0;
            }
           

            table {
                width: 100%;
                font-size: 14px;
                overflow-x: auto;
            }

            th, td {
                padding: 8px;
            }
        }
 /* Sidebar Styles */
        .sidebar {
            width: 220px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            color: #fff;
            padding: 20px;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
        }

        .sidebar ul li a:hover {
            color: #ffc107;
        }

        /* Profile container with left margin for the sidebar */
        .profile-container {
            margin-left: 240px; /* Ensure there's space for the sidebar */
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <!-- Sidebar navigation -->
    <div class="sidebar">
        <ul>
            <li><a href="NEWDashboard.php">Home</a></li>
            <li><a href="Profile.php">Profile Overview</a></li>
            <li><a href="Profile1.php">Update Profile</a></li>
            <li><a href="home.php">My Properties</a></li>
            <li><a href="changePassword.php">Change Password</a></li>
            <li><a href="/houserental-master/homlisti/my-account/logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main content -->
    <h2>&nbsp;&nbsp;Your Properties</h2>
    
    <div>
        <table>
            <tr>
                <th>ID</th>
                <th>Address</th>
                <th>Rent</th>
                <th>Bedrooms</th>
                <th>Bathrooms</th>
                <th>Status</th>
                <th>Action</th>
                <th>Action</th>
            </tr>
            <?php
            if (mysqli_num_rows($properties_result) > 0) {
                while ($property = mysqli_fetch_assoc($properties_result)) {
                    echo "<tr>";
                    echo "<td>" . $property['pid'] . "</td>";
                    echo "<td>" . $property['adress'] . "</td>";
                    echo "<td>" . $property['rent'] . "</td>";
                    echo "<td>" . $property['bedroom'] . "</td>";
                    echo "<td>" . $property['bathroom'] . "</td>";
                    echo "<td>" . $property['status'] . "</td>";
                    echo "<td><a href='update_property.php?pid=" . $property['pid'] . "'>Update</a></td>";
                     echo "<td><a href='RentApplications.php?pid=" . $property['pid'] . "'>See Rental Applications</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>You have no properties listed.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
