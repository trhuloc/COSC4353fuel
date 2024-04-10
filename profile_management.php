<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Client Information</title>
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
<?php
// Include the database connection file
require_once 'Pricing.php';
require_once 'db.php';
if (session_status() === PHP_SESSION_NONE) {
    @session_start();
}
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: login.php");
} else {
    $username = $_SESSION['username'];
}
if (!isset($_SESSION['username'])) {
    $username = "testuser";
}
$stmt = $mysqli->prepare("SELECT UserID FROM usercredentials WHERE Username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($userID);
$stmt->fetch();
$stmt->close();

$stmt = $mysqli->prepare("SELECT * FROM clientinformation WHERE UserID = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$clientData = $result->fetch_assoc();
$stmt->close();
// Validate and process form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $fullName = $_POST['fullName'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zipcode = $_POST['zipcode'];

    // Perform validation
    $isValid = true;
    $errorMessages = [];

    if (empty($fullName)) {
        $errorMessages[] = "Full Name is required.";
        $isValid = false;
    } elseif (strlen($fullName) > 50) {
        $errorMessages[] = "Full Name should not exceed 50 characters.";
        $isValid = false;
    }

    if (empty($address1)) {
        $errorMessages[] = "Address 1 is required.";
        $isValid = false;
    } elseif (strlen($address1) > 100) {
        $errorMessages[] = "Address 1 should not exceed 100 characters.";
        $isValid = false;
    }

    if (strlen($address2) > 100) {
        $errorMessages[] = "Address 2 should not exceed 100 characters.";
        $isValid = false;
    }

    if (empty($city)) {
        $errorMessages[] = "City is required.";
        $isValid = false;
    } elseif (strlen($city) > 100) {
        $errorMessages[] = "City should not exceed 100 characters.";
        $isValid = false;
    }

    if (empty($state)) {
        $errorMessages[] = "State is required.";
        $isValid = false;
    } elseif (strlen($state) !== 2) {
        $errorMessages[] = "Invalid State format.";
        $isValid = false;
    }

    if (empty($zipcode)) {
        $errorMessages[] = "Zipcode is required.";
        $isValid = false;
    } elseif (!preg_match('/^[0-9]{5,9}$/', $zipcode)) {
        $errorMessages[] = "Invalid Zipcode format.";
        $isValid = false;
    }

    // If the form data is valid, prepare data for update
    if ($isValid) {
        // Check if the user already has data in the clientinformation table
        // If user already has data, update it in the database
        if ($clientData) {
            $stmt = $mysqli->prepare("UPDATE clientinformation SET FullName = ?, Address1 = ?, Address2 = ?, City = ?, StateCode = ?, Zipcode = ? WHERE UserID = ?");
            $stmt->bind_param("ssssssi", $fullName, $address1, $address2, $city, $state, $zipcode, $userID);
            $stmt->execute();
            $stmt->close();
        } else {
            // If no existing data, insert new record into the clientinformation table
            $stmt = $mysqli->prepare("INSERT INTO clientinformation (UserID, FullName, Address1, Address2, City, StateCode, Zipcode) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssssi", $userID, $fullName, $address1, $address2, $city, $state, $zipcode);
            $stmt->execute();
            $stmt->close();
        }

        // Redirect to a success page
        header("Location: profile_success.html");
        exit();
    } else {
        // Output error messages
        foreach ($errorMessages as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
}

$stmt = $mysqli->prepare("SELECT * FROM clientinformation WHERE UserID = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$clientData = $result->fetch_assoc();
$stmt->close();
?>
    <div class="taskbar">
        <a href="dashboard.php" class="taskbar-button">Dashboard</a>
        <a href="submit_quote.php" class="taskbar-button">Fuel Quote Form</a>
        <a href="quote_history.php" class="taskbar-button">Fuel Quote History</a>
        <a href="profile_management.php" class="taskbar-button">Profile Management</a>
        <a href="logout.php" class="taskbar-button">Logout</a>
    </div>
<h2>Edit Client Information</h2>

<form method="post" action="">
    <label for="fullName">Full Name:</label><br>
    <input type="text" id="fullName" name="fullName" value="<?= !empty($clientData['FullName']) ? $clientData['FullName'] : '' ?>"><br>

    <label for="address1">Address 1:</label><br>
    <input type="text" id="address1" name="address1" value="<?= !empty($clientData['Address1']) ? $clientData['Address1'] : '' ?>"><br>

    <label for="address2">Address 2:</label><br>
    <input type="text" id="address2" name="address2" value="<?= !empty($clientData['Address2']) ? $clientData['Address2'] : '' ?>"><br>

    <label for="city">City:</label><br>
    <input type="text" id="city" name="city" value="<?= !empty($clientData['City']) ? $clientData['City'] : '' ?>"><br>

    <label for="state">State:</label><br>
    <select id="state" name="state">
        <option value="">Select State</option>
        <option value="AL" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'AL' ? 'selected' : '' ?>>Alabama</option>
        <option value="AK" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'AK' ? 'selected' : '' ?>>Alaska</option>
        <option value="AZ" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'AZ' ? 'selected' : '' ?>>Arizona</option>
        <option value="AR" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'AR' ? 'selected' : '' ?>>Arkansas</option>
        <option value="CA" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'CA' ? 'selected' : '' ?>>California</option>
        <option value="CO" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'CO' ? 'selected' : '' ?>>Colorado</option>
        <option value="CT" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'CT' ? 'selected' : '' ?>>Connecticut</option>
        <option value="DE" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'DE' ? 'selected' : '' ?>>Delaware</option>
        <option value="FL" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'FL' ? 'selected' : '' ?>>Florida</option>
        <option value="GA" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'GA' ? 'selected' : '' ?>>Georgia</option>
        <option value="HI" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'HI' ? 'selected' : '' ?>>Hawaii</option>
        <option value="ID" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'ID' ? 'selected' : '' ?>>Idaho</option>
        <option value="IL" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'IL' ? 'selected' : '' ?>>Illinois</option>
        <option value="IN" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'IN' ? 'selected' : '' ?>>Indiana</option>
        <option value="IA" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'IA' ? 'selected' : '' ?>>Iowa</option>
        <option value="KS" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'KS' ? 'selected' : '' ?>>Kansas</option>
        <option value="KY" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'KY' ? 'selected' : '' ?>>Kentucky</option>
        <option value="LA" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'LA' ? 'selected' : '' ?>>Louisiana</option>
        <option value="ME" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'ME' ? 'selected' : '' ?>>Maine</option>
        <option value="MD" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'MD' ? 'selected' : '' ?>>Maryland</option>
        <option value="MA" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'MA' ? 'selected' : '' ?>>Massachusetts</option>
        <option value="MI" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'MI' ? 'selected' : '' ?>>Michigan</option>
        <option value="MN" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'MN' ? 'selected' : '' ?>>Minnesota</option>
        <option value="MS" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'MS' ? 'selected' : '' ?>>Mississippi</option>
        <option value="MO" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'MO' ? 'selected' : '' ?>>Missouri</option>
        <option value="MT" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'MT' ? 'selected' : '' ?>>Montana</option>
        <option value="NE" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'NE' ? 'selected' : '' ?>>Nebraska</option>
        <option value="NV" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'NV' ? 'selected' : '' ?>>Nevada</option>
        <option value="NH" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'NH' ? 'selected' : '' ?>>New Hampshire</option>
        <option value="NJ" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'NJ' ? 'selected' : '' ?>>New Jersey</option>
        <option value="NM" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'NM' ? 'selected' : '' ?>>New Mexico</option>
        <option value="NY" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'NY' ? 'selected' : '' ?>>New York</option>
        <option value="NC" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'NC' ? 'selected' : '' ?>>North Carolina</option>
        <option value="ND" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'ND' ? 'selected' : '' ?>>North Dakota</option>
        <option value="OH" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'OH' ? 'selected' : '' ?>>Ohio</option>
        <option value="OK" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'OK' ? 'selected' : '' ?>>Oklahoma</option>
        <option value="OR" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'OR' ? 'selected' : '' ?>>Oregon</option>
        <option value="PA" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'PA' ? 'selected' : '' ?>>Pennsylvania</option>
        <option value="RI" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'RI' ? 'selected' : '' ?>>Rhode Island</option>
        <option value="SC" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'SC' ? 'selected' : '' ?>>South Carolina</option>
        <option value="SD" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'SD' ? 'selected' : '' ?>>South Dakota</option>
        <option value="TN" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'TN' ? 'selected' : '' ?>>Tennessee</option>
        <option value="TX" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'TX' ? 'selected' : '' ?>>Texas</option>
        <option value="UT" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'UT' ? 'selected' : '' ?>>Utah</option>
        <option value="VT" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'VT' ? 'selected' : '' ?>>Vermont</option>
        <option value="VA" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'VA' ? 'selected' : '' ?>>Virginia</option>
        <option value="WA" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'WA' ? 'selected' : '' ?>>Washington</option>
        <option value="WV" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'WV' ? 'selected' : '' ?>>West Virginia</option>
        <option value="WI" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'WI' ? 'selected' : '' ?>>Wisconsin</option>
        <option value="WY" <?= !empty($clientData['StateCode']) && $clientData['StateCode'] === 'WY' ? 'selected' : '' ?>>Wyoming</option>
    </select><br>

    <label for="zipcode">Zipcode:</label><br>
    <input type="text" id="zipcode" name="zipcode" value="<?= !empty($clientData['Zipcode']) ? $clientData['Zipcode'] : '' ?>"><br>

    <input type="submit" value="Submit">
</form>

</body>
</html>