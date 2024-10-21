<?php
// Start session and connect to the database
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

$email = $_SESSION['email']; // Assuming user_id is stored in the session

// Fetch user details
$sql = "SELECT fname, lname, mobile, email, dob, aadhar, address FROM tbl_users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "No user data found.";
}

// If the form is submitted, update the user profile
if (isset($_POST['update_profile'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $aadhar = $_POST['aadhar'];
    $address = $_POST['address'];
    
    // Update image if a new one is uploaded
    if (isset($_FILES['profile_image']['tmp_name']) && $_FILES['profile_image']['tmp_name'] != '') {
        $image = $_FILES['profile_image']['tmp_name'];
        $imageContent = addslashes(file_get_contents($image));
        $sql = "UPDATE tbl_users SET profile_image='$imageContent' WHERE email='$email'";
        $conn->query($sql);
    }

    // Update other fields in the database
    $sql = "UPDATE tbl_users SET fname='$fname', lname='$lname', mobile='$mobile', email='$email', dob='$dob', aadhar='$aadhar', address='$address' WHERE email='$email'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['UPDATE_MSG']="Profile Updated Successfully...";
        header("Location: profile.php"); // Redirect to the profile page after update
    } else {
        $_SESSION['UPDATE_MSG']="Profile Updated Successfully...";
        header("Loaction:profile.php");
    }
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
    </style>
</head>
<body>

<div class="container profile-container">
    <div class="row">
        <!-- Profile Image Section -->
        <div class="col-md-4">
            <div class="text-center">
                <!-- Fetch and display the image from the database -->
                <img src="fetch_image.php" class="profile-image" alt="Profile Image">
                <h2 class="mt-3"><?php echo $user['fname'] . " " . $user['lname']; ?></h2>
            </div>
        </div>

        <!-- Profile Information Section with Edit Form -->
        <div class="col-md-8">
            <div class="profile-card">
                <h3>Edit Profile Information</h3>
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="fname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $user['fname']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="lname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $user['lname']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile</label>
                        <input type="text" class="form-control" id="mobile" name="mobile" minlength="10" maxlength="10" value="<?php echo $user['mobile']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $user['dob']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="aadhar" class="form-label">Aadhar Number</label>
                        <input type="text" class="form-control" id="aadhar" name="aadhar" minlength="12" maxlength="12" value="<?php echo $user['aadhar']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo $user['address']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="profile_image" class="form-label">Profile Image</label>
                        <input type="file" class="form-control" id="profile_image" name="profile_image">
                    </div>
                    <button type="submit" name="update_profile" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // JavaScript to ensure the user is at least 18 years old
    document.getElementById('dob').addEventListener('change', function() {
        const dob = new Date(this.value);
        const today = new Date();
        const age = today.getFullYear() - dob.getFullYear();
        const month = today.getMonth() - dob.getMonth();
        if (month < 0 || (month === 0 && today.getDate() < dob.getDate())) {
            age--;
        }
        if (age < 18) {
            this.setCustomValidity("You must be at least 18 years old.");
        } else {
            this.setCustomValidity("");
        }
    });

    // You can also add an event listener to validate the form before submission
    document.getElementById('profileForm').addEventListener('submit', function(event) {
        // Additional form validations can be added here
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
