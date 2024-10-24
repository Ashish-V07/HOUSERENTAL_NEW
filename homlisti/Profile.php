<?php
// Start the session and include database connection
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "house_rental";

if (!isset($_SESSION['loggedin'])) {
    header("Location: /houserental-master/homlisti/my-account/index.php");
    exit();
}
if ($_SESSION['email'] == "22bmiit150@gmail.com") {
    header("Location: /houserental-master/homlisti/admin/dashboard.php");
    exit();
}


if(isset($_SESSION['UPDATE_MSG']))
{
    $msg=$_SESSION['UPDATE_MSG'];
    echo "<script>alert(".$msg.")</script>";
   unset($_SESSION['UPDATE_MSG']);
    
}
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming user_id is stored in session
$email = $_SESSION['email'];

// Fetch user details
$sql = "SELECT fname, lname, mobile, email, dob, aadhar, address FROM tbl_users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // fetch user data
    $row = $result->fetch_assoc();
} else {
    echo "No user data found.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-container {
            margin-top: 50px;
        }
        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }
        .profile-card {
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
        .user-info {
            margin-top: 20px;
        }
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .sidebar a {
            padding: 15px;
            text-decoration: none;
            font-size: 18px;
            color: #333;
            display: block;
            margin: 10px 0;
        }
        .sidebar a:hover {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<?php include 'sidebaar.php';?>

<!-- Main Profile Content -->
<div class="container profile-container" style="margin-left: 270px;">
    <div class="row">
        <!-- Profile Image Section -->
        <div class="col-md-4">
            <div class="text-center">
                <!-- Fetch and display the image from the database -->
                <img src="fetch_image.php" class="profile-image" alt="Profile Image">
                <h2 class="mt-3"><?php echo $row['fname'] . " " . $row['lname']; ?></h2>
            </div>
        </div>
        
        <!-- Profile Information Section -->
        <div class="col-md-8">
            <div class="profile-card">
                <h3>User Information</h3>
                <div class="user-info">
                    <p><strong>Mobile:</strong> <?php echo $row['mobile']; ?></p>
                    <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
                    <p><strong>Date of Birth:</strong> <?php echo $row['dob']; ?></p>
                    <p><strong>Aadhar:</strong> <?php echo $row['aadhar']; ?></p>
                    <p><strong>Address:</strong> <?php echo $row['address']; ?></p>
                </div>
                
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
