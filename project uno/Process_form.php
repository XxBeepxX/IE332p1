<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check the submitted option
    $selectedOption = $_POST["singleSelect"];
    
    // Include the respective PHP file based on the selected option
    if ($selectedOption === "3") {
        include("customer_freq.php"); // Include the PHP file for Customer Loyalty
    } elseif ($selectedOption === "1") {
        include("SQLcommands.php"); // Include the PHP file for Return Reason
    } elseif ($selectedOption === "4") {
        include("return_reason.php"); // Include the PHP file for Return Reason
    } elseif ($selectedOption === "5") {
        include("len_inventory.php"); // Include the PHP file for Return Reason
    } elseif ($selectedOption === "2") {
        include("products_sold.php"); // Include the PHP file for Return Reason
    } else {
        echo "Invalid option selected.";
    }
}
?>