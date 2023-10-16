<!DOCTYPE html>
<html>
<head>
    <style>
        .tablink {
            background-color: #555;
            color: white;
            float: left;
            border: solid;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            font-size: 17px;
            width: 25%;
            /*transition: background-color 0.3s; /* Add a smooth transition */
        }

        .tablink:hover {
            background-color: #777;
        }

        /* Style the tab content */
        .tabcontent {
            color: white;
            display: none;
            padding: 50px;
            text-align: center;
        }

        #Home {background-color:red;}
        #About {background-color:green;}
        #Register {background-color:blue;}
        #Login {background-color:orange;}

        input {
            background-color: white;
            border-radius: 5px;
            height: 25px;
        }
        body {
            background-image: url("login.gif");
            background-repeat: no-repeat;
            background-size: cover;
            /* Fallback background color */
            background-color: white;
            margin: 0; /* Added to remove default body margin */
        }
        /* Added CSS for the form container */
        #form-container {
            background-color: lightgray;
            text-align: center;
            width: 400px;
            margin: 0 auto;
            padding: 20px; /* Added for spacing */
            box-sizing: border-box; /* Added to include padding in width calculation */
        }
        input[type="submit"] {
            background-color: green;
        }
        input[type="reset"] {
            background-color: red;
        }
        /* Added styling for the "Register" button */
        #register-button {
            background-color: white; /* Updated to white background */
            border: none;
            color: #007BFF; /* Changed text color to blue */
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 10px;
            cursor: pointer;
        }
        #forgot-button {
            background-color: white; /* Updated to white background */
            border: none;
            color: #007BFF; /* Changed text color to blue */
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 10px;
            cursor: pointer;
        }
        p{
            text-align: center;

        }

        p2 {
            text: size 800%;
            color: orange;
        }

    </style>
</head>
<body>
<div id="Home" class="tabcontent">
  <h1>Home</h1>
  <p>Home page</p>
</div>

<div id="About" class="tabcontent">
  <h1>About</h1>
  <p>About this project</p> 
</div>

<div id="Register" class="tabcontent">
  <h1>Register</h1>
  <p>Create an account</p>
</div>

<div id="Login" class="tabcontent">
  <h1>Login</h1>
  <p>Already have an account? Log in</p>
</div>

<button class="tablink" onmouseover="openCity('Home', this, 'red')" onclick="Goto('home.php')">Home</button>
<button class="tablink" onmouseover="openCity('About', this, 'green')" onclick="Goto('about.php')">About</button>
<button class="tablink" onmouseover="openCity('Register', this, 'blue')" onclick="Goto('register.php')">Register</button>
<button class="tablink" onmouseover="openCity('Login', this, 'orange')" onclick="Goto('login.php')">Login</button>

    <!-- Moved the form container inside the body -->
    <div id="form-container">
        <!-- <img src="j4o.gif" alt="picture of me" width="500" height="600" style="float:left"> -->
        
        <form id="form" action="loginverify.php" method="post" name="logForm" onsubmit="return validate()">
            <label for="my_email">Email:</label><input type="email" name="my_email" id="my_email" placeholder="Enter your email address"><br>
            <label for="password">Password:</label><input type="password" name="password" id="password" placeholder="password"><br>
            <input type="submit">
            <input type="reset">
        </form>

        <!-- Stylish "Register" button with text -->
        <button id="register-button" onclick="window.location.href = 'register.php';">Don't have an account? Register here</button>
        <button id="forgot-button" onclick="window.location.href = 'passwordreset.php';">Forgot your password? Reset it here</button>
    </div>

    <hr>
    <p>
    <p2>
        Thanks for using our software!
    </p2>
    </p>
    <?php
    session_start();
    if ($_SESSION['email'] !== null) {
        echo '<script>alert("Already logged in as ' . $_SESSION['email'] . '");</script>';
        echo '<script>window.location.href = "main.php";</script>';
        exit();
    }
    ?>

   
    <script>

        function Goto(id) {
            window.location.href = id;
        }
        function openCity(cityName, elmnt, color) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablink");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].style.backgroundColor = "";
            }
            document.getElementById(cityName).style.display = "block";
            elmnt.style.backgroundColor = color;
        }
        
        function validate() {
            var phoneNumberPattern = /^\d{10}$/;
            var errors = [];
            
            // First name check
            // Email check
            if (document.logForm.my_email.value == "") {
                errors.push("Please provide an email!!!");
                document.getElementById("my_email").style.backgroundColor = "red";
            } else {
                document.getElementById("my_email").style.backgroundColor = "white";
            }

            // Password check
            if (document.logForm.password.value == "") {
                errors.push("Please provide a password!!!");
                document.getElementById("password").style.backgroundColor = "red";
            } else {
                document.getElementById("password").style.backgroundColor = "white";
            }
            if (errors.length > 0) {
                alert(errors.join("\n"));
                return false;
            }
            return true; // Form is valid
        }
        document.getElementById("defaultOpen").click();
    </script>
</body>
</html>
