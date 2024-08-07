<?php
session_start(); // Start the session

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
    $user_profile = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : '';
} else {
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safe Journey</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <link rel="stylesheet" href="home.css">
    <link rel="icon" href="img/journey.png">
</head>

<body>
    <div class="navbar">
        <nav>
            <div>
                <a href="index.php" class="logo">
                    <img src="img/journey.png" alt="logo img">
                    <h1>Safe Journey</h1>
                </a>
            </div>
            <ul>
                <li><a href="#home" id="homeLink" class="active">Home</a></li>
                <li><a href="map.php">View Map</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contactus">Contact Us</a></li>
            </ul>
            <img src="<?php echo !empty($user_profile) ? $user_profile : 'img/default-profile.png'; ?>" class="user-profile" alt="Profile Picture" onclick="toggleMenu()">


            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info-box">
                        <div class="user-info">
                            <img src="<?php echo !empty($user_profile) ? $user_profile : 'img/default-profile.png'; ?>" class="user-profile" alt="Profile Picture">
                            <h3 class="user-name"><?php echo $user_name; ?></h3>
                        </div>
                        <hr>
                    </div>


                    <a href="#" class="sub-menu-link" onclick="showEditProfileForm()">
                        <img src="img/profile.png">
                        <p>Edit Profile</p>
                        <span class="chevron"><i class="fas fa-chevron-right"></i></span>
                    </a>

                    <div id="editProfileForm">
                        <img id="back_arrow_edit" src="img/left-arrow.png" onclick="hideEditProfileForm()" alt="Back Arrow">
                        <span>Edit Profile</span>
                        <img id="profilePreview" src="<?php echo !empty($user_profile) ? $user_profile : 'img/default-profile.png'; ?>" class="user-profile" alt="Profile Picture">
                        <form action="update_profile.php" method="post" enctype="multipart/form-data">
                            <div class="file-container">
                                <label for="file-input">Choose File</label>
                                <input type="file" id="file-input" name="profile_picture" accept="image/*" required onchange="previewImage(event)">
                                <input type="submit" value="Upload Profile" class="upload_profile">
                            </div>
                        </form>
                    </div>


                    <a href="#" class="sub-menu-link" onclick="showSettingsForm()">
                        <img src="img/setting.png">
                        <p>Settings & Privacy</p>
                        <span class="chevron"><i class="fas fa-chevron-right"></i></span>
                    </a>

                    <div id="SettingsForm">
                        <img id="back_arrow_settings" src="img/left-arrow.png" onclick="hideSettingsForm()" alt="Back Arrow">
                        <span>Settings & Privacy</span>
                    </div>

                    <a href="#" class="sub-menu-link" onclick="showHelpForm()">
                        <img src="img/help.png">
                        <p>Help & Support</p>
                        <span class="chevron"><i class="fas fa-chevron-right"></i></span>
                    </a>

                    <div id="HelpForm">
                        <img id="back_arrow_help" src="img/left-arrow.png" onclick="hideHelpForm()" alt="Back Arrow">
                        <span>Help & Support</span>
                    </div>

                    <a href="#" class="sub-menu-link" onclick="showNightModeForm()">
                        <img src="img/night-mode.png">
                        <p>Display & Accessibility</p>
                        <span class="chevron"><i class="fas fa-chevron-right"></i></span>
                    </a>

                    <div id="NightModeForm">
                        <img id="back_arrow_nightmode" src="img/left-arrow.png" onclick="hideNightModeForm()" alt="Back Arrow">
                        <span>Display & Accessibility</span>
                    </div>

                    <a href="#" class="sub-menu-link">
                        <img src="img/feedback.png">
                        <p>Give Feedback</p>
                        <span></span>
                    </a>

                    <a href="logout.php" class="sub-menu-link">
                        <img src="img/logout.png">
                        <p>Log out</p>
                        <span></span>
                    </a>

                </div>
            </div>
        </nav>
    </div>
    <div class="journey-banner" id="home">
        <h1>
            Start your <span style="color: #FFA500;">Journey</span> with <span style="color: #e12c2c;">Safe Journey!</span>
        </h1>
        <h3>
            We will guide you with safety by informing about accident-prone <br> areas when you reach one.
        </h3>
        <img src="img/directions-concept-illustration_114360-1741.avif" alt="Start Your Journey">
    </div>

    <div class=carousel-box>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="5"></li>

        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="img/car.jpg" alt="First Slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="img/car1.png" alt="Second Slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="img/car2.jpg" alt="Third Slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="img/car3.jpg" alt="Fourth Slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="img/car4.avif" alt="Fifth Slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="img/car5.jpg" alt="Sixth Slide">
            </div>

        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    </div>

    <div class="about" id="about" data-aos="zoom-in" data-aos-easing="ease-in-out" data-aos-delay="200" data-aos-offset="0">
        <h1>ABOUT</h1>
        <p>Our platform is equipped with a state-of-the-art map system that alerts you
            when you are approaching accident-prone areas. We use data from government databases
            to identify these areas, based on their previous history of accidents. By leveraging
            this data, we can provide you with real-time alerts that can help you avoid accidents
            and other dangerous situations. We take the safety of our users very seriously, and that's
            why we have created this platform. By utilizing data from government databases on accident-prone
            areas, we are able to provide you with accurate and up-to-date information that can help you stay
            safe on the road.
        </p>
    </div>
    <div class="contactus" id="contactus" data-aos="zoom-in" data-aos-easing="ease-in-out" data-aos-delay="200" data-aos-offset="0">
        <h1>Contact <span>Us!</span></h1>
        <div class="contact-container">
            <div class="form">
                <div class="form-group">
                    <input class="form-input" type="text" name="name" id="name" placeholder="Full Name">
                    <input class="form-input" type="number" name="phone" id="phone" placeholder="Mobile Number">
                </div>
                <div class="form-group">
                    <input class="form-input" type="email" name="email" id="email" placeholder="Email Address">
                    <input class="form-input" type="text" name="subject" id="subject" placeholder="Subject">
                </div>
                <div class="your-message">
                    <textarea class="form-input" name="text" id="text" cols="30" rows="10" placeholder=" Your Message"></textarea>
                </div>
                <br>
                <div>
                    <input type="submit" value="Send Message" id="sub">
                </div>
            </div>
            <div class="contact-image">
                <img src="img/contactus.png" alt="Contact Image">
            </div>
        </div>
    </div>
    <br>

    <div class="d-flex flex-column h-100">
        <section class="hero text-white py-5 flex-grow-1">
            <div class="container py-4">
                <div class="row">
                    <div class="col-lg-6">
                    </div>
                </div>
            </div>
        </section>


        <!-- FOOTER -->
        <footer class="w-100 py-4 flex-shrink-0">
            <div class="container py-4">
                <div class="row gy-4 gx-5">
                    <div class="col-lg-4 col-md-6">
                        <h5 class="h1 text-white" style="margin-left: -400px;">Safe Journey</h5>
                        <p class="medium text-muted" style="margin-left: -400px; font-size: 20px;">Start your Journey with Safe Journey!</p>
                    </div>
                    <div class="col-lg-2 col-md-6" style="margin-left: 20px; font-size: 18px;">
                        <h5 class="text-white mb-3">Quick links</h5>
                        <ul class="list-unstyled text-muted">
                            <li><a href="#home">Home</a></li>
                            <li><a href="map.php">View Map</a></li>
                            <li><a href="#about">About</a></li>
                            <li><a href="#contactus">Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-6" style="margin-left: 300px; font-size: 18px;">
                        <h5 class="text-white mb-3">Company</h5>
                        <ul class="list-unstyled text-muted">
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Investors</a></li>
                            <li><a href="#">Terms & Conditions</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr>
            <div class="bottom-line">
                <div class="copyright">
                    <p class="small text-muted mb-0">
                        &copy; Copyrights. All rights reserved. <a class="text-primary" href="#">safejourney.com</a>
                    </p>
                </div>
                <div class="d-flex justify-content-end" style="margin-right: 45px;">
                    <a href="#"><i class="fab fa-facebook-f mx-3"></i></a>
                    <a href="#"><i class="fab fa-twitter mx-3"></i></a>
                    <a href="#"><i class="fab fa-instagram mx-3"></i></a>
                    <a href="#"><i class="fab fa-linkedin mx-3"></i></a>
                    <a href="#"><i class="fab fa-youtube mx-3"></i></a>
                </div>
            </div>
        </footer>
    </div>



    <script>
        /*
    function toggleMenu(){
        var subMenu = document.getElementById("subMenu");
        subMenu.classList.toggle("open-menu");
    }
    document.addEventListener('click', function(event) {
        var subMenu = document.getElementById('subMenu');
        var userIcon = document.querySelector('.user-profile');

        if (event.target !== subMenu && !subMenu.contains(event.target) && event.target !== userIcon) {
            subMenu.classList.remove('open-menu');
        }
});
*/
        /*
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth scrolling to all links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();

                   /* document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                   
                  let targetElement = document.querySelector(this.getAttribute('href'));
                    let offset = 132;

                    window.scrollTo({
                        top: targetElement.offsetTop - offset,
                        behavior: 'smooth'
                        
                    });
                });
            });
        });
        */
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth scrolling to all links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();

                    let targetElement;
                    let offset;

                    if (this.getAttribute('href') === '#home') {
                        targetElement = document.querySelector('#home');
                        offset = 248; // Adjust the offset for the Home section
                    } else if (this.getAttribute('href') === '#about') {
                        targetElement = document.querySelector('#about');
                        offset = 180; // Adjust the offset for the About section
                    } else if (this.getAttribute('href') === '#contactus') {
                        targetElement = document.querySelector('#contactus');
                        offset = 121; // Adjust the offset for the Contact Us section
                    } else {
                        targetElement = document.querySelector(this.getAttribute('href'));
                        offset = 132;
                    }

                    window.scrollTo({
                        top: targetElement.offsetTop - offset,
                        behavior: 'smooth'
                    });
                });
            });

            AOS.init(); // Initialize AOS
        });
        // Javascript for sliding animation to carousel images
        document.addEventListener('DOMContentLoaded', function() {
            var carousel = document.getElementById('carouselExample');
            var currentIndex = 0;

            function slideRight() {
                var items = carousel.querySelectorAll('.carousel-item');
                currentIndex = (currentIndex + 1) % items.length;
                items[currentIndex].classList.add('active');
                items[(currentIndex + items.length - 1) % items.length].classList.remove('active');
            }

            function startCarousel() {
                setInterval(slideRight, 3000); // Slide every 3 seconds (adjust as needed)
            }

            startCarousel();
        });
        /*
        document.addEventListener('DOMContentLoaded', function() {
            var homeLink = document.getElementById('homeLink');
            var aboutLink = document.querySelector('a[href="#about"]');
            var contactUsLink = document.querySelector('a[href="#contactus"]');

            aboutLink.addEventListener('click', function() {
                homeLink.classList.remove('active');
            });

            contactUsLink.addEventListener('click', function() {
                homeLink.classList.remove('active');
            });

            homeLink.addEventListener('click', function() {
                homeLink.classList.add('active');
            });
        });
        */
        document.addEventListener('DOMContentLoaded', function() {
            var homeLink = document.getElementById('homeLink');

            homeLink.addEventListener('click', function(e) {
                e.preventDefault();
            });
        });



        function toggleMenu() {
            var subMenu = document.getElementById("subMenu");
            subMenu.classList.toggle("open-menu");
            //subMenu.classList.toggle("close-menu");

        }

        document.addEventListener('click', function(event) {
            var subMenu = document.getElementById('subMenu');
            var userIcon = document.querySelector('.user-profile');
            var editProfileForm = document.getElementById("editProfileForm");
            var settingsForm = document.getElementById("SettingsForm");
            var helpForm = document.getElementById("HelpForm");
            var nightmodeForm = document.getElementById("NightModeForm");

            if (event.target !== subMenu && !subMenu.contains(event.target) && event.target !== userIcon) {
                subMenu.classList.remove('open-menu');
                editProfileForm.style.display = "none";
                settingsForm.style.display = "none";
                helpForm.style.display = "none";
                nightmodeForm.style.display = "none";
            }
        });

        function showEditProfileForm() {
            hideSettingsForm();
            hideHelpForm();
            hideNightModeForm();
            var editProfileForm = document.getElementById("editProfileForm");
            var subMenu = document.getElementById("subMenu");
            editProfileForm.style.display = "block";
            //subMenu.classList.remove('open-menu');
        }

        function hideEditProfileForm() {
            var editProfileForm = document.getElementById("editProfileForm");
            var subMenu = document.getElementById("subMenu");
            editProfileForm.style.display = "none";
            subMenu.classList.add('open-menu');
        }

        function showSettingsForm() {
            hideEditProfileForm();
            hideHelpForm();
            hideNightModeForm();
            var settingsForm = document.getElementById("SettingsForm");
            var subMenu = document.getElementById("subMenu");
            settingsForm.style.display = "block";
            //subMenu.classList.remove('open-menu');
        }

        function hideSettingsForm() {
            var settingsForm = document.getElementById("SettingsForm");
            settingsForm.style.display = "none";
        }

        function showHelpForm() {
            hideEditProfileForm();
            hideSettingsForm();
            hideNightModeForm();
            var helpForm = document.getElementById("HelpForm");
            var subMenu = document.getElementById("subMenu");
            helpForm.style.display = "block";
            //subMenu.classList.remove('open-menu');
        }

        function hideHelpForm() {
            var helpForm = document.getElementById("HelpForm");
            helpForm.style.display = "none";
        }

        function showNightModeForm() {
            hideEditProfileForm();
            hideSettingsForm();
            hideHelpForm();
            var nightmodeForm = document.getElementById("NightModeForm");
            var subMenu = document.getElementById("subMenu");
            nightmodeForm.style.display = "block";
            //subMenu.classList.remove('open-menu');
        }

        function hideNightModeForm() {
            var nightmodeForm = document.getElementById("NightModeForm");
            nightmodeForm.style.display = "none";
        }

        document.getElementById("back_arrow_edit").addEventListener("click", function() {
            var editProfileForm = document.getElementById("editProfileForm");
            var subMenu = document.getElementById("subMenu");
            editProfileForm.style.display = "none";
            subMenu.classList.add('open-menu');
        });

        document.getElementById("back_arrow_settings").addEventListener("click", function() {
            var settingsForm = document.getElementById("SettingsForm");
            var subMenu = document.getElementById("subMenu");
            settingsForm.style.display = "none";
            subMenu.classList.add('open-menu');
        });

        document.getElementById("back_arrow_help").addEventListener("click", function() {
            var helpForm = document.getElementById("HelpForm");
            var subMenu = document.getElementById("subMenu");
            helpForm.style.display = "none";
            subMenu.classList.add('open-menu');
        });

        document.getElementById("back_arrow_nightmode").addEventListener("click", function() {
            var nightmodeForm = document.getElementById("NightModeForm");
            var subMenu = document.getElementById("subMenu");
            nightmodeForm.style.display = "none";
            subMenu.classList.add('open-menu');
        });



        function previewImage(event) {
            var input = event.target;
            var preview = document.getElementById('profilePreview');

            var reader = new FileReader();
            reader.onload = function() {
                preview.src = reader.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

</html>
