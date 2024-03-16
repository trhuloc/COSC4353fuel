<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassWord = "";
$dbName = "login_register";
$conn = mysqli_connect($hostName,$dbUser,$dbPassWord,$dbName);
if (!$conn) {
    die("Connection failed");
}