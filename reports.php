<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
include 'config.php';

$sales = mysqli_query($conn, "SELECT sales.*, users.full_name 
                               FROM sales 
                               JOIN users ON sales.user_id = users.user_id 
                               ORDER BY sale_date DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reports</title>
</head>
<body>
    <h2>Sales Reports</h2>
    <a href="dashboard.php">Back to Dashboard</a>
    <hr>
    <table border="1" cellpadding="8">
        <tr>
            <th>Sale ID</th>
            <th>Cashier</th>
            <th>Total Amount</th>
            <th>Amount Paid</th>
            <th>Change</th>
            <th>Date</th>
            <th>Details</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($sales)): ?>
        <tr>
            <td><?php echo $row['sale_id']; ?></td>
            <td><?php echo $row['full_name']; ?></td>
            <td>₱<?php echo $row['total_amount']; ?></td>
            <td>₱<?php echo $row['amount_paid']; ?></td>
            <td>₱<?php echo $row['change_amount']; ?></td>
            <td><?php echo $row['sale_date']; ?></td>
            <td><a href="sale_details.php?id=<?php echo $row['sale_id']; ?>">View</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>