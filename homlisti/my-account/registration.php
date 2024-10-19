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
        // Check if the user already exists before generating OTP
        if (!checkExistingUser($c, $_POST['email'], $_POST['aadhar'], $_POST['mobile_no'])) {
            storeFormData();
            sendotp();
        }
    } elseif (isset($_POST['verify_otp'])) {
        storeFormData();
        verifyotp();
    } elseif (isset($_POST['register'])) {
        if (isset($_SESSION['otp_verified']) && $_SESSION['otp_verified']) {
            storeFormData();
            if (passwordsMatch()) {
                // No need to check if the user exists again, as it's already done during OTP generation
                registerUser($c);
                session_unset();
                session_destroy();
                header("Location: index.php");
                exit();
            } else {
                echo '<script>alert("Passwords do not match. Please check again.");</script>';
                storeFormData();
            }
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
        storeFormData();
    } else {
        echo '<script>alert("OTP verification failed. Please try again.");</script>';
    }
}

function passwordsMatch() {
    $formData = $_SESSION['form_data'] ?? [];
    $password = $formData['password'] ?? '';
    $cpassword = $formData['cpassword'] ?? '';
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

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO tbl_users (fname, lname, mobile, email, dob, aadhar, address, password) 
              VALUES ('$first_name', '$last_name', $mobile_no, '$email', '$dob', '$adhar', '$address', '$hashed_password')";

    if (mysqli_query($c, $query)) {
        echo '<script>alert("User registered successfully.");</script>';
        $_SESSION['email'] = $email; // Set session email
        header("Location: index.php");
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
        return true;
    }

    if (mysqli_num_rows($aadharResult) > 0) {
        echo '<script>alert("Aadhaar number already exists.");</script>';
        return true;
    }

    if (mysqli_num_rows($mobileResult) > 0) {
        echo '<script>alert("Mobile number already exists.");</script>';
        return true;
    }

    return false;
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
            var timerInterval; // Global variable for timer interval ID

            function startTimer(duration, display) {
                var timer = duration, minutes, seconds;
                timerInterval = setInterval(function () {
                    minutes = parseInt(timer / 60, 10);
                    seconds = parseInt(timer % 60, 10);

                    minutes = minutes < 10 ? "0" + minutes : minutes;
                    seconds = seconds < 10 ? "0" + seconds : seconds;

                    display.textContent = minutes + ":" + seconds;

                    if (--timer < 0) {
                        clearInterval(timerInterval); // Stop the timer when it reaches zero
                        alert("OTP has expired. Please generate a new one.");
                        // Optionally, you can disable the OTP input field or take other actions here
                    }
                }, 1000);
            }

            function validateMobileNo(input) {
                // Allow only digits (remove non-digit characters)
                input.value = input.value.replace(/\D/g, '');
            }

            function validateName(input) {
                // Allow only alphabetic characters
                input.value = input.value.replace(/[^A-Za-z]/g, '');
            }

            function validateDate(input) {
                var selectedDate = new Date(input.value);
                var today = new Date();
                var age = today.getFullYear() - selectedDate.getFullYear();
                var month = today.getMonth() - selectedDate.getMonth();

                if (month < 0 || (month === 0 && today.getDate() < selectedDate.getDate())) {
                    age--;
                }

                var oldestDate = new Date();
                oldestDate.setFullYear(today.getFullYear() - 100); // 100 years ago

                if (selectedDate > today) {
                    alert("Date cannot be in the future.");
                    input.value = ''; // Clear the input if invalid
                    return;
                }

                if (selectedDate < oldestDate) {
                    alert("This date is not eligible for registration.");
                    input.value = ''; // Clear the input if invalid
                    return;
                }

                if (age < 18) {
                    alert("You must be at least 18 years old.");
                    input.value = ''; // Clear the input if invalid
                    return;
                }
            }

            window.onload = function () {
<?php if (!$otp_verified && isset($_SESSION['otp_expiry_time'])): ?>
                    var fiveMinutes = <?php echo $_SESSION['otp_expiry_time'] - time(); ?>;
                    var display = document.querySelector('#timer');
                    startTimer(fiveMinutes, display);
<?php endif; ?>

                // Attach event listener to the date input field
                document.getElementById('dob').addEventListener('change', function (event) {
                    validateDate(event.target);
                });

                // Attach input validation for first and last names
                document.getElementById('first_name').addEventListener('input', function (event) {
                    validateName(event.target);
                });

                document.getElementById('last_name').addEventListener('input', function (event) {
                    validateName(event.target);
                });

                // Validate mobile number input
                document.getElementById('mobile_no').addEventListener('input', function (event) {
                    validateMobileNo(event.target);
                });

                // Form submission validation
                document.querySelector('form').addEventListener('submit', function (event) {
                    var email = document.getElementById('email').value;
                    var password = document.getElementById('password').value;

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
                                <label class="details" for="mobile_no">Mobile No.:</label>
                                <input type="text" name="mobile_no" id="mobile_no" maxlength="10" minlength="10" value="<?php echo htmlspecialchars($_SESSION['form_data']['mobile_no'] ?? ''); ?>" required>
                            </div>
                            <div class="input-box">
                                <label class="details" for="email">Email Id:</label>
                                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($_SESSION['form_data']['email'] ?? ''); ?>" required>
                            </div>

                            <div class="input-box">
                                <label class="details" for="dob">Date Of Birth:</label>
                                <input type="date" name="dob" id="dob" value="<?php echo htmlspecialchars($_SESSION['form_data']['dob'] ?? ''); ?>" required>
                            </div>

                            <div class="input-box">
                                <label class="details" for="aadhar">Aadhar Number:</label>
                                <input type="text" maxlength="12" minlength="12" id="aadhar" name="aadhar" value="<?php echo htmlspecialchars($_SESSION['form_data']['aadhar'] ?? ''); ?>" required>
                            </div>
                            <div class="input-box">
                                <label class="details" for="address">Address:</label>
                                <textarea name="address" id="address" required><?php echo htmlspecialchars($_SESSION['form_data']['address'] ?? ''); ?></textarea>
                            </div>

                            <div class="input-box">
                                <label class="details" for="password">Password:</label>
                                <input type="password" name="password" id="password" value='<?php echo htmlspecialchars($_SESSION['form_data']['password'] ?? ''); ?>' required>
                            </div>
                            <div class="input-box">
                                <label class="details" for="cpassword">Confirm Password:</label>
                                <input type="password" name="cpassword" id="cpassword" <?php echo htmlspecialchars($_SESSION['form_data']['cpassword'] ?? ''); ?>value='' required>
                            </div>
                        </div>
                        <div class="button" colspan="2">
                            <input type="submit" name="generate_otp" value="Generate OTP">
                        </div>
                        <?php if (isset($_SESSION['otp'])): ?>
                            <div id="otp-section">
                                <div class="input-box">
                                    <label for="otp" class="details">Enter OTP:</label>
                                    <input type="text" name="otp" id="otp" maxlength="6" minlength="6" oninput="validateMobileNo(this)">
                                </div>
                                <div class="button">
                                    <input type="submit" name="verify_otp" value="Verify OTP">
                                </div>
                                <div class="input-box">
                                    <label class="details">OTP Expiry Time:</label>
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
                    <div class="login-link">
                        <p>Already have an account? <a href="index.php">Login here</a></p>
                    </div>
                </div>

            </div>
        </div>

    </body>
</html>
