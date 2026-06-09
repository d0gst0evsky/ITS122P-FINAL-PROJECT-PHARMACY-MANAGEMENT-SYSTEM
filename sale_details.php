<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
include 'config.php';

$id = $_GET['id'];

$sale = mysqli_fetch_assoc(mysqli_query($conn, "SELECT sales.*, users.full_name 
                            FROM sales 
                            JOIN users ON sales.user_id = users.user_id 
                            WHERE sale_id='$id'"));

$items = mysqli_query($conn, "SELECT sale_items.*, medicines.name 
                               FROM sale_items 
                               JOIN medicines ON sale_items.medicine_id = medicines.medicine_id 
                               WHERE sale_id='$id'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sale Details</title>
</head>
<body>
    <h2>Sale Details</h2>
    <a href="reports.php">Back to Reports</a>
    <hr>
    <p><strong>Sale ID:</strong> <?php echo $sale['sale_id']; ?></p>
    <p><strong>Cashier:</strong> <?php echo $sale['full_name']; ?></p>
    <p><strong>Date:</strong> <?php echo $sale['sale_date']; ?></p>
    <hr>
    <table border="1" cellpadding="8">
        <tr>
            <th>Medicine</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Subtotal</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($items)): ?>
        <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td>₱<?php echo $row['unit_price']; ?></td>
            <td>₱<?php echo $row['quantity'] * $row['unit_price']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <hr>
    <p><strong>Total Amount:</strong> ₱<?php echo $sale['total_amount']; ?></p>
    <p><strong>Amount Paid:</strong> ₱<?php echo $sale['amount_paid']; ?></p>
    <p><strong>Change:</strong> ₱<?php echo $sale['change_amount']; ?></p>
</body>
</html>