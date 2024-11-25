<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = $_POST['request_id'];
    $action = $_POST['action'];
    $pid = $_POST['Property_id'];
    
    // Connect to the database
    $conn = mysqli_connect('localhost', 'root', '', 'house_rental');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($action == 'accept') {
        // Accept the request and reject others for the same property
        $accept_query = "UPDATE rental_applications SET status = 'Accepted' WHERE user_id = '$request_id'";
        $PUpadte_query="UPDATE property SET AvailabilityStatus = 'Booked' WHERE  pid= '$pid'";
        $email_query="select u.email,r.property_id from tbl_users u inner join rental_applications r on u.id=r.user_id where u.id='$request_id'";
       $Aemail= mysqli_query($conn, $email_query);
       $res= mysqli_fetch_assoc($Aemail);
       $sendemail=$res['email'];
       $prid=$res['property_id'];
       $t='Accepted';
       sendMail($sendemail,$t,$prid);
       
        if (mysqli_query($conn, $accept_query) && mysqli_query($conn,$PUpadte_query)) {
            // Find the property ID associated with this request
            $property_query = "SELECT property_id FROM rental_applications WHERE user_id = '$request_id'";
            $property_result = mysqli_query($conn, $property_query);
            $property_row = mysqli_fetch_assoc($property_result);
            $property_id = $property_row['property_id'];

            // Reject other requests for the same property
            $reject_query = "UPDATE rental_applications SET status = 'Rejected' 
                             WHERE property_id = '$property_id' AND user_id != '$request_id'";
            mysqli_query($conn, $reject_query);

            $_SESSION['msg'] = "Request accepted and others rejected.";
        } else {
            $_SESSION['msg'] = "Error accepting the request: " . mysqli_error($conn);
        }
    } elseif ($action === 'reject') {
        // Reject the specific request
        $reject_query = "UPDATE rental_applications SET status = 'Rejected' WHERE user_id = '$request_id'";
       $email_query="select u.email,r.property_id from tbl_users u inner join rental_applications r on u.id=r.user_id where u.id='$request_id'";
        $Remail= mysqli_query($conn, $email_query);
        
        $res= mysqli_fetch_assoc($Remail);
       $sendemail=$res['email'];
      
       $prid=$res['property_id'];
      $t='Rejected';
        sendMail($sendemail,$t,$prid);
        
        if (mysqli_query($conn, $reject_query)) {
            $_SESSION['msg'] = "Request rejected successfully.";
        } else {
            $_SESSION['msg'] = "Error rejecting the request: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['msg'] = "Invalid action.";
    }

   
    // Redirect back to the dashboard or requests page
    header("Location: /houserental-master/homlisti/NEWDashboard.php");
    exit();
}
function sendMail($recipient_email,$type,$propertyid) 
{


require 'C:\XAMPP\htdocs\houserental-master\PHPMailer-master\src\PHPMailer.php';
require 'C:\XAMPP\htdocs\houserental-master\PHPMailer-master\src\Exception.php';
require 'C:\XAMPP\htdocs\houserental-master\PHPMailer-master\src\SMTP.php';


    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ashishvaghasiya150@gmail.com'; // Enter your email
        $mail->Password = 'dnvjaacfmzrpovwi'; // Enter your email password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Sender and recipient
        $mail->setFrom('ashishvaghasiya150@gmail.com', 'RentEase');
        $mail->addAddress($recipient_email);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "About Rental Request";
        $mail->Body ="
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
                background-color: #2e86de;
                color: #ffffff;
                padding: 20px;
                border-top-left-radius: 8px;
                border-top-right-radius: 8px;
                text-align: center;
                font-size: 24px;
                font-weight: bold;
            }
            .content {
                padding: 20px;
                text-align: center;
            }
            .content h2 {
                color: #2e86de;
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
                color: #2e86de;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                RentEase Rental Request
            </div>
            <div class='content'>
                <h2></h2>
                <p>Dear User,</p>
                <p>Your Rental request has been marked as <strong>$type</strong> for property id  <strong>$propertyid</strong> .</p>
                <p>Thank you for helping us improve our service!</p>
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
        echo 'Email has been sent.';
    } catch (Exception $e) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
}
?>
