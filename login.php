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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the form data (you can add more validations as per your requirements)
    if (empty($username) || empty($password)) {
        echo "<p>Please enter both username and password.</p>";
    } 
    else {
        // Perform authentication (you can replace this with your own authentication logic)
        if ($username === 'admin' && $password === 'password') {
            $encryptedUsername = md5($username);
            $_SESSION['username'] = $encryptedUsername; // Store the username in the session
            echo "<p>Login successful!</p>";
            header("Location: dashboard.php"); // Redirect to dashboard.html
        } else {
            // Invalid credentials
            echo "<p>Invalid username or password.</p>";
        }
    }
}
?>