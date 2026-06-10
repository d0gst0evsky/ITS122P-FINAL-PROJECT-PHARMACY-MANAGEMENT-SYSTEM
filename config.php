<?php
// config.php - database connection file
// this file connects our pharmacy system to the database

// database credentials
$db_host = "localhost";
$db_user = "root";
$db_pass = ""; // walang password sa localhost
$db_name = "pharmacy_management";

// connect to the database
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// check kung nag-connect
if (!$conn) {
    die("Hindi makakonekta sa database: " . mysqli_connect_error());
}
?>