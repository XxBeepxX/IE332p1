<?php
$servername = "mydb.itap.purdue.edu";
$username = "g1131592";
$password = "IE332";
$database = $username;

session_start();
$email = $_SESSION['email'];

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['multiSelect']) && !empty($_POST['multiSelect'])) {
    $selectedProducts = $_POST['multiSelect']; // Assign selected products
    $selectedProductsString = implode("', '", $selectedProducts);
    // Generate the SQL query with JOINS to filter by selected products and merge based on p_id and i_id
    $query = "SELECT Products.pname, COUNT(Orders.o_id) AS O_number
              FROM Orders
              INNER JOIN Inventory ON Orders.i_id = Inventory.i_id
              INNER JOIN Products ON Inventory.p_id = Products.p_id
              WHERE email = '$email'
              AND Products.pname IN ('$selectedProductsString')
              GROUP BY Products.p_id
              ORDER BY O_number DESC";
}


$result = $conn->query($query);

if ($result->num_rows > 0) {
    $data = [
        'labels' => [],
        'O_number' => []
    ];

    while ($row = $result->fetch_assoc()) {
        $data['labels'][] = $row['pname'];
        $data['O_number'][] = $row['O_number'];
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
    <title>Products Sold Histogram</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Products Sold Histogram</h2>
    <div style="width: 80%;">
        <canvas id="histogramChart"></canvas>
    </div>
    <a href="javascript:history.back()">Back</a>
    <script>
        // Parse the PHP response and convert it into JavaScript data
        var data = <?php echo json_encode($data); ?>;
        
        var ctx = document.getElementById('histogramChart').getContext('2d');
        var histogramChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Number of Product Sold',
                    data: data.O_number,
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
</body>
</html>
