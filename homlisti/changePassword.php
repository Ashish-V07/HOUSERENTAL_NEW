<?php
// Start session and include database connection
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "house_rental";

if (!isset($_SESSION['loggedin'])) {
    header("Location: /houserental-master/homlisti/my-account/index.php");
    exit();
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the logged-in user's email from the session
$email = $_SESSION['email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Fetch the old password hash from the database
    $sql = "SELECT password FROM tbl_users WHERE email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        // Verify old password
        if (password_verify($oldPassword, $hashedPassword)) {
            // Validate new password and confirm password match
            if ($newPassword === $confirmPassword) {
                // Validate password strength (e.g., minimum 8 characters)
                if (strlen($newPassword) >= 8) {
                    // Hash the new password
                    $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                    // Update the password in the database
                    $updateSql = "UPDATE tbl_users SET password = '$newHashedPassword' WHERE email = '$email'";
                    if ($conn->query($updateSql) === TRUE) {
                        $_SESSION['UPDATE_MSG'] = "Password changed successfully!";
                    } else {
                        $_SESSION['UPDATE_MSG'] = "Error updating password!";
                    }
                } else {
                    $_SESSION['UPDATE_MSG'] = "Password must be at least 8 characters long!";
                }
            } else {
                $_SESSION['UPDATE_MSG'] = "New password and confirm password do not match!";
            }
        } else {
            $_SESSION['UPDATE_MSG'] = "Old password is incorrect!";
        }
    }
    header("Location: changePassword.php");
    
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <style>
        /* Add your styling here */
        body {
            background: linear-gradient(to right, #f0f4f8, #c0c9d7);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Arial', sans-serif;
        }

        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .container h2 {
            margin-bottom: 1rem;
        }

        .container form input {
            width: 90%;
            padding: 0.8rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .container form button {
            width: 97%;
            padding: 0.8rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #message {
            margin-top: 1rem;
            font-weight: bold;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }
         /* Sidebar Styles */
        .sidebar {
            width: 220px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            color: #fff;
            padding: 20px;
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

        /* Profile container with left margin for the sidebar */
        
    </style>
</head>
<body>
    <div class="sidebar">
    <ul>
         <li><a href="NEWDashboard.php">Home</a></li>
        <li><a href="Profile.php">Profile Overview</a></li>
        <li><a href="Profile1.php">Update Profile</a></li>
        <li><a href="home.php">My Properties</a></li>
        <li><a href="Payment.php">Payments</a> </li>
        <li><a href="changePassword.php">Change Password</a></li>
        <li><a href="/houserental-master/homlisti/my-account/logout.php">Logout</a></li>
    </ul>
</div>
    <div class="container">
        <h2>Change Password</h2>
        <form method="POST">
            <input type="password" name="oldPassword" placeholder="Old Password" required>
            <input type="password" name="newPassword" placeholder="New Password" required>
            <input type="password" name="confirmPassword" placeholder="Confirm New Password" required>
            <button type="submit">Change Password</button>
        </form>
        <div id="message">
            <?php
            if (isset($_SESSION['UPDATE_MSG'])) {
                echo '<p class="' . (strpos($_SESSION['UPDATE_MSG'], 'successfully') !== false ? 'success' : 'error') . '">' . $_SESSION['UPDATE_MSG'] . '</p>';
                unset($_SESSION['UPDATE_MSG']);
            }
            ?>
        </div>
    </div>
</body>
</html>
