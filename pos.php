<?php
// pos.php - Point of Sale page para sa pagbebenta ng medicines

session_start();

// i-redirect sa login kung hindi naka-login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'config.php';

// kunin lahat ng medicines na may stock pa
$available_meds = mysqli_query($conn, "SELECT * FROM medicines WHERE stock_quantity > 0 ORDER BY name ASC");

$success_msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // kunin yung mga piniling medicine at quantity
    $med_ids = $_POST['medicine_id'];
    $quantities = $_POST['quantity'];
    $amt_paid = $_POST['amount_paid'];
    $grand_total = 0;

    // i-insert muna ang sale record na may 0 total, i-update mamaya
    $sale_sql = "INSERT INTO sales (user_id, total_amount, amount_paid, change_amount) 
                 VALUES ('{$_SESSION['user_id']}', '0', '$amt_paid', '0')";
    mysqli_query($conn, $sale_sql);

    // kunin yung id ng bagong sale
    $new_sale_id = mysqli_insert_id($conn);

    // i-loop sa bawat medicine na binili
    for ($x = 0; $x < count($med_ids); $x++) {
        $chosen_med_id = $med_ids[$x];
        $chosen_qty = $quantities[$x];

        // kunin yung presyo ng medicine
        $med_info = mysqli_fetch_assoc(mysqli_query($conn, 
            "SELECT * FROM medicines WHERE medicine_id='$chosen_med_id'"));
        
        $item_price = $med_info['price'];
        $item_subtotal = $item_price * $chosen_qty;
        $grand_total += $item_subtotal;

        // i-save sa sale_items table
        mysqli_query($conn, "INSERT INTO sale_items (sale_id, medicine_id, quantity, unit_price) 
                             VALUES ('$new_sale_id', '$chosen_med_id', '$chosen_qty', '$item_price')");

        // bawasan yung stock ng medicine
        mysqli_query($conn, "UPDATE medicines SET stock_quantity = stock_quantity - '$chosen_qty' 
                             WHERE medicine_id='$chosen_med_id'");
    }

    // kalkulahin ang sukli
    $sukli = $amt_paid - $grand_total;

    // i-update yung total at sukli sa sales table
    mysqli_query($conn, "UPDATE sales SET total_amount='$grand_total', change_amount='$sukli' 
                         WHERE sale_id='$new_sale_id'");

    $success_msg = "Matagumpay ang benta! Total: ₱$grand_total | Sukli: ₱$sukli";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS - Pharmacy System</title>
</head>
<body>

    <h2>Point of Sale</h2>
    <a href="dashboard.php">Back to Dashboard</a>
    <hr>

    <!-- ipakita ang success message kung meron -->
    <?php if (!empty($success_msg)) echo "<p style='color:green;'>$success_msg</p>"; ?>

    <form method="POST">
        <table border="1" cellpadding="8">
            <tr>
                <th>Medicine</th>
                <th>Quantity</th>
            </tr>
            <tr>
                <td>
                    <select name="medicine_id[]">
                        <?php while ($med = mysqli_fetch_assoc($available_meds)): ?>
                        <option value="<?php echo $med['medicine_id']; ?>">
                            <?php echo $med['name']; ?> - ₱<?php echo $med['price']; ?> 
                            (Stock: <?php echo $med['stock_quantity']; ?>)
                        </option>
                        <?php endwhile; ?>
                    </select>
                </td>
                <td><input type="number" name="quantity[]" value="1" min="1"></td>
            </tr>
        </table>
        <br>

        <label>Bayad ng Customer: ₱</label>
        <input type="number" step="0.01" name="amount_paid" placeholder="0.00"><br><br>

        <button type="submit">Complete the order</button>
        <a href="dashboard.php">Cancel</a>

    </form>

</body>
</html>