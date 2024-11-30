<?php
session_start();
ob_start(); // Start output buffering
if (!$_SESSION['email'] == "22bmiit150@gmail.com") {
    header("Location: /houserental-master/homlisti/my-account/index.php");
    exit();
}


// Database connection
include 'db_connection.php';
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\XAMPP\htdocs\houserental-master\PHPMailer-master\src\PHPMailer.php';
require 'C:\XAMPP\htdocs\houserental-master\PHPMailer-master\src\Exception.php';
require 'C:\XAMPP\htdocs\houserental-master\PHPMailer-master\src\SMTP.php';

// Function to send denial email
function sendDenialEmail($recipient_email, $property_id) {
    try {
        $mail = new PHPMailer(true);

        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ashishvaghasiya150@gmail.com'; // your email address
        $mail->Password = 'dnvjaacfmzrpovwi'; // your email password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Sender and recipient
        $mail->setFrom('ashishvaghasiya150@gmail.com', 'RentEase');
        $mail->addAddress($recipient_email);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Property Verification Denied';
       $mail->Body = "
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f9f9f9;
                margin: 0;
                padding: 0;
                color: #333333;
            }
            .container {
                max-width: 600px;
                margin: auto;
                padding: 20px;
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            .header {
                background-color: #D9534F;
                color: #ffffff;
                padding: 20px;
                text-align: center;
                font-size: 24px;
                font-weight: bold;
                border-top-left-radius: 8px;
                border-top-right-radius: 8px;
            }
            .content {
                padding: 20px;
                text-align: left;
            }
            .content h2 {
                color: #D9534F;
                font-size: 20px;
            }
            .content p {
                font-size: 16px;
                line-height: 1.6;
                margin: 10px 0;
            }
            .footer {
                text-align: center;
                padding: 15px;
                font-size: 14px;
                color: #888888;
            }
            .footer a {
                color: #D9534F;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                RentEase Property Denial Notification
            </div>
            <div class='content'>
                <h2>Property Submission Denied</h2>
                <p>Dear User,</p>
                <p>We regret to inform you that your property <strong>$property_id</strong> has been denied. Please ensure that all the information provided is accurate and complete, then try submitting again.</p>
                <p>If you need further assistance, feel free to reach out to our support team.</p>
                <p>Thank you for your understanding.</p>
                <p>Warm regards,<br>RentEase Team</p>
            </div>
            <div class='footer'>
                &copy; " . date("Y") . " RentEase. All rights reserved.<br>
              
            </div>
        </div>
    </body>
    </html>
";

        // Send email
        $mail->send();

        echo '<script>alert("Denial email has been sent to the user.");</script>';
    } catch (Exception $e) {
        echo '<script>alert("Message could not be sent. Mailer Error: ' . $mail->ErrorInfo . '");</script>';
    }
}

// Function to send approval email
function sendApprovalEmail($recipient_email, $property_id) {
    try {
        $mail = new PHPMailer(true);

        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ashishvaghasiya150@gmail.com'; // your email address
        $mail->Password = 'dnvjaacfmzrpovwi'; // your email password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Sender and recipient
        $mail->setFrom('ashishvaghasiya150@gmail.com', 'RentEase');
        $mail->addAddress($recipient_email);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Property Verification Approved';
      $mail->Body = "
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f9f9f9;
                margin: 0;
                padding: 0;
                color: #333333;
            }
            .container {
                max-width: 600px;
                margin: auto;
                padding: 20px;
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            .header {
                background-color: #4CAF50;
                color: #ffffff;
                padding: 20px;
                text-align: center;
                font-size: 24px;
                font-weight: bold;
                border-top-left-radius: 8px;
                border-top-right-radius: 8px;
            }
            .content {
                padding: 20px;
                text-align: left;
            }
            .content h2 {
                color: #4CAF50;
                font-size: 20px;
            }
            .content p {
                font-size: 16px;
                line-height: 1.6;
                margin: 10px 0;
            }
            .footer {
                text-align: center;
                padding: 15px;
                font-size: 14px;
                color: #888888;
            }
            .footer a {
                color: #4CAF50;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                RentEase Property Approval
            </div>
            <div class='content'>
                <h2>Congratulations!</h2>
                <p>Dear User,</p>
                <p>Your property <strong>$property_id</strong> has been approved and is now listed for rental on our platform.</p>
                <p>Thank you for trusting us with your property. We wish you great success in finding the perfect tenants!</p>
                <p>Warm regards,<br>RentEase Team</p>
            </div>
            <div class='footer'>
                &copy; " . date("Y") . " RentEase. All rights reserved.<br>
               
            </div>
        </div>
    </body>
    </html>
";

        // Send email
        $mail->send();

        echo '<script>alert("Approval email has been sent to the user.");</script>';
    } catch (Exception $e) {
        echo '<script>alert("Message could not be sent. Mailer Error: ' . $mail->ErrorInfo . '");</script>';
    }
}

// Fetch all properties based on status passed in the URL
$status_filter = 'Pending'; // Default status

if (isset($_GET['status'])) {
    $status = $_GET['status'];
    if ($status === 'allowed') {
        $status_filter = 'Allow';
    } elseif ($status === 'denied') {
        $status_filter = 'Denied';
    } elseif ($status === 'pending') {
        $status_filter = 'Pending';
    }
}

$sql = "SELECT p.*,u.email FROM property p inner join tbl_users u on u.id=p.uid WHERE status = '$status_filter'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <title>Admin Property Verification</title>
        <style>
            .property-image {
                width: 200px; /* Set a fixed width */
                height: 150px; /* Set a fixed height */
                object-fit: cover; /* Ensures the image fits the dimensions without distortion */
                margin: 5px; /* Adds space between images */
            }
            .allow {
    background-color: #28a745; /* Green for 'Allow' */
    color: #ffffff; /* White text */
    border: none;
    padding: 5px 10px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.allow:hover {
    background-color: #218838; /* Darker green on hover */
}

.deny {
    background-color: #dc3545; /* Red for 'Deny' */
    color: #ffffff; /* White text */
    border: none;
    padding: 5px 10px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.deny:hover {
    background-color: #c82333; /* Darker red on hover */
}

           
        </style>

    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar navigation -->
                <nav class="col-md-2 d-none d-md-block sidebar position-fixed vh-100" style="background-color: #d3d3d3 ;">
                    <div class="sidebar-sticky">
                        <h4 class="sidebar-heading">Admin Menu</h4>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" href="dashboard.php">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="admin_category.php">Category</a>
                            </li>
                            <li class="nav-item">
                                <select class="form-control" id="managePropertySelect" onchange="location = this.value;">
                                    <option selected disabled>Manage Property:</option>
                                    <option value="admin_verify.php?status=pending">Pending Properties</option>
                                    <option value="admin_verify.php?status=allowed">Allowed Properties</option>
                                    <option value="admin_verify.php?status=denied">Denied Properties</option>
                                </select>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="manage_users.php">Manage Users</a> <!-- New Manage Users Link -->
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="ManageFeedback.php">Manage Feedback</a>
                            </li>
                              <li class="nav-item">
                                <a class="nav-link" href="changePassword.php">Change Password</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">Logout</a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- Main content -->
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        echo "<div class='container'>";

                        while ($row = mysqli_fetch_assoc($result)) {
                            $pid = $row['pid'];
                            echo "<div class='card'>
                            <div class='card-header'>Property ID: " . $row['pid'] . "</div>
                            <div class='card-body'>
                                <table>
                                 <tr style='font-weight: bold;'>
                                        <td><strong>Email:&nbsp</strong></td>
                                        <td>" . $row['email'] . "</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Address:</strong></td>
                                        <td>" . $row['adress'] . "</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Rent:</strong></td>
                                        <td>" . $row['rent'] . "</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Bedrooms:</strong></td>
                                        <td>" . $row['bedroom'] . "</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Bathrooms:</strong></td>
                                        <td>" . $row['bathroom'] . "</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Description:</strong></td>
                                        <td>" . $row['description'] . "</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Size:</strong></td>
                                        <td>" . $row['size'] . "</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Images:</strong></td>
                                        <td>";

                            // Fetch and display house images
                            $image_sql = "SELECT image FROM tblimage WHERE pid = '$pid'";
                            $image_result = mysqli_query($conn, $image_sql);

                            if (mysqli_num_rows($image_result) > 0) {
                                while ($image_row = mysqli_fetch_assoc($image_result)) {
                                    echo "<img src='data:image/jpeg;base64," . base64_encode($image_row['image']) . "' class='property-image' />";
                                }
                            } else {
                                echo "No images available";
                            }

                            echo "</td></tr>";

                            // Check and display document if available
                            echo "<tr>
                            <td><strong>Document:</strong></td>
                            <td>";
                            if ($row['document']) {
                                echo "<a href='download.php?pid=" . $row['pid'] . "' target='_blank'>Download/View Document</a>";
                            } else {
                                echo "No document available";
                            }

                            echo "</td></tr></table>";

                            // Provide options to verify or deny the property
                            echo "<div class='buttons'>";

                            if ($row['status'] === 'Pending') {
                                echo "<form action='admin_verify.php' method='POST'>
                                <input type='hidden' name='pid' value='" . $row['pid'] . "'>
                                <input type='submit' name='allow' value='Allow' class='allow'>
                                <input type='submit' name='deny' value='Deny' class='deny'>
                              </form>";
                            } elseif ($row['status'] === 'Allow') {
                                echo "<p class='text-success'>This property is already approved.</p>";
                            } elseif ($row['status'] === 'Denied') {
                                echo "<p class='text-danger'>This property has been denied.</p>
                              <form action='admin_verify.php' method='POST'>
                                <input type='hidden' name='pid' value='" . $row['pid'] . "'>
                                <input type='submit' name='reallow' value='Re-allow for Update' class='allow'>
                              </form>";
                            }

                            echo "</div></div></div>";
                        }
                        echo "</div>";
                    } else {
                        echo "<p>No properties found in this status.</p>";
                    }
                    ?>
                </main>
            </div>
        </div>

        <?php
// Handle Allow, Deny, and Re-Allow Actions
        if (isset($_POST['allow'])) {
            $pid = $_POST['pid'];
            $sql = "UPDATE property SET status = 'Allow' WHERE pid = '$pid'";

            if (mysqli_query($conn, $sql)) {
                // Fetch user's email and send approval notification
                $email_query = "SELECT u.email,p.adress FROM tbl_users u JOIN property p ON u.id = p.uid WHERE p.pid = '$pid'";
                $email_result = mysqli_query($conn, $email_query);
                if ($email_row = mysqli_fetch_assoc($email_result)) {
                    $user_email = $email_row['email'];
                    $adress=$email_row['adress'];
                    sendApprovalEmail($user_email,$adress );
                }

                header("Location: admin_verify.php");
                ob_end_flush(); // Close the buffer
                exit;
            }
        } elseif (isset($_POST['deny'])) {
            $pid = $_POST['pid'];
            $sql = "UPDATE property SET status = 'Denied' WHERE pid = '$pid'";

            if (mysqli_query($conn, $sql)) {
                // Fetch user's email and send denial notification
                $email_query = "SELECT u.email,p.adress FROM tbl_users u JOIN property p ON u.id = p.uid WHERE p.pid = '$pid'";
                $email_result = mysqli_query($conn, $email_query);
                if ($email_row = mysqli_fetch_assoc($email_result)) {
                    $user_email = $email_row['email'];
                     $adress=$email_row['adress'];
                    sendDenialEmail($user_email, $adress);
                }

                header("Location: admin_verify.php");
                ob_end_flush(); // Close the buffer
                exit;
            }
        } elseif (isset($_POST['reallow'])) {
            $pid = $_POST['pid'];
            $sql = "UPDATE property SET status = 'Pending' WHERE pid = '$pid'";

            if (mysqli_query($conn, $sql)) {
                // Fetch the user's email and notify them
                $email_query = "SELECT u.email,p.adress FROM tbl_users u JOIN property p ON u.id = p.uid WHERE p.pid = '$pid'";
                $email_result = mysqli_query($conn, $email_query);
                
                if ($email_row = mysqli_fetch_assoc($email_result)) {
                    $user_email = $email_row['email'];
                        $adress=$email_row['adress'];
                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'ashishvaghasiya150@gmail.com';
                        $mail->Password = 'dnvjaacfmzrpovwi';
                        $mail->SMTPSecure = 'tls';
                        $mail->Port = 587;
                        $mail->setFrom('ashishvaghasiya150@gmail.com', 'RentEase');
                        $mail->addAddress($user_email);
                        $mail->isHTML(true);
                       
                        $mail->Subject = 'Property Ready for Update';
                       $mail->Body = "
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f9;
                margin: 0;
                padding: 0;
                color: #333333;
            }
            .container {
                max-width: 600px;
                margin: auto;
                padding: 20px;
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            .header {
                background-color: #FFA500;
                color: #ffffff;
                padding: 20px;
                text-align: center;
                font-size: 24px;
                font-weight: bold;
                border-top-left-radius: 8px;
                border-top-right-radius: 8px;
            }
            .content {
                padding: 20px;
                text-align: left;
            }
            .content h2 {
                color: #FFA500;
                font-size: 20px;
            }
            .content p {
                font-size: 16px;
                line-height: 1.6;
                margin: 10px 0;
            }
            .footer {
                text-align: center;
                padding: 15px;
                font-size: 14px;
                color: #888888;
            }
            .footer a {
                color: #FFA500;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                RentEase Property Update Notification
            </div>
            <div class='content'>
                <h2>Property Ready for Updates</h2>
                <p>Dear User,</p>
                <p>Your property  <strong>$adress</strong> is now ready for updates. You can update the property details and resubmit it for verification.</p>
                <p>We appreciate your continued partnership with us!</p>
                <p>Warm regards,<br>RentEase Team</p>
            </div>
            <div class='footer'>
                &copy; " . date("Y") . " RentEase. All rights reserved.<br>
                
            </div>
        </div>
    </body>
    </html>
";

                        $mail->send();
                    } catch (Exception $e) {
                        echo '<script>alert("Error: ' . $mail->ErrorInfo . '");</script>';
                    }
                }

                header("Location: admin_verify.php");
                ob_end_flush();
                exit;
            }
        }
        ?>
    </body>
</html>
