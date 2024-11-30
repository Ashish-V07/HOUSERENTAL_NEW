<?php

session_start();
//if (!isset($_SESSION['email'])) {
//    header("Location: index.php");
//    exit();
//}

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'house_rental';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['property_id']) || empty($_GET['property_id'])) {
    echo "Invalid property ID.";
    exit();
}

$property_id = (int)$_GET['property_id'];

// Fetch property details
$query = "
    SELECT p.*, c.cname,u.fname 
    FROM tblcategory c
    inner JOIN property p ON p.cid = c.id
    inner join tbl_users u on p.uid=u.id
    WHERE p.pid = $property_id
";
$result = $conn->query($query);

if ($result->num_rows === 0) {
    echo "Property not found.";
    exit();
}

$property = $result->fetch_assoc();

// Fetch property images
$image_query = "SELECT image FROM tblimage WHERE pid = $property_id";
$image_result = $conn->query($image_query);

$images = [];
while ($row = $image_result->fetch_assoc()) {
    if (!empty($row['image'])) {
        $images[] = base64_encode($row['image']);
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .property-header {
            background-color: #f8f9fa;
            padding: 20px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        .property-header h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: bold;
        }

        .carousel img {
            max-height: 600px;
            width: 100%;
            object-fit: cover;
            border-radius: 5px;
        }

        .property-details {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .property-details h4 {
            font-weight: bold;
            margin-bottom: 20px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
            display: inline-block;
        }

        .property-description {
            margin-top: 20px;
        }

        .property-description h5 {
            font-weight: bold;
        }

        .navbar a {
            color: #fff !important;
            padding: 15px;
        }
          .request-rent-button {
    background-color: #cce5ff; /* Light blue background */
    color: #004085; /* Dark blue text */
    border: 1px solid #004085; /* Dark blue border for definition */
    padding: 8px 15px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s;
}

.request-rent-button:hover {
    background-color: #004085; /* Dark blue background on hover */
    color: #ffffff; /* White text on hover */
}
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Home</a>
           
            <a class="navbar-brand" href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="property-header">
            <h1><?php echo htmlspecialchars($property['adress']); ?></h1>
        </div>

        <!-- Image Carousel -->
        <div id="propertyCarousel" class="carousel slide mt-4" data-ride="carousel">
            <div class="carousel-inner">
                <?php
                if (count($images) > 0) {
                    foreach ($images as $index => $image) {
                        $activeClass = $index === 0 ? 'active' : '';
                        echo '<div class="carousel-item ' . $activeClass . '">';
                        echo '<img src="data:image/jpeg;base64,' . $image . '" alt="Property Image" >';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="carousel-item active"><p class="text-center">No images available for this property.</p></div>';
                }
                ?>
            </div>
            <a class="carousel-control-prev" href="#propertyCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#propertyCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <!-- Property Details -->
        <div class="property-details mt-4">
            <h4>Property Details</h4>
            <p><strong>Category:</strong> <?php echo htmlspecialchars($property['cname']); ?></p>
            <p><strong>Rent:</strong> ₹<?php echo number_format($property['rent'], 2); ?></p>
            <p><strong>Bedrooms:</strong> <?php echo htmlspecialchars($property['bedroom']); ?></p>
            <p><strong>Bathrooms:</strong> <?php echo htmlspecialchars($property['bathroom']); ?></p>
            <p><strong>Kitchens:</strong> <?php echo htmlspecialchars($property['kitchen']); ?></p>
            <p><strong>Floor:</strong> <?php echo htmlspecialchars($property['floor']); ?></p>
            <p><strong>Parking:</strong> <?php echo $property['parking'] == 1 ? 'Yes' : 'No'; ?></p>
            <p><strong>Size:</strong> <?php echo htmlspecialchars($property['size']); ?> sq ft</p>
            <h2><strong>Owner Name:</strong> <?php echo htmlspecialchars($property['fname']); ?> </h2>
            <?php
             echo "<form action='../../request_rent.php' method='POST'>";
                echo "<input type='hidden' name='property_id' value='" . $property['pid'] . "' />";
//                echo "<input type='hidden' name='user_id' value='" . $uid . "' />"; 
                echo "<button type='submit' class='request-rent-button'>Request Rent</button>";
                echo "</form>";
            ?>
        </div>

        <!-- Property Description -->
        <div class="property-description mt-4">
            <h5>Description</h5>
            <p><?php echo htmlspecialchars($property['description']); ?></p>
        </div>

        <div class="mt-4 text-center">
            <a href="index.php" class="btn btn-secondary">Back to Properties</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>