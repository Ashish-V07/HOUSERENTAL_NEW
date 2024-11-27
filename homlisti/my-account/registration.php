<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\XAMPP\htdocs\houserental-master\PHPMailer-master\src\PHPMailer.php';
require 'C:\XAMPP\htdocs\houserental-master\PHPMailer-master\src\Exception.php';
require 'C:\XAMPP\htdocs\houserental-master\PHPMailer-master\src\SMTP.php';

$otp_validity_duration = 60; // OTP validity duration in seconds (e.g., 60 seconds)
$otp_verified = false; // Flag to check if OTP is verified
$c = mysqli_connect('localhost', 'root', '', 'house_rental');

// Check connection 
if (!$c) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['generate_otp'])) {
        if (checkExistingUser($c, $_POST['email'])) {
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
            header("Location: index.php");
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
        $mail->Username = 'ashishvaghasiya150@gmail.com'; // enter your email address
        $mail->Password = 'dnvjaacfmzrpovwi'; // enter your email password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Sender and recipient
        $mail->setFrom('ashishvaghasiya150@gmail.com', 'RentEase');
        $mail->addAddress($recipient_email);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'OTP for registration';
        $mail->Body = "
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f7f7f7;
                margin: 0;
                padding: 0;
                color: #333333;
            }
            .container {
                max-width: 500px;
                margin: auto;
                padding: 20px;
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            .header {
                background-color: #5A9BD5;
                color: #ffffff;
                padding: 20px;
                text-align: center;
                font-size: 22px;
                font-weight: bold;
                border-top-left-radius: 8px;
                border-top-right-radius: 8px;
            }
            .content {
                padding: 20px;
                text-align: center;
            }
            .content p {
                font-size: 16px;
                line-height: 1.6;
                margin: 10px 0;
            }
            .otp-box {
                font-size: 24px;
                color: #5A9BD5;
                font-weight: bold;
                padding: 10px;
                border: 1px dashed #5A9BD5;
                display: inline-block;
                margin-top: 10px;
            }
            .footer {
                text-align: center;
                padding: 15px;
                font-size: 14px;
                color: #888888;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                RentEase OTP Verification
            </div>
            <div class='content'>
                <p>Dear User,</p>
                <p>Your One-Time Password (OTP) for registration is:</p>
                <div class='otp-box'>$otp</div>
                <p>Please enter this OTP to complete your registration. This OTP is valid for a limited time.</p>
            </div>
            <div class='footer'>
                &copy; " . date("Y") . " RentEase. All rights reserved.
            </div>
        </div>
    </body>
    </html>
";


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
    $email = $formData['email'] ?? '';
    $password = $formData['password'] ?? '';

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO tbl_users (fname, lname, email, password) 
              VALUES ('$first_name', '$last_name', '$email', '$hashed_password')";

    if (mysqli_query($c, $query)) {
        $_SESSION['RMSG'] = "User registered successfully.";
        header("Location: index.php");
    } else {
        echo '<script>alert("Error: ' . mysqli_error($c) . '");</script>';
    }
}

function checkExistingUser($c, $email) {
    $emailQuery = "SELECT * FROM tbl_users WHERE email = '$email'";
    $emailResult = mysqli_query($c, $emailQuery);

    if (mysqli_num_rows($emailResult) > 0) {
        echo '<script>alert("Email already exists.");</script>';
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
    <link href="regstyle.css" rel="stylesheet"/>

    <script>
        var timerInterval;

        function startTimer(duration, display) {
            var timer = duration, minutes, seconds;
            timerInterval = setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    clearInterval(timerInterval);
                    alert("OTP has expired. Please generate a new one.");
                }
            }, 1000);
        }

        function validateName(input) {
            input.value = input.value.replace(/[^A-Za-z]/g, '');
        }

        window.onload = function () {
            <?php if (!$otp_verified && isset($_SESSION['otp_expiry_time'])): ?>
                var remainingTime = <?php echo $_SESSION['otp_expiry_time'] - time(); ?>;
                var display = document.querySelector('#timer');
                startTimer(remainingTime, display);
            <?php endif; ?>

            document.getElementById('first_name').addEventListener('input', function (event) {
                validateName(event.target);
            });

            document.getElementById('last_name').addEventListener('input', function (event) {
                validateName(event.target);
            });

            document.querySelector('form').addEventListener('submit', function (event) {
                var email = document.getElementById('email').value;
                var password = document.getElementById('password').value;
                var cpassword = document.getElementById('cpassword').value;

                var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                var passwordPattern = /^(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{6,}$/;

                if (!emailPattern.test(email)) {
                    alert('Please enter a valid email address.');
                    event.preventDefault();
                    return;
                }

                if (!passwordPattern.test(password)) {
                    alert('Password must be at least 6 characters long and include at least one special character.');
                    event.preventDefault();
                    return;
                }

                if (password !== cpassword) {
                    alert('Passwords do not match. Please try again.');
                    event.preventDefault();
                    return;
                }
            });
        };
    </script>
</head>
<body>

<div class="container">
    <div class="image-section">
        <div class="welcome-text">
            <h1>Welcome</h1>
            <p>Register to access our services.</p>
            <video autoplay loop muted style="width: 100%; height: 100%; object-fit: cover;">
                <source src="path-to-your-video.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>
    <div class="form-section">
        <div class="title">Registration</div>
        <div class="content">
            <form action="#" method="post">
                <div class="user-details">
                    <div class="input-box">
                        <label class="details" for="first_name">First Name:</label>
                        <input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($_SESSION['form_data']['first_name'] ?? ''); ?>" required>
                    </div>
                    <div class="input-box">
                        <label class="details" for="last_name">Last Name:</label>
                        <input type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($_SESSION['form_data']['last_name'] ?? ''); ?>" required>
                    </div>
                    <div class="input-box">
                        <label class="details" for="email">Email:</label>
                        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($_SESSION['form_data']['email'] ?? ''); ?>" required>
                    </div>
                    <div class="input-box">
                        <label class="details" for="password">Password:</label>
                        <input type="password" name="password" id="password" value="<?php echo htmlspecialchars($_SESSION['form_data']['password'] ?? ''); ?>" required>
                    </div>
                    <div class="input-box">
                        <label class="details" for="cpassword">Confirm Password:</label>
                        <input type="password" name="cpassword" id="cpassword" value="<?php echo htmlspecialchars($_SESSION['form_data']['cpassword'] ?? ''); ?>" required>
                    </div>
                </div>

                <div class="button">
                    <input type="submit" name="generate_otp" value="Generate OTP">
                </div>

                <?php if (isset($_SESSION['otp'])): ?>
                    <div class="otp-section">
                        <div class="input-box">
                            <label for="otp">Enter OTP:</label>
                            <input type="text" name="otp" id="otp" >
                        </div>
                        <div id="timer"></div>
                        <div class="button">
                            <input type="submit" name="verify_otp" value="Verify OTP">
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['otp_verified']) && $_SESSION['otp_verified']): ?>
                    <div class="button">
                        <input type="submit" name="register" value="Register">
                    </div>
                <?php endif; ?>
            </form>
            <p>Alredy have an account?, <a href="index.php">Login here</a></p>
                                                                    
        </div>
    </div>
</div>

</body>
</html>
