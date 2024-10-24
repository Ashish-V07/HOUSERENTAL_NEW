<?php
include 'db_connection.php'; // DB connection

if (isset($_POST['search_query'])) {
    $searchQuery = mysqli_real_escape_string($conn, $_POST['search_query']);
    $query = "
        SELECT u.*, COUNT(p.cid) AS property_count 
        FROM tbl_users u 
        LEFT JOIN property p ON u.id = p.uid 
        WHERE u.fname LIKE '%$searchQuery%' OR u.User_Status LIKE '%$searchQuery%' OR u.lname LIKE '%$searchQuery%' OR u.id LIKE '%$searchQuery%' OR u.email LIKE '%$searchQuery%'
        GROUP BY u.id
    ";
    $result = mysqli_query($conn, $query);
    $output = '';

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $output .= "<tr>
                <td>{$row['id']}</td>
                <td>{$row['fname']}</td>
                <td>{$row['lname']}</td>
                <td>{$row['email']}</td>
                <td>{$row['mobile']}</td>
                <td>{$row['aadhar']}</td>
                    <td>{$row['property_count']}</td>
            </tr>";
        }
    } else {
        $output .= "<tr><td colspan='6'>No users found</td></tr>";
    }
    echo $output;
}
?>
