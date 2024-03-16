<?php

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the form data (you can add more validations as per your requirements)
    if (empty($username) || empty($password)) {
        // Handle empty fields error
        echo "Please enter both username and password.";
    } else {
        // Perform authentication (you can replace this with your own authentication logic)
        if ($username === 'admin' && $password === 'password') {
            // Successful login
            echo "Login successful!";
        } else {
            // Invalid credentials
            echo "Invalid username or password.";
        }
    }
} else {
    // Handle non-POST requests (optional)
    echo "Invalid request.";
}