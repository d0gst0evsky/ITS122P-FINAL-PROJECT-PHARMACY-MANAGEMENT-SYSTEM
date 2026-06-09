<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
include 'config.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM medicines WHERE medicine_id='$id'");
header('Location: inventory.php');
exit();
?>