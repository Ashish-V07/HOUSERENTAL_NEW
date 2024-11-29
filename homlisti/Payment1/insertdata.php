<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require 'vendor/autoload.php'; // Include Razorpay SDK
        session_start();

        use Razorpay\Api\Api;

        if (isset($_GET['method'])) {
            $conn = mysqli_connect("localhost", "root", "", "house_rental");

            $method = $_GET['method'];
            // Razorpay API Key and Secret
            $key = 'rzp_test_m1eAUjY9HN3jsd';       // Replace with your Razorpay Key ID
            $secret = 'GXPobogvAfuhuiFjnXDaGeVc'; // Replace with your Razorpay Secret
            // Initialize Razorpay API
            $api = new Api($key, $secret);

            try {
                // Fetch payment details
                $payment = $api->payment->fetch($method);
                $payment_method = $payment->method; // e.g., 'card', 'upi', 'netbanking'
                // Save payment details into the database
                $uid = $_GET['uid']; // User ID
                $pid = $_GET['pid']; // Property ID
                $amount = $_GET['amount'];

                $sql_property = "SELECT rent FROM property WHERE pid = '$pid'";
                $result_property = mysqli_query($conn, $sql_property);
                if (mysqli_num_rows($result_property) > 0) {
                    $property = mysqli_fetch_assoc($result_property);
                    $monthly_rent = $property['rent'];
                } else {
                    die("Property not found.");
                }

                $start_date = date('Y-m-d'); // Current date
                $end_date = date('Y-m-d', strtotime("+30 days")); // +30 days from current date

                $sql_rent = "INSERT INTO tblrent (uid,pid,startdate,enddate,monthlyrent) 
             VALUES ('$uid', '$pid','$start_date', '$end_date','$monthly_rent')";

                if (mysqli_query($conn, $sql_rent)) {
                    $rentId = mysqli_insert_id($conn); // Get the inserted rentid
                    // Step 3: Insert into tbl_payment table using the rentid, uid, and other details
                    $payment_date = date('Y-m-d'); // Payment date (current date)
                    // Payment method
                    $status = 'successful'; // Payment status
                    $rid=$rentId;
                    $sql_payment = "INSERT INTO tblpayment (rid,tid,amount,pdate,pmethod, status) 
                    VALUES ('$rentId', '$uid', '$amount','$payment_date', '$payment_method', '$status')";

                    if (mysqli_query($conn, $sql_payment)) {
                        $_SESSION['payment_msg'] = "Payment successful Thank you";
                          //$_SESSION['rentID']=$rid;
                          setcookie("rentID",$rid,time()+86400*365,"/");
                        header("Location: /houserental-master/homlisti/Genrate_Bill/Send_bill.php");
                        exit();
                    } else {
                        echo "Error inserting payment data: " . mysqli_error($conn);
                    }
                } else {
                    echo "Error inserting rent data: " . mysqli_error($conn);
                }
            } catch (Exception $e) {
                echo "Error fetching payment details: " . $e->getMessage();
            }
        } else {
            echo "Payment ID not provided.";
        }
        ?>

    </body>
</html>
