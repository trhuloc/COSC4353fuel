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
        if (isset($_POST["submit"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $passWordRepeat = $_POST["repeat_password"];

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $errors = array();

            if(empty($username) || empty($password) || empty($passWordRepeat)) {
                array_push($errors,"All fields are required");
            }
            if(strlen($password) < 7) {
                array_push($errors,"Password must be at least 7 characters long");
            }
            if($password != $passWordRepeat) {
                array_push($errors,"Password does not match");
            }
            require_once "database.php";
            $sql = "SELECT * FROM users WHERE username = '$username'";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount>0) {
                array_push($errors,"Username already exists!");
            }
            if(count($errors) > 0) {
                foreach($errors as $error) {   
                    echo "<div class = 'alert alert-danger'>$error</div>";
                } 
            } else {
                $sql = "INSERT INTO users (username, password) VALUE (?, ?)";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                if ($prepareStmt) {
                    mysqli_stmt_bind_param($stmt,"ss", $username, $passwordHash);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'>You are registered successfully.</div>";
                } else{
                    die("Something went wrong");
                }
            }
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class = "form-group">
                <!-- Username -->
                <label for="username">Username:</label><br>
                <input type="text" class = "form-control" id="username" name="username" data-validate="required"><br>
            </div>
            <div class = "form-group">
                <!-- Password -->
                <label for="password">Password:</label><br>
                <input type="password" class = "form-control" id="password" name="password" pattern="(?=.*\d)(?=.*[\W_]).{7,}" title="Minimum of 7 characters. Should have at least one special character and one number." data-validate="required"><br>
            </div>
            <div class = "form-group">
                <!-- Confirm Password -->
                <label for="password">Repeat Password:</label><br>
                <input type="password" class = "form-control" id="password_confirmation" name="repeat_password" data-validate="required"><br><br>
            </div>
            <div class = "form-btn" >
                <input type="submit" class = "btn btn-primary" value="Register" name = "submit">
            </div>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>