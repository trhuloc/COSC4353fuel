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
        echo "<p style='color: red;'>Please fill in all the fields.</p>";
    } elseif (strlen($password) < 8) {
        echo "<p style='color: red;'>Password must be at least 8 characters long.</p>";
    } else {
        // Check if the username already exists
        $check_stmt = $mysqli->prepare("SELECT UserID FROM usercredentials WHERE Username = ?");
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $check_stmt->store_result();
        
        if ($check_stmt->num_rows > 0) {
            echo "<p style='color: red;'>Username already exists. Please choose a different one.</p>";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Perform the registration process
            // Prepare and execute the SQL statement
            $insert_stmt = $mysqli->prepare("INSERT INTO usercredentials (Username, Password) VALUES (?, ?)");
            $insert_stmt->bind_param("ss", $username, $hashed_password);
            
            if ($insert_stmt->execute()) {
                // Display a success message
                echo "Registration successful!";
                header("Location: register_success.html");
            } else {
                echo "<p style='color: red;'>Registration failed. Please try again.</p>";
            }
        }
    }
}

?>