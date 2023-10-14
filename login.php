<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "safejourney";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$msg = ""; // Initialize the $msg variable

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Basic validation
    if (empty($email) || empty($password)) {
        $msg = "Please enter both email and password.";
    } else {
        $check_user = "SELECT id, email, password FROM usertable WHERE email = ? LIMIT 1";
        $stmt = mysqli_prepare($conn, $check_user);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result === false) {
            $msg = "Error in executing the database query.";
        } elseif (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_email'] = $email;
                $_SESSION['user_id'] = $row['id'];
                // Fetch and store user name in session
                $user_name_query = "SELECT name FROM usertable WHERE id = ?";
                $stmt = mysqli_prepare($conn, $user_name_query);
                mysqli_stmt_bind_param($stmt, "i", $row['id']);
                mysqli_stmt_execute($stmt);
                $name_result = mysqli_stmt_get_result($stmt);
                $name_row = mysqli_fetch_assoc($name_result);
                $_SESSION['user_name'] = $name_row['name'];
                // $_SESSION['profile_picture'] = $user_profile_row['$user_profile'];
                // $user_profile = $_SESSION['profile_picture'];
                // Assuming $profile_picture_path contains the path to the user's profile picture
                // $_SESSION['profile_picture'] = $profile_picture_path;
                // Fetch and store user profile picture path in session
                $profile_picture_query = "SELECT user_profile FROM usertable WHERE id = ?";
                $stmt = mysqli_prepare($conn, $profile_picture_query);
                mysqli_stmt_bind_param($stmt, "i", $row['id']);
                mysqli_stmt_execute($stmt);
                $profile_result = mysqli_stmt_get_result($stmt);
                $profile_row = mysqli_fetch_assoc($profile_result);
                $_SESSION['profile_picture'] = $profile_row['user_profile'];

                

                // Set a cookie to remember the email address if the checkbox is checked
                if (isset($_POST['remember_me'])) {
                    // Set a cookie to keep the user logged in for a longer duration
                    $cookie_name = "user_email";
                    $cookie_value = $email;
                    $cookie_duration = 60 * 60 * 24 * 7; // 7 days
                    setcookie($cookie_name, $cookie_value, time() + $cookie_duration, "/");
                }

                header("Location: home.php");
                exit();
            } else {
                $msg = "Wrong password. Please try again.";
            }
        } else {
            $msg = "User not found. Please check your email and try again.";
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <div class="loginform" id="loginform">
        <form action="login.php" method="post">
            <div class=form-container>
                <hr>
                <h1 id="hd">Log in</h1>
                <br>
                <label for="email">Email Address</label><br>
                <div>
                    <input type="email" name="email" id="email" required="required" placeholder="Enter your email address">
                </div>
                <br>
                <div>
                <label for="password">Password <a href="forgotpassword.html">Forgot Password?</a></label><br>
                <div class="input-box">
                    <input class="password" type="password" name="password" id="password" required="required" placeholder="Enter password">
                    <?php echo $msg; ?>
                        <i class="show fa fa-eye"></i>
                        <i class="hide fa fa-eye-slash"></i>
                </div>
                </div>
                <br>
                <div class="g-recaptcha" data-sitekey="6LecAnYlAAAAAMsTps4xJMZF3LBj_1np2gaX8oWz" required="required"></div>
                <br>
                <div class="rememberme">
                    <input type="checkbox" name="remember_me" id="remember_me">
                    <label for="remember_me">Remember Me</label>
                </div>
                <br>
                <div class="button-container">
                    <input type="submit" value="Log in" id="submit">
                </div>
                <br>
                <div class="account">
                    Create an account? <a href="signup.php">Sign up</a>
                </div>
                <br>
                <div class="line"></div>

                <div class="signup-options">
                <div class="google">
                    <img src="img/google.png" id="google-icon">
                    <span>Log in with Google</span>
            </div>

                    <div class="facebook">
                    <img src="img/facebook.png" id="facebook-icon">
                    <span>Log in with Facebook</span>
            </div>
            </div>
            </div>
        </form>
    </div>
    <script>
         var passwordField = document.querySelector('.password');
        var show = document.querySelector('.show');
        var hide = document.querySelector('.hide');

        show.onclick = function() {
            passwordField.setAttribute("type", "password");
            show.style.display = "none";
            hide.style.display = "block";
        }
        hide.onclick = function() {
            passwordField.setAttribute("type", "text");
            hide.style.display = "none";
            show.style.display = "block";
        }
    </script>
</body>

</html>