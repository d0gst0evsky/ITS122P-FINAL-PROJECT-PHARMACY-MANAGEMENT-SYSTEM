<?php
// config.php - database connection file
// this file connects our pharmacy system to the database

// database credentials (Updated for Clever Cloud)
$db_host = "bjwp2fpsaulvdv9hejkp-mysql.services.clever-cloud.com";
$db_user = "uk7tfecxmfqcfjb3";
$db_pass = "ZGlaYFY13Pt8eX2LXM6t"; // <-- Pindutin mo yung orange lock sa Clever Cloud at i-paste rito ang password
$db_name = "bjwp2fpsaulvdv9hejkp";

// connect to the database
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// check kung nag-connect
if (!$conn) {
    die("Hindi makakonekta sa database: " . mysqli_connect_error());
}
?>
