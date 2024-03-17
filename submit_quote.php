<!DOCTYPE html>
<html lang="en">

<head>
    <title>Client Profile Management</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <style>
        .taskbar {
            background-color: #333;
            overflow: hidden;
        }

        .taskbar-button {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .taskbar-button:hover {
            background-color: #ddd;
            color: black;
        }

        .container {
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <div class="taskbar">
        <a href="dashboard.php" class="taskbar-button">Dashboard</a>
        <a href="fuel_quote_form.html" class="taskbar-button">Fuel Quote Form</a>
        <a href="quote_history.html" class="taskbar-button">Fuel Quote History</a>
        <a href="profile_management.php" class="taskbar-button">Profile Management</a>
        <a href="logout.php" class="taskbar-button">Logout</a>
    </div>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $gallonsRequested = $_POST["gallonsRequested"];
    $deliveryDate = $_POST["deliveryDate"];

    // Validate Gallons Requested
    if (!is_numeric($gallonsRequested)) {
        // Handle validation error
        echo "Gallons Requested must be a numeric value.";
    } else {
        // Perform calculations
        $pricingModule = new PricingModule(2.3); // $1.50 per gallon
        $totalPrice = $pricingModule->calculateTotalPrice($gallonsRequested); // 1000 gallons requested
        echo "<h1>Total Amount Due: $totalPrice</h1>";
    }
} else {
    // Handle empty form data
    echo "Please fill out the form.";
}
?>