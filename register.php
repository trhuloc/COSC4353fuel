<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the submitted username and password
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate the input (you can add more validation logic here)
    if (empty($username) || empty($password)) {
        $error_message = "Please fill in all the fields.";
    } else {
        // Perform the registration process (you can add your own logic here)
        // For example, you can store the user details in a database

        // Display a success message
        $success_message = "Registration successful!";
    }
}
?>

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

        // Display success message if registration is successful
        if (isset($success_message)) {
            echo "<p style='color: green;'>$success_message</p>";
        }
        ?>
        <form action="register.php" method="post">
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