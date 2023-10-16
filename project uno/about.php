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

        body {
          background-image: url("about.gif");
          background-repeat: no-repeat;
          background-size: cover;
          background-color:whitesmoke;
          font-family: verdana;
          font-size: 18px;
          margin-bottom: 0px;
      } 
      h2 {
          background-color: green;
          border-style: solid;
          text-align: center;
          margin-top:0px;
      }
      h4 {
          background-color: green;
          border-style: outset;
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
          
          <script>
            window.onload = function() {
              openCity('About', this, 'green');
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

        <body2>  

        <h2 style="margin: 0px 0; padding: 0; ">
                IE 332 Group 2 - Project 1
                <h4>
                    Allowing companies to access trends in transactions between their products, the time of transactions, and which customers that the transaction is happening with
                </h4>
            </h2>
            <p2>
            <ul style="background-color: rgba(255, 255, 255, 0.7);">
            <li>Many customers make transactions with multiple companies.<br></li>
            <li>Each customer has his/her own ID that is tracked by each company that he/she transacts with.<br></li>
            <li>Every company sells a variety of products.<br></li>
            <li>Each individual product has its own unique ID.<br></li>
            <li>However, similar products are priced the same between different companies.<br></li>
            <li>Each product and customer trends differently in every season of the year.<br></li>
            <li>A few unsatisfied customers return their products back to the company.<br></li>
            <li>All inventory and transaction history is visible to respective companies looking for data.<br></li>
            <li>Order, sell, and return dates are all separated from one another.<br></li>
            <li>All this data is available on all platforms, making it very portable.<br></li>
            <li>The benefits of companies using this inventory management software are to maximize revenues, minimize shelving lives, and recognize the most valuable customers at certain times of the year.<br></li>
            </ul>
            </p2>

        </body2>
</html>