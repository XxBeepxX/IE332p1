<html>
<head>
    <style>
        input {
            background-color: white;
            border-radius: 5px;
            height: 25px;
        }
        body {
            background-image: url("j4o.gif");
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
    </style>
</head>
<body>
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
        
        <form id="form" action="registerverify.php" method="post" name="myForm" onsubmit="return validate()">
            <label for="fname">First name:</label><input type="text" name="fname" id="fname" placeholder="first name"><br>
            <label for="my_lname">Last name:</label><input type="text" name="my_lname" id="my_lname" placeholder="last name"><br>
            <label for="my_email">Email:</label><input type="email" name="my_email" id="my_email" placeholder="Enter your email address"><br>
            <label for="password">Password:</label><input type="password" name="password" id="password" placeholder="password"><br>
            <label for="repeat_pass">Confirm Password:</label><input type="password" name="repeat_pass" id="repeat_pass" placeholder="repeat password"><br>
            <input type="submit">
            <input type="reset">
        </form>
    </div>

    <script>
        function validate() {
            var phoneNumberPattern = /^\d{10}$/;
            var errors = [];
            
            // First name check
            if (document.myForm.fname.value == "") {
                errors.push("Please provide a first name!!!");
                document.getElementById("fname").style.backgroundColor = "red";
            } else {
                document.getElementById("fname").style.backgroundColor = "white";
            }
            
            // Last name check
            if (document.myForm.my_lname.value == "") {
                errors.push("Please provide a last name!!!");
                document.getElementById("my_lname").style.backgroundColor = "red";
            } else {
                document.getElementById("my_lname").style.backgroundColor = "white";
            }
            
            // Email check
            if (document.myForm.my_email.value == "") {
                errors.push("Please provide an email!!!");
                document.getElementById("my_email").style.backgroundColor = "red";
            } else {
                document.getElementById("my_email").style.backgroundColor = "white";
            }

            // Password check
            if (document.myForm.password.value == "") {
                errors.push("Please provide a password!!!");
                document.getElementById("password").style.backgroundColor = "red";
            } else {
                document.getElementById("password").style.backgroundColor = "white";
            }

            // Password repeat check
            if (document.myForm.repeat_pass.value == "") {
                errors.push("Please verify your password");
                document.getElementById("repeat_pass").style.backgroundColor = "red";
            } else if (document.myForm.repeat_pass.value != document.myForm.password.value) {
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
