<?php
$servername = "mydb.itap.purdue.edu"; 
$username = "g1131592";    
$password = "IE332";    
$database = $username;  

//Form data
//$cname = $_POST['cname'];
//$pass = $_POST['password'];

session_start();
$email = $_SESSION['email'];


//if (empty($cname) || empty($email) || empty($password)) {
//    echo '<script>window.location.href = "main.php";</script>';
//}

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//isolating the specific company tables
// $UProducts = "SELECT * FROM Products WHERE email ='$email'";
// $UInventory = "SELECT i.* FROM Inventory AS i INNER JOIN Products AS p ON i.p_id = p.p_id AND p.email='$email'";
// $UOrders = "SELECT o.* FROM Orders AS o INNER JOIN Products AS p ON o.p_id = p.p_id AND p.email='$email'";
// $UCustomer = "SELECT c.* FROM Customer AS c INNER JOIN ($UOrders) AS o ON c.customer_id = o.customer_id";


//SQL muliselect commands
// SELECT * FROM your_table
//$emails = ["test", "jones", "example"]; // Replace with your array of values
//$query = "SELECT * FROM your_table WHERE ";
// Loop through the array and construct the query
//foreach ($emails as $email) {
//    $query .= "email = '$email' OR ";
//}
// Remove the trailing ' OR ' from the query
//$query = rtrim($query, ' OR ');
// Now, you have the final SQL query
//echo $query;
// $prodproflossmon = "SELECT SUM(sell_price - man_cost) AS total_price_difference
// FROM $UProducts"; 
// AS o
// INNER JOIN $UProducts AS p ON o.p_id = p.p_id";
//ON o.p_id = i.p_id
//WHERE o.p_id IN (SELECT p_id FROM ($UInventory))
// $custloltrends = "";

if (isset($_POST['multiSelect']) && !empty($_POST['multiSelect'])) {
    $selectedProducts = $_POST['multiSelect']; // Assign selected products
    $selectedProductsString = implode("', '", $selectedProducts);

$woot = "SELECT pname, man_cost, sell_price, (sell_price - man_cost) AS price_difference
FROM Products WHERE email = '$email'
AND Products.pname IN ('$selectedProductsString')";

$result = $conn->query($woot);
if ($result === false) {
    echo "Query error: " . $conn->error;
} elseif ($result->num_rows > 0) {
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

} else {
    $data = [];
    echo "No data found.";
}
}

if (isset($_POST['multiSelect']) && !empty($_POST['multiSelect'])) {
    $selectedProducts = $_POST['multiSelect'];
    $selectedProductsString = implode("', '", $selectedProducts);

    $word = "SELECT Products.pname, COUNT( Orders.o_id ) * ( Products.sell_price - Products.man_cost ) AS product_profit, Orders.o_date AS o_date
             FROM Orders
             INNER JOIN Inventory ON Orders.i_id = Inventory.i_id
             INNER JOIN Products ON Inventory.p_id = Products.p_id
             WHERE email = '$email'
             AND Products.pname IN ('$selectedProductsString')
             GROUP BY Products.pname";
}

$result = $conn->query($word);

if ($result === false) {
    echo "Query error: " . $conn->error;
} elseif ($result->num_rows > 0) {
    $data1 = [];
    $totalProfit = 0;

    while ($row = $result->fetch_assoc()) {
        $data1[] = $row;
        $totalProfit += $row['product_profit'];

    }
    $totalRow = [
        'pname' => 'Total Profit',
        'product_profit' => '',
        'total_profit' => $totalProfit,
    ];

    $data1[] = $totalRow;

} else {
    $data1 = [];
    echo "No data found.";
}
if ($result->num_rows > 0) {
    $data3 = [
        'labels' => [],
        'o_date' => []
    ];

    while ($row = $result->fetch_assoc()) {
        $data3['labels'][] = $row['o_date'];
        $data3['product_profit'][] = $row['product_profit'];
    }

    // Close the database connection
    $conn->close();
} else {
    $data3 = [
        'labels' => [],
        'product_profit' => []
    ];
}

$conn->close();
?>  

<!DOCTYPE html>
<html>
<head>
    <title>Product Profit Information</title>
    <style>
        table {
            margin-bottom: 20px; /* Add margin to separate tables */
        }
    </style>
     <title>Products Sold Histogram</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Product Profit Information</h2>
    <?php
    if (!empty($data)) {
        echo '<table border="1">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Manufacturing Cost</th>
                    <th>Sell Price</th>
                    <th>Profit per Product Sold</th> 
                </tr>
            </thead>
            <tbody>';
        
        foreach ($data as $item) {
            echo "<tr>";
            echo "<td>" . $item['pname'] . "</td>";
            echo "<td>" . $item['man_cost'] . "</td>";
            echo "<td>" . $item['sell_price'] . "</td>";
            echo "<td>" . $item['price_difference'] . "</td>";
            echo "</tr>";
        }
        
        echo '</tbody></table>';
    }
    ?>
    <?php
    if (!empty($data1)) {
        echo '<table border="1">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Profit</th> 
                    <th>Total Profit</th>
                </tr>
            </thead>
            <tbody>';
        
        foreach ($data1 as $item) {
            echo "<tr>";
            echo "<td>" . $item['pname'] . "</td>";
            echo "<td>" . $item['product_profit'] . "</td>";
            echo "<td>" . $item['total_profit'] . "</td>";
            echo "</tr>";
        }
        
        echo '</tbody></table>';
    }
    ?>
    <a href="javascript:history.back()">Back</a>
    <h2>Products Sold Histogram</h2>
    <div style="width: 80%;">
        <canvas id="histogramChart"></canvas>
    </div>
    <script>
        // Parse the PHP response and convert it into JavaScript data
        var data = <?php echo json_encode($data3); ?>;
        
        var ctx = document.getElementById('histogramChart').getContext('2d');
        var histogramChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Number of Product Sold',
                    data: data.product_profit,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    </script>
</body>
</html>
