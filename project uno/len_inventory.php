<?php
$servername = "mydb.itap.purdue.edu";
$username = "g1131592";
$password = "IE332";
$database = $username;
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if any options are selected in the multiSelect dropdown for products
if (isset($_POST['multiSelect']) && !empty($_POST['multiSelect'])) {
    $selectedProducts = $_POST['multiSelect'];
    $selectedProductsString = implode("', '", $selectedProducts);

    // Generate the SQL query with JOINs to filter by selected products and merge based on p_id and i_id
    $query = "SELECT Products.pname, AVG(DATEDIFF(Orders.o_date, Inventory.b_date)) AS days_in_inventory
              FROM Orders
              INNER JOIN Inventory ON Orders.i_id = Inventory.i_id
              INNER JOIN Products ON Inventory.p_id = Products.p_id
              WHERE Products.pname IN ('$selectedProductsString')
              GROUP BY Products.pname
              ORDER BY days_in_inventory DESC";
} 

$result = $conn->query($query);

// Check if there are results or handle errors
if ($result === false) {
    echo "Query error: " . $conn->error;
} elseif ($result->num_rows > 0) {
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Close the database connection
    $conn->close();
} else {
    $data = [];
    echo "No data found.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Products in Inventory</title>
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Products in Inventory</h2>
    <div style="width: 80%;">
        <canvas id="myChart"></canvas>
    </div>
    <a href="javascript:history.back()">Back</a>

    <?php
    if (!empty($data)) {
        // Prepare the data for the chart
        $productNames = [];
        $avgDaysInInventory = [];

        foreach ($data as $item) {
            $productNames[] = $item['pname'];
            $avgDaysInInventory[] = $item['days_in_inventory'];
        }
    }
    ?>

    <script>
        // Create a bar chart using Chart.js
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($productNames); ?>,
                datasets: [{
                    label: 'Average Days in Inventory',
                    data: <?php echo json_encode($avgDaysInInventory); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>

