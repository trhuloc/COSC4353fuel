<?php
    require_once 'Pricing.php';
    require_once 'db.php';
    if (session_status() === PHP_SESSION_NONE) {
        @session_start();
    }
    if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
        header("Location: login.php");
    }
    else {
        $username = $_SESSION['username'];
    }
    if(!isset($_SESSION['username']))
    {
        $username = "testuser";
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $gallonsRequested = $_POST["gallonsRequested"];
        $deliveryDate = $_POST["deliveryDate"];

        if (empty($_POST["gallonsRequested"]) || empty($_POST["deliveryDate"])) {
            // Display error message and redirect back to form
            echo "Please fill out the required information.";
        }

        // Validate field types
        $gallonsRequested = filter_var($_POST["gallonsRequested"], FILTER_VALIDATE_INT);
        if ($gallonsRequested === false || $gallonsRequested <= 0) {
            // Display error message and redirect back to form
            echo "Gallons Requested must be larger than 0.";
        }

        $deliveryDate = $_POST["deliveryDate"];
        $today = date("Y-m-d"); // Current date
        if ($deliveryDate < $today) {
            // Display error message and redirect back to form
            echo "Delivery Date must be valid.";
        }

        // Validate Gallons Requested
        if (!is_numeric($gallonsRequested)) {
            // Handle validation error
            echo "Gallons Requested must be a numeric value.";
        } else {
            // Get UserID from clientcredentials table
            $stmt = $mysqli->prepare("SELECT UserID FROM usercredentials WHERE Username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($userID);
            $stmt->fetch();
            $stmt->close();

            $pricingModule = new PricingModule(1.5); // $1.50 per gallon
            //get $location by select statecode in  clientcredentials table
            $stmt = $mysqli->prepare("SELECT StateCode FROM clientinformation WHERE UserID = ?");
            $stmt->bind_param("s", $userID);
            $stmt->execute();
            $stmt->bind_result($location);
            $stmt->fetch();
            $stmt->close();
            //get $hasHistory by select count(*) in fuelquote table
            $stmt = $mysqli->prepare("SELECT count(*) FROM fuelquote WHERE UserID = ?");
            $stmt->bind_param("s", $userID);
            $stmt->execute();
            $stmt->bind_result($hasHistory);
            $stmt->fetch();
            $stmt->close();
            if($hasHistory > 0)
                $hasHistory = 1;
            else
                $hasHistory = 0;
            $totalPrice = $pricingModule->calculateTotalPrice($gallonsRequested,$location,$hasHistory);

            // Insert into database
            $stmt = $mysqli->prepare("INSERT INTO fuelquote (UserID, GallonsRequested, DeliveryDate, TotalAmountDue) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiss", $userID, $gallonsRequested, $deliveryDate, $totalPrice);
            $stmt->execute();
            $stmt->close();
            header("Location: quote_success.html");
        }
    } else {
        // Handle empty form data
        echo "Please fill out the form.";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Fuel Quote Form</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <script src="fuel_quote_form.js" defer></script>
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
        <a href="submit_quote.html" class="taskbar-button">Fuel Quote Form</a>
        <a href="quote_history.html" class="taskbar-button">Fuel Quote History</a>
        <a href="profile_management.php" class="taskbar-button">Profile Management</a>
        <a href="logout.php" class="taskbar-button">Logout</a>
    </div>
    <div class="container">
        <h2>Fuel Quote Form</h2>
        <form action="submit_quote.php" method="post">
            
            <label for="gallonsRequested">Gallons Requested:</label>
            <input type="number" id="gallonsRequested" name="gallonsRequested" min="1" value="0" required><br>
            <span id="test"></span><br>

            <label for="deliveryAddress">Delivery Address:</label>
            <input type="text" id="deliveryAddress" name="deliveryAddress" value="In-state" readonly ><br>

            
            <label for="deliveryDate">Delivery Date:</label>
            <input type="date" id="deliveryDate" name="deliveryDate" required><br>
            
            <label for="suggestedPrice">Suggested Price / Gallon:</label>
            <input type="number" id="suggestedPrice" name="suggestedPrice" readonly step="0.01" ><br>
            
            <label for="totalAmountDue">Total Amount Due:</label>
            <input type="number" id="totalAmountDue" name="totalAmountDue" readonly step="0.01" ><br>
            
            <input type="submit" value="Submit Quote">
        </form>
    </div>
</body>

</html>
