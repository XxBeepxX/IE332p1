<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: "Lato", sans-serif;}

.tablink {
  background-color: #555;
  color: white;
  float: left;
  border: none;
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
</style>
</head>
<body>

<p>Click on the buttons inside the tabbed menu:</p>

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

<button class="tablink" onmouseover="setTimeout(function() { openCity('Home', this, 'red'); }, 300)" onclick="Goto('home.php')">Home</button>
<button class="tablink" onmouseover="setTimeout(function() { openCity('About', this, 'green'); }, 300)" onclick="Goto('about.html')">About</button>
<button class="tablink" onmouseover="setTimeout(function() { openCity('Register', this, 'blue'); }, 300)" onclick="Goto('register.php')">Register</button>
<button class="tablink" onmouseover="setTimeout(function() { openCity('Login', this, 'orange'); }, 300)" onclick="Goto('login.php')">Login</button>

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
</script>
   
</body>
</html>
