<?php
session_start();

if (isset($_SESSION['email'])) {
    header("Location: dashboard.php");
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="logstyle.css"/>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="login">Login</button>
        </form>
        <div class="login-link">
            <p>If you don't have an account, <a href="registration.php">register here</a></p>
        </div>
        <p class="message"><?php echo $message; ?></p>
    </div>
</body>
</html>
