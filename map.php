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
  <title>View Map</title>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="map.css">
  <link rel="icon" href="img/journey.png">

</head>

<!-- <body onload="initMap()"> -->
<body>
  <div class="navbar">
    <nav>
      <div>
        <a href="home.php" class="logo">
          <img src="img/journey.png" alt="logo img">
          <h1>Safe Journey</h1>
        </a>
      </div>
      <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="map.php" id="mapLink" class="active">View Map</a></li>
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

  <div class="search-location">
      <input type="text" id="location-input" placeholder="Enter a location">
      <button onclick="searchLocation()">Search Location</button>
  </div>
  <div class="current-location">
  <button onclick="getCurrentLocation()">
        <img src="img/my_location.png" alt="Current Location Icon" id="current-location-button"> Your Location
    </button>
  </div>
    <br>
    <div class="origin-destination">
      <input type="text" id="origin-input" placeholder="Enter origin">
      <input type="text" id="destination-input" placeholder="Enter destination">
      <button onclick="calculateDistance()">Get Route</button>
    </div>
    <br>
    <div class="start-journey">
  <button onclick="startJourney()">
        <img src="img/start.png" alt="Start Journey Icon" id="start-journey-button"> Start Journey
    </button>
  </div>
    <div id="distance"></div>
    <div id="map"></div>

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
    var map;
    var marker;
    var geocoder;
    var directionsService;
    var directionsDisplay;
    var autocomplete;
    var originAutocomplete;
    var destinationAutocomplete;
    var accidentMarkers = [];

    function initMap() {
      // Initialize map
      map = new google.maps.Map(document.getElementById("map"), {
        zoom: 10,
        center: {
          lat: 32.2245,
          lng: 76.1566
        }, // Default center is Central University of Himachal Pradesh
      });

      // Initialize geocoder and directions service
      geocoder = new google.maps.Geocoder();
      directionsService = new google.maps.DirectionsService();
      directionsDisplay = new google.maps.DirectionsRenderer();

      // Display directions on map
      directionsDisplay.setMap(map);

      function showAccidentMarkers() {
        var origin = document.getElementById("origin-input").value;
        var destination = document.getElementById("destination-input").value;

        if (origin && destination) {
          geocoder.geocode({
              address: origin
            },
            function(originResults, originStatus) {
              if (originStatus === "OK") {
                geocoder.geocode({
                    address: destination
                  },
                  function(destinationResults, destinationStatus) {
                    if (destinationStatus === "OK") {
                      var originLatLng = originResults[0].geometry.location;
                      var destinationLatLng =
                        destinationResults[0].geometry.location;

                      // Get the route between origin and destination using Directions Service
                      var directionsService =
                        new google.maps.DirectionsService();
                      directionsService.route({
                          origin: originLatLng,
                          destination: destinationLatLng,
                          travelMode: google.maps.TravelMode.DRIVING,
                        },
                        function(response, status) {
                          if (status === "OK") {
                            // Get the polyline of the route as a Path object
                            var routePolyline = new google.maps.Polyline({
                              path: response.routes[0].overview_path,
                            });

                            for (var i = 0; i < accidentMarkers.length; i++) {
                              var marker = accidentMarkers[i];
                              var markerLatLng = marker.getPosition();

                              // Check if the marker is on the route using the isLocationOnEdge method
                              var isOnRoute =
                                google.maps.geometry.poly.isLocationOnEdge(
                                  markerLatLng,
                                  routePolyline,
                                  10e-5 // tolerance in degrees
                                );
                              if (isOnRoute) {
                                marker.setMap(map);
                              } else {
                                marker.setMap(null);
                              }
                            }
                          } else {
                            alert(
                              "Directions request failed due to " + status
                            );
                          }
                        }
                      );
                    } else {
                      alert(
                        "Geocode was not successful for the following reason: " +
                        destinationStatus
                      );
                    }
                  }
                );
              } else {
                alert(
                  "Geocode was not successful for the following reason: " +
                  originStatus
                );
              }
            }
          );
        } else {
          for (var i = 0; i < accidentMarkers.length; i++) {
            accidentMarkers[i].setMap(map);
          }
        }
      }

      function clearAccidentMarkers() {
        var origin = document.getElementById("origin-input").value;

        if (!origin) {
          return; // Don't clear markers if origin field is empty
        }

        for (var i = 0; i < accidentMarkers.length; i++) {
          accidentMarkers[i].setMap(null);
        }
        accidentMarkers = [];
      }

      // Create autocomplete for location search
      autocomplete = new google.maps.places.Autocomplete(
        document.getElementById("location-input")
      );
      autocomplete.bindTo("bounds", map); // Restrict autocomplete results to the visible map area
      autocomplete.addListener("place_changed", function() {
        var place = autocomplete.getPlace();
        if (place.geometry) {
          map.setCenter(place.geometry.location);
          map.setZoom(15);
        } else {
          alert("No results found for the selected location.");
        }
      });

      // Initialize origin and destination autocomplete
      originAutocomplete = new google.maps.places.Autocomplete(
        document.getElementById("origin-input")
      );
      originAutocomplete.bindTo("bounds", map);
      originAutocomplete.addListener("place_changed", function() {
        var place = originAutocomplete.getPlace();
        if (!place.geometry) {
          window.alert(
            "No details available for input: '" + place.name + "'"
          );
          return;
        }
        document.getElementById("origin-input").value =
          place.formatted_address;
        map.setCenter(place.geometry.location);
        map.setZoom(15);
        clearAccidentMarkers();
        showAccidentMarkers();
      });
      destinationAutocomplete = new google.maps.places.Autocomplete(
        document.getElementById("destination-input")
      );
      destinationAutocomplete.bindTo("bounds", map);
      destinationAutocomplete.addListener("place_changed", function() {
        var place = destinationAutocomplete.getPlace();
        if (!place.geometry) {
          window.alert(
            "No details available for input: '" + place.name + "'"
          );
          return;
        }
        document.getElementById("destination-input").value =
          place.formatted_address;
        map.setCenter(place.geometry.location);
        map.setZoom(15);
        clearAccidentMarkers();
        showAccidentMarkers();
      });
    }

    function calculateDistance() {
      var origin = document.getElementById("origin-input").value;
      var destination = document.getElementById("destination-input").value;

      directionsService.route({
          origin: origin,
          destination: destination,
          travelMode: "DRIVING",
        },

        function(response, status) {
          if (status === "OK") {
            directionsDisplay.setDirections(response);
            var distance = response.routes[0].legs[0].distance.text;
            document.getElementById("distance").innerHTML =
              "Distance: " + distance;

            // Get the route polyline from the response
            var routePolyline = new google.maps.Polyline({
              path: response.routes[0].overview_path,
            });

            function addAccidentMarker(location, title, locationname, accidents, fatalities) {
              var icon = {
                url: "https://shorturl.at/eoLOX",
                scaledSize: new google.maps.Size(25, 25),
              };

              var accidentMarker = new google.maps.Marker({
                position: location,
                icon: icon,
                map: map,
              });

              accidentMarker.addListener("click", function() {
                var infoWindow = new google.maps.InfoWindow({
                  content: "<h3>" + title + "</h3>" +
                    "<ul>" +
                    "<li><strong>Location:</strong> " + locationname + "</li>" +
                    "<li><strong>Number of Accidents:</strong> " + accidents + "</li>" +
                    "<li><strong>Number of Fatalities:</strong> " + fatalities + "</li>" +
                    "</ul>"
                });
                infoWindow.open(map, accidentMarker);
              });

              accidentMarkers.push(accidentMarker);
              // Check if the marker is on or near the route polyline
              var isOnRoute = google.maps.geometry.poly.isLocationOnEdge(
                location,
                routePolyline,
                10e-3 // tolerance in degrees
              );

              // Show or hide the marker based on the result
              if (isOnRoute) {
                accidentMarker.setVisible(true);
              } else {
                accidentMarker.setVisible(false);
              }
            }
            // Add accident-prone areas as custom markers
            addAccidentMarker({
                lat: 32.22678,
                lng: 76.169994
              },
              "Accident-prone area. Take caution",
              "Draman",
              20,
              7
            ); //Draman
            addAccidentMarker({
                lat: 32.2283,
                lng: 76.0813
              },
              "Accident-prone area. Take caution",
              "32 Mile",
              32,
              12
            ); //32 Mile
            addAccidentMarker({
                lat: 32.183314,
                lng: 76.214868
              },
              "Accident-prone area. Take caution",
              "Rait",
              5,
              0
            ); //Rait
            addAccidentMarker({
                lat: 32.186642,
                lng: 76.219007
              },
              "Accident-prone area. Take caution",
              "Chambi",
              16,
              5
            ); //Chambi
            addAccidentMarker({
                lat: 32.214012,
                lng: 76.287205
              },
              "Accident-prone area. Take caution",
              "Garoh",
              6,
              0
            ); //Garoh
            addAccidentMarker({
                lat: 32.172707,
                lng: 76.257523
              },
              "Accident-prone area. Take caution",
              "Kuthman",
              8,
              1
            ); //Kuthman
            addAccidentMarker({
                lat: 32.153479,
                lng: 76.270057
              },
              "Accident-prone area. Take caution",
              "Gaggal",
              24,
              6
            ); //Gaggal
            addAccidentMarker({
                lat: 32.161164,
                lng: 76.291356
              },
              "Accident-prone area. Take caution",
              "Chaitru",
              15,
              5
            ); //Chaitru
            addAccidentMarker({
                lat: 32.196887,
                lng: 76.319152
              },
              "Accident-prone area. Take caution",
              "Jawahar Nagar",
              7,
              1
            ); //Jawahar Nagar
            addAccidentMarker({
                lat: 32.198736,
                lng: 76.321668
              },
              "Accident-prone area. Take caution",
              "Near Jawahar Nagar Civil lines Rd",
              10,
              2
            ); //Near Jawahar Nagar Civil lines Rd
            addAccidentMarker({
                lat: 32.244051,
                lng: 76.321723
              },
              "Accident-prone area. Take caution",
              "McLeod Ganj",
              34,
              16
            ); //McLeod Ganj
            addAccidentMarker({
                lat: 32.133951,
                lng: 76.295072
              },
              "Accident-prone area. Take caution",
              "Matour",
              15,
              5
            ); //Matour
            addAccidentMarker({
                lat: 32.112381,
                lng: 76.301876
              },
              "Accident-prone area. Take caution",
              "Tanda",
              11,
              5
            ); //Tanda
            addAccidentMarker({
                lat: 32.097057,
                lng: 76.268321
              },
              "Accident-prone area. Take caution",
              "Tehsil Chowk Kangra",
              19,
              7
            ); //Tehsil Chowk
            addAccidentMarker({
                lat: 32.146234,
                lng: 76.008329
              },
              "Accident-prone area. Take caution",
              "Jawali",
              5,
              1
            ); //Jawali
            addAccidentMarker({
                lat: 32.11402,
                lng: 76.534881
              },
              "Accident-prone area. Take caution",
              "Palampur",
              31,
              17
            ); //Palampur
            addAccidentMarker({
                lat: 32.113591,
                lng: 76.534636
              },
              "Accident-prone area. Take caution",
              "Sugghar Palampur",
              9,
              2
            ); //Sugghar Palampur
          } else {
            alert("Directions request failed due to " + status);
          }
        }
      );
    }

    function searchLocation() {
      var location = document.getElementById("location-input").value;
      if (location) {
        geocoder.geocode({
          address: location
        }, function(results, status) {
          if (status === "OK") {
            var place = results[0];
            map.setCenter(place.geometry.location);
            map.setZoom(15);
          } else {
            alert(
              "Geocode was not successful for the following reason: " + status
            );
          }
        });
      } else {
        alert("Please enter a location to search.");
      }
    }
/*
    function getCurrentLocation() {
      if (navigator.geolocation) {
        var options = {
          enableHighAccuracy: true,
        };
        navigator.geolocation.getCurrentPosition(
          function(position) {
            var currentLatLng = {
              lat: position.coords.latitude,
              lng: position.coords.longitude,
            };
            map.setCenter(currentLatLng);
            map.setZoom(15);
            if (marker) {
              marker.setMap(null);
            }
            marker = new google.maps.Marker({
              position: currentLatLng,
              map: map,
              animation: google.maps.Animation.DROP,
              draggable: false,
              title: "Current Location",
            });
          },
          function(error) {
            if (error.code === error.PERMISSION_DENIED) {
              alert(
                "You denied the geolocation request. Using default location instead."
              );
            } else {
              alert(
                "Unable to retrieve your location. Using default location instead."
              );
            }
          },
          options
        );
      } else {
        alert(
          "Your browser doesn't support geolocation. Using default location instead."
        );
      }
    }
*/

function getCurrentLocation() {
  var options = {
          enableHighAccuracy: true,
        };
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var currentLatLng = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            if (marker) {
                marker.setMap(null);
            }

            marker = new google.maps.Marker({
                position: currentLatLng,
                map: map,
                title: "Current Location",
                icon: {
                    url: 'img/gps.png',
                    size: new google.maps.Size(30, 30),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(15, 15),
                    scaledSize: new google.maps.Size(30, 30)
                }
            });

            map.setCenter(currentLatLng);
            map.setZoom(15);
        }, function(error) {
            if (error.code === error.PERMISSION_DENIED) {
                alert("You denied the geolocation request.");
            } else {
                alert("Unable to retrieve your location.");
            }
        });
    } else {
        alert("Your browser doesn't support geolocation.");
    }
}

document.getElementById("current-location-button").addEventListener("click", getCurrentLocation);



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
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCxFXpfuSswK-hwJ_D2XBL1EtBVJw0xAAA&libraries=places&callback=initMap"></script>

</html>
