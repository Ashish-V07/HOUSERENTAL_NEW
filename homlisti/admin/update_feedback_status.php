<?php
include 'db_connection.php';
use PHPMailer\PHPMailer\PHPMailer;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fid = $_POST['fid'];
    $uid = $_POST['uid'];

    // Update the feedback status to 'done'
    $sql = "UPDATE tblfeedback SET status = 'DONE' WHERE fid = '$fid'";
    if (mysqli_query($conn, $sql)) {
        // Fetch the user's email to send the notification
        $userSql = "SELECT email FROM tbl_users WHERE id = $uid";
        $userResult = mysqli_query($conn, $userSql);
        if (mysqli_num_rows($userResult) > 0) {
            $user = mysqli_fetch_assoc($userResult);
            $email = $user['email'];

            // Send email using PHPMailer
            sendMail($email, $fid);
            
            echo 'success';
        } else {
            echo 'User not found.';
        }
    } else {
        echo 'Error updating feedback status.';
    }

    mysqli_close($conn);
}

function sendMail($recipient_email, $fid) 
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
        $mail->Subject = "Feedback Status Updated";
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
                RentEase Feedback Update
            </div>
            <div class='content'>
                <h2>Feedback Status Updated</h2>
                <p>Dear User,</p>
                <p>Your feedback (ID: <strong>$fid</strong>) has been marked as <strong>done</strong>.</p>
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
