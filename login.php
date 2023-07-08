<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";
$port = 3307;
$conn = mysqli_connect($servername, $username, $password, $dbname, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} 

$msg = ""; // Initialize the $msg variable

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $uname = $_POST['email'];
    $pwd = $_POST['paswrd'];
    $check_user = "SELECT email, password FROM usertable WHERE email = '$uname' AND password = '$pwd'";
    $response = mysqli_query($conn, $check_user);
    
    if (mysqli_num_rows($response) == 1) {
        $_SESSION['user'] = $uname;
        header("Location: homepage.php");
        exit();
    } else {
        $msg = "Wrong password";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="login.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <form action="login.php" method="post">
        <h1 id="hd">Login</h1>
        <br>
        <label for="username">USER NAME</label><br>
        <div> <input type="email" name="email" id="username" required="required"> </div>
        <br>
        <label for="paswrd">PASSWORD</label><br>
        <div><input type="password" name="paswrd" id="paswrd"><?php echo $msg; ?></div>
        <br>
        <div class="g-recaptcha" data-sitekey="6LecAnYlAAAAAMsTps4xJMZF3LBj_1np2gaX8oWz"></div>
        <br>
        <a href="forgetpassword">FORGET PASSWORD</a>
        <br>
        <br>
        <div>
            <input type="submit" value="LOGIN" id="sub">
        </div>

        <br>
        Create an account? <a href="signup.php">Signup</a>
        <br>
    </form>
</body>
</html>
