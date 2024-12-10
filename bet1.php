<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "footydb";

// Create database connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve and sanitize form data
$fname = mysqli_real_escape_string($conn, $_POST['firstname']);
$lname = mysqli_real_escape_string($conn, $_POST['surname']);
$idno = $_POST['idno'];
$dob = $_POST['dob'];
$league =$_POST['league'];
$gender = $_POST['gender'];
$phone = $_POST['phone'];
$teams = isset($_POST['teams']) ? mysqli_real_escape_string($conn, implode(", ", $_POST['teams'])) : "";

// Handle file upload
$photo = $_FILES['photo'];
$photoPath = "uploads/" . basename($photo['name']);
if (!move_uploaded_file($photo['tmp_name'], $photoPath)) {
    die("Failed to upload photo.");
}

// Insert data into MySQL database
$sql = "INSERT INTO reg (firstname, surname, idno, dob, league, gender, phone, teams, photo)
        VALUES ('$fname', '$lname', '$idno', '$dob', '$league', '$gender', '$phone', '$teams', '$photoPath')";

if (mysqli_query($conn, $sql)) {
    echo "Registration successful!";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);
?>
