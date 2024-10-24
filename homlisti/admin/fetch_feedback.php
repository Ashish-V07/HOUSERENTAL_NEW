<?php
include 'db_connection.php';

// Get the search filters from the AJAX request
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$type_filter = isset($_GET['type']) ? $_GET['type'] : '';

// Create the base SQL query
$sql = "SELECT fid, uid, type, descr, date, status FROM tblfeedback WHERE 1=1";

// Apply filters based on selected status and type
if (!empty($status_filter)) {
    $sql .= " AND status = '" . mysqli_real_escape_string($conn, $status_filter) . "'";
}
if (!empty($type_filter)) {
    $sql .= " AND type = '" . mysqli_real_escape_string($conn, $type_filter) . "'";
}

$result = mysqli_query($conn, $sql);

// Check if any feedback records are found
if (mysqli_num_rows($result) > 0) {
    // Loop through the result set and generate table rows
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['fid'] . "</td>";
        echo "<td>" . $row['uid'] . "</td>";
        echo "<td>" . $row['type'] . "</td>";
        echo "<td>" . $row['descr'] . "</td>";
        echo "<td>" . $row['date'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        
        // Show 'Done' button if status is 'UNDER REVIEW'
        if ($row['status'] == 'UNDER REVIEW') {
            echo "<td><button class='btn btn-success done-btn' id='btnDone' data-fid='" . $row['fid'] . "' data-uid='" . $row['uid'] . "'>Done</button></td>";
        } else {
            echo "<td><button class='btn btn-secondary' disabled>Done</button></td>";
        }
        
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No feedbacks found</td></tr>";
}

mysqli_close($conn);
?>
