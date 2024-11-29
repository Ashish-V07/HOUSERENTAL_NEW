<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['loggedin'])) {
    header("Location: /practical1/homlisti/my-account/index.php");
    exit();
}

$email = $_SESSION['email']; // Logged-in user's email

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "house_rental";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user ID based on logged-in email
$userQuery = "SELECT id FROM tbl_users WHERE email = '$email'";
$userResult = $conn->query($userQuery);
if ($userResult->num_rows == 1) {
    $user = $userResult->fetch_assoc();
    $loggedInUserId = $user['id'];
} else {
    echo "<script>alert('User not found. Please log in again.');</script>";
    exit();
}

// Fetch properties rented by the logged-in user
$propertyQuery = "
    SELECT ra.property_id, p.adress 
    FROM rental_applications ra
    INNER JOIN property p ON ra.property_id = p.pid
    WHERE ra.status = 'Accepted' AND ra.user_id = '$loggedInUserId'
";
$propertyResult = $conn->query($propertyQuery);

// Fetch maintenance categories
$categoryQuery = "SELECT ID, NAME FROM tblMaintananceCategory";
$categoryResult = $conn->query($categoryQuery);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $propertyID = $_POST['property_id'];
    $description = $_POST['description'];
    $maintananceID = $_POST['maintanance_id'];
    $requestDate = date('Y-m-d');

    $insertQuery = "
        INSERT INTO tblMaintanance (PID, TID, Issue, Status, RequestDATE, McID) 
        VALUES ('$propertyID', '$loggedInUserId', '$description', 'PENDING', '$requestDate', '$maintananceID')
    ";
    if ($conn->query($insertQuery) === TRUE) {
        echo $_SESSION['MMSG']="Maintenance request submitted successfully!";
        header("Location:demo2.php");
        exit();
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Request</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Maintenance Request Form</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="property_id">Select Property:</label>
            <select name="property_id" id="property_id" class="form-control" required>
                <option value="">Select Property</option>
                <?php
                if ($propertyResult->num_rows > 0) {
                    while ($row = $propertyResult->fetch_assoc()) {
                        echo "<option value='{$row['property_id']}'>{$row['adress']}</option>";
                    }
                } else {
                    echo "<option value=''>No rented properties available</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="description">Description of Issue:</label>
            <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="maintanance_id">Select Maintenance Type:</label>
            <select name="maintanance_id" id="maintanance_id" class="form-control" required>
                <option value="">Select Category</option>
                <?php
                if ($categoryResult->num_rows > 0) {
                    while ($row = $categoryResult->fetch_assoc()) {
                        echo "<option value='{$row['ID']}'>{$row['NAME']}</option>";
                    }
                } else {
                    echo "<option value=''>No categories available</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit Request</button>
    </form>
</div>
</body>
</html>
