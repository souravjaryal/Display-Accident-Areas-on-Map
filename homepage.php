<?php
if (isset($_SESSION['user'])) {
    echo "<div class='user-profile'>";
    echo "<img src='img/user.png' alt='user'>";
    echo "<span>" . $_SESSION['user'] . "</span>";
    echo "<a href='logout.php'>Sign out</a>";
    echo "</div>";
} 
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="homepage.css">
</head>

<body>
    <header>
        <nav class="navig">
            <ul>
                <li><a href="#" class="active">HOME</a></li>
                <li><a href="#aboutus">ABOUT US</a></li>
                <li><a href="#contactus">CONTACT US</a></li>
                <li><a href="map.html" target="_blank">VIEW MAP</a></li>
                <form action="login.php">
                    <input type="submit" value="LOGOUT" id="logout">
                </form>
            </ul>
        </nav>
    </header>
    <div class="col-sm-12 col-centered"></div>
    <div id="carouselExample" class="carousel slide col-sm-12 col-centered" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExample" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExample" data-slide-to="1"></li>
            <li data-target="#carouselExample" data-slide-to="2"></li>
            <li data-target="#carouselExample" data-slide-to="3"></li>
            <li data-target="#carouselExample" data-slide-to="4"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/anime.jpg" alt="no pic">
            </div>
            <div class="carousel-item">
                <img src="img/car.png" alt="no pic">
            </div>
            <div class="carousel-item">
                <img src="img/alll.jpg" alt="no pic">
            </div>
            <div class="carousel-item">
                <img src="img/animated.png" alt="no pic">
            </div>
            <div class="carousel-item">
                <img src="img/video.png" alt="no pic">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div id="about">
        <h1 id="heading">ABOUT US</h1>
        <p id="about">Introducing our new website, designed to keep you safe while you are on the road. Our website is
            equipped with a state-of-the-art map system that alerts you when you are approaching accident-prone areas.
            We use data from government databases to identify these areas, based on their previous history of accidents.
            By leveraging this data, we can provide you with real-time alerts that can help you avoid accidents and
            other dangerous situations.
            We take the safety of our users very seriously, and that's why we have created this website. By utilizing
            data from government databases on accident-prone areas, we are able to provide you with accurate and
            up-to-date information that can help you stay safe on the road.</p>
    </div>

    <br>

    <footer>
        <div class="info-wrap">
            <h1 id="contactus">CONTACT US</h1>
            <ul class="info-details">
                <li>
                    <i class="fas fa-phone-alt"></i>
                    <span class="clr">PHONE NO:</span> <a href="tel:+123456789">+91-0123456789</a>
                </li>
                <li>
                    <i class="fas fa-paper-plane"></i>
                    <span class="clr">E-MAIL:</span> <a href="mailto:info@yoursite.com">xyz@gmail.com</a>
                </li>
            </ul>
            <div class="social">
                <a href="https://www.facebook.com/yourpagename"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.twitter.com/yourpagename"><i class="fab fa-twitter"></i></a>
                <a href="https://www.instagram.com/yourpagename"><i class="fab fa-instagram"></i></a>
                <a href="https://www.linkedin.com/yourpagename"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
