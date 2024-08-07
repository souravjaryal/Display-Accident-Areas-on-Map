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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Basic validation
    if (empty($name) || empty($email) || empty($password)) {
        $msg = "Please enter all required fields.";
        } 
        else {
            $check_user = "SELECT email FROM usertable WHERE email = ?";
            $stmt = mysqli_prepare($conn, $check_user);
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result === false) {
                $msg = "Error in executing the database query.";
            } elseif (mysqli_num_rows($result) === 0) {
                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $store_users = "INSERT INTO usertable (name, email, password) 
                            VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($conn, $store_users);

                if ($stmt === false) {
                    $msg = "Error in preparing the database query.";
                } else {
                    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed_password);
                    mysqli_stmt_execute($stmt);

                    if (mysqli_stmt_affected_rows($stmt) > 0) {
                        $_SESSION['user_name'] = $name; // Store the user's name in the session
                        // this line to set the user ID in the session
                        $_SESSION['user_id'] = mysqli_insert_id($conn);
                        header("Location: index.php");
                        exit();
                    } else {
                        echo "Signup failed. Please try again later.";
                    }
                }
            } else {
                $msg = 'User already exists. Please choose a different email address.';
            }
        }
    }
// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sign up</title>
    <link rel="stylesheet" href="signup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body>
    <div class="signupform" id="signupform">
        <form action="signup.php" method="post">
            <div class=form-container>
                <hr>
                <h1 id="hd"> Sign up</h1>
                <div>
                    <div id="line">
                        Create an account to start your
                    </div>
                    <div class="line1">
                        Safe Journey!
                    </div>
                </div>

                <label for="name">Name</label><br>
                <div>
                    <input type="text" name="name" id="name" required="required" placeholder="Full name">
                </div>
                <br>
                <label for="email">Email</label><br>
                <div>
                    <input type="email" name="email" id="email" required="required" placeholder="Enter your email address">
                </div>
                <br>
                <div>
                    <label for="password">Password</label><br>
                    <div class="input-box">
                        <input class="password" type="password" name="password" id="password" required="required" placeholder="Enter Password" title="minimum 8 characters and mix of (A-Z), (a-z), (0-9) and (!@#$%^&*)">
                        <p id="message">Password is <span id="strength"></span></p>
                        <i class="show fa fa-eye"></i>
                        <i class="hide fa fa-eye-slash"></i>
                    </div>
                </div>
                <br>
                <div class="g-recaptcha" data-sitekey="6LecAnYlAAAAAMsTps4xJMZF3LBj_1np2gaX8oWz" required="required"></div>
                <br>
                    <input type="checkbox" name="check" id="checkbox" required="required">
                <span class="terms">I accept the <a href="#">Terms Of Use</a> & <a href="#">Privacy Policy</a></span>
                <br>
                <div class="button-container">
                    <input type="submit" value="Sign up" id="submit">
                </div>
                <br>
                <div class="account">
                    Already registered? <a href="login.php">Log in</a>
                </div>
                <br>
                <div class="line"></div>

                <div class="signup-options">
                <div class="google">
                    <img src="img/google.png" id="google-icon">
                    <span>Continue with Google</span>
            </div>

                    <div class="facebook">
                    <img src="img/facebook.png" id="facebook-icon">
                    <span>Continue with Facebook</span>
            </div>
            </div>
            </div>
        </form>
    </div>
    <script>
        var pass = document.getElementById("password");
        var msg = document.getElementById("message");
        var str = document.getElementById("strength");

        pass.addEventListener('input', () => {
            if (pass.value.length > 0) {
                msg.style.display = "block";
            } else {
                msg.style.display = "none";
            }

            var hasLowerCase = /[a-z]/.test(pass.value);
            var hasUpperCase = /[A-Z]/.test(pass.value);
            var hasDigit = /\d/.test(pass.value);
            var hasSpecialChar = /\W/.test(pass.value);
            var isLengthValid = pass.value.length >= 8;

            if (isLengthValid && hasLowerCase && hasUpperCase && hasDigit && hasSpecialChar) {
                str.innerHTML = "strong";
                pass.style.borderColor = "green";
                msg.style.color = "green";
            } else if (hasLowerCase && hasUpperCase && hasDigit) {
                str.innerHTML = "medium";
                pass.style.borderColor = "orange";
                msg.style.color = "orange";
            } else {
                str.innerHTML = "weak";
                pass.style.borderColor = "red";
                msg.style.color = "red";
            }
        });
        pass.addEventListener('blur', () => {
            pass.style.borderColor = "";
            msg.style.display = "none";
        });

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
