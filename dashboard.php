<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
    <p>Role: <?php echo $_SESSION['role']; ?></p>
    <hr>
    <a href="inventory.php">Inventory</a> |
    <a href="pos.php">POS</a> |
    <a href="staff.php">Staff</a> |
    <a href="reports.php">Reports</a> |
    <a href="logout.php">Logout</a>
</body>
</html>