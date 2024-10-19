<?php
session_start();

if (isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$message = '';

$c = mysqli_connect('localhost', 'root', '', 'house_rental');

if (!$c) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT password,fname FROM tbl_users WHERE email = '$email'";
    $nameQuery="select fname from tbl_users where email='$email'";
  
    $result = mysqli_query($c, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $stored_password = $row['password'];
        $_SESSION['name']=$row['fname'];
        if (password_verify($password, $stored_password)) {
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email; 
            header("Location: dashboard.php"); 
            exit();
        } else {
            $message = 'Invalid email or password.';
        }
    } else {
        $message = 'Invalid email or password.';
    }
}

mysqli_close($c);
?>