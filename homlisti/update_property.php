
<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
if ($_SESSION['email'] == "22bmiit150@gmail.com") {
    header("Location: /houserental-master/homlisti/admin/dashboard.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "house_rental");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get user ID based on email
$uname = $_SESSION['email'];
$sql = "SELECT id FROM tbl_users WHERE email = '$uname'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$uid = $row['id'];  // Fetch user ID

// Get property ID from URL
if (isset($_GET['pid'])) {
    $property_id = $_GET['pid'];

    // Fetch property details
    $property_sql = "SELECT * FROM property WHERE pid = '$property_id' AND uid = '$uid'";
    $property_result = mysqli_query($conn, $property_sql);

    if (mysqli_num_rows($property_result) > 0) {
        $property = mysqli_fetch_assoc($property_result);
    } else {
        echo "Property not found or you are not authorized to update this property!";
        exit();
    }
} else {
    echo "No property ID specified!";
    header("Location: home.php");
    exit();
}

// Handle form submission
if (isset($_POST['btnupdate'])) {
   $cid = $_POST['cid'];
    $address = $_POST['address'];
    $rent = $_POST['rent'];
    $bedroom = $_POST['bedroom'];
    $bathroom = $_POST['bathroom'];
    $kitchen = $_POST['kitchen'];
    $floor = $_POST['floor'];
    $parking = $_POST['parking'];
    $description = $_POST['description'];
    $size = $_POST['size'];
$sec=$_POST['sd'];
    // Handle document update
    $document = $property['document'];
    if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
        $document = addslashes(file_get_contents($_FILES['document']['tmp_name']));
    }

    // Update property information
    $update_sql = "UPDATE property 
                   SET cid = '$cid', adress = '$address',SecurityDeposit='$sec',rent = '$rent', bedroom = '$bedroom', 
                       bathroom = '$bathroom', kitchen = '$kitchen', floor = '$floor', 
                       parking = '$parking', description = '$description', size = '$size', document = '$document'
                   WHERE pid = '$property_id' AND uid = '$uid'";

    if (mysqli_query($conn, $update_sql)) {
        // Handle house images update (optional)
        if (isset($_FILES['house_image']) && count($_FILES['house_image']['tmp_name']) > 0) {
            // Delete old images
            mysqli_query($conn, "DELETE FROM tblimage WHERE pid = '$property_id'");
            // Insert new images
            for ($i = 0; $i < count($_FILES['house_image']['tmp_name']); $i++) {
                if ($_FILES['house_image']['error'][$i] == 0) {
                    $house_image = addslashes(file_get_contents($_FILES['house_image']['tmp_name'][$i]));
                    $image_sql = "INSERT INTO tblimage (sid, pid, image) VALUES (NULL, '$property_id', '$house_image')";
                    mysqli_query($conn, $image_sql);
                }
            }
        }

        $_SESSION['property']="Property updated successfully!";
        header("Location:home.php");
        die();
    } else {
        echo "Error: " . $update_sql . "<br>" . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Property</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
            display: flex;
        }

        /* Sidebar styling */
        .sidebar {
            width: 220px;
            height: 100vh;
            background-color: #343a40;
            padding: 20px;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        .sidebar ul li a:hover {
            color: #ffc107;
        }

        /* Main content styling */
        .main-content {
            margin-left: 240px; /* Sidebar width + padding */
            padding: 20px;
            width: 100%;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
            color: #555;
        }

        input[type="text"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
            font-size: 14px;
        }

        input[type="file"] {
            font-size: 14px;
        }

        textarea {
            resize: vertical;
        }

        input[type="submit"] {
            grid-column: 1 / -1;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        /* Responsive adjustments */
        @media(max-width: 768px) {
            .form-group {
                grid-template-columns: 1fr;
            }

            .container {
                margin: 20px;
                padding: 15px;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-content {
                margin-left: 0;
            }
        }

    </style>
</head>
<body>

    <!-- Sidebar navigation -->
    <div class="sidebar">
        <ul>
            <li><a href="NEWDashboard.php">Home</a></li>
            <li><a href="Profile.php">Profile Overview</a></li>
            <li><a href="Profile1.php">Update Profile</a></li>
            <li><a href="home.php">My Properties</a></li>
            <li><a href="changePassword.php">Change Password</a></li>
            <li><a href="/houserental-master/homlisti/my-account/logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main content -->
    <div class="main-content">
        <div class="container">
            <h2>Update Property</h2>
            <form action="update_property.php?pid=<?php echo $property_id; ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <!-- Category -->
                    <div>
                        <label for="category">Category:</label>
                        <select name="cid" id="category" required>
                            <option value="">Select Category</option>
                            <?php
                            $sql = "SELECT id, cname FROM tblcategory";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['id'] . "' " . ($row['id'] == $property['cid'] ? "selected" : "") . ">" . $row['cname'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" maxlength="255" value="<?php echo $property['adress']; ?>" required>
                    </div>

                    <!-- Rent -->
                    <div>
                        <label for="rent">Rent:</label>
                        <input type="number" step="0.01" id="rent" name="rent" value="<?php echo $property['rent']; ?>" required oninput="validateNumberInput(this)">
                    </div>

                    <!-- Bedrooms -->
                    <div>
                        <label for="bedroom">Bedrooms:</label>
                        <input type="number" id="bedroom" name="bedroom" value="<?php echo $property['bedroom']; ?>" required oninput="validateNumberInput(this)">
                    </div>

                    <!-- Bathrooms -->
                    <div>
                        <label for="bathroom">Bathrooms:</label>
                        <input type="number" id="bathroom" name="bathroom" value="<?php echo $property['bathroom']; ?>" required oninput="validateNumberInput(this)">
                    </div>

                    <!-- Kitchen -->
                    <div>
                        <label for="kitchen">Kitchen:</label>
                        <input type="number" id="kitchen" name="kitchen" value="<?php echo $property['kitchen']; ?>" required oninput="validateNumberInput(this)">
                    </div>

                    <!-- Floor -->
                    <div>
                        <label for="floor">Floor:</label>
                        <input type="number" id="floor" name="floor" value="<?php echo $property['floor']; ?>" required oninput="validateNumberInput(this)">
                    </div>

                    <!-- Parking -->
                    <div>
                        <label for="parking">Parking:</label>
                        <input type="number" min="0" max="1" id="parking" name="parking" value="<?php echo $property['parking']; ?>" required oninput="validateNumberInput(this)">
                    </div>

                    <!-- Property Size -->
                    <div>
                        <label for="size">Property Size (in square feet):</label>
                        <input type="number" id="size" name="size" value="<?php echo $property['size']; ?>" required oninput="validateNumberInput(this)">
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" rows="3"><?php echo $property['description']; ?></textarea>
                    </div>
<div>
                        <label for="sd">Security Deposit:</label>
                        <input type="number" id="sd" name="sd" value="<?php echo $property['SecurityDeposit'];?>" required oninput="validateNumberInput(this)">
                    </div>
                    <!-- Document -->
                    <div>
                        <label for="document">Update Document:</label>
                        <input type="file" id="document" name="document" required>
                    </div>

                    <!-- House Images -->
                    <div>
                        <label for="house_image">Update House Images:</label>
                        <input type="file" id="house_image" name="house_image[]" multiple required>
                    </div>
                </div>

                <input type="submit" name="btnupdate" value="Update Property">
            </form>
        </div>
    </div>

    <script>
        function validateNumberInput(input) {
            input.value = input.value.replace(/\D/g, ''); // Remove non-digit characters
        }
    </script>
</body>
</html>
