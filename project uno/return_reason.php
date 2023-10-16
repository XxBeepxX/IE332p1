<?php
$servername = "mydb.itap.purdue.edu";
$username = "g1131592";
$password = "IE332";
$database = $username;
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize $data as an empty array
$data = [];

// Check if any options are selected in the multiSelect dropdown
if (isset($_POST['multiSelect']) && !empty($_POST['multiSelect'])) {
    $selectedProducts = $_POST['multiSelect'];
    $selectedProductsString = implode("', '", $selectedProducts);

    // Generate the SQL query with JOINS to filter by selected products and merge based on p_id and i_id
    $query = "SELECT return_reason, COUNT(*) AS return_count
              FROM Orders
              INNER JOIN Inventory ON Orders.i_id = Inventory.i_id
              INNER JOIN Products ON Inventory.p_id = Products.p_id
              WHERE Products.pname IN ('$selectedProductsString')
              AND return_reason <> ''
              GROUP BY return_reason";
} 

$result = $conn->query($query);

if ($result === false) {
    // Handle the SQL query error
    echo "Error: " . $conn->error;
} else {
    // Check if there are results
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Return Reason Histogram</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Return Reason Histogram</h2>
    <div style="width: 80%;">
        <canvas id="myChart"></canvas>
    </div>
    <a href="javascript:history.back()">Back</a>
    <script>
        // Data from PHP
        var data = <?php echo json_encode($data); ?>;
        
        // Check if data is not empty before using it
        if (data.length > 0) {
            var labels = data.map(function(item) {
                return item.return_reason;
            });
            var counts = data.map(function(item) {
                return item.return_count;
            });

            var ctx = document.getElementById('myChart').getContext('2d');
            
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Frequency',
                        data: counts,
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
        } else {
            // Display a message when there's no data
            document.getElementById('myChart').style.display = 'none';
        }
        </script>
    </body>
</html>
