<?php
$conn = mysqli_connect("localhost", "root", "", "test");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$property_id = 2  ;
$sql = "SELECT * FROM property WHERE id = '$property_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    
    $document = $row['document'];
    $document_name = 'document_' . $property_id . '.pdf'; // You can name the document dynamically

    if (!empty($document)) {
          echo "<h3>Uploaded Document:</h3>";
        echo "<a href='data:application/pdf;base64," . base64_encode($document) . "' download='$document_name'>Download Document</a>";
        
        echo "<embed src='data:application/pdf;base64," . base64_encode($document) . "' width='600' height='400' type='application/pdf'>";
    } else {
        echo "No document uploaded.";
    }
} else {
    echo "No property found.";
}


$sql_images = "SELECT image FROM tblimage WHERE pid = '$property_id'";
$result_images = mysqli_query($conn, $sql_images);

if (mysqli_num_rows($result_images) > 0) {
    echo "<h3>Uploaded Images:</h3>";
    while ($row_image = mysqli_fetch_assoc($result_images)) {
        $image_data = $row_image['image'];
        echo "<img src='data:image/jpeg;base64," . base64_encode($image_data) . "' alt='House Image' width='300' height='200'><br><br>";
    }
} else {
    echo "No images uploaded.";
}

mysqli_close($conn);
?>
