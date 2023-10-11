<?php
//SQL check
$servername = "mydb.itap.purdue.edu"; 
$username = "g1131592";    
$password = "IE332";    
$database = $username;  

$email = $_POST['email'];
$emailpassword = $_POST['password'];

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM LoginData WHERE email = '$email'";
$result = $conn->query($sql);
//SQL check done 
// Check if any rows were returned

if ($result->num_rows > 0) {
    if ($emailpassword != $row['password']) {
        echo '<script>alert("Incorrect password");</script>';;
        header("Location: login.php");
        exit;
    } else {
        header("Location: submitted.php");
        exit;
    }
} else {
    echo '<script>alert("Email does not exist, please register an account!");</script>';
    header("Location: login.php");
    exit;
}

$conn->close();
header("Location: submitted.php");
?>
