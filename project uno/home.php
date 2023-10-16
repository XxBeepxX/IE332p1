<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.logo {
text-align: center;
background-color: lightblue;
  background-image: url("background.gif");
  background-repeat: no-repeat;
  background-size: cover;
  text-align: center;
  width: 100%; /* Use a percentage value to make it responsive */
  height: 100vh; /* Use viewport height to cover the entire viewport */
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

h2 {
  text-align: center;
  font-size: 200%;
}

p{
  text-align: center;
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

<h2>
  IE 332 Group 2 - Project 1
</h2>
<hr>
<div class="background">
</div>

<div class="logo">
  <img src="logo1.jpg" width=1000px height=700px/>
</div>

<script>
window.onload = function() {
  openCity('Home', this, 'red');
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
</script>
   
</body>
</html>
