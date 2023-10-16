<?php
// SQL check
$email = $_SESSION['email'];

$servername = "mydb.itap.purdue.edu"; 
$username = "g1131592";    
$password = "IE332";    
$database = $username;  


$email = $_POST['my_email'];
$emailpassword = $_POST['password'];

if (empty($cname) || empty($email) || empty($password)) {
    echo '<script>window.location.href = "login.php";</script>';
}

$encodedemail = $email;
$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM LoginData WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); // Fetch the data from the result set

    if ($emailpassword != $row['password']) {
        echo '<script>alert("Incorrect password");</script>';
        echo '<script>window.location.href = "login.php";</script>';
        exit;
    } else {
        session_start();
        $_SESSION['email'] = "$email";
        header("Location: main.php");
        exit;
    }
} else {
    echo '<script>alert("Email does not exist, please register an account!");</script>';
    echo '<script>window.location.href = "login.php";</script>';
    exit;
    
}
$conn->close();
?>