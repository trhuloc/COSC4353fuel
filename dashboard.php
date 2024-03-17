<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username']) || empty($_SESSION['username']) || !isset($_SESSION['encryptedUsername']) || empty($_SESSION['encryptedUsername'])){
    header("Location: login.php");
    exit;
}
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
        <a href="fuel_quote_form.html" class="taskbar-button">Fuel Quote Form</a>
        <a href="quote_history.html" class="taskbar-button">Fuel Quote History</a>
        <a href="profile_management.php" class="taskbar-button">Profile Management</a>
        <a href="logout.php" class="taskbar-button">Logout</a>
    </div>
    <div class="container">
        <h2>Welcome to the Dashboard</h2>
        <div class="dashboard-content">
            <div class="dashboard-item">
                <h3>Total Fuel Quotes</h3>
                <p>Today: 5</p>
                <p>This Week: 25</p>
                <p>This Month: 120</p>
            </div>
            <div class="dashboard-item">
                <h3>Recent Fuel Quotes</h3>
                <ul>
                    <li>Quote ID: 12345 - Gallons Requested: 1000</li>
                    <li>Quote ID: 12346 - Gallons Requested: 800</li>
                    <li>Quote ID: 12347 - Gallons Requested: 1200</li>
                </ul>
            </div>
            <div class="dashboard-item">
                <h3>Upcoming Deliveries</h3>
                <ul>
                    <li>Client: John Doe - Delivery Date: 2024-03-01</li>
                    <li>Client: Jane Smith - Delivery Date: 2024-03-03</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
