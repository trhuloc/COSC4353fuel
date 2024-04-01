
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
// Include the database connection file
require_once 'db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the submitted username and password
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate the input (you can add more validation logic here)
    if (empty($username) || empty($password)) {
        echo "<p style='color: red;'>Please enter both username and password.</p>";
    } else {
        // Retrieve the hashed password from the database
        $stmt = $mysqli->prepare("SELECT UserID, Password FROM usercredentials WHERE Username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // Username exists, fetch the hashed password
            $row = $result->fetch_assoc();
            $hashed_password = $row['Password'];

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                echo "Password is correct.";
                session_start();
                $_SESSION['username'] = $username;
                // Redirect to dashboard or any other page after successful login
                header("Location: dashboard.php");
            } else {
                // Invalid password
                echo "<p style='color: red;'>Invalid username or password.</p>";
            }
        } else {
            // Invalid username
            echo "<p style='color: red;'>Invalid username or password.</p>";
        }
    }
}
?>