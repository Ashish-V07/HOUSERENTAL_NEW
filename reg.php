<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\XAMPP\htdocs\houserental-master\PHPMailer-master\src\PHPMailer.php';
require 'C:\XAMPP\htdocs\houserental-master\PHPMailer-master\src\Exception.php';
require 'C:\XAMPP\htdocs\houserental-master\PHPMailer-master\src\SMTP.php';

$otp_validity_duration = 60; // OTP validity duration in seconds (e.g., 60 seconds)
$otp_verified = false; // Flag to check if OTP is verified
$c = mysqli_connect('localhost', 'root', '', 'test');

// Check connection
if (!$c) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['generate_otp'])) {
        if (checkExistingUser($c, $_POST['email'], $_POST['aadhar'], $_POST['username'], $_POST['mobile_no'])) {
            storeFormData();
            sendotp();
        }
    } elseif (isset($_POST['verify_otp'])) {
        storeFormData();
        verifyotp();
    } elseif (isset($_POST['register'])) {
        if (isset($_SESSION['otp_verified']) && $_SESSION['otp_verified']) {
            if (checkExistingUser($c, $_POST['email'], $_POST['aadhar'], $_POST['username'], $_POST['mobile_no'])) {
                registerUser($c);
            }
        } else {
            echo '<script>alert("OTP verification required.");</script>';
        }
    }
}

function storeFormData() {
    $_SESSION['form_data'] = $_POST;
}

function checkExistingUser($c, $email, $aadhar, $username, $mobile) {
    $emailQuery = "SELECT * FROM tbl_users WHERE email = '$email'";
    $aadharQuery = "SELECT * FROM tbl_users WHERE aadhar = '$aadhar'";
    $usernameQuery = "SELECT * FROM tbl_users WHERE username = '$username'";
    $mobileQuery = "SELECT * FROM tbl_users WHERE mobile = $mobile";

    $emailResult = mysqli_query($c, $emailQuery);
    $aadharResult = mysqli_query($c, $aadharQuery);
    $usernameResult = mysqli_query($c, $usernameQuery);
    $mobileResult = mysqli_query($c, $mobileQuery);

    if (mysqli_num_rows($emailResult) > 0) {
        echo '<script>alert("Email already exists.");</script>';
        return false;
    }

    if (mysqli_num_rows($aadharResult) > 0) {
        echo '<script>alert("Aadhaar number already exists.");</script>';
        return false;
    }

    if (mysqli_num_rows($usernameResult) > 0) {
        echo '<script>alert("Username already exists.");</script>';
        return false;
    }

    if (mysqli_num_rows($mobileResult) > 0) {
        echo '<script>alert("Mobile number already exists.");</script>';
        return false;
    }

    return true;
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
        $mail->Password = 'lcebozebvastggsl'; // enter your email password
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

function registerUser($c) {
    $formData = $_SESSION['form_data'] ?? [];

    $first_name = $formData['first_name'] ?? '';
    $last_name = $formData['last_name'] ?? '';
    $mobile_no = $formData['mobile_no'] ?? '';
    $email = $formData['email'] ?? '';
    $dob = $formData['dob'] ?? '';
    $address = $formData['address'] ?? '';
    $username = $formData['username'] ?? '';
    $password = $formData['password'] ?? '';
    $aadhar = $formData['aadhar'] ?? '';

    // Simple query for insertion
    $query = "INSERT INTO tbl_users (fname, lname, mobile, email, dob, address, city, username, password, aadhar) 
              VALUES ('$first_name', '$last_name', $mobile_no, '$email', '$dob', '$address', '$city', '$username', '$password', '$aadhar')";

    if (mysqli_query($c, $query)) {
        echo '<script>alert("User registered successfully.");</script>';
        // Clear session variables after successful registration
        session_unset();
        session_destroy();
    } else {
        echo '<script>alert("Error: ' . mysqli_error($c) . '");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="UTF-8">
        <title>Responsive Registration Form | CodingLab</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Poppins', sans-serif;
            }
            body {
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 10px;
                background: linear-gradient(135deg, #71b7e6, #9b59b6);
                margin: 0;
            }
            .container {
                display: flex;
                max-width: 1200px;
                width: 100%;
                height: 80%;
                background-color: #fff;
                border-radius: 5px;
                box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
            }
            .image-section {
                flex: 1;
                background: url('hero-bg.jpg') no-repeat center center/cover;
                border-top-left-radius: 5px;
                border-bottom-left-radius: 5px;
            }
            .form-section {
                flex: 1;
                padding: 25px 30px;
                overflow-y: auto;
            }
            .form-section .title {
                font-size: 25px;
                font-weight: 500;
                position: relative;
            }
            .form-section .title::before {
                content: "";
                position: absolute;
                left: 0;
                bottom: 0;
                height: 3px;
                width: 30px;
                border-radius: 5px;
                background: linear-gradient(135deg, #71b7e6, #9b59b6);
            }
            .form-section .user-details {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                margin: 20px 0 12px 0;
            }
            .form-section form .user-details .input-box {
                margin-bottom: 15px;
                width: calc(50% - 10px); /* Adjusted width to make input fields smaller */
            }
            .form-section form .input-box span.details {
                display: block;
                font-weight: 500;
                margin-bottom: 5px;
            }
            .form-section .user-details .input-box input,
            .form-section .user-details .input-box textarea {
                height: 35px; /* Adjusted height to make input fields smaller */
                width: 100%;
                outline: none;
                font-size: 14px; /* Adjusted font size to make input fields smaller */
                border-radius: 5px;
                padding-left: 10px;
                border: 1px solid #ccc;
                border-bottom-width: 2px;
                transition: all 0.3s ease;
            }
            .form-section .user-details .input-box textarea {
                height: auto;
                padding-top: 10px;
                padding-bottom: 10px;
                resize: vertical;
            }
            .form-section .user-details .input-box input:focus,
            .form-section .user-details .input-box input:valid,
            .form-section .user-details .input-box textarea:focus,
            .form-section .user-details .input-box textarea:valid {
                border-color: #9b59b6;
            }
            .form-section form .gender-details .gender-title {
                font-size: 20px;
                font-weight: 500;
            }
            .form-section form .category {
                display: flex;
                width: 100%;
                margin: 14px 0;
                justify-content: space-between;
            }
            .form-section form .category label {
                display: flex;
                align-items: center;
                cursor: pointer;
            }
            .form-section form .category label .dot {
                height: 18px;
                width: 18px;
                border-radius: 50%;
                margin-right: 10px;
                background: #d9d9d9;
                border: 5px solid transparent;
                transition: all 0.3s ease;
            }
            #dot-1:checked ~ .form-section .category label:nth-child(1) .dot,
            #dot-2:checked ~ .form-section .category label:nth-child(2) .dot {
                background: #9b59b6;
                border-color: #9b59b6;
            }
            .form-section form .button {
                margin: 35px 0;
            }
            .form-section form .button input {
                height: 45px;
                width: 100%;
                border: none;
                outline: none;
                color: #fff;
                font-size: 16px;
                background: linear-gradient(135deg, #71b7e6, #9b59b6);
                cursor: pointer;
                border-radius: 5px;
            }
            .form-section form .button input:hover {
                background: #9b59b6;
            }
            input[type="text"] {
                width: 100%;
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 5px;
            }
            #otp-section {
                display: block;
            }
            #timer {
                font-size: 18px;
                font-weight: bold;
                color: #ff0000;
            }
        </style>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div class="container">
            <div class="image-section">
                <div style="color: #fff; padding: 20px;">
                    <h1>Welcome</h1>
                    <p>Register to access our services.</p>
                </div>
            </div>
            <div class="form-section">
                <div class="title">Registration</div>
                <div class="content">
                    <form action="#" method="post">
                        <div class="user-details">
                            <div class="input-box">
                                <span class="details">First Name</span>
                                <input type="text" name="first_name"  required>
                            </div>
                            <div class="input-box">
                                <span class="details">Last Name</span>
                                <input type="text" name="last_name" required>
                            </div>
                            <div class="input-box">
                                <span class="details">Mobile No</span>
                                <input type="text" name="mobile_no" required>
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
                                <span class="details">Aadhar</span>
                                <input type="text" name="aadhar" required>
                            </div>
                            <div class="input-box">
                                <span class="details">Address</span>
                                <textarea name="address" required></textarea>
                            </div>
                            <div class="input-box">
                                <span class="details">City</span>
                                <input type="text" name="city" required>
                            </div>
                            <div class="input-box">
                                <span class="details">Username</span>
                                <input type="text" name="username" required>
                            </div>
                            <div class="input-box">
                                <span class="details">Password</span>
                                <input type="password" name="password" required>
                            </div>
                        </div>
                        <div class="button" colspan="2">
                            <input type="submit" name="generate_otp" value="Generate OTP">
                        </div>
                        <?php if (isset($_SESSION['otp'])): ?>
                            <div id="otp-section">
                                <div class="input-box">
                                    <span class="details">Enter OTP</span>
                                    <input type="text" name="otp" id="otp" maxlength="6" minlength="6">
                                </div>
                                <div class="button">
                                    <input type="submit" name="verify_otp" value="Verify OTP">
                                </div>
                                <div class="input-box">
                                    <span class="details">OTP Expiry Time</span>
                                    <div id="timer">00:00</div> <!-- Display timer here -->
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['otp_verified']) && $_SESSION['otp_verified']): ?>
                            <div class="button">
                                <input type="submit" name="register" value="Register">
                            </div>
                        <?php endif; ?>

                    </form>
                </div>
            </div>
        </div>

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
                        timer = 0;
                        clearInterval(timerInterval);
                    }
                }, 1000);
            }

            window.onload = function () {
<?php if (isset($_SESSION['otp_expiry_time'])): ?>
                    var expiryTime = <?php echo $_SESSION['otp_expiry_time'] - time(); ?>;
                    if (expiryTime > 0) {
                        var display = document.querySelector('#timer');
                        startTimer(expiryTime, display);
                    } else {
                        document.querySelector('#timer').textContent = "00:00";
                    }
<?php endif; ?>
            };
        </script>
    </body>
</html>

