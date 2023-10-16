<?php
$servername = "mydb.itap.purdue.edu";
$username = "g1131592";
$password = "IE332";
$database = $username;
$conn = new mysqli($servername, $username, $password, $database);

session_start();
if (!isset($_SESSION['email'])) {
    // User is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}
$email = $_SESSION['email'];


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM Products WHERE email ='$email'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>SQL Data Management</title>
    <style>

        h1.head2 {
            background-image: url("mainback.jpg");
        }
        body {
            font-family: Arial, sans-serif;
    
            
        }
        .container {
            display: flex;
        }
        .left-panel {
            flex: 1;
            padding: 10px;
        }
        .middle-panel {
        flex: 3;
        display: flex;
        flex-direction: column; /* Ensure children are stacked vertically */
        justify-content: center; /* Center its children horizontally */
        align-items: center; /* Center its children vertically */
        padding: 20px; /* Add padding to create space around the content */
    }

    .middle-panel h2,
    .middle-panel select,
    .middle-panel input,
    .middle-panel button {
        margin: 10px; /* Add margin to separate child elements */
    }


        .data-panel {
            max-height: 300px;
            overflow-y: auto;
            padding: 20px;
            width: 40%;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        select, input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }
        .upload-btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        .search-btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #28A745;
            color: white;
            border: none;
            cursor: pointer;
        }
        .modal {
            display: none; /* Hide the modal by default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4); /* Semi-transparent background */
        }
        /* Style for the modal content */
        /* Style for the modal content */
        .modal-content {
            position: absolute;
            top: 50%;
            left: 60%; /* Adjust left to 60% to shift it slightly to the right */
            transform: translate(-50%, -50%);
            background-color: #fefefe;
            padding: 20px;
            border: 1px solid #888;
            width: 400px; /* Increase the width to make it larger */
            text-align: center; /* Center-align the text within the modal */
        }
        input[type="text"] {
            width: 100%; /* Make the input full width */
            max-width: 300px; /* Set a maximum width for the text box */
            padding: 10px;
            margin: 0 auto; /* Center-align the text box */
            display: block; /* Display as a block element to center it */
        }
        #form input[type="submit"], #form button {
            padding: 10px 20px; /* Add padding to the buttons for spacing */
            margin: 10px 0; /* Add margin to separate buttons from other elements */
        }

        .tableviewer {
            max-height: 500px; /* Increase the max height to make it larger */
            overflow-y: auto;
            padding: 20px;
            width: 70%; /* Adjust the width as needed */
            background-color: #007BFF; /* Set the background color to blue */
            color: white; /* Set the text color to white */
            position: relative;
            top: 200px; /* Move the container down by 200px */
            left: 300px; /* Move the container right by 50px */
    }

        .tableviewer table {
            border-collapse: collapse;
            width: 100%;
        }

        .tableviewer th, .tableviewer td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .tableviewer th {
            background-color: #333; /* Set a darker background color for headers */
        }



    </style>
</head>
<head2>
<h1>Group 2<h1> 
<h3>Data Library<h3>
</head2>
<body>
<div class="container">
    <div class="left-panel">
        <h2>Products</h2>
        <table class="product-table">
        <tr>
            <th>Product Name</th>
        </tr>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td><a class='product-link' data-pid='" . $row["p_id"] .
                "' data-sellprice='" . $row["sell_price"] . "' data-costprice='" . $row["man_cost"] .  "'>" . $row["pname"] . "</a></td>";

                // echo "<td><a class='product-link' data-pid='" . $row["p_id"] . "' data-sellprice='" . $row["sell_price"] . "'>" . $row["pname"] . "</a></td>";
                echo "</tr>";

            }
        } else {
            echo "0 results";
        }
        ?>
    </table>
        <button id="UploadButton">Upload Product Data CSV</button>
        <div id="hiddenItems" class="modal">
            <div class="modal-content">
                <span id="closeModal" style="float: right;">&times;</span>
                <h2>Upload Product Data CSV</h2>
                <form id="form" action="verify_csv.php" method="post" name="myForm" enctype="multipart/form-data" onsubmit="return verifyupload()">
                    <!-- onsubmit="return validate()" -->
                    <input type="text" id="csvName" name="csvName" placeholder="Enter a name for the CSV">
                    <input type="text" id="csvmprice" name="csvmprice" placeholder="Enter the manufacturing cost of the product">
                    <input type="text" id="csvsprice" name="csvsprice" placeholder="Enter the sell price of the product">
                    <input type="file" id="csvFile" name="csvFile" accept=".csv">
                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>
    <div class="middle-panel">
        <h2>SQL Search</h2>
        <form method="POST" action="advanced_search.php" onsubmit="return validateSearchForm()">
            <select name="searchOption" id="searchOption">
                <option value="option1">Average Length of Product Storage</option>
                <option value="option2">Most/Least Time in Storage</option>
                <option value="option3">Table of Product Sold</option>
                <option value="option4">Product Returned</option>
                <option value="option5">Customer Loyalty</option>
                <!-- Add more options as needed -->
            </select>
            <label for="startDate">Start Date:</label>
            <input type="date" name ="startDate" id="startDate" placeholder="Select a start date">

            <label for="endDate">End Date:</label>
            <input type="date" name ="endDate" id="endDate" placeholder="Select an end date">

            <button class="search-btn" id="searchButton">Search</button>
        </form>
    </div>
</div>
<button id="logout" onclick="window.location.href = 'logout.php';">Logout</button>
<div class="data-panel">
    <h2>Summary Reports</h2>
    <table id="resultTable">
        <form action="Process_form.php" method="post" onsubmit="return validateForm()">
            
            <!-- Single-select drop-down -->
            <label for="singleSelect">Select type of Analysis:</label>
            <select id="singleSelect" name="singleSelect">
                <option value="">-- Select One --</option>
                <option value="1">Product Profit/Loss By Month</option>
                <option value="2">Products Sold by Company</option>
                <option value="3">Customer Loyalty Trends</option>
                <option value="4">Return Reason</option>
                <option value="5">Average Time in Inventory</option>
            </select>

            <!-- Multi-select drop-down -->
            <label for="multiSelect">Select Any Products:</label> <p>
            <!-- <select id="multiSelect" name="multiSelect[]" multiple> -->
                <?php
                // Move the database connection part here to avoid duplication
                $servername = "mydb.itap.purdue.edu";
                $username = "g1131592";
                $password = "IE332";
                $database = $username;
                $conn = new mysqli($servername, $username, $password, $database);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM Products WHERE email ='$email'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<label><input type='checkbox' name='multiSelect[]' value='" . $row["pname"] . "'>" . $row["pname"] . "</label><br>";
                    }
                }

                $conn->close();
                ?>
                
            </select>

            <input type="submit" value="Submit">
        </form>
    </table>
                
</div>
<div id="product-details"></div>
<script>
    // Function to upload a CSV file
    function verifyupload() {
        var errors = [];
        if (document.myForm.csvName.value == "") {
                errors.push("Please provide a name for the product");
                document.getElementById("csvName").style.backgroundColor = "red";
            } else {
                document.getElementById("csvName").style.backgroundColor = "white";
            }

            // man check
        if (document.myForm.csvmprice.value == "") {
            errors.push("Please provide a manufacturing price!!!");
            document.getElementById("csvmprice").style.backgroundColor = "red";
        } else {
            document.getElementById("csvmprice").style.backgroundColor = "white";
        }

        if (document.myForm.csvsprice.value == "") {
            errors.push("Please provide a sell price!!!");
            document.getElementById("csvsprice").style.backgroundColor = "red";
        } else {
            document.getElementById("csvsprice").style.backgroundColor = "white";
        }

        if (errors.length > 0) {
            alert(errors.join("\n"));
            return false;
        }
        return true; // Form is valid

    }
</script>


<script>
// Get references to the modal and button elements
var modal = document.getElementById("hiddenItems");
var btn = document.getElementById("UploadButton");
var span = document.getElementById("closeModal");

// When the user clicks the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
<script>

    $(document).ready(function() {
        $(".product-link").on("click", function() {
            var productId = $(this).data("pid");
            var sellPrice = $(this).data("sellprice"); // Corrected variable name
            var costPrice = $(this).data("costprice"); // Corrected variable name
            
            $.ajax({
                url: "", // Replace with the actual URL of your PHP file
                type: "POST",
                data: {
                    product_id: productId,
                    sell_price: sellPrice, // Corrected variable name
                    cost_price: costPrice // Corrected variable name
                },
                success: function(response) {
                    // Display the response in a modal or on the page as needed
                    alert("Product ID: " + productId + "\nSell Price: " + sellPrice + "\nCost Price: " + costPrice);
                },
                error: function() {
                    alert("An error occurred while fetching data.");
                }
            });
        });
    });

</script>
<?php
$servername = "mydb.itap.purdue.edu";
$username = "g1131592";
$password = "IE332";
$database = $username;
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["product_id"])) {
    $productId = $_POST["product_id"];

    // SQL query to retrieve the sell_price based on the product_id
    $sql = "SELECT sell_price FROM Products WHERE p_id = '$productId'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Fetch the first row
        $sellPrice = $row['sell_price']; // Retrieve the value of sell_price
        echo "Sell Price: " . $sellPrice; // sellPrice
    } else {
        echo "No results found.";
    }
}

$conn->close();
?>

<script>
function validateForm() {
    var analysisType = document.getElementById("singleSelect").value;
    var productCheckboxes = document.querySelectorAll('input[name="multiSelect[]"]:checked');

    if (analysisType === "") {
        alert("Please select an analysis type.");
        return false;
    }

    if (productCheckboxes.length === 0) {
        alert("Please select at least one product.");
        return false;
    }

    // If both conditions pass, set the hidden input to 1
    document.getElementById("productSelected").value = "1";
    return true;
}

function validateSearchForm() {
    var searchOption = document.getElementById("searchOption").value;
    var startDate = document.getElementById("startDate").value;
    var endDate = document.getElementById("endDate").value;

    if (searchOption === "") {
        alert("Please select a search option.");
        return false;
    }

    if (startDate === "" || endDate === "") {
        alert("Please select both a start date and an end date.");
        return false;
    }

    // Add more specific date validation if needed

    return true;
}
</script>


</body>
</html>

<!-- if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["product_id"])) {
    $productId = $_POST["product_id"];

    // Query the database to fetch product details based on $productId
    // Construct the HTML to display the product details

    // Send the product details HTML as the response
    echo $productDetailsHTML;
} -->
