<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
include 'config.php';

$result = mysqli_query($conn, "SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff</title>
</head>
<body>
    <h2>Staff</h2>
    <a href="dashboard.php">Back to Dashboard</a>
    <br><br>
    <a href="add_staff.php">+ Add Staff</a>
    <br><br>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Full Name</th>
            <th>Role</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['full_name']; ?></td>
            <td><?php echo $row['role']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td>
                <a href="edit_staff.php?id=<?php echo $row['user_id']; ?>">Edit</a> |
                <a href="delete_staff.php?id=<?php echo $row['user_id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>