<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
include 'config.php';

$result = mysqli_query($conn, "SELECT * FROM medicines");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventory</title>
</head>
<body>
    <h2>Inventory</h2>
    <a href="dashboard.php">Back to Dashboard</a>
    <br><br>
    <a href="add_medicine.php">+ Add Medicine</a>
    <br><br>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Unit</th>
            <th>Expiry</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['medicine_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['category']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td><?php echo $row['stock_quantity']; ?></td>
            <td><?php echo $row['unit']; ?></td>
            <td><?php echo $row['expiry_date']; ?></td>
            <td>
                <a href="edit_medicine.php?id=<?php echo $row['medicine_id']; ?>">Edit</a> |
                <a href="delete_medicine.php?id=<?php echo $row['medicine_id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>