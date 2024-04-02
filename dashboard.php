<?php
@session_start();
require_once 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit(); // Stop further execution
}

$username = $_SESSION['username'];

$stmt = $mysqli->prepare("SELECT UserID FROM usercredentials WHERE Username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows == 0) {
    header("Location: index.html");
    exit();
}
$stmt->bind_result($userID);
$stmt->fetch();
$stmt->close();

// Get state code
$stmt = $mysqli->prepare("SELECT StateCode FROM clientinformation WHERE UserID = ?");
$stmt->bind_param("i", $userID); // Assuming UserID is an integer
$stmt->execute();
$stmt->bind_result($location);
$stmt->fetch();
$stmt->close();

$_SESSION['location'] = $location;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Fuel Management System - Dashboard</title>
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
        <a href="quote_history.html" class="taskbar-button">Fuel Quote History</a>
        <a href="profile_management.php" class="taskbar-button">Profile Management</a>
        <a href="logout.php" class="taskbar-button">Logout</a>
    </div>
    <div class="container">
        <h2>Welcome to the Dashboard</h2>
        <div class="dashboard-content">
            <!-- Your dashboard content here -->
        </div>
    </div>
</body>
</html>