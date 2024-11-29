<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Database connection
$conn = mysqli_connect("localhost", "root", "", "house_rental");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch `pid` from the URL
if (!isset($_GET['pid'])) {
    echo "Property ID not provided.";
    exit();
}

$pid = $_GET['pid'];

// Fetch payment details from `tblpayment` related to the `pid`
$sql = "SELECT p.id AS payment_id, r.uid,t.adress,p.amount, p.pdate, p.status AS payment_status 
        FROM tblpayment p 
        INNER JOIN tblrent r ON p.rid = r.rid 
        INNER JOIN property t ON t.pid=r.pid
        INNER JOIN tbl_users u ON u.id=t.uid
        WHERE r.pid = '$pid'";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
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
</head>
<body>
   

    <h2>Payment Details for Property <?php echo $_GET['padd'];?></h2>

<?php if (mysqli_num_rows($result) > 0): ?>
    <table>
        <tr>
            <th>Payment ID</th>
            <th colspan="2">User Name</th>
            <th>Amount</th>
            <th>Payment Date</th>
            <th>Status</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <?php 
        $id=$row['uid'];
        $user="select fname,lname from tbl_users where id=$id";
        $userres=mysqli_query($conn, $user);  
        $resu= mysqli_fetch_assoc($userres);
        
                ?>
            <tr>
                <td><?= htmlspecialchars($row['payment_id']) ?></td>
                <td><?= htmlspecialchars($resu['fname']) ?></td>
                <td><?= htmlspecialchars($resu['lname']) ?></td>
                <td>Rs. <?= number_format($row['amount'], 2) ?></td>
                <td><?= htmlspecialchars($row['pdate']) ?></td>
                <td><?= htmlspecialchars($row['payment_status']) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p style="text-align: center;">No payment details found for this property.</p>
<?php endif; ?>

<a href="home.php" class="back-button">Back to Properties</a>

</body>
</html>
