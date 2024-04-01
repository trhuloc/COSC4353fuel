<?php
function getUsername() {
    if (session_status() === PHP_SESSION_NONE) {
        @session_start();
    }
    if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
        header("Location: login.php");
    }
    return $_SESSION['username'];
}
?>
