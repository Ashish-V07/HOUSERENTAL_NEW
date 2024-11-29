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
try {
$id=$_GET['prid'];
$sql2="select adress from property where pid='$id'";

$res= mysqli_query($conn, $sql2);
$r= mysqli_fetch_assoc($res);
$property_id=$r['adress'];

$rentRequest = "SELECT 
    u.id, 
    u.fname, 
    u.lname, 
    u.mobile, 
    u.email, 
    r.status 
FROM 
    tbl_users u 
INNER JOIN 
    rental_applications r 
ON 
    u.id = r.user_id 
WHERE 
    r.property_id = '$id'
GROUP BY 
    u.id;
";
$rentResult = mysqli_query($conn, $rentRequest);

} catch (Exception $ex) {
    echo 'sorry not found';
    die();
}

?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Ygz42h78KZ+e6zgNRt9Ax7LYVsZSVfzM0XOeL+TQwV3BXuDEok65B1JYIuaxFKM4" crossorigin="anonymous">

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
            /* Accept Button Style */
            button.accept-btn  {
                display: inline-block;
                text-decoration: none;
                color: #fff;
                background-color: #28a745;
                padding: 8px 16px;
                border: none;
                border-radius: 5px;
                font-size: 14px;
                cursor: pointer;
                transition: background-color 0.3s ease, transform 0.2s ease;
            }

            button.accept-btn :hover {
                background-color: #218838;
                transform: scale(1.05);
            }

            /* Reject Button Style */
            button.reject-btn  {
                display: inline-block;
                text-decoration: none;
                color: #fff;
                background-color: #dc3545;
                padding: 8px 16px;
                border: none;
                border-radius: 5px;
                font-size: 14px;
                cursor: pointer;
                transition: background-color 0.3s ease, transform 0.2s ease;
            }

            button.reject-btn :hover {
                background-color: #c82333;
                transform: scale(1.05);
            }

            /* Ensure buttons inline with proper spacing */
            button {
                margin-right: 10px;
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
                  <li><a href="Payment.php">Payments</a></li>
                <li><a href="changePassword.php">Change Password</a></li>
                <li><a href="/houserental-master/homlisti/my-account/logout.php">Logout</a></li>
            </ul>
        </div>

        <!-- Main content -->
        <h2>&nbsp;&nbsp;Rental applications for Property <?php echo $property_id; ?></h2>

        <div>
            <table>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Contact No</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php
                if (mysqli_num_rows($rentResult) > 0) {
                    while ($rent = mysqli_fetch_assoc($rentResult)) {
                        echo "<tr>";
                        echo "<td>" . $rent['id'] . "</td>";
                        echo "<td>" . $rent['fname'] . "</td>";
                        echo "<td>" . $rent['lname'] . "</td>";
                        echo "<td>" . $rent['mobile'] . "</td>";
                        echo "<td>" . $rent['email'] . "</td>";
                        echo "<td>" . $rent['status'] . "</td>";
                        echo "<td>";
                        echo "<form method='POST' action='handle_rental_request.php' style='display:inline-block; margin-right:5px;'>";
                        echo "<input type='hidden' name='request_id' value='" . $rent['id'] . "'>";
                        echo "<input type='hidden' name='action' value='accept'>";
                        echo "<input type='hidden' name='Property_id' value='".$id."'>";
                        echo "<button type='submit' class='accept-btn'>Accept</button>";
                        echo "</form>";

                        echo "<form method='POST' action='handle_rental_request.php' style='display:inline-block;'>";
                        echo "<input type='hidden' name='request_id' value='" . $rent['id'] . "'>";
                        echo "<input type='hidden' name='action' value='reject'>";
                        echo "<button type='submit' class='reject-btn'>Reject</button>";
                        echo "</form>";
                        echo "</td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No Requests found</td></tr>";
                }
                ?>
            </table>
        </div>
    </body>
</html>
