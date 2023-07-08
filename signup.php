<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";
$port = 3307;
$conn = mysqli_connect($servername, $username, $password, $dbname, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} 


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['uname'];
    $email = $_POST['email'];
    $pwd = $_POST['pasword'];
    $check_user = "SELECT email FROM usertable WHERE email = '$email'";
    $response = $conn->query($check_user);
    if ($response->num_rows == 0) {
        $store_users = "INSERT INTO usertable (name, email, password) 
                        VALUES ('$username', '$email', '$pwd')";
       
        if ($conn->query($store_users)) {
            echo "Successfully Signup";
            header("Location: login.php");
            exit();
        } else {
            echo "Signup failed";
        }
    } else {
        echo 'User already exists';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGN UP</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>
    <form action="signup.php" method="post">
        <h1 id="hd"> SIGN UP</h1>
        <h3 id="line">It's free and only takes a minute</h3>
        <label for="username">NAME</label><br>
        <div> <input type="text" name="uname" id="uname" required="required"> </div>
        <br>
        <label for="mail">EMAIL</label><br>
        <div> <input type="email" name="email" id="mail" required="required"> </div>
        <br>
        <label for="paswrd">PASSWORD</label><br>
        <div><input type="password" name="pasword" id="paswrd" required="required"></div>
        <br>
        <input type="checkbox" name="check" required="required">
        <span class="terms">I accept the <a href="">Term Of Use</a>& <a href="">Privacy Policy</a></span>
        <br><br>
        <div>
            <input type="submit" value="SIGN UP" id="sub" onclick="tst()">
        </div>
        <br>
        Already registered? <a href="login.php">Login</a>
        <br>
    </form>
</body>
</html>
