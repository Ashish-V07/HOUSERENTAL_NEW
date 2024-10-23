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
        $mail->Body = "Dear User, your feedback (ID: $fid) has been marked as done.";

        // Send email
        $mail->send();
        echo 'Email has been sent.';
    } catch (Exception $e) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
}
?>
