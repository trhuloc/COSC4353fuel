<!DOCTYPE html>
<html lang="en">
<head>
    <title>Fuel Management System - Login</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username"><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password"><br><br>
            <input type="submit" value="Login">
        </form>
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>
</body>
</html>
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start the session if it is not already active
}
include 'db.php';

// Attempt to establish a connection to the database
// $mysqli = new mysqli($host, $username, $password, $dbname, $port);

// Check if the connection was successful
if ($mysqli->connect_error) {
    //die("Connection failed: " . $mysqli->connect_error);
    // Print message if connection fails
    echo "<p>Failed to connect to the database.</p>";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the form data
    if (empty($username) || empty($password)) {
        echo "<p>Please enter both username and password.</p>";
    } else {
        // Perform authentication
        $sql = "SELECT UserID, Username, Password FROM usercredentials WHERE Username = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            // Verify password
            if (password_verify($password, $row['Password'])) {
                $_SESSION['UserID'] = $row['UserID'];
                $_SESSION['Username'] = $row['Username'];
                $_SESSION['ProfileUpdated'] = $row['ProfileUpdated'];
                echo "<p>Login successful!</p>";
                header("Location: dashboard.php"); // Redirect to dashboard
                exit();
            } else {
                // Invalid password
                echo "<p>Invalid username or password.</p>";
            }
        } else {
            // User not found
            echo "<p>Invalid username or password.</p>";
        }

        $stmt->close();
    }
}
?>