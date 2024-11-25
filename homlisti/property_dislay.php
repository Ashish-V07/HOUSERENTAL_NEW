<?php
session_start();
//if (!isset($_SESSION['email'])) {
//    header("Location: login.php");
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

$email = $_SESSION['email'];
$user_query = "SELECT id FROM tbl_users WHERE email = '$email'";
$user_result = mysqli_query($conn, $user_query);
$row = mysqli_fetch_assoc($user_result);
$uid = $row['id'];

$query = "
    SELECT p.*, i.image 
    FROM property p
    LEFT JOIN tblimage i ON p.pid = i.pid
    WHERE p.status = 'Allow' and p.AvailabilityStatus='Available'
";

$result = $conn->query($query);

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
?>
<html>
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

        /* Dropdown Styling */
        select {
            height: 38px; /* Adjust height */
            border-radius: 5px; /* Rounded corners */
            border: 1px solid #ccc; /* Border color */
            padding: 5px; /* Padding inside dropdown */
            background-color: #fff; /* Background color */
            font-size: 16px; /* Font size */
            transition: border-color 0.3s; /* Transition effect */
        }
        /* Add some styles for the header */
        .navbar {
            background-color: #3498db;
            padding: 10px;
            color: white;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin-right: 15px;
        }
        .navbar a:hover {
            color: #2980b9;
        }
        select:focus {
            border-color: #3498db; /* Border color on focus */
            outline: none; /* Remove default outline */
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5); /* Add shadow on focus */
        }

        /* Optional: Style for all form inputs to maintain consistency */
        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="password"] {
            border-radius: 5px; /* Rounded corners */
            border: 1px solid #ccc; /* Border color */
            padding: 8px; /* Padding inside input */
            font-size: 16px; /* Font size */
            transition: border-color 0.3s; /* Transition effect */
        }

        input:focus {
            border-color: #3498db; /* Border color on focus */
            outline: none; /* Remove default outline */
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5); /* Add shadow on focus */
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#searchForm').on('submit', function(e) {
            e.preventDefault(); 

            $.ajax({
                type: 'GET',
                url: 'test2.php', 
                data: $(this).serialize(), 
                success: function(response) {
                    $('#propertyResults').html(response); 
                },
                error: function() {
                    alert('Error fetching properties.');
                }
            });
        });
    });
    </script>
</head>
<body>
   <div class="navbar">
       
        <a href="property_dislay.php">Home</a>
                <a href="logout.php">Logout</a>
    
        </div>
    <div class="container">
    </div>

<div class="container">
    <h1>Available Properties</h1>
    <form id="searchForm" class="mb-4">
        <div class="form-row">
            <select name="cid" id="category" >
                <option value="">Select Category</option>
                <?php
                // Fetch categories for dropdown
                $conn = mysqli_connect("localhost", "root", "", "house_rental");

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $sql = "SELECT id, cname FROM tblcategory";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['cname']) . "</option>";
                }

                mysqli_close($conn);
                ?>
            </select>
            <div class="col">
                <input type="text" class="form-control" name="address" placeholder="Address">
            </div>
            <div class="col">
                <input type="number" class="form-control" name="rent" placeholder="Max Rent">
            </div>
            <div class="col">
                <input type="number" class="form-control" name="bedroom" placeholder="Bedrooms">
            </div>
            <div class="col">
                <input type="number" class="form-control" name="kitchen" placeholder="Kitchen">
            </div>
            <div class="col">
                <input type="number" class="form-control" name="floor" placeholder="Floor">
            </div>
            <div class="col">
                <select class="form-control" name="parking">
                    <option value="">Parking</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
            <div class="col">
                <input type="number" class="form-control" name="size" placeholder="Size (sq ft)">
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>
    <div id="propertyResults" class="row">
        <?php
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
                echo "<input type='hidden' name='user_id' value='" . $uid . "' />"; 
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
    </div>
</div>
</body>
</html>
    
