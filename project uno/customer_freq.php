<?php
$servername = "mydb.itap.purdue.edu";
$username = "g1131592";
$password = "IE332";
$database = $username;
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$selectedProducts = []; // Initialize the selectedProducts array

// Check if any options are selected in the multiSelect dropdown
if (isset($_POST['multiSelect']) && !empty($_POST['multiSelect'])) {
    $selectedProducts = $_POST['multiSelect']; // Assign selected products
    $selectedProductsString = implode("', '", $selectedProducts);

    // Generate the SQL query with JOINS to filter by selected products and merge based on p_id and i_id
    $query = "SELECT Customer.c_name, COUNT(Orders.customer_id) AS frequency
              FROM Orders
              INNER JOIN Customer ON Orders.customer_id = Customer.customer_id
              INNER JOIN Inventory ON Orders.i_id = Inventory.i_id
              INNER JOIN Products ON Inventory.p_id = Products.p_id
              WHERE Products.pname IN ('$selectedProductsString')
              GROUP BY Orders.customer_id
              ORDER BY frequency DESC";
} 

$result = $conn->query($query);

if ($result->num_rows > 0) {
    $data = [
        'labels' => [],
        'frequency' => []
    ];

    while ($row = $result->fetch_assoc()) {
        $data['labels'][] = $row['c_name'];
        $data['frequency'][] = $row['frequency'];
    }

    // Close the database connection
    $conn->close();
} else {
    $data = [
        'labels' => [],
        'frequency' => []
    ];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Name Histogram</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Customer Name Histogram</h2>
    <div style="width: 80%;">
        <canvas id="histogramChart"></canvas>
    </div>
    <a href="javascript:history.back()">Back</a>
    <script>
        // Parse the PHP response and convert it into JavaScript data
        var data = <?php echo json_encode($data); ?>;
        
        var ctx = document.getElementById('histogramChart').getContext('2d');
        <?php
        if (!empty($data)) {
        ?>
        var histogramChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Frequency',
                    data: data.frequency,
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
        <?php
        }
        ?>
    </script>
</body>
</html>
