<?php
@session_start();

if (session_status() === PHP_SESSION_ACTIVE)
    session_destroy();

// Redirect to login page
header("Location: index.html");
?>