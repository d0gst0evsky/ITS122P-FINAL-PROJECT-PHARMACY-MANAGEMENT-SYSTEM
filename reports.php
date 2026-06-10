<?php
// reports.php - para makita ang lahat ng benta

session_start();

// i-redirect sa login kung hindi naka-login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'config.php';

// admin lang ang pwedeng makakita ng reports
if ($_SESSION['role'] != 'admin') {
    header('Location: dashboard.php');
    exit();
}

// kunin lahat ng sales kasama ang pangalan ng cashier
$sales_list = mysqli_query($conn, "SELECT sales.*, users.full_name 
                                   FROM sales 
                                   JOIN users ON sales.user_id = users.user_id 
                                   ORDER BY sale_date DESC");

// i-count kung ilan lahat ng sales
$total_sales = mysqli_num_rows($sales_list);

// kalkulahin ang kabuuang kita
$revenue_query = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_amount) AS total_revenue FROM sales"));
$total_revenue = $revenue_query['total_revenue'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Reports - Pharmacy System</title>
</head>
<body>

    <h2>📊 Sales Reports</h2>
    <a href="dashboard.php">Back to Dashboard</a>
    <hr>

    <!-- summary ng sales -->
    <p>Total Transactions: <strong><?php echo $total_sales; ?></strong></p>
    <p>Kabuuang Kita: <strong>₱<?php echo number_format($total_revenue, 2); ?></strong></p>
    <hr>

    <!-- check kung may sales -->
    <?php if ($total_sales == 0): ?>
        <p>Wala pang sales record.</p>
    <?php else: ?>

    <table border="1" cellpadding="8">
        <tr>
            <th>Sale ID</th>
            <th>Cashier</th>
            <th>Total Amount</th>
            <th>Bayad</th>
            <th>Sukli</th>
            <th>Petsa</th>
            <th>Details</th>
        </tr>

        <?php while ($sale = mysqli_fetch_assoc($sales_list)): ?>
        <tr>
            <td><?php echo $sale['sale_id']; ?></td>
            <td><?php echo $sale['full_name']; ?></td>
            <td>₱<?php echo number_format($sale['total_amount'], 2); ?></td>
            <td>₱<?php echo number_format($sale['amount_paid'], 2); ?></td>
            <td>₱<?php echo number_format($sale['change_amount'], 2); ?></td>
            <td><?php echo $sale['sale_date']; ?></td>
            <td><a href="sale_details.php?id=<?php echo $sale['sale_id']; ?>">Tingnan</a></td>
        </tr>
        <?php endwhile; ?>

    </table>

    <?php endif; ?>

</body>
</html>