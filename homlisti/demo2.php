<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'C:\XAMPP\htdocs\houserental-master\PHPMailer-master\src\PHPMailer.php';
require 'C:\XAMPP\htdocs\houserental-master\PHPMailer-master\src\Exception.php';
require 'C:\XAMPP\htdocs\houserental-master\PHPMailer-master\src\SMTP.php';

if (isset($_SESSION['ARMSG'])) {
    echo "<script>alert('". addslashes($_SESSION['ARMSG']) ."');</script>";
    unset($_SESSION['ARMSG']); // Clear the message after displaying
}
// Redirect to login if not logged in
if (!isset($_SESSION['loggedin'])) {
    header("Location: /houserental-master/homlisti/my-account/index.php");
    exit();
}
if (isset($_SESSION['MMSG'])) {
    echo "<script>alert('". addslashes($_SESSION['MMSG']) ."');</script>";
    unset($_SESSION['MMSG']);
}
$email = $_SESSION['email']; // Logged-in owner's email

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "house_rental";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch owner ID based on logged-in email
$ownerQuery = "SELECT id FROM tbl_users WHERE email = '$email'";
$ownerResult = $conn->query($ownerQuery);
if ($ownerResult->num_rows == 1) {
    $owner = $ownerResult->fetch_assoc();
    $loggedInOwnerId = $owner['id'];
} else {
    echo "<script>alert('Owner not found. Please log in again.');</script>";
    exit();
}

// Fetch maintenance requests for the properties owned by the logged-in owner
$requestQuery = "
    SELECT tm.RID,p.adress, tm.Issue, tm.Status, tm.RequestDATE, tm.McID, 
           p.adress, tu.email, tu.fname, mc.NAME AS MaintananceCategory 
    FROM tblMaintanance tm
    INNER JOIN property p ON tm.PID = p.pid
    INNER JOIN tbl_users tu ON tm.TID = tu.id
    INNER JOIN tblMaintananceCategory mc ON tm.McID = mc.ID
    WHERE p.uid = '$loggedInOwnerId'
";
$requestResult = $conn->query($requestQuery);

// Handle owner action (Accept/Reject)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $requestID = $_POST['request_id'];
    $action = $_POST['action']; // 'Accepted' or 'Rejected'

    // Update request status
    $updateQuery = "UPDATE tblMaintanance SET Status = '$action' WHERE RID = '$requestID'";
    if ($conn->query($updateQuery) === TRUE) {
        // Fetch tenant email for notification
        $emailQuery = "
            SELECT tu.email 
            FROM tblMaintanance tm
            INNER JOIN tbl_users tu ON tm.TID = tu.id
            WHERE tm.RID = '$requestID'
        ";
        $emailResult = $conn->query($emailQuery);
        if ($emailResult->num_rows == 1) {
            $tenant = $emailResult->fetch_assoc();
            $tenantEmail = $tenant['email'];
            $adress=$_POST['address'];
            $type=$_POST['type'];
            // Send email notification using PHPMailer
            $mail = new PHPMailer(true);
            try {
                // SMTP configuration
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Use your SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'ashishvaghasiya150@gmail.com'; // Your email
                $mail->Password = 'dnvjaacfmzrpovwi'; // Your email password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Sender and recipient settings
                $mail->setFrom('ashishvaghasiya150@gmail.com', 'RentEase');
                $mail->addAddress($tenantEmail); // Add tenant's email address

                // Email subject and body
                $mail->isHTML(true);
                $mail->Subject = 'Maintenance Request Update';
                $mail->Body = "
    <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; border: 1px solid #ddd; border-radius: 8px; padding: 20px; background-color: #f9f9f9;'>
        <h2 style='text-align: center; color: #007bff;'>Maintenance Request Update</h2>

        <p style='font-size: 16px;'>
            Dear Valued Tenant,
        </p>

        <p style='font-size: 14px;'>
            We hope this email finds you well. We are writing to inform you about the status of your maintenance request for the property located at:
        </p>

        <table style='width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 14px;'>
            <tr>
                <td style='padding: 8px; border: 1px solid #ddd; background-color: #f1f1f1; font-weight: bold;'>Address:</td>
                <td style='padding: 8px; border: 1px solid #ddd;'>$adress</td>
            </tr>
            <tr>
                <td style='padding: 8px; border: 1px solid #ddd; background-color: #f1f1f1; font-weight: bold;'>Request Type:</td>
                <td style='padding: 8px; border: 1px solid #ddd;'>$type</td>
            </tr>
            <tr>
                <td style='padding: 8px; border: 1px solid #ddd; background-color: #f1f1f1; font-weight: bold;'>Status:</td>
                <td style='padding: 8px; border: 1px solid #ddd; color: #$statusColor;'>$action</td>
            </tr>
        </table>

        <p style='font-size: 14px;'>
            After reviewing your request, we would like to notify you that the status has been updated to <strong style='color: #007bff;'>$action</strong>.
        </p>

        <p style='font-size: 14px;'>
            We appreciate your patience and understanding as we strive to ensure the best living experience for you. If you have any further concerns or questions, please do not hesitate to contact us at 
            <a href='mailto:ashishvaghasiya150@gmail.com' style='color: #007bff;'>ashishvaghasiya150@gmail.com</a>.
        </p>

        <p style='font-size: 14px;'>
            Thank you for choosing <strong>RentEase</strong> for your housing needs.
        </p>

        <p style='font-size: 14px; text-align: center;'>
            Best regards,<br>
            <strong>RentEase Support Team</strong>
        </p>

        <div style='text-align: center; font-size: 12px; margin-top: 20px; color: #777;'>
            <p>This is an automated message. Please do not reply directly to this email.</p>
        </div>
    </div>
";

                // Send email
                $mail->send();
                $_SESSION['ARMSG'] = "Request $action successfully, and tenant has been notified.";
                header("Location: " . $_SERVER['PHP_SELF']); // Reload the page
                exit();
                } catch (Exception $e) {
                echo "<script>alert('Request $action, but email could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
            }
        }
    } else {
        echo "<script>alert('Error updating request status: " . $conn->error . "');</script>";
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Maintenance Requests</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Sidebar styles */
        .sidebar {
            width: 220px; /* Fixed width for sidebar */
            height: 100vh; /* Full height */
            position: fixed; /* Sticks to the left */
            top: 0;
            left: 0;
            background-color: #343a40; /* Dark background color */
            color: #fff; /* White text */
            padding: 20px;
            overflow-y: auto; /* Add scroll for long content */
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

        /* Main content styles */
        .container {
            margin-left: 240px; /* Matches the sidebar width + some spacing */
            padding: 20px;
        }

        /* Table styles */
        table {
            width: 100%; /* Ensure table spans the entire width */
            overflow-x: auto; /* Scrollable table if content overflows */
        }
           .rating-button-container {
            display: flex;
            justify-content: flex-end; /* Align the button to the right */
            margin-bottom: 10px; /* Add some space below the button */
        }

        .rating-button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            margin-right:30px; 
            margin-top: 20px;
        }

        .rating-button:hover {
            background-color: lightgrey;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <ul>
            <li><a href="NEWDashboard.php">Home</a></li>
            <li><a href="Profile.php">Profile Overview</a></li>
            <li><a href="Profile1.php">Update Profile</a></li>
            <li><a href="home.php">My Properties</a></li>
            <li><a href="demo2.php">Maintenance</a></li>
            <li><a href="Payment.php">Payments</a></li>
            <li><a href="changePassword.php">Change Password</a></li>
            <li><a href="/houserental-master/homlisti/my-account/logout.php">Logout</a></li>
        </ul>
    </div>
<div class="rating-button-container">
        <!-- Button redirects to the Rating page -->
        <a href="demo.php" class="rating-button">Maintenance Request</a>
    </div>
    <!-- Main Content -->
    <div class="container">
        <h2>Manage Maintenance Requests</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Property Address</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Tenant</th>
                    <th>Request Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($requestResult->num_rows > 0) {
                    while ($row = $requestResult->fetch_assoc()) {
                        echo "
                            <tr>
                                <td>{$row['RID']}</td>
                                <td>{$row['adress']}</td>
                                <td>{$row['Issue']}</td>
                                <td>{$row['MaintananceCategory']}</td>
                                <td>{$row['fname']}</td>
                                <td>{$row['RequestDATE']}</td>
                                <td>{$row['Status']}</td>
                                <td>
                                    <form method='POST' action=''  style='display: flex; gap: 10px; align-items: center;'>
                                        <input type='hidden' name='request_id' value='{$row['RID']}'>
                                         <input type='hidden' name='address' value='{$row['adress']}'>
                                              <input type='hidden' name='type' value='{$row['MaintananceCategory']}'>
                                        <button name='action' value='Accepted' class='btn btn-success btn-sm'>Accept</button>
                                        <button name='action' value='Rejected' class='btn btn-danger btn-sm'>Reject</button>
                                    </form>
                                </td>
                            </tr>
                        ";
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center'>No maintenance requests available.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
