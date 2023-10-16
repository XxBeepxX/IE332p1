<html>
<head>
    <style>
        input {
            background-color: white;
            border-radius: 5px;
            height: 25px;
        }
        body {
            background-image: url("register.gif");
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
        p {
            text-align:center;

        }

        p2 {
            text: size 1000%;
            color:red;
        }

        .p3{
             background-image: url("registergif.gif");
             background-repeat: no-repeat;
             background-attachment: fixed;
             background-size: cover; 
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

    <div id="nav-placeholder"></div>
    <!-- Was testing a universal header
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {
            $("#nav-placeholder").load("nav.html");
        });
    </script>
    -->
    <!-- Moved the form container inside the body -->
    <div id="form-container">
        <!-- <img src="j4o.gif" alt="picture of me" width="500" height="600" style="float:left"> -->
        
        <form id="form" action="registerverify.php" method="post" name="regForm" onsubmit="return validate()">
            <label for="cname">Company name:</label><input type="text" name="cname" id="cname" placeholder="company name"><br>
            <label for="my_email">Email:</label><input type="email" name="my_email" id="my_email" placeholder="Enter your email address"><br>
            <label for="password">Password:</label><input type="password" name="password" id="password" placeholder="password"><br>
            <label for="repeat_pass">Confirm Password:</label><input type="password" name="repeat_pass" id="repeat_pass" placeholder="repeat password"><br>
            <input type="submit">
            <input type="reset">
        </form>
    </div>

    <hr>
    <p> 
        <p2>
            MAKE SURE PASSWORD IS SECURE!!
    </p2>
    </p>
    <hr>
    <p3>

    </p3>


    <script>
        window.onload = function() {
            openCity('Register', this, 'blue');
        }   
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
            if (document.regForm.cname.value == "") {
                errors.push("Please provide a company name!!!");
                document.getElementById("cname").style.backgroundColor = "red";
            } else {
                document.getElementById("cname").style.backgroundColor = "white";
            }
            
            
            // Email check
            if (document.regForm.my_email.value == "") {
                errors.push("Please provide an email!!!");
                document.getElementById("my_email").style.backgroundColor = "red";
            } else {
                document.getElementById("my_email").style.backgroundColor = "white";
            }

            // Password check
            if (document.regForm.password.value == "") {
                errors.push("Please provide a password!!!");
                document.getElementById("password").style.backgroundColor = "red";
            } else {
                document.getElementById("password").style.backgroundColor = "white";
            }

            // Password repeat check
            if (document.regForm.repeat_pass.value == "") {
                errors.push("Please verify your password");
                document.getElementById("repeat_pass").style.backgroundColor = "red";
            } else if (document.regForm.repeat_pass.value != document.regForm.password.value) {
                errors.push("Passwords do not match");
                document.getElementById("repeat_pass").style.backgroundColor = "red"; // Set background color to red for mismatch
            } else {
                document.getElementById("repeat_pass").style.backgroundColor = "white";
            }
            // Display all errors at once
            if (errors.length > 0) {
                alert(errors.join("\n"));
                return false;
            }
            return true; // Form is valid
        }
    </script>
</body>
</html>
