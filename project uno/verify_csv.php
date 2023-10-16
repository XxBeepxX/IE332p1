<?php
$tableName = $_POST["csvName"];
$man_cost = $_POST["csvmprice"];
$sell_price = $_POST["csvsprice"];

//import csv
$tmpName = $_FILES['csvFile']['tmp_name'];
$handle = fopen($tmpName, 'r');
//grab the email from loginverify
session_start();
$email = $_SESSION['email'];


$header = fgetcsv($handle, 0, ',');
$expectedHeaders = array('OrderedStatus','customer_id','customer_name','stock_date','sell_date','return_reason'); // Replace with your actual headers


if ($header !== $expectedHeaders) {
    
    // Headers do not match, handle this error as needed
    $nonMatchingHeaders = array_diff($headers, $expectedHeaders);
    echo '<script>alert("Headers: ' . implode(', ', $nonMatchingHeaders) . ' do not match");</script>';
    $conn->close();
    echo '<script>window.location.href = "main.php";</script>';
    exit;

} else {
    $servername = "mydb.itap.purdue.edu"; 
    $username = "g1131592";    
    $password = "IE332";    
    $database = $username;  
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM Products WHERE pname = '$tableName'";
    $result = $conn->query($sql);

    if ($result === false) {
        // Query execution error
        echo "Error: " . $conn->error;
    } else {
        if ($result->num_rows > 0) {
            // Table with this name already exists
            echo '<script>alert("Table with this name already exists");</script>';
            $conn->close();
            echo '<script>window.location.href = "main.php";</script>';
            exit;
        }
    }
    //CSV validator
    while (($data = fgetcsv($handle, 0, ',')) !== false) {
        $inventorystatus = $data[0];
        $reason = $data[5];
        if ($inventorystatus == 0 && $reason != "") {
            echo '<script>alert("Table logic error: Objects in inventory cannot be returned.");</script>';
            $conn->close();
            echo '<script>window.location.href = "main.php";</script>';
            exit;
        }
    }

    $sql = "INSERT INTO Products (email, pname, man_cost, sell_price) VALUES ('$email', '$tableName','$man_cost','$sell_price')";
    $result = $conn->query($sql);
    $sql = "SELECT MAX(p_id) FROM Products";
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);
    $currentP_ID = $row[0];
    while (($data = fgetcsv($handle, 0, ',')) !== false) {
        $inventorystatus = $data[0];
        $customer_id = $data[1];
        $customer_name = $data[2];
        $stock_date = $data[3]; //b_date 
        $sell_date = $data[4];
        $reason = $data[5];
        //Insert inventory dat

        
        $sql = "INSERT INTO Inventory (p_id, b_date) VALUES ('$currentP_ID','$stock_date')"; //P_ID is a foreign key so there are dupes
        $result = $conn->query($sql);
        //Insert Customer data
        $sql = "INSERT IGNORE INTO Customer (customer_id, c_name) VALUES ('$customer_id','$customer_name')"; //P_ID is a foreign key so there are dupes
        
        $result = $conn->query($sql);
        //Insert order data     
        if ($inventorystatus != 0) {
            $sql = "SELECT MAX(i_id) FROM Inventory";
            $result = $conn->query($sql);
            $row = mysqli_fetch_array($result);
            $currenti_ID = $row[0];
            $sql = "INSERT INTO Orders (i_id,customer_id, o_date, return_reason) VALUES ('$currenti_ID','$customer_id', '$sell_date','$reason')"; //P_ID is a foreign key so there are dupes
            $result = $conn->query($sql);
        }
        //drop down menu, for which tables, click table, another drop down for what you want to search for within that table, filter button to filte

    }
    $conn->close();
    echo '<script>alert("Data inserted succesfully");</script>';
    echo '<script>window.location.href = "main.php";</script>';
}

fclose($handle);
?>