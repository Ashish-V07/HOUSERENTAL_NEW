<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f4f4;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .property {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            margin-bottom: 15px;
        }
        .property:hover {
            transform: translateY(-5px);
        }
        .slideshow {
            position: relative;
            height: 200px; /* Adjusted height for better visuals */
            overflow: hidden;
            border-radius: 5px;
        }
        .slideshow-images {
            display: flex;
            animation: slide 10s infinite;
        }
        .slideshow-images img {
            min-width: 100%;
            height: auto;
            border-radius: 5px;
            object-fit: cover;
        }
        @keyframes slide {
            0%, 20% { transform: translateX(0); }
            25%, 45% { transform: translateX(-100%); }
            50%, 70% { transform: translateX(-200%); }
            75%, 100% { transform: translateX(-300%); }
        }
        .action-icons {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }
        .action-icons a, .action-icons button {
            text-decoration: none;
            color: #3498db;
            transition: color 0.3s;
        }
        .action-icons a:hover, .action-icons button:hover {
            color: #2980b9;
        }
        .request-rent-button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<?php
session_start();
// Database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'house_rental';
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Get user ID from session

// Fetch search parameters
$address = $_GET['address'] ?? '';
$rent = $_GET['rent'] ?? '';
$bedroom = $_GET['bedroom'] ?? '';
$kitchen = $_GET['kitchen'] ?? '';
$floor = $_GET['floor'] ?? '';
$parking = $_GET['parking'] ?? '';
$size = $_GET['size'] ?? '';
$category = $_GET['cid'] ?? ''; // Category search parameter

// Build the query
$query = "
    SELECT p.*, i.image 
    FROM property p
    LEFT JOIN tblimage i ON p.pid = i.pid
    WHERE p.status = 'Allow'
";

// Add conditions based on search parameters
$conditions = [];
if (!empty($address)) {
    $conditions[] = "p.adress LIKE '" . $conn->real_escape_string($address) . "%'";
}
if (!empty($rent)) {
    $conditions[] = "p.rent <= " . (float)$rent;
}
if (!empty($bedroom)) {
    $conditions[] = "p.bedroom >= " . (int)$bedroom;
}
if (!empty($kitchen)) {
    $conditions[] = "p.kitchen >= " . (int)$kitchen;
}
if (!empty($floor)) {
    $conditions[] = "p.floor >= " . (int)$floor;
}
if ($parking !== '') {
    $conditions[] = "p.parking = " . (int)$parking;
}
if (!empty($size)) {
    $conditions[] = "p.size >= " . (int)$size;
}
if (!empty($category)) { // Add condition for category
    $conditions[] = "p.cid = " . (int)$category; // Assuming `cid` is the foreign key in `property` table
}

// Append conditions to the query
if (count($conditions) > 0) {
    $query .= " AND " . implode(' AND ', $conditions);
}

// Execute the query
$result = $conn->query($query);

// Initialize an array to group properties by ID
$properties = [];

while ($row = $result->fetch_assoc()) {
    $pid = $row['pid'];
    if (!isset($properties[$pid])) {
        $properties[$pid] = [
            'details' => $row,
            'images' => []
        ];
    }
    if (!empty($row['image'])) {
        $properties[$pid]['images'][] = base64_encode($row['image']);
    }
}

$conn->close();

// Display the properties
if (count($properties) > 0) {
    foreach ($properties as $property) {
        $details = $property['details'];
        $images = $property['images'];
        echo "<div class='col-md-4'>";
        echo "<div class='property'>";
        echo "<h2>" . htmlspecialchars($details['adress']) . "</h2>";
        echo "<p><strong>Rent:</strong> ₹" . number_format($details['rent'], 2) . "</p>";
        echo "<p><strong>Bedrooms:</strong> " . htmlspecialchars($details['bedroom']) . "</p>";
        echo "<p><strong>Bathrooms:</strong> " . htmlspecialchars($details['bathroom']) . "</p>";
        echo "<p><strong>Kitchen:</strong> " . htmlspecialchars($details['kitchen']) . "</p>";
        echo "<p><strong>Floor:</strong> " . htmlspecialchars($details['floor']) . "</p>";
        echo "<p><strong>Parking:</strong> " . ($details['parking'] == 1 ? 'Yes' : 'No') . "</p>";
        echo "<p><strong>Size:</strong> " . htmlspecialchars($details['size']) . " sq ft</p>";
        echo "<p><strong>Description:</strong> " . htmlspecialchars($details['description']) . "</p>";
        echo "<div class='slideshow'>";
        echo "<div class='slideshow-images'>";
        foreach ($images as $image) {
            echo '<img src="data:image/jpeg;base64,' . $image . '" alt="Property Image" />';
        }
        echo "</div></div>";
        echo "<div class='action-icons'>";
        echo "<a href='#'><i class='fas fa-heart'></i> Save</a>";
        echo "<a href='#'><i class='fas fa-eye'></i> View</a>";
        echo "<form action='request_rent.php' method='POST'>";
        echo "<input type='hidden' name='property_id' value='" . $details['pid'] . "' />";
       // echo "<input type='hidden' name='user_id' value='" . $uid . "' />";
        echo "<button type='submit' class='request-rent-button'>Request Rent</button>";
        echo "</form>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<p>No properties found.</p>";
}
?>
