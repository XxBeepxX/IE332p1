<?php
    //SQL check
    $servername = "mydb.itap.purdue.edu"; 
    $username = "g1131592";    
    $password = "IE332";    
    $database = $username;  
    $fname = $_POST['fname'];
    $lname = $_POST['my_lname'];
    $email = $_POST['my_email'];
    $pass = $_POST['password'];

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM LoginData WHERE email = '$email'";
    $result = $conn->query($sql);
    
    //SQL check done 
    // Check if any rows were returned
    if ($result->num_rows > 0) {
        echo '<script>alert("Account already exists with this email");</script>';
        $conn->close();
        exit;
    } else {
        $sql =  "INSERT INTO LoginData (firstname, lastname, email, password) VALUES ('$fname','$lname', '$email', '$pass')";
        $result = $conn->query($sql);
        $conn->close();
        header("Location: submitted.php");
    }
?>