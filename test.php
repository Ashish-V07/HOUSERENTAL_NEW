<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'D:\xampp\htdocs\house\phpmailer\src\PHPMailer.php';
require 'D:\xampp\htdocs\house\phpmailer\src\Exception.php';
require 'D:\xampp\htdocs\house\phpmailer\src\SMTP.php';


$otp_validity_duration = 60; // OTP validity duration in seconds (e.g., 60 seconds)
$otp_verified = false; // Flag to check if OTP is verified
$c = mysqli_connect('localhost', 'root', '', '');

// Check connection
if (!$c) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['generate_otp'])) {
        if (checkExistingUser($c, $_POST['email'], $_POST['aadhar'], $_POST['mobile_no'])) {
            if (passwordsMatch($_POST['password'], $_POST['cpassword'])) {
                storeFormData();
                sendotp();
            } else {
                echo '<script>alert("Passwords do not match. Please check again.");</script>';
                storeFormData();
            }
        }
    } elseif (isset($_POST['verify_otp'])) {
        storeFormData();
        verifyotp();
    } elseif (isset($_POST['register'])) {
        if (isset($_SESSION['otp_verified']) && $_SESSION['otp_verified']) {
            storeFormData();
            registerUser($c);
            session_unset();
            session_destroy();
            header("Location: login.php");
            exit();
        } else {
            echo '<script>alert("OTP verification required.");</script>';
        }
    }
}

function storeFormData() {
    $_SESSION['form_data'] = $_POST;
}

function sendotp() {
    try {
        $recipient_email = $_POST['email'];
        $otp = mt_rand(100000, 999999);
        $otp_generation_time = time();

        $mail = new PHPMailer(true);

        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = '22bmiit009@gmail.com'; // enter your email address
        $mail->Password = 'lpfomeqdeegfncar'; // enter your email password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Sender and recipient
        $mail->setFrom('22bmiit009@gmail.com', 'House');
        $mail->addAddress($recipient_email);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'OTP for registration';
        $mail->Body = 'Your OTP is: ' . $otp;

        // Send email
        $mail->send();

        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $recipient_email;
        $_SESSION['otp_generation_time'] = $otp_generation_time;
        $_SESSION['otp_expiry_time'] = $otp_generation_time + $GLOBALS['otp_validity_duration']; // Calculate OTP expiry time
        echo '<script>alert("OTP has been sent to your email.");</script>';
    } catch (Exception $e) {
        echo '<script>alert("Message could not be sent. Mailer Error: ' . $mail->ErrorInfo . '");</script>';
    }
}

function verifyotp() {
    $user_otp = $_POST['otp'];
    $session_otp = $_SESSION['otp'] ?? '';
    $current_time = time();

    if ($current_time > ($_SESSION['otp_expiry_time'] ?? 0)) {
        echo '<script>alert("OTP has expired. Please generate a new OTP.");</script>';
        unset($_SESSION['otp']);
        unset($_SESSION['otp_generation_time']);
        unset($_SESSION['otp_expiry_time']);
    } elseif ($user_otp == $session_otp) {
        echo '<script>alert("OTP verification successful!");</script>';
        $_SESSION['otp_verified'] = true;
        // Save updated form data
        storeFormData();
    } else {
        echo '<script>alert("OTP verification failed. Please try again.");</script>';
    }
}

function passwordsMatch($password, $cpassword) {
    return $password === $cpassword;
}

function registerUser($c) {
    $formData = $_SESSION['form_data'] ?? [];

    $first_name = $formData['first_name'] ?? '';
    $last_name = $formData['last_name'] ?? '';
    $mobile_no = $formData['mobile_no'] ?? '';
    $email = $formData['email'] ?? '';
    $dob = $formData['dob'] ?? '';
    $adhar = $formData['aadhar'] ?? '';
    $address = $formData['address'] ?? '';
    $password = $formData['password'] ?? '';
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Simple query for insertion
    $query = "INSERT INTO tbl_users (fname, lname, mobile, email, dob, aadhar, address, password) 
              VALUES ('$first_name', '$last_name', $mobile_no, '$email', '$dob', '$adhar', '$address', '$hashed_password')";

    if (mysqli_query($c, $query)) {
        echo '<script>alert("User registered successfully.");</script>';
        // Redirect to home page after successful registration
        header("Location: home.php");
    } else {
        echo '<script>alert("Error: ' . mysqli_error($c) . '");</script>';
    }
}

function checkExistingUser($c, $email, $aadhar, $mobile) {
    $emailQuery = "SELECT * FROM tbl_users WHERE email = '$email'";
    $aadharQuery = "SELECT * FROM tbl_users WHERE aadhar = '$aadhar'";
    $mobileQuery = "SELECT * FROM tbl_users WHERE mobile = $mobile";

    $emailResult = mysqli_query($c, $emailQuery);
    $aadharResult = mysqli_query($c, $aadharQuery);
    $mobileResult = mysqli_query($c, $mobileQuery);

    if (mysqli_num_rows($emailResult) > 0) {
        echo '<script>alert("Email already exists.");</script>';
        return false;
    }

    if (mysqli_num_rows($aadharResult) > 0) {
        echo '<script>alert("Aadhaar number already exists.");</script>';
        return false;
    }

    if (mysqli_num_rows($mobileResult) > 0) {
        echo '<script>alert("Mobile number already exists.");</script>';
        return false;
    }

    return true;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registration</title>
        <link href="regstyle.css" rel="stylesheet" />

<!--        <style>
           
        </style>-->
    </head>
    <body>
        <div class="container">
            <div class="image-section"></div>
            <div class="form-section">
                <div class="title">Registration</div>
                <form method="POST" action="">
                    <div class="user-details">
                        <div class="input-box">
                            <span class="details">First Name</span>
                            <input type="text" name="first_name" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Last Name</span>
                            <input type="text" name="last_name" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Mobile Number</span>
                            <input type="tel" name="mobile_no" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Email</span>
                            <input type="email" name="email" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Date of Birth</span>
                            <input type="date" name="dob" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Aadhar Number</span>
                            <input type="text" name="aadhar" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Address</span>
                            <input type="text" name="address" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Password</span>
                            <input type="password" name="password" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Confirm Password</span>
                            <input type="password" name="cpassword" required>
                        </div>
                        <div class="input-box" id="otp-container" style="display: none;">
                            <span class="details">Enter OTP</span>
                            <input type="text" name="otp" id="otp" required>
                        </div>
                    </div>
                    <div class="button">
                        <input type="submit" name="generate_otp" value="Generate OTP" id="generate_otp">
                        <input type="submit" name="verify_otp" value="Verify OTP" id="verify_otp" style="display: none;">
                        <input type="submit" name="register" value="Register" id="register" style="display: none;">
                    </div>
                </form>
            </div>
        </div>
        <script>
            document.getElementById('generate_otp').addEventListener('click', function() {
                document.getElementById('otp-container').style.display = 'block';
                document.getElementById('verify_otp').style.display = 'inline';
            });

            document.getElementById('verify_otp').addEventListener('click', function() {
                document.getElementById('register').style.display = 'inline';
            });
        </script>
    </body>
</html>