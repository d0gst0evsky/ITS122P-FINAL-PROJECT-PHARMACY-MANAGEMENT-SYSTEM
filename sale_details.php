<?php
// sale_details.php - para makita ang detalye ng isang benta

session_start();

// i-redirect sa login kung hindi naka-login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'config.php';

// kunin yung id ng sale na gusto tingnan
$sale_id = $_GET['id'];

// check kung may id
if (empty($sale_id)) {
    header('Location: reports.php');
    exit();
}

// kunin yung info ng sale kasama ang pangalan ng cashier
$sale_info = mysqli_fetch_assoc(mysqli_query($conn, 
    "SELECT sales.*, users.full_name 
     FROM sales 
     JOIN users ON sales.user_id = users.user_id 
     WHERE sale_id='$sale_id'"));

// kung wala yung sale, balik sa reports
if (!$sale_info) {
    header('Location: reports.php');
    exit();
}

// kunin lahat ng items na nabenta sa transaction na ito
$sold_items = mysqli_query($conn, 
    "SELECT sale_items.*, medicines.name 
     FROM sale_items 
     JOIN medicines ON sale_items.medicine_id = medicines.medicine_id 
     WHERE sale_id='$sale_id'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sale Details - Pharmacy System</title>
</head>
<body>

    <h2>Sale Details</h2>
    <a href="reports.php">Back to Reports</a>
    <hr>

    <!-- basic info ng sale -->
    <p><strong>Sale ID:</strong> #<?php echo $sale_info['sale_id']; ?></p>
    <p><strong>Cashier:</strong> <?php echo $sale_info['full_name']; ?></p>
    <p><strong>Date:</strong> <?php echo $sale_info['sale_date']; ?></p>
    <hr>

    <!-- listahan ng mga nabentang medicine -->
    <h3>Sold Medicines:</h3>
    <table border="1" cellpadding="8">
        <tr>
            <th>Medicine</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Subtotal</th>
        </tr>

        <?php while ($item = mysqli_fetch_assoc($sold_items)): ?>
        <tr>
            <td><?php echo $item['name']; ?></td>
            <td><?php echo $item['quantity']; ?></td>
            <td>₱<?php echo number_format($item['unit_price'], 2); ?></td>
            <td>₱<?php echo number_format($item['quantity'] * $item['unit_price'], 2); ?></td>
        </tr>
        <?php endwhile; ?>

    </table>
    <hr>

    <!-- summary ng bayad -->
    <p><strong>Total Cost:</strong> ₱<?php echo number_format($sale_info['total_amount'], 2); ?></p>
    <p><strong>Amount Paid:</strong> ₱<?php echo number_format($sale_info['amount_paid'], 2); ?></p>
    <p><strong>Change:</strong> ₱<?php echo number_format($sale_info['change_amount'], 2); ?></p>

</body>
</html>