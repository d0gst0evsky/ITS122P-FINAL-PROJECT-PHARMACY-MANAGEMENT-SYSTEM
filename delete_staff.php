<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
include 'config.php';

$id = $_GET['id'];

// Prevent deleting yourself
if ($id == $_SESSION['user_id']) {
    header('Location: staff.php');
    exit();
}

mysqli_query($conn, "DELETE FROM users WHERE user_id='$id'");
header('Location: staff.php');
exit();
?>