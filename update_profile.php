<?php

session_start();

if (isset($_SESSION['user_id']) && isset($_FILES['profile_picture'])) {
    $user_id = $_SESSION['user_id'];

    // Define allowed file types and maximum file size
    $allowed_file_types = ['jpg', 'jpeg', 'png'];
    $max_file_size = 5 * 1024 * 1024; // 5MB

    $file_name = $_FILES['profile_picture']['name'];
    $file_tmp = $_FILES['profile_picture']['tmp_name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Check file type
    if (!in_array($file_ext, $allowed_file_types)) {
        echo "Error: Only JPG, JPEG, and PNG files are allowed.";
        exit();
    }

    // Check file size
    if ($_FILES['profile_picture']['size'] > $max_file_size) {
        echo "Error: File size exceeds the maximum limit (5MB).";
        exit();
    }


    // Define the directory where you want to store the uploaded profile photos
    $upload_dir = "profile_picture/";

    // Generate a unique file name for the uploaded photo
    $new_file_name = $user_id . '.' . $file_ext;
    $destination = $upload_dir . $new_file_name;

    // Move the uploaded file to the destination directory
    if (move_uploaded_file($file_tmp, $destination)) {
        // Update the user_profile column in the database with the file path or reference

        // Assuming you have already established a database connection
        // Adjust the database connection details accordingly
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "safejourney";

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }


        $sql = "UPDATE usertable SET user_profile = '$destination' WHERE id = '$user_id'";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['profile_picture'] = $destination; // Add this line to update the session variable
            echo "Profile picture updated successfully"; // Debug output
            header("Location: home.php"); // Redirect to the homepage after successful upload
            exit();
        } else {
            echo "Error updating profile photo: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Failed to move uploaded file." . $_FILES['profile_picture']['error'];
    }
}

?>
