<?php
session_start();
if (!$_SESSION['email'] == "22bmiit150@gmail.com") {
    header("Location: /houserental-master/homlisti/my-account/index.php"); // Redirect to login if not logged in
    exit();
}

// Include your DB connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "house_rental";

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

        // Debugging: Output the old password and the hashed password
        // echo "Old Password: " . $oldPassword . "<br>";
        // echo "Hashed Password: " . $hashedPassword . "<br>";

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
    } else {
        $_SESSION['UPDATE_MSG'] = "User not found!";
    }

    // Redirect to changePassword.php to show the message
    header("Location: changePassword.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <title>Change Password</title>
        <style>
            body{
               background: linear-gradient(to right, #f0f4f8, #c0c9d7);
               height: 100vh;
            }
        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            padding-top: 12%;
        }
        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.5rem;
            color: #007bff;
        }
        .form-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }
        .form-container button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form-container button:hover {
            background-color: #0056b3;
        }
        .form-container .message {
            margin-top: 10px;
            text-align: center;
            font-weight: bold;
        }
        .form-container .message.success {
            color: green;
        }
        .form-container .message.error {
            color: red;
        }
            </style>
    </head>

    <body>
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <nav class="col-md-2 d-none d-md-block sidebar position-fixed vh-100" style="background-color: #d3d3d3 ;">
                    <div class="sidebar-sticky">
                        <h4 class="sidebar-heading">Admin Menu</h4>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" href="dashboard.php">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="admin_category.php">Category</a>
                            </li>

                            <!-- Manage Property Selection Dropdown -->
                            <!-- Manage Property Selection Dropdown -->
                            <li class="nav-item" >
                                <select class="form-control" id="managePropertySelect" onchange="location = this.value;">
                                    <option selected disabled>Manage Property:</option>
                                    <option value="admin_verify.php?status=pending">Pending Properties</option>
                                    <option value="admin_verify.php?status=allowed">Allowed Properties</option>
                                    <option value="admin_verify.php?status=denied">Denied Properties</option>
                                </select>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="manage_users.php">Manage Users</a> <!-- New Manage Users Link -->
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="ManageFeedback.php">Manage Feedback</a>
                            </li>
                              <li class="nav-item">
                                <a class="nav-link" href="changePassword.php">Change Password</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">Logout</a>
                            </li>
                            
                        </ul>
                    </div>
                </nav>

                <!-- Main Content -->
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="main-content">
        <div class="form-container">
            <h2>Change Password</h2>
            <form method="POST">
                <input type="password" name="oldPassword" placeholder="Old Password" required>
                <input type="password" name="newPassword" placeholder="New Password" required>
                <input type="password" name="confirmPassword" placeholder="Confirm New Password" required>
                <button type="submit">Change Password</button>
            </form>
            <div class="message">
                <?php
                if (isset($_SESSION['UPDATE_MSG'])) {
                    echo '<p class="' . (strpos($_SESSION['UPDATE_MSG'], 'successfully') !== false ? 'success' : 'error') . '">' . $_SESSION['UPDATE_MSG'] . '</p>';
                    unset($_SESSION['UPDATE_MSG']);
                }
                ?>
            </div>
        </div>
    </div>
</main>

            </div>
        </div>
         

        <!-- Bootstrap JS and jQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>
