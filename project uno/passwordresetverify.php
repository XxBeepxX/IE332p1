<?php
require "mail.php";
$servername = "mydb.itap.purdue.edu";
$username = "g1131592";
$password = "IE332";
$database = $username;

$email = $_POST['email'];

if (empty($email)) {
    echo '<script>window.location.href = "register.php";</script>';
    exit;
}

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM LoginData WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows <= 0) {
    echo '<script>alert("Email does not exist in the database");</script>';
    $conn->close();
    echo '<script>window.location.href = "passwordreset.php";</script>';
    exit;
} else {
}

$conn->close();
?>
