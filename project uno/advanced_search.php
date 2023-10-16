<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selectedOption = $_POST['searchOption'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $startDate = date("Y-m-d", strtotime($startDate));
    $endDate = date("Y-m-d", strtotime($endDate));

    // Replace with your database credentials
    $servername = "mydb.itap.purdue.edu";
    $username = "g1131592";
    $password = "IE332";
    $database = $username;

    session_start();
    $email = $_SESSION['email'];

    // Create a MySQLi connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


        if ($selectedOption == 'option1') {
            // SQL query for "Average Length of Product Storage"
            $sql = "SELECT AVG(DATEDIFF(Orders.o_date, Inventory.b_date)) AS avg_storage_days 
            FROM Orders
            INNER JOIN Inventory ON Orders.i_id = Inventory.i_id
            INNER JOIN Products ON Inventory.p_id = Products.p_id
            WHERE email = '$email'
            AND Orders.o_date >= '$startDate' 
            AND Orders.o_date <= '$endDate'
            AND Inventory.b_date >= '$startDate' 
            AND Inventory.b_date <= '$endDate'";

            $result = $conn->query($sql);

            if ($result) {
                $row = $result->fetch_assoc();
                echo "Average Length of Product Storage: " . $row['avg_storage_days'] . " days";
                
            } else {
                echo "Error: " . $conn->error;
            }
        } elseif ($selectedOption == 'option2') {
            // SQL query for "Most/Least Time in Storage"
            $sql = "SELECT MAX(DATEDIFF(Orders.o_date, Inventory.b_date)) AS max_storage_days, MIN(DATEDIFF(Orders.o_date, Inventory.b_date)) AS min_storage_days, Products.pname
            FROM Orders
            INNER JOIN Inventory ON Orders.i_id = Inventory.i_id
            INNER JOIN Products ON Inventory.p_id = Products.p_id
            WHERE email = '$email'
            AND Orders.o_date >= '$startDate' 
            AND Orders.o_date <= '$endDate'
            AND Inventory.b_date >= '$startDate' 
            AND Inventory.b_date <= '$endDate'";
            $result = $conn->query($sql);

            if ($result) {
                $row = $result->fetch_assoc();
                echo "Most Time in Storage: " . $row['max_storage_days'] . " days<br>";
                echo "Least Time in Storage: " . $row['min_storage_days'] . " days";
            } else {
                echo "Error: " . $conn->error;
            }
        } if ($selectedOption == 'option3') {
            // SQL query for "Table of Product Sold"
            $sql = "SELECT Products.pname, COUNT(Orders.o_id) AS O_number
                    FROM Orders
                    INNER JOIN Inventory ON Orders.i_id = Inventory.i_id
                    INNER JOIN Products ON Inventory.p_id = Products.p_id
                    WHERE email = '$email'
                    AND Orders.o_date >= '$startDate' 
                    AND Orders.o_date <= '$endDate'
                    AND Inventory.b_date >= '$startDate' 
                    AND Inventory.b_date <= '$endDate'
                    GROUP BY Products.p_id
                    ORDER BY O_number DESC";
        
            // Execute the query
            $result = $conn->query($sql);
        
            if ($result) {
                echo "<table>";
                echo "<tr><th>Product Name</th><th>Number of Orders</th></tr>";
        
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['pname'] . "</td>";
                    echo "<td>" . $row['O_number'] . "</td>";
                    echo "</tr>";
                }
        
                echo "</table>";
            } else {
                echo "Error: " . $conn->error;
            }
        } elseif ($selectedOption == 'option4') {
            // SQL query for "Product Returned"
            $sql = "SELECT Products.pname, return_reason, COUNT(*) AS return_count
            FROM Orders
            INNER JOIN Inventory ON Orders.i_id = Inventory.i_id
            INNER JOIN Products ON Inventory.p_id = Products.p_id
            WHERE return_reason <> ''
            AND email = '$email'
            GROUP BY Products.pname, return_reason
            AND Orders.o_date >= '$startDate' 
            AND Orders.o_date <= '$endDate'
            AND Inventory.b_date >= '$startDate' 
            AND Inventory.b_date <= '$endDate'";
            $result = $conn->query($sql);

            if ($result) {
                echo "<table>";
                echo "<tr><th>Product Name</th><th>Return Reason</th><th>Return Count</th></tr>";
        
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['pname'] . "</td>";
                    echo "<td>" . $row['return_reason'] . "</td>";
                    echo "<td>" . $row['return_count'] . "</td>";
                    echo "</tr>";
                }
        
                echo "</table>";
            } else {
                echo "Error: " . $conn->error;
            }
        } elseif ($selectedOption == 'option5') {
            // SQL query for "Customer Loyalty"
            $sql = "SELECT Customer.c_name, COUNT(Orders.customer_id) AS frequency
                    FROM Orders
                    INNER JOIN Customer ON Orders.customer_id = Customer.customer_id
                    INNER JOIN Inventory ON Orders.i_id = Inventory.i_id
                    INNER JOIN Products ON Inventory.p_id = Products.p_id
                    WHERE Orders.o_date >= '$startDate' 
                    AND Orders.o_date <= '$endDate'
                    AND Inventory.b_date >= '$startDate' 
                    AND Inventory.b_date <= '$endDate'
                    GROUP BY Orders.customer_id
                    ORDER BY frequency DESC";
            
            $result = $conn->query($sql);
        
            if ($result) {
                echo '<table>';
                echo '<tr><th>Customer Name</th><th>Frequency</th></tr>';
        
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['c_name'] . '</td>';
                    echo '<td>' . $row['frequency'] . '</td>';
                    echo '</tr>';
                }
        
                echo '</table>';
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            // Handle other options or display an error message
            echo "Invalid option selected.";
        }

        // Close the MySQLi connection
        $conn->close();

        echo '<form action="main.php">'; // Replace with the actual URL of your previous page
        echo '<input type="submit" value="Back">';
        echo '</form>';
    
}
?>
