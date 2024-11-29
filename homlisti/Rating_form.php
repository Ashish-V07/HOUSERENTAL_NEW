<?php
session_start();

// Check if the user is logged in (adjust the session check as needed)
if (!isset($_SESSION['email'])) {
    header("Location: index.php"); // Redirect to login if not logged in
    exit();
}

$email = $_SESSION['email'];

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

// Fetch the logged-in user's ID using their email
$sql = "SELECT id FROM tbl_users WHERE email = '$email'";
$result = $conn->query($sql);
$userId = null;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userId = $row['id'];
} else {
    echo "User not found!";
    exit();
}

// Get the property ID passed via URL (make sure the URL has `pid` parameter)
$pid = isset($_GET['pid']) ? $_GET['pid'] : null;
if ($pid == null) {
    echo "Property ID not found!";
    exit();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    // Insert the review data into tblreview
    $sql = "INSERT INTO tblreview (uid, pid, rating, comment) 
            VALUES ('$userId', '$pid', '$rating', '$comment')";
    
    if ($conn->query($sql) === TRUE) {
       $_SESSION['rating']="Your review has been submitted successfully!";
       header("Location:Payment.php");
       die();
    } else {
        echo "Error: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate Property</title>
    <style>
        .rating-form {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .rating-form label {
            font-size: 18px;
            font-weight: bold;
        }

        .rating-form input[type="number"] {
            width: 60px;
            padding: 5px;
            font-size: 16px;
        }

        .rating-form textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            height: 100px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-top: 10px;
            resize: vertical;
        }

        .rating-form button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .rating-form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<h2 style="text-align: center;">Rate Property</h2>

<form class="rating-form" method="POST">
    <label for="rating">Rating (1 to 5):</label>
    <input type="number" id="rating" name="rating" min="1" max="5" required><br><br>

    <label for="comment">Comment:</label><br>
    <textarea id="comment" name="comment" required></textarea><br><br>

    <button type="submit">Submit Review</button>
    
</form>

</body>
</html>

<?php
// Close the connection
$conn->close();
?>
