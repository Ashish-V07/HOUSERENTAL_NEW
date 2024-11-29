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

// Fetch rented properties for the logged-in user
$sql = "SELECT p.pid, p.adress, p.rent, p.bedroom, p.bathroom, p.kitchen, p.floor, p.parking, p.description, r.startdate, r.enddate 
        FROM tblrent r
        INNER JOIN property p ON r.pid = p.pid
        WHERE r.uid = '$userId' AND p.status = 'Allow'"; // Only show allowed properties

$result = $conn->query($sql);

// Display rented properties in a table
echo "<table class='property-table'>";
echo "<thead>";
echo "<tr>
        <th>Property Address</th>
        <th>Rent</th>
        <th>Rental Period</th>
        <th>Action</th>
      </tr>";
echo "</thead>";
echo "<tbody>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['adress'] . "</td>";
        echo "<td>" . $row['rent'] . "</td>";
        echo "<td>" . $row['startdate'] . " to " . $row['enddate'] . "</td>";
        echo "<td> <form action='Rating_form.php' method='GET' style='margin: 0;'>
        <input type='hidden' name='pid' value='" . htmlspecialchars($row['pid']) . "'>
        <button type='submit' style='background-color: #007bff; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer;'>
            Rating
        </button>
    </form></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='9' style='text-align: center;'>No rented properties found.</td></tr>";
}

echo "</tbody>";
echo "</table>";

echo "<a href='Payment.php' class='back-button'>Back to Payment</a>";

// Close the connection
$conn->close();
?>

<!-- CSS for styling the table -->
<style>
    table.property-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th {
        background-color: #4CAF50;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #ddd;
    }

    td {
        font-size: 14px;
    }

    td[colspan="9"] {
        text-align: center;
        font-style: italic;
        color: #888;
    }
    
        .back-button {
            display: block;
            width: 150px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
</style>
