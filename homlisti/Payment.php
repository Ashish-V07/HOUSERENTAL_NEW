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
if (isset($_SESSION['payment_msg'])) {
    echo "<script>
        alert('" . addslashes($_SESSION['payment_msg']) . "');
    </script>";
    unset($_SESSION['payment_msg']);
}
if (isset($_SESSION['rating'])) {
    echo "<script>
        alert('" . addslashes($_SESSION['rating']) . "');
    </script>";
    unset($_SESSION['rating']);
}
if (isset($_SESSION['pdf'])) {
    echo "<script>alert('". addslashes($_SESSION['pdf']) ."');</script>";
    unset($_SESSION['pdf']);
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
$properties_sql = "SELECT r.id,p.adress,p.pid,p.SecurityDeposit,u.fname FROM rental_applications r inner join property p on r.property_id=p.pid inner join tbl_users u on p.uid=u.id WHERE r.user_id = '$uid' and r.status='Accepted'";
$properties_result = mysqli_query($conn, $properties_sql);

//
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
            .rating-button-container {
            display: flex;
            justify-content: flex-end; /* Align the button to the right */
            margin-bottom: 15px; /* Add some space below the button */
        }

        .rating-button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            margin-right:30px; 
            margin-top: -20px;
        }

        .rating-button:hover {
            background-color: #218838;
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
                 <li><a href="demo2.php">Maintenance</a> </li>
                <li><a href="Payment.php">Payments</a> </li>
                <li><a href="changePassword.php">Change Password</a></li>
                <li><a href="/houserental-master/homlisti/my-account/logout.php">Logout</a></li>
            </ul>
        </div>

        <!-- Main content -->
        <h2>&nbsp;&nbsp;Your Payments</h2>
 <div class="rating-button-container">
        <!-- Button redirects to the Rating page -->
        <a href="Rating.php" class="rating-button">Rate a Property</a>
    </div>
        <div>
            <table>
                <tr>

                    <th>Property</th>
                    <th>Amount to pay</th>
                    <th>Owner name</th>
                    <th>Status</th>
                    <th>Action</th>

                </tr>
                <?php
                if (mysqli_num_rows($properties_result) > 0) {

                    while ($property = mysqli_fetch_assoc($properties_result))
                    {
                           $status = "pending";
                        if(isset($_COOKIE['rentID']))
                        {
                            $rentID = $_COOKIE['rentID'];
                            $sql = "select status from tblpayment where rid='$rentID'";
                             $res = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($res) > 0) {
                            $statusres = mysqli_fetch_assoc($res);
                            $status = $statusres['status'];
                        }
                        }
                        
                     
                       
                        echo "<tr>";

                        echo "<td>" . $property['adress'] . "</td>";
                        echo "<td>" . $property['SecurityDeposit'] . "</td>";
                        echo "<td>" . $property['fname'] . "</td>";

                        echo "<td>" . $status . "</td>";
                        if ($status != 'successful') {
                            echo "<td>
                            <form action='Payment1/index.php' method='GET' style='display:inline;'>
                                <input type='hidden' name='sd' value='" . htmlspecialchars($property['SecurityDeposit']) . "'>
                                <input type='hidden' name='pid' value='" . htmlspecialchars($property['pid']) . "'>
                                <input type='hidden' name='uid' value='" . htmlspecialchars($uid) . "'>
                                <button type='submit' style='background-color: #007bff; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;'>
                                    Payment
                                </button>
                            </form>
                          </td>";
                        } else {
                            echo "<td>
                            <button type='button' disabled style='background-color: gray; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: not-allowed;'>
                                Payment
                            </button>
                          </td>";
                        }

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>NO payment requests</td></tr>";
                }
                ?>
            </table>
        </div>
    </body>
</html>
