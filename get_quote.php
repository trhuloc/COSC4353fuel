<!DOCTYPE html>
<html lang="en">
<head>
    <title>Fuel Quote Form</title>
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
        <a href="submit_quote.php" class="taskbar-button">Fuel Quote Form</a>
        <a href="quote_history.php" class="taskbar-button">Fuel Quote History</a>
        <a href="profile_management.php" class="taskbar-button">Profile Management</a>
        <a href="logout.php" class="taskbar-button">Logout</a>
    </div>
    <div class="container">
        <h2>Fuel Quote Form</h2>
        <?php
        require_once 'Pricing.php';
        require_once 'db.php';
        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }
        if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
            header("Location: login.php");
            exit;
        } else {
            $username = $_SESSION['username'];
        }
        if (!isset($_SESSION['username'])) {
            $username = "testuser";
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $gallonsRequested = $_POST["gallonsRequested"];
            $deliveryDate = $_POST["deliveryDate"];
            $stmt = $mysqli->prepare("SELECT UserID FROM usercredentials WHERE Username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($userID);
            $stmt->fetch();
            $stmt->close();
            $pricingModule = new PricingModule(1.5); // $1.50 per gallon
            $stmt = $mysqli->prepare("SELECT StateCode FROM clientinformation WHERE UserID = ?");
            $stmt->bind_param("s", $userID);
            $stmt->execute();
            $stmt->bind_result($location);
            $stmt->fetch();
            $stmt->close();
            $stmt = $mysqli->prepare("SELECT count(*) FROM fuelquote WHERE UserID = ?");
            $stmt->bind_param("s", $userID);
            $stmt->execute();
            $stmt->bind_result($hasHistory);
            $stmt->fetch();
            $stmt->close();
            if ($hasHistory > 0) {
                $hasHistory = 1;
            } else {
                $hasHistory = 0;
            }
            $totalPrice = $pricingModule->calculateTotalPrice($gallonsRequested, $location, $hasHistory);
            if ($location == "TX") {
                $instate = "In State";
            } else {
                $instate = "Out of State";
            }
        }
        ?>
        <form id="quoteForm" action="get_quote.php" method="post">
            <label for="gallonsRequested">Gallons Requested:</label>
            <input type="number" id="gallonsRequested" name="gallonsRequested" min="1" value="<?php echo isset($gallonsRequested) ? $gallonsRequested : ''; ?>" required><br>

            <label for="deliveryAddress">Delivery Address:</label>
            <input type="text" id="deliveryAddress" name="deliveryAddress" value="<?php echo isset($instate) ? $instate : ''; ?>" readonly><br>

            <label for="deliveryDate">Delivery Date:</label>
            <input type="date" id="deliveryDate" name="deliveryDate" value="<?php echo isset($deliveryDate) ? $deliveryDate : ''; ?>" required><br>

            <label for="suggestedPrice">Suggested Price / Gallon:</label>
            <input type="number" id="suggestedPrice" name="suggestedPrice" readonly step="0.01" value="<?php echo isset($totalPrice) ? $totalPrice / $gallonsRequested : ''; ?>"><br>

            <label for="totalAmountDue">Total Amount Due:</label>
            <input type="number" id="totalAmountDue" name="totalAmountDue" readonly step="0.01" value="<?php echo isset($totalPrice) ? $totalPrice : ''; ?>"><br>

            <input type="submit" value="Submit Quote" id="submitQuoteBtn">
        </form>
    </div>
</body>
</html>

<?php
    $stmt = $mysqli->prepare("INSERT INTO fuelquote (UserID, GallonsRequested, DeliveryDate, TotalAmountDue) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $userID, $gallonsRequested, $deliveryDate, $totalPrice);
    $stmt->execute();
    $stmt->close();
    $suggestedPrice = $totalPrice/$gallonsRequested;
    header("Location: quote_success.html");
?>


