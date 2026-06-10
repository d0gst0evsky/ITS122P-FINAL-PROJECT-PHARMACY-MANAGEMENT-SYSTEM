<?php
// dashboard.php - main page after login

session_start();

// kung hindi pa naka-login, ibalik sa login page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// kunin yung info ng naka-login na user
$current_user = $_SESSION['username'];
$current_role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Pharmacy System</title>
</head>
<body>

    <!-- welcome message -->
    <h2>Welcome, <?php echo $current_user; ?>! 👋</h2>
    <p>Logged in as: <strong><?php echo $current_role; ?></strong></p>
    <hr>

    <!-- navigation links -->
    <nav>
        <a href="inventory.php">💊 Inventory</a> &nbsp;|&nbsp;
        <a href="pos.php">🛒 POS</a> &nbsp;|&nbsp;

        <!-- ipakita lang ang Staff, Reports, at Register kung admin -->
        <?php if ($current_role == 'admin'): ?>
            <a href="staff.php">👥 Staff</a> &nbsp;|&nbsp;
            <a href="reports.php">📊 Reports</a> &nbsp;|&nbsp;
            <a href="register.php">➕ Register User</a> &nbsp;|&nbsp;
        <?php endif; ?>

        <a href="logout.php">🚪 Logout</a>
    </nav>

</body>
</html>