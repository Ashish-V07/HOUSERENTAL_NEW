<?php
include 'db_connection.php';

if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    
    $query = "SELECT document FROM property WHERE pid = '$pid'";
    $result = mysqli_query($conn, $query);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $document = $row['document'];
        
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="property_document.pdf"');
        echo $document;
        exit();
    }
}

header("Location: admin_verify.php");
exit();
?>
