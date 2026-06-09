<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
include 'config.php';

$medicines = mysqli_query($conn, "SELECT * FROM medicines WHERE stock_quantity > 0");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $medicine_ids = $_POST['medicine_id'];
    $quantities = $_POST['quantity'];
    $total = 0;
    $amount_paid = $_POST['amount_paid'];

    // Insert sale
    $sale_query = "INSERT INTO sales (user_id, total_amount, amount_paid, change_amount) 
                   VALUES ('{$_SESSION['user_id']}', '0', '$amount_paid', '0')";
    mysqli_query($conn, $sale_query);
    $sale_id = mysqli_insert_id($conn);

    // Insert sale items
    for ($i = 0; $i < count($medicine_ids); $i++) {
        $med_id = $medicine_ids[$i];
        $qty = $quantities[$i];

        $med = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM medicines WHERE medicine_id='$med_id'"));
        $unit_price = $med['price'];
        $subtotal = $unit_price * $qty;
        $total += $subtotal;

        mysqli_query($conn, "INSERT INTO sale_items (sale_id, medicine_id, quantity, unit_price) 
                             VALUES ('$sale_id', '$med_id', '$qty', '$unit_price')");

        // Update stock
        mysqli_query($conn, "UPDATE medicines SET stock_quantity = stock_quantity - '$qty' 
                             WHERE medicine_id='$med_id'");
    }

    $change = $amount_paid - $total;

    // Update total and change in sales
    mysqli_query($conn, "UPDATE sales SET total_amount='$total', change_amount='$change' 
                         WHERE sale_id='$sale_id'");

    $success = "Sale completed! Total: ₱$total | Change: ₱$change";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>POS</title>
</head>
<body>
    <h2>Point of Sale</h2>
    <a href="dashboard.php">Back to Dashboard</a>
    <hr>
    <?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
    <form method="POST">
        <table border="1" cellpadding="8">
            <tr>
                <th>Medicine</th>
                <th>Quantity</th>
            </tr>
            <tr>
                <td>
                    <select name="medicine_id[]">
                        <?php while ($med = mysqli_fetch_assoc($medicines)): ?>
                        <option value="<?php echo $med['medicine_id']; ?>">
                            <?php echo $med['name']; ?> - ₱<?php echo $med['price']; ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </td>
                <td><input type="number" name="quantity[]" value="1" min="1"></td>
            </tr>
        </table>
        <br>
        <label>Amount Paid: ₱</label>
        <input type="number" step="0.01" name="amount_paid"><br><br>
        <button type="submit">Complete Sale</button>
    </form>
</body>
</html>