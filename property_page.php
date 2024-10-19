<?php
session_start();

//if (!isset($_SESSION['email'])) {
//    header("Location: login.php");
//    exit();
//}

$conn = mysqli_connect("localhost", "root", "", "house_rental");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$uname = "22bmiit009@gmail.com";
$sql = "SELECT id FROM tbl_users WHERE email = '$uname'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $uid = $row['id'];  // Fetch user id
} else {
    echo "User not found!";
}
if (isset($_POST['btnsubmit'])) {
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

    // Handle document upload
    $document = NULL;
    if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
        $document = addslashes(file_get_contents($_FILES['document']['tmp_name']));
    }

    $house_image = NULL;
    if (isset($_FILES['house_image']) && $_FILES['house_image']['error'] == 0) {
        $house_image = addslashes(file_get_contents($_FILES['house_image']['tmp_name']));
    }

    $sql = "INSERT INTO property (cid, uid, adress, rent, bedroom, bathroom, kitchen, floor, parking, description, size, document) 
            VALUES ('$cid', '$uid', '$address', '$rent', '$bedroom', '$bathroom', '$kitchen', '$floor', '$parking', '$description', '$size', '$document')";

    if (mysqli_query($conn, $sql)) {
        $property_id = mysqli_insert_id($conn);

        if ($house_image !== NULL) {
            $image_sql = "INSERT INTO tblimage (sid, pid, image) VALUES (NULL, '$property_id', '$house_image')";
            mysqli_query($conn, $image_sql);
        }

        echo "New property and image added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

//if (isset($_POST['btnsubmit'])) {
//    $cid = $_POST['cid'];
//    $address = $_POST['address'];
//    $rent = $_POST['rent'];
//    $bedroom = $_POST['bedroom'];
//    $bathroom = $_POST['bathroom'];
//    $kitchen = $_POST['kitchen'];
//    $floor = $_POST['floor'];
//    $parking = $_POST['parking'];
//    $description = $_POST['description'];
//    $size = $_POST['size'];
//
//    $document = NULL;
//    if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
//        $document = addslashes(file_get_contents($_FILES['document']['tmp_name']));
//    }
//
//    $sql = "INSERT INTO property (cid, uid, adress, rent, bedroom, bathroom, kitchen, floor, parking, description, size, document) 
//        VALUES ('$cid', '$uid', '$address', '$rent', '$bedroom', '$bathroom', '$kitchen', '$floor', '$parking', '$description', '$size', '$document')";
//    if (isset($_POST['btnsubmit'])) {
//        if (mysqli_query($conn, $sql)) {
//            echo "New property added successfully!";
//        } else {
//            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
//        }
//    }
//}
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Entry Form</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px; /* Increased width for better field alignment */
            margin: 60px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-bottom: 30px;
            letter-spacing: 1px;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus,
        input[type="file"]:focus {
            border-color: #4CAF50;
            outline: none;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            letter-spacing: 1px;
            transition: background-color 0.3s ease;
            width: 100%;
            animation: popIn 0.5s ease-in-out;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Flexbox to align form groups in rows of 4 */
        .form-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px; /* Spacing between fields */
        }

        .form-group > div {
            flex: 1 1 23%; /* Four fields in a row */
        }

        textarea {
            width: 100%; /* Ensure textarea takes full width */
        }

        @keyframes popIn {
            0% {
                transform: scale(0.9);
            }
            100% {
                transform: scale(1);
            }
        }

        /* Additional Hover Effect */
        input[type="submit"]:hover {
            background-color: #66bb6a;
            transition: background-color 0.2s ease-in-out;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .fade-in {
            opacity: 0;
            animation: fadeEffect 1.5s forwards;
        }

        @keyframes fadeEffect {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="container fade-in">
        <h2>Property Entry Form</h2>
        <form action="property_page.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <!-- Category and Address -->
                <div>
                    <label for="category">Category:</label>
                    <select name="cid" id="category" required>
                        <option value="">Select Category</option>
                        <?php
                        $conn = mysqli_connect("localhost", "root", "", "house_rental");

                        if (!$conn) {
                            die("Connection failed: " . mysqli_connect_error());
                        }

                        $sql = "SELECT id, cname FROM tblcategory";
                        $result = mysqli_query($conn, $sql);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row['id'] . "'>" . $row['cname'] . "</option>";
                        }

                        mysqli_close($conn);
                        ?>
                    </select>
                </div>

                <div>
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" maxlength="255" required>
                </div>

                <!-- Rent -->
                <div>
                    <label for="rent">Rent:</label>
                    <input type="number" step="0.01" id="rent" name="rent" placeholder="Rent" required>
                </div>

                <!-- Bedrooms -->
                <div>
                    <label for="bedroom">Bedrooms:</label>
                    <input type="number" id="bedroom" name="bedroom" placeholder="Bedrooms" required>
                </div>

                <!-- Bathrooms -->
                <div>
                    <label for="bathroom">Bathrooms:</label>
                    <input type="number" id="bathroom" name="bathroom" placeholder="Bathrooms" required>
                </div>

                <!-- Kitchen -->
                <div>
                    <label for="kitchen">Kitchen:</label>
                    <input type="number" id="kitchen" name="kitchen" placeholder="Kitchen" required>
                </div>

                <!-- Floor -->
                <div>
                    <label for="floor">Floor:</label>
                    <input type="number" id="floor" name="floor" placeholder="Floor" required>
                </div>

                <!-- Parking -->
                <div>
                    <label for="parking">Parking:</label>
                    <input type="number" min="0" max="1" id="parking" name="parking" placeholder="Parking (0 or 1)" required>
                </div>

                <!-- Property Size -->
                <div>
                    <label for="size">Property Size (in square feet):</label>
                    <input type="number" step="0.01" id="size" name="size" placeholder="Size">
                </div>

                <!-- Description -->
                <div style="flex: 1 1 100%;">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" rows="3"></textarea>
                </div>

                <!-- Upload Document -->
                <div>
                    <label for="document">Upload Document:</label>
                    <input type="file" id="document" name="document" required>
                </div>

                <!-- Upload House Image -->
                <div>
                    <label for="house_image">Upload House Image:</label>
                    <input type="file" id="house_image" name="house_image" required>
                </div>
            </div>

            <!-- Submit Button -->
            <input type="submit" name="btnsubmit" value="Submit">
        </form>
    </div>
</body>
</html>
