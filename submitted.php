<?php
    $servername = "mydb.itap.purdue.edu"; 
    $username = "g1131592";    
    $password = "IE332";    
    $database = $username;  
    $conn = new mysqli($servername, $username, $password, $database);
    $email = $fname = $_POST['my_email'];
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql =  "INSERT INTO LoginData (email) VALUES ('$email')";
    $result = $conn->query($sql);
    $conn->close();
?>


<html>
<head>
    <title>Form Submitted</title>
    <style>
        body {
            background-image: url("j4o.gif");
            background-repeat: no-repeat;
            background-size: cover;
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        h1 {
            color: #333;
        }

        p {
            color: #666;
        }

        a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Account Has Been Created</h1>
        <p>Thank you for creating one</p>
        
        <!-- Add a button-styled link to the login page -->
        <a href="login.html">Try Logging in</a>
    </div>
</body>
</html>
