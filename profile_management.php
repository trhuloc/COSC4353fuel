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
require_once 'db.php';

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
        // Retrieve the UserID of the currently logged-in user
        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['username'])) {
            // Redirect to the login page if not logged in
            header("Location: login.php");
            exit(); // Stop further execution
        }
        $username = $_SESSION['username'];

        $stmt = $mysqli->prepare("SELECT UserID FROM usercredentials WHERE Username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($userID);
        $stmt->fetch();
        $stmt->close();

        // Check if the user already has data in the clientinformation table
        $stmt = $mysqli->prepare("SELECT * FROM clientinformation WHERE UserID = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        $clientData = $result->fetch_assoc();
        $stmt->close();
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

        $stmt = $mysqli->prepare("UPDATE usercredentials SET ProfileUpdated = 1 WHERE UserID = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $stmt->close();

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

// Retrieve client information from the database
$stmt = $mysqli->prepare("SELECT * FROM clientinformation WHERE UserID = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$clientData = $result->fetch_assoc();
$stmt->close();
?>

<h2>Edit Client Information</h2>
<div class="taskbar">
        <a href="dashboard.php" class="taskbar-button">Dashboard</a>
        <a href="fuel_quote_form.html" class="taskbar-button">Fuel Quote Form</a>
        <a href="quote_history.html" class="taskbar-button">Fuel Quote History</a>
        <a href="profile_management.php" class="taskbar-button">Profile Management</a>
        <a href="logout.php" class="taskbar-button">Logout</a>
</div>
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
    <input type="text" id="state" name="state" maxlength="2" value="<?= !empty($clientData['StateCode']) ? $clientData['StateCode'] : '' ?>"><br>

    <label for="zipcode">Zipcode:</label><br>
    <input type="text" id="zipcode" name="zipcode" value="<?= !empty($clientData['Zipcode']) ? $clientData['Zipcode'] : '' ?>"><br>

    <input type="submit" value="Submit">
</form>

</body>
</html>

