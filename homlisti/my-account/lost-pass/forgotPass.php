<?php
session_start(); // Start the session at the top of your PHP file
include 'db_connection.php';



if(!isset($_SESSION['otp_email']))
{
    header("Location: /houserental-master/homlisti/my-account/lost-pass/index.php");
}
// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the OTP and new passwords entered by the user
    $user_input_otp = $_POST['otp'];
    $new_password = $_POST['newPassword'];
    $confirm_password = $_POST['confirmPassword'];

    // Retrieve the stored OTP and generation time from session
   $stored_otp = isset($_SESSION['OTP_CODE']) ? trim($_SESSION['OTP_CODE']) : null; // Adjusted to match your earlier naming
    
    $otp_generation_time = $_SESSION['otp_generation_time'] ?? null;

    // Check if the OTP exists in the session
    if ($stored_otp && $otp_generation_time) {
        // Verify if the entered OTP matches the stored OTP
        if ($user_input_otp === $stored_otp) {
            // Check if OTP is still valid (e.g., valid for 5 minutes)
            $current_time = time();
            if (($current_time - $otp_generation_time) <= 300) { // 300 seconds = 5 minutes
                // Check if new password and confirm password match
                if ($new_password === $confirm_password) {
                    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

                    // Assuming you have the user's email in the session
                    $user_email = $_SESSION['otp_email'];

                    // Database connection
                
                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Update the password in the database
                    $sql = "UPDATE tbl_users SET password = '$hashed_password' WHERE email = '$user_email'";
                   
                    $res= mysqli_query($conn, $sql);
                    

                    if ($res) {
                       // echo "<script>alert('Password updated successfully!');</script>";
                        // Unset OTP from session if no longer needed
                                                $_SESSION['success_pass']="Password updated successfully! ";

                        unset($_SESSION['OTP_CODE'], $_SESSION['otp_generation_time'], $_SESSION['otp_email']);
                        header("Location:/houserental-master/homlisti/my-account/index.php");
                        die();
                    } else {
                        echo "<script>alert('Error updating password. Please try again.');</script>";
                    }

                   
                    $conn->close();
                   

                    // Unset OTP from session if no longer needed
                    unset($_SESSION['OTP_CODE'], $_SESSION['otp_generation_time']);
                } else {
                    echo "<script>alert('New password and confirm password do not match!');</script>";
                }
            } else {
                echo "<script>alert('OTP has expired. Please request a new OTP.');</script>";
            }
        } else {
            echo "<script>alert('Invalid OTP. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('No OTP found. Please request a new OTP.');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }

        body {
            background: linear-gradient(to right, #f0f4f8, #c0c9d7);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            animation: fadeIn 1s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            transition: transform 0.3s;
        }

        .container:hover {
            transform: scale(1.02);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .input-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #555;
        }

        input[type="password"], input[type="text"] {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        input[type="password"]:focus, input[type="text"]:focus {
            border-color: #5a9bd4;
            box-shadow: 0 0 5px rgba(90, 155, 212, 0.5);
            outline: none;
        }

        button {
            width: 100%;
            padding: 0.8rem;
            border: none;
            border-radius: 5px;
            background: linear-gradient(to right, #5a9bd4, #3a8ec3);
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }

        button:hover {
            background: linear-gradient(to right, #3a8ec3, #5a9bd4);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <form id="changePasswordForm" method="post">
            <div class="input-group">
                <label for="newPassword">New Password</label>
                <input type="password" id="newPassword" name="newPassword" required>
            </div>
            <div class="input-group">
                <label for="confirmPassword">Confirm New Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
            </div>
            <div class="input-group">
                <label for="otp">Enter OTP</label>
                <input type="text" id="otp" name="otp" required maxlength="6" pattern="\d{6}" title="Please enter a valid 6-digit OTP">
            </div>
            <button type="submit">Change Password</button>
        </form>
        <div id="message"></div>
    </div>
</body>
</html>
