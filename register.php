<!DOCTYPE html>
<html lang="en">
<head>
    <title>Fuel Management System - Register</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <?php
        // Display error message if there's any
        if (isset($error_message)) {
            echo "<p style='color: red;'>$error_message</p>";
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" data-validate="required"><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" data-validate="required"><br><br>
            <input type="submit" value="Register">
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>